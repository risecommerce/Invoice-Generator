<?php

require '../includes/auth.php';
require '../config/db.php';
require '../vendor/autoload.php';
require '../includes/env.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header('Content-Type: application/json');

if (!isLoggedIn()) {
    http_response_code(401);
    echo json_encode([
        'error' => 'Not logged in.'
    ]);
    exit;
}

$data = json_decode(
    file_get_contents('php://input'),
    true
);

$invoiceId = (int)($data['invoiceId'] ?? 0);

$recipientEmail = trim(
    $data['recipientEmail'] ?? ''
);

$recipientName = trim(
    $data['recipientName'] ?? ''
);

$message = trim(
    $data['message'] ?? ''
);

$pdfBase64 = $data['pdfBase64'] ?? '';

if (
    !$invoiceId ||
    !filter_var($recipientEmail, FILTER_VALIDATE_EMAIL)
) {
    http_response_code(400);

    echo json_encode([
        'error' => 'A valid invoice and recipient email are required.'
    ]);

    exit;
}

$stmt = $pdo->prepare(
    'SELECT * FROM invoices WHERE id = ? AND user_id = ?'
);

$stmt->execute([
    $invoiceId,
    $_SESSION['user_id']
]);

$invoice = $stmt->fetch();

if (!$invoice) {
    http_response_code(404);

    echo json_encode([
        'error' => 'Invoice not found.'
    ]);

    exit;
}

$token = bin2hex(
    random_bytes(24)
);

$pdo->prepare(
    'INSERT INTO invoice_sends
    (
        invoice_id,
        user_id,
        recipient_email,
        recipient_name,
        message,
        view_token
    )
    VALUES (?, ?, ?, ?, ?, ?)'
)->execute([
    $invoiceId,
    $_SESSION['user_id'],
    $recipientEmail,
    $recipientName,
    $message,
    $token
]);

$senderName = trim(
    ($_SESSION['first_name'] ?? '') . ' ' .
    ($_SESSION['last_name'] ?? '')
);

if ($senderName === '') {
    $senderName = 'InvoiceScheduler';
}

$senderEmail = $_SESSION['email'] ?? '';

if (
    !$senderEmail ||
    !filter_var($senderEmail, FILTER_VALIDATE_EMAIL)
) {
    http_response_code(400);

    echo json_encode([
        'error' => 'Your email address is missing or invalid.'
    ]);

    exit;
}

$invoiceLabel = $invoice['invoice_number']
    ?: ('INV-' . str_pad(
        $invoice['id'],
        4,
        '0',
        STR_PAD_LEFT
    ));

$scheme = (
    !empty($_SERVER['HTTPS']) &&
    $_SERVER['HTTPS'] !== 'off'
)
    ? 'https'
    : 'http';

$baseUrl =
    $scheme . '://' .
    $_SERVER['HTTP_HOST'] .
    dirname($_SERVER['SCRIPT_NAME'], 2);

$viewUrl =
    $baseUrl .
    '/public-invoice?token=' .
    $token;

$safeMessage = nl2br(
    htmlspecialchars(
        $message,
        ENT_QUOTES,
        'UTF-8'
    )
);

$messageBlock = '';

if ($message !== '') {
    $messageBlock =
        '<p style="color:#374151;">' .
        '<strong>Message from ' .
        htmlspecialchars(
            $senderName,
            ENT_QUOTES,
            'UTF-8'
        ) .
        ':</strong>' .
        '</p>' .

        '<div style="' .
        'background:#F9FAFB;' .
        'border-radius:6px;' .
        'padding:12px;' .
        'color:#374151;' .
        '">' .
        $safeMessage .
        '</div>';
}

