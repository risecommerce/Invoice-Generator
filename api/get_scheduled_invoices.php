<?php

require '../includes/auth.php';
require '../config/db.php';

header('Content-Type: application/json');

if (!isLoggedIn()) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'error' => 'Not logged in.'
    ]);
    exit;
}

$userId = (int)($_SESSION['user_id'] ?? 0);

if (!$userId) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'error' => 'Invalid user session.'
    ]);
    exit;
}

function normalizeMoney($value)
{
    if ($value === null || $value === '') {
        return 0;
    }

    if (is_numeric($value)) {
        return (float)$value;
    }

    $value = trim((string)$value);

    $value = str_replace(',', '', $value);

    if (preg_match('/-?\d+(?:\.\d+)?/', $value, $matches)) {
        return (float)$matches[0];
    }

    return 0;
}

try {

    $stmt = $pdo->prepare("
        SELECT
            id,
            user_id,
            original_invoice_id,
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
            logo_data,
            created_at,
            updated_at,
            deleted_at
        FROM scheduled_invoices
        WHERE user_id = ?
          AND is_scheduled = 1
          AND (deleted_at IS NULL OR deleted_at = '')
        ORDER BY created_at DESC
    ");

    $stmt->execute([$userId]);

    $invoices = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($invoices as &$invoice) {

        $invoice['id'] = (int)$invoice['id'];

        $invoice['user_id'] = (int)$invoice['user_id'];

        $invoice['original_invoice_id'] =
            $invoice['original_invoice_id'] !== null
                ? (int)$invoice['original_invoice_id']
                : null;

        $invoice['is_scheduled'] =
            (int)$invoice['is_scheduled'];

        $invoice['status'] =
            !empty($invoice['status'])
                ? $invoice['status']
                : 'Open';

        $invoice['schedule_frequency'] =
            !empty($invoice['schedule_frequency'])
                ? $invoice['schedule_frequency']
                : null;

        $invoice['customer_email'] =
            !empty($invoice['customer_email'])
                ? $invoice['customer_email']
                : null;

        if (!empty($invoice['line_items'])) {

            $decodedItems = json_decode(
                $invoice['line_items'],
                true
            );

            $invoice['line_items'] =
                json_last_error() === JSON_ERROR_NONE &&
                is_array($decodedItems)
                    ? $decodedItems
                    : [];

        } else {

            $invoice['line_items'] = [];
        }

        $invoice['discount_value'] =
            normalizeMoney($invoice['discount_value']);

        $invoice['tax_value'] =
            normalizeMoney($invoice['tax_value']);

        $invoice['shipping_value'] =
            normalizeMoney($invoice['shipping_value']);

        $invoice['amount_paid'] =
            normalizeMoney($invoice['amount_paid']);

        $invoice['subtotal'] =
            normalizeMoney($invoice['subtotal']);

        $invoice['total'] =
            normalizeMoney($invoice['total']);

        $invoice['balance'] =
            normalizeMoney($invoice['balance']);
    }

    unset($invoice);

    echo json_encode([
        'success' => true,
        'count' => count($invoices),
        'data' => $invoices
    ]);

} catch (PDOException $e) {

    http_response_code(500);

    echo json_encode([
        'success' => false,
        'error' => 'Database error.'
    ]);
}