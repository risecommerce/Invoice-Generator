<?php
declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| INVOICE RECREATION + EMAIL SCRIPT (WITH PDF ATTACHMENT)
|--------------------------------------------------------------------------
| Run:
| php api/send_due_reminders.php
|
| This script:
| 1. Finds invoices due today.
| 2. Creates a new invoice.
| 3. Generates PDF on server (Dompdf) and emails it as attachment.
| 4. Prevents duplicate invoice recreation.
|--------------------------------------------------------------------------
*/

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit("CLI access only.\n");
}

date_default_timezone_set('Asia/Kolkata');

require_once __DIR__ . '/../includes/env.php';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$today = new DateTimeImmutable('today');

/*
|--------------------------------------------------------------------------
| CONFIGURATION
|--------------------------------------------------------------------------
*/

$emailApiUrl = 'https://invoicescheduler.com/api/create_email_due_invoices.php';

// SMTP address is used by the email API for transport.
// The customer/sender address is loaded per invoice from the users table.

/*
|--------------------------------------------------------------------------
| DUPLICATE PREVENTION TABLE
|--------------------------------------------------------------------------
*/

$pdo->exec("
    CREATE TABLE IF NOT EXISTS invoice_recreation_logs (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        source_invoice_id BIGINT UNSIGNED NOT NULL,
        source_due_date DATE NOT NULL,
        new_invoice_id BIGINT UNSIGNED NULL,
        created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        UNIQUE KEY unique_invoice_cycle
            (source_invoice_id, source_due_date)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
");

/*
|--------------------------------------------------------------------------
| DATE PARSER
|--------------------------------------------------------------------------
*/

function parseInvoiceDate(?string $value): ?DateTimeImmutable
{
    if (!$value) {
        return null;
    }

    $value = trim($value);

    foreach (['!M j, Y', '!M d, Y', '!Y-m-d'] as $format) {
        $date = DateTimeImmutable::createFromFormat(
            $format,
            $value,
            new DateTimeZone('Asia/Kolkata')
        );

        if ($date instanceof DateTimeImmutable) {
            return $date;
        }
    }

    try {
        return new DateTimeImmutable(
            $value,
            new DateTimeZone('Asia/Kolkata')
        );
    } catch (Throwable $e) {
        return null;
    }
}

/*
|--------------------------------------------------------------------------
| GENERATE UNIQUE INVOICE NUMBER
|--------------------------------------------------------------------------
*/

function generateInvoiceNumber(PDO $pdo): string
{
    do {
        $number = 'INV-' . date('Ymd') . '-' .
            strtoupper(bin2hex(random_bytes(3)));

        $check = $pdo->prepare("
            SELECT id
            FROM invoices
            WHERE invoice_number = ?
            LIMIT 1
        ");

        $check->execute([$number]);

    } while ($check->fetchColumn());

    return $number;
}

/*
|--------------------------------------------------------------------------
| CALCULATE NEW DUE DATE
|--------------------------------------------------------------------------
| Default payment terms: 30 days
|--------------------------------------------------------------------------
*/

function calculateNewDueDate(
    DateTimeImmutable $invoiceDate
): string {
    return $invoiceDate->modify('+30 days')->format('M j, Y');
}

/*
|--------------------------------------------------------------------------
| EXTRACT CLIENT NAME
|--------------------------------------------------------------------------
*/

function extractClientName($billTo): string
{
    if (is_string($billTo)) {
        $decoded = json_decode($billTo, true);

        if (is_array($decoded)) {
            $billTo = $decoded;
        } else {
            // plain textarea: first line is the client name
            $first = strtok(trim($billTo), "\n");
            return trim((string)$first);
        }
    }

    if (is_array($billTo)) {
        return trim((string)(
            $billTo['clientName']
            ?? $billTo['name']
            ?? $billTo['company']
            ?? $billTo['full_name']
            ?? ''
        ));
    }

    return '';
}

/*
|--------------------------------------------------------------------------
| PDF HELPERS (Dompdf - tables only, no flexbox)
|--------------------------------------------------------------------------
*/

function h($s): string
{
    return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
}

function lines($s): string
{
    $out = '';
    foreach (explode("\n", (string)$s) as $i => $l) {
        $out .= '<div style="' . ($i === 0 ? 'font-weight:bold;' : '') . '">' . h($l) . '</div>';
    }
    return $out;
}

function num($v): float
{
    $v = preg_replace('/[^0-9.\-]/', '', (string)$v);
    return ($v === '' || $v === null) ? 0.0 : (float)$v;
}

function currencyCode(string $c): string
{
    $code = trim(explode(' ', trim($c))[0]);
    return $code !== '' ? $code : 'USD';
}

function money(float $n, string $cur): string
{
    return currencyCode($cur) . ' ' . number_format($n, 2);
}

function renderInvoiceHtml(array $d): string
{
    $cc = currencyCode($d['currency']);

    $rows = '';
    foreach ($d['lineItems'] as $li) {
        $desc = trim((string)($li['description'] ?? ''));
        $rate = num($li['rate'] ?? 0);
        $qty  = num($li['quantity'] ?? 0);

        if ($desc === '' && $rate == 0) {
            continue;
        }

        $rows .= '<tr>
            <td class="td">' . lines($desc) . '</td>
            <td class="td r">' . h($li['quantity'] ?? '') . '</td>
            <td class="td r">' . h(money($rate, $cc)) . '</td>
            <td class="td r">' . h(money($qty * $rate, $cc)) . '</td>
        </tr>';
    }

    $tr = fn($l, $v, $b = false) =>
        '<tr><td style="padding:5px 0;' . ($b ? 'font-weight:bold;' : '') . '">' . h($l) .
        '</td><td style="padding:5px 0;text-align:right;' . ($b ? 'font-weight:bold;' : '') . '">' . h($v) . '</td></tr>';

    $tot = $tr('Subtotal', $d['subtotal']);

    if (num($d['discountValue']) != 0) {
        $p = $d['discountType'] === 'percent';
        $tot .= $tr(
            'Discount' . ($p ? " ({$d['discountValue']}%)" : ''),
            $p ? $d['discountValue'] . '%' : money(num($d['discountValue']), $cc)
        );
    }
    if (num($d['taxValue']) != 0) {
        $p = $d['taxType'] === 'percent';
        $tot .= $tr(
            'Tax' . ($p ? " ({$d['taxValue']}%)" : ''),
            $p ? $d['taxValue'] . '%' : money(num($d['taxValue']), $cc)
        );
    }
    if (num($d['shippingValue']) != 0) {
        $p = $d['shippingType'] === 'percent';
        $tot .= $tr(
            'Shipping',
            $p ? $d['shippingValue'] . '%' : money(num($d['shippingValue']), $cc)
        );
    }

    $tot .= '<tr><td colspan="2" style="border-top:1px solid #D1D5DB;"></td></tr>';
    $tot .= $tr('Total:', $d['total'], true);

    $logo = !empty($d['uploadedLogoData'])
        ? '<img src="' . h($d['uploadedLogoData']) . '" style="max-width:140px;max-height:90px;">'
        : '';

    $meta = '<tr><td class="mk">Date:</td><td class="mv">' . h($d['invoiceDate']) . '</td></tr>
             <tr><td class="mk">Due Date:</td><td class="mv">' . h($d['dueDate']) . '</td></tr>';

    if ($d['paymentTerms'] !== '') {
        $meta .= '<tr><td class="mk">Terms:</td><td class="mv">' . h($d['paymentTerms']) . '</td></tr>';
    }
    if ($d['poNumber'] !== '') {
        $meta .= '<tr><td class="mk">PO:</td><td class="mv">' . h($d['poNumber']) . '</td></tr>';
    }

    $meta .= '<tr><td colspan="2" style="padding-top:8px;">
        <table width="100%" style="background:#F3F4F6;"><tr>
            <td style="padding:8px 12px;color:#6B7280;">Balance Due:</td>
            <td style="padding:8px 12px;text-align:right;font-size:14px;font-weight:bold;">' . h($d['balance']) . '</td>
        </tr></table></td></tr>';

    $ship = $d['shipTo'] !== ''
        ? '<td width="50%" valign="top"><div class="lbl">Ship To:</div>' . lines($d['shipTo']) . '</td>'
        : '<td width="50%"></td>';

    $terms = $d['terms'] !== ''
        ? '<div class="sec">' . h($d['termsHeading']) . '</div><div class="small">' . nl2br(h($d['terms'])) . '</div>'
        : '';

    return '<!DOCTYPE html><html><head><meta charset="utf-8"><style>
        @page { margin: 0; }
        body { font-family: DejaVu Sans, Arial, sans-serif; font-size:11px; color:#111827; margin:0; padding:36px 40px; }
        .td { padding:9px 12px; border-bottom:1px solid #E5E7EB; color:#374151; }
        .r { text-align:right; }
        .th { background:#1F2937; color:#fff; padding:10px 12px; font-size:10px; }
        .mk { color:#6B7280; padding:4px 0; text-align:right; }
        .mv { padding:4px 0 4px 14px; text-align:right; }
        .lbl { color:#6B7280; margin-bottom:2px; }
        .sec { font-size:9px; font-weight:bold; letter-spacing:1px; color:#6B7280; text-transform:uppercase; margin:16px 0 6px; }
        .small { font-size:10.5px; color:#4B5563; line-height:1.6; }
    </style></head><body>

    <table width="100%" style="border-bottom:1px solid #E5E7EB;"><tr>
        <td width="50%">' . $logo . '</td>
        <td width="50%" align="right">
            <div style="font-size:10px;font-weight:bold;letter-spacing:2px;color:#6B7280;">INVOICE</div>
            <div style="font-size:26px;font-weight:bold;">#' . h($d['invoiceNumber']) . '</div>
        </td>
    </tr></table>

    <table width="100%" style="margin:14px 0 22px;"><tr>
        <td width="52%" valign="top" style="padding-right:15px;">
            <div style="line-height:1.5;">' . lines($d['billFrom']) . '</div>
            <table width="100%" style="margin-top:18px;"><tr>
                <td width="50%" valign="top"><div class="lbl">Bill To:</div>' . lines($d['billTo']) . '</td>
                ' . $ship . '
            </tr></table>
        </td>
        <td width="48%" valign="top"><table width="100%">' . $meta . '</table></td>
    </tr></table>

    <table width="100%" cellspacing="0" cellpadding="0">
        <tr>
            <th class="th" align="left">Item</th>
            <th class="th" align="right" width="70">Quantity</th>
            <th class="th" align="right" width="95">Rate</th>
            <th class="th" align="right" width="105">Amount</th>
        </tr>
        ' . $rows . '
    </table>

    <table width="100%" style="margin-top:14px;"><tr>
        <td width="58%"></td>
        <td width="42%"><table width="100%">' . $tot . '</table></td>
    </tr></table>

    <div style="margin-top:20px;border-top:1px solid #E5E7EB;padding-top:6px;">
        <div class="sec">' . h($d['notesHeading']) . '</div>
        <div class="small">' . nl2br(h($d['notes'])) . '</div>
        ' . $terms . '
    </div>

    </body></html>';
}

function generateInvoicePdf(array $d): string
{
    $options = new Options();
    $options->set('isRemoteEnabled', false);
    $options->set('defaultFont', 'DejaVu Sans');

    $dompdf = new Dompdf($options);
    $dompdf->loadHtml(renderInvoiceHtml($d), 'UTF-8');
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    return $dompdf->output();
}

/*
|--------------------------------------------------------------------------
| SEND EMAIL WITH PDF ATTACHMENT
|--------------------------------------------------------------------------
| API fields (same as index.php):
| email, senderName, senderEmail, invoice (JSON), pdf (file)
|--------------------------------------------------------------------------
*/

function callInvoiceEmailFile(
    string $emailApiUrl,
    array $invoice,
    string $senderEmail
): array {

    $clientEmail = trim((string)($invoice['customerEmail'] ?? ''));

    if ($clientEmail === '' || !filter_var($clientEmail, FILTER_VALIDATE_EMAIL)) {
        throw new RuntimeException('Client email is missing or invalid.');
    }

    if ($senderEmail === '' || !filter_var($senderEmail, FILTER_VALIDATE_EMAIL)) {
        throw new RuntimeException('Sender email is missing or invalid.');
    }

    if (!function_exists('curl_init')) {
        throw new RuntimeException('PHP cURL extension is not installed.');
    }

    // Generate PDF on server
    $fileName = preg_replace('/[\\\\\/:*?"<>|]/', '-', (string)$invoice['invoiceNumber']) . '.pdf';
    $tmp = tempnam(sys_get_temp_dir(), 'inv_');
    file_put_contents($tmp, generateInvoicePdf($invoice));

    try {
        $ch = curl_init($emailApiUrl);

        curl_setopt_array($ch, [
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => [
                'email'       => $clientEmail,
                'senderName'  => 'InvoiceScheduler',
                'senderEmail' => $senderEmail,
                'invoice'     => json_encode($invoice, JSON_UNESCAPED_UNICODE),
                'pdf'         => new CURLFile($tmp, 'application/pdf', $fileName),
            ],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 20,
            CURLOPT_TIMEOUT        => 90,
        ]);

        $response = curl_exec($ch);

        if ($response === false) {
            $error = curl_error($ch);
            curl_close($ch);
            throw new RuntimeException('Email API connection failed: ' . $error);
        }

        $httpCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $result = json_decode($response, true);

        if ($httpCode < 200 || $httpCode >= 300 || !is_array($result) || empty($result['success'])) {
            throw new RuntimeException(
                'Email API failed. HTTP: ' . $httpCode . '. Response: ' . $response
            );
        }

        return $result;

    } finally {
        @unlink($tmp);
    }
}

/*
|--------------------------------------------------------------------------
| LOAD INVOICES DUE TODAY
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    SELECT *
    FROM invoices
    WHERE deleted_at IS NULL
      AND COALESCE(balance, 0) > 0
      AND is_scheduled = 1
      AND COALESCE(
          STR_TO_DATE(TRIM(due_date), '%b %e, %Y'),
          STR_TO_DATE(TRIM(due_date), '%b %d, %Y'),
          STR_TO_DATE(TRIM(due_date), '%Y-%m-%d')
      ) = ?
    ORDER BY id ASC
");

$stmt->execute([
    $today->format('Y-m-d')
]);

$invoices = $stmt->fetchAll(PDO::FETCH_ASSOC);

$created = 0;
$skipped = 0;
$failed = 0;
$emailSent = 0;
$emailFailed = 0;
$lastSenderEmail = '';
$lastCustomerEmail = '';
$lastFromEmail = 'postman@invoicescheduler.com';

/*
|--------------------------------------------------------------------------
| CREATE NEW INVOICE
|--------------------------------------------------------------------------
*/

foreach ($invoices as $source) {

    $sourceId = (int)$source['id'];

    $sourceDueDate = parseInvoiceDate(
        $source['due_date'] ?? null
    );

    if (!$sourceDueDate) {
        echo "Skipped invoice ID {$sourceId}: invalid due date.\n";
        $skipped++;
        continue;
    }

    $sourceDueDateString = $sourceDueDate->format('Y-m-d');

    try {

        // Start transaction
        $pdo->beginTransaction();

        // Prevent duplicate invoice creation
        $claim = $pdo->prepare("
            INSERT IGNORE INTO invoice_recreation_logs
                (source_invoice_id, source_due_date)
            VALUES (?, ?)
        ");

        $claim->execute([
            $sourceId,
            $sourceDueDateString
        ]);

        if ($claim->rowCount() !== 1) {

            $pdo->rollBack();

            $skipped++;

            echo "Skipped invoice ID {$sourceId}: already processed.\n";

            continue;
        }

        // New invoice details
        $newInvoiceDate = $today->format('M j, Y');
        $newDueDate = calculateNewDueDate($today);
        $newInvoiceNumber = generateInvoiceNumber($pdo);

        /*
        |--------------------------------------------------------------------------
        | INSERT NEW INVOICE
        |--------------------------------------------------------------------------
        */

        $insert = $pdo->prepare("
            INSERT INTO invoices (
                user_id,
                invoice_number,
                bill_from,
                bill_to,
                ship_to,
                invoice_date,
                payment_terms,
                due_date,
                po_number,
                status,
                is_scheduled,
                schedule_frequency,
                customer_email,
                notes,
                terms,
                notes_heading,
                terms_heading,
                currency,
                line_items,
                discount_value,
                discount_type,
                tax_value,
                tax_type,
                shipping_value,
                shipping_type,
                amount_paid,
                subtotal,
                total,
                balance,
                logo_data
            ) VALUES (
                :user_id,
                :invoice_number,
                :bill_from,
                :bill_to,
                :ship_to,
                :invoice_date,
                :payment_terms,
                :due_date,
                :po_number,
                :status,
                :is_scheduled,
                :schedule_frequency,
                :customer_email,
                :notes,
                :terms,
                :notes_heading,
                :terms_heading,
                :currency,
                :line_items,
                :discount_value,
                :discount_type,
                :tax_value,
                :tax_type,
                :shipping_value,
                :shipping_type,
                0,
                :subtotal,
                :total,
                :balance,
                :logo_data
            )
        ");

        $insert->execute([
            ':user_id'            => $source['user_id'],
            ':invoice_number'     => $newInvoiceNumber,
            ':bill_from'          => $source['bill_from'],
            ':bill_to'            => $source['bill_to'],
            ':ship_to'            => $source['ship_to'],
            ':invoice_date'       => $newInvoiceDate,
            ':payment_terms'      => $source['payment_terms'],
            ':due_date'           => $newDueDate,
            ':po_number'          => $source['po_number'],
            ':status'             => 'Draft',
            ':is_scheduled'       => 0,
            ':schedule_frequency' => null,
            ':customer_email'     => $source['customer_email'],
            ':notes'              => $source['notes'],
            ':terms'              => $source['terms'],
            ':notes_heading'      => $source['notes_heading'],
            ':terms_heading'      => $source['terms_heading'],
            ':currency'           => $source['currency'],
            ':line_items'         => $source['line_items'],
            ':discount_value'     => $source['discount_value'],
            ':discount_type'      => $source['discount_type'],
            ':tax_value'          => $source['tax_value'],
            ':tax_type'           => $source['tax_type'],
            ':shipping_value'     => $source['shipping_value'],
            ':shipping_type'      => $source['shipping_type'],
            ':subtotal'           => $source['subtotal'],
            ':total'              => $source['total'],
            ':balance'            => $source['total'],
            ':logo_data'          => $source['logo_data'],
        ]);

        $newInvoiceId = (int)$pdo->lastInsertId();

        // Update recreation log
        $log = $pdo->prepare("
            UPDATE invoice_recreation_logs
            SET new_invoice_id = ?
            WHERE source_invoice_id = ?
              AND source_due_date = ?
        ");

        $log->execute([
            $newInvoiceId,
            $sourceId,
            $sourceDueDateString
        ]);

        // Commit invoice creation
        $pdo->commit();

        $created++;

        echo "Created invoice {$newInvoiceNumber} from source ID {$sourceId}.\n";

        /*
        |--------------------------------------------------------------------------
        | SEND EMAIL WITH PDF ATTACHMENT
        |--------------------------------------------------------------------------
        */

        try {

            $clientName = extractClientName($source['bill_to'] ?? '');

            if ($clientName === '') {
                $clientName = 'Client';
            }

            $emailInvoice = [
                'invoiceNumber'    => $newInvoiceNumber,
                'clientName'       => $clientName,
                'customerEmail'    => (string)$source['customer_email'],

                'billFrom'         => (string)$source['bill_from'],
                'billTo'           => (string)$source['bill_to'],
                'shipTo'           => (string)$source['ship_to'],

                'invoiceDate'      => $newInvoiceDate,
                'paymentTerms'     => (string)$source['payment_terms'],
                'dueDate'          => $newDueDate,
                'poNumber'         => (string)$source['po_number'],

                'notes'            => (string)$source['notes'],
                'terms'            => (string)$source['terms'],
                'notesHeading'     => $source['notes_heading'] ?: 'Notes',
                'termsHeading'     => $source['terms_heading'] ?: 'Terms',

                'currency'         => (string)$source['currency'],
                'uploadedLogoData' => (string)($source['logo_data'] ?? ''),
                'lineItems'        => json_decode((string)$source['line_items'], true) ?: [],

                'discountValue'    => (string)$source['discount_value'],
                'discountType'     => (string)$source['discount_type'],
                'taxValue'         => (string)$source['tax_value'],
                'taxType'          => (string)$source['tax_type'],
                'shippingValue'    => (string)$source['shipping_value'],
                'shippingType'     => (string)$source['shipping_type'],

                'amountPaid'       => '0',
                'subtotal'         => (string)$source['subtotal'],
                'total'            => (string)$source['total'],
                'balance'          => (string)$source['total'],
            ];

            // Sender email = account email belonging to invoice.user_id.
            // Assumes the account table is `users` and its email column is `email`.
            $userEmailStmt = $pdo->prepare("SELECT email FROM users WHERE id = ? LIMIT 1");
            $userEmailStmt->execute([(int)$source['user_id']]);
            $invoiceSenderEmail = trim((string)$userEmailStmt->fetchColumn());

            if ($invoiceSenderEmail === '' || !filter_var($invoiceSenderEmail, FILTER_VALIDATE_EMAIL)) {
                throw new RuntimeException('Account email not found/invalid for user_id ' . (int)$source['user_id']);
            }

            // Record the addresses for the final terminal output.
            $lastSenderEmail = $invoiceSenderEmail;
            $lastCustomerEmail = trim((string)($source['customer_email'] ?? ''));

            callInvoiceEmailFile(
                $emailApiUrl,
                $emailInvoice,
                $invoiceSenderEmail
            );

            $emailSent++;

            echo "Email sent successfully (with PDF) for invoice {$newInvoiceNumber}.\n";

        } catch (Throwable $emailError) {

            // Invoice already exists; do not roll back
            $failed++;
            $emailFailed++;

            fwrite(
                STDERR,
                "Email failed for invoice {$newInvoiceNumber}: " .
                $emailError->getMessage() .
                "\n"
            );
        }

    } catch (Throwable $e) {

        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }

        $failed++;

        fwrite(
            STDERR,
            "Failed source invoice ID {$sourceId}: " .
            $e->getMessage() .
            "\n"
        );
    }
}

/*
|--------------------------------------------------------------------------
| FINAL RESULT
|--------------------------------------------------------------------------
*/

echo "\n";
echo "====================================\n";
echo "       INVOICE SCRIPT STATUS\n";
echo "====================================\n";
echo "Script Run Status : COMPLETED\n";
echo "Created          : {$created}\n";
echo "Skipped          : {$skipped}\n";
echo "Failed           : {$failed}\n";
echo "------------------------------------\n";
echo "             EMAIL STATUS\n";
echo "------------------------------------\n";
echo "Email Sent       : {$emailSent}\n";
echo "Email Failed     : {$emailFailed}\n";
echo "Sender Email    : " . ($lastSenderEmail !== '' ? $lastSenderEmail : 'Not Found') . "\n";
echo "Customer Email  : " . ($lastCustomerEmail !== '' ? $lastCustomerEmail : 'Not Found') . "\n";
echo "------------------------------------\n";
echo "             EMAIL HEADERS\n";
echo "------------------------------------\n";
echo "From            : InvoiceScheduler <{$lastFromEmail}>\n";
echo "Reply-To        : " . ($lastSenderEmail !== '' ? $lastSenderEmail : 'Not Found') . "\n";
echo "To              : " . ($lastCustomerEmail !== '' ? $lastCustomerEmail : 'Not Found') . "\n";
echo "CC              : " . ($lastSenderEmail !== '' ? $lastSenderEmail : 'Not Found') . "\n";
echo "====================================\n";
echo "Finished.\n";

exit($failed > 0 ? 1 : 0);