$htmlBody =
    '<div style="' .
    'font-family:-apple-system,Segoe UI,Helvetica,Arial,sans-serif;' .
    'max-width:560px;' .
    'margin:0 auto;' .
    'padding:24px;' .
    '">' .

    '<h1 style="' .
    'text-align:center;' .
    'font-size:22px;' .
    'color:#1E2838;' .
    '">' .
    'Invoice ' .
    htmlspecialchars(
        $invoiceLabel,
        ENT_QUOTES,
        'UTF-8'
    ) .
    '</h1>' .

    '<p style="color:#374151;">' .
    htmlspecialchars(
        $senderName,
        ENT_QUOTES,
        'UTF-8'
    ) .
    ' has sent you an invoice.' .
    '</p>' .

    $messageBlock .

    '<p style="' .
    'color:#374151;' .
    'margin-top:16px;' .
    '">' .
    'Please find the invoice attached to this email as a PDF document.' .
    '</p>' .

    '<p style="color:#1E2838;">' .
    '<strong>Total Amount:</strong> ' .
    htmlspecialchars(
        $invoice['total'] ?? '',
        ENT_QUOTES,
        'UTF-8'
    ) .
    '</p>' .

    '<div style="' .
    'text-align:center;' .
    'margin-top:24px;' .
    '">' .

    '<a href="' .
    htmlspecialchars(
        $viewUrl,
        ENT_QUOTES,
        'UTF-8'
    ) .
    '" style="' .
    'background:#1AA260;' .
    'color:#fff;' .
    'text-decoration:none;' .
    'padding:12px 24px;' .
    'border-radius:6px;' .
    'font-weight:600;' .
    'display:inline-block;' .
    '">' .
    'View Invoice' .
    '</a>' .

    '</div>' .
    '</div>';

$subject =
    'Invoice ' .
    $invoiceLabel .
    ' from ' .
    $senderName;

$mail = new PHPMailer(true);

try {

    $mail->isSMTP();

    $mail->Host = env('SMTP_HOST', 'smtp.hostinger.com');

    $mail->SMTPAuth = true;

    $mail->Username =
        env('SMTP_USERNAME');

    $mail->Password =
        env('SMTP_PASSWORD');

    $mail->SMTPSecure =
        PHPMailer::ENCRYPTION_STARTTLS;

    $mail->Port = (int) env('SMTP_PORT', '587');

    $mail->setFrom(
        env('SMTP_FROM_EMAIL', env('SMTP_USERNAME')),
        $senderName
    );

    $mail->addReplyTo(
        $senderEmail,
        $senderName
    );

    $mail->addAddress(
        $recipientEmail,
        $recipientName
    );

    $mail->isHTML(true);

    $mail->Subject = $subject;

    $mail->Body = $htmlBody;

    $mail->AltBody =
        "Invoice {$invoiceLabel}\n\n" .
        "{$senderName} has sent you an invoice.\n\n" .
        (
            $message !== ''
                ? $message . "\n\n"
                : ''
        ) .
        "Please find the invoice attached " .
        "to this email as a PDF document.\n\n" .
        "Total Amount: " .
        ($invoice['total'] ?? '') .
        "\n\n" .
        "View Invoice: " .
        $viewUrl;

    if ($pdfBase64 !== '') {

        $pdfData = preg_replace(
            '#^data:application/pdf;filename=generated\.pdf;base64,#',
            '',
            $pdfBase64
        );

        $pdfData = preg_replace(
            '#^data:application/pdf;base64,#',
            '',
            $pdfData
        );

        $pdfData = base64_decode(
            $pdfData,
            true
        );

        if ($pdfData === false) {
            throw new Exception(
                'Invalid PDF data.'
            );
        }

        $mail->addStringAttachment(
            $pdfData,
            'Invoice-' . $invoiceLabel . '.pdf',
            'base64',
            'application/pdf'
        );
    }

    $mail->send();

    echo json_encode([
        'success' => true,
        'viewUrl' => $viewUrl
    ]);

    exit;

} catch (Exception $e) {

    http_response_code(500);

    echo json_encode([
        'success' => false,
        'error' => 'Email could not be sent.',
        'details' => $mail->ErrorInfo
    ]);

    exit;
}
