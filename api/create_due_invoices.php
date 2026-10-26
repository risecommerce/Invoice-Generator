<?php

header('Content-Type: application/json; charset=UTF-8');

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../includes/env.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method.'
    ]);
    exit;
}

$email = trim($_POST['email'] ?? '');
$senderName = trim($_POST['senderName'] ?? 'InvoiceScheduler');
$senderEmail = trim($_POST['senderEmail'] ?? '');

if ($senderName === '') {
    $senderName = 'InvoiceScheduler';
}

if ($senderEmail === '' || !filter_var($senderEmail, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Current user email is missing or invalid.'
    ]);
    exit;
}

if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Please enter a valid email address.'
    ]);
    exit;
}

$invoice = [];

if (!empty($_POST['invoice'])) {
    $decodedInvoice = json_decode($_POST['invoice'], true);

    if (is_array($decodedInvoice)) {
        $invoice = $decodedInvoice;
    }
}

$invoiceNumber = trim((string) ($invoice['invoiceNumber'] ?? 'invoice'));
$invoiceNumber = preg_replace('/[\\\\\/:*?"<>|]/', '-', $invoiceNumber);

if ($invoiceNumber === '') {
    $invoiceNumber = 'invoice';
}

$clientName = trim((string) ($invoice['clientName'] ?? ''));

if ($clientName === '') {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Please enter the client name before sending the invoice.'
    ]);
    exit;
}

$safeClientName = htmlspecialchars($clientName, ENT_QUOTES, 'UTF-8');

if (!isset($_FILES['pdf']) || $_FILES['pdf']['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'PDF file was not received.'
    ]);
    exit;
}

$pdfTmpPath = $_FILES['pdf']['tmp_name'];

if (!is_uploaded_file($pdfTmpPath)) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Invalid PDF upload.'
    ]);
    exit;
}

$pdfSize = filesize($pdfTmpPath);

if ($pdfSize === false || $pdfSize <= 0) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'PDF file is empty.'
    ]);
    exit;
}

$pdfHandle = fopen($pdfTmpPath, 'rb');
$pdfSignature = $pdfHandle !== false ? fread($pdfHandle, 5) : false;

if ($pdfHandle !== false) {
    fclose($pdfHandle);
}

if ($pdfSignature !== '%PDF-') {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'The uploaded file is not a valid PDF.'
    ]);
    exit;
}

$filename = $invoiceNumber . '.pdf';

$smtpHost = env('SMTP_HOST', 'smtp.hostinger.com');
$smtpPort = (int) env('SMTP_PORT', '587');
$smtpUsername = env('SMTP_USERNAME');
$smtpPassword = env('SMTP_PASSWORD');
$smtpFromEmail = env('SMTP_FROM_EMAIL', $smtpUsername);

if (
    !$smtpUsername ||
    !$smtpPassword ||
    !$smtpFromEmail ||
    !filter_var($smtpFromEmail, FILTER_VALIDATE_EMAIL)
) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'SMTP configuration is incomplete.'
    ]);
    exit;
}

$safeClientName = htmlspecialchars($clientName, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
$safeInvoiceNumber = htmlspecialchars($invoiceNumber, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
$safeSenderName = htmlspecialchars($senderName, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = $smtpHost;
    $mail->SMTPAuth = true;
    $mail->Username = $smtpUsername;
    $mail->Password = $smtpPassword;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = $smtpPort;
    $mail->Timeout = 30;

    $mail->setFrom($smtpFromEmail, $senderName);
    $mail->addReplyTo($senderEmail, $senderName);
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->CharSet = 'UTF-8';

    // ---------------------------------------------------------------
    // LOGO (shown in header)
    // ---------------------------------------------------------------
    $logoUrl = 'https://invoicescheduler.com/assets/invoice-logo.png';

    $logoCandidates = [
        __DIR__ . '/../assets/invoice-logo.png',
        __DIR__ . '/../public/assets/invoice-logo.png',
        __DIR__ . '/assets/invoice-logo.png',
    ];

    if (!empty($_SERVER['DOCUMENT_ROOT'])) {
        $logoCandidates[] = rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/assets/invoice-logo.png';
    }

    $logoPath = null;

    foreach ($logoCandidates as $candidate) {
        if (is_file($candidate) && is_readable($candidate)) {
            $logoPath = $candidate;
            break;
        }
    }

    // Logo size: fixed height, width auto (keeps proportions)
    $logoHeight = 48;
    $logoImgStyle = 'display:block;height:' . $logoHeight . 'px;width:auto;border:0;outline:none;text-decoration:none;';
    $logoSrc = $logoUrl; // fallback: hosted image

    if ($logoPath !== null) {
        $imageInfo = @getimagesize($logoPath);

        if ($imageInfo !== false && $imageInfo['mime'] === 'image/png') {
            // Embed as inline CID image
            $mail->addEmbeddedImage(
                $logoPath,
                'invoicescheduler_logo',
                'invoice-logo.png',
                'base64',
                'image/png',
                'inline'
            );
            $logoSrc = 'cid:invoicescheduler_logo';
        } else {
            error_log('Invoice logo is not a valid PNG: ' . $logoPath);
        }
    } else {
        error_log('Invoice logo not found in any known path, using hosted URL.');
    }

    $logoHtml = '
        <a href="https://invoicescheduler.com/" target="_blank" style="display:inline-block;text-decoration:none;">
            <img
                src="' . $logoSrc . '"
                alt="invoicescheduler.com"
                height="' . $logoHeight . '"
                style="' . $logoImgStyle . '"
            >
        </a>';

    $mail->Subject = 'Invoice #' . $invoiceNumber . ' from ' . $senderName;

    $mail->Body = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Invoice Notification</title>
</head>
<body style="margin:0;padding:0;background-color:#F3F4F6;font-family:Arial,Helvetica,sans-serif;color:#253047;">

<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0"
       style="width:100%;background-color:#F3F4F6;padding:30px 12px;">
<tr>
<td align="center">

    <table role="presentation" width="600" cellspacing="0" cellpadding="0" border="0"
           style="width:100%;max-width:600px;background-color:#FFFFFF;border:1px solid #E5E7EB;">

        <!-- Header: Logo + website name -->
        <tr>
            <td align="left" valign="middle"
                style="padding:16px 25px;background-color:#FFFFFF;border-bottom:3px solid #B12F26;">
                <table role="presentation" cellspacing="0" cellpadding="0" border="0">
                    <tr>
                        <td align="left" valign="middle">
                            ' . $logoHtml . '
                        </td>
                        <td align="left" valign="middle" style="padding-left:10px;">
                            <a href="https://invoicescheduler.com/" target="_blank"
                               style="font-family:Arial,Helvetica,sans-serif;font-size:22px;font-weight:bold;color:#B12F26;text-decoration:none;">
                                invoicescheduler.com
                            </a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- Email content -->
        <tr>
            <td style="padding:24px 30px 28px;font-size:14px;line-height:1.9;color:#374151;">

                <p style="margin:0 0 18px;">
                    Dear ' . $safeClientName . ',
                </p>

                <p style="margin:0 0 16px;">
                    Please find attached Invoice #
                    <strong>' . $safeInvoiceNumber . '</strong>
                    from <strong>' . $safeSenderName . '</strong>.
                </p>

                <p style="margin:0 0 16px;">
                    Please review the attached invoice and arrange payment by the due date.
                    If you have any questions regarding the invoice or services,
                    please feel free to contact us.
                </p>

                <p style="margin:0 0 22px;">
                    Thank you for your continued business and trust in
                    <strong>RiseCore Technologies Pvt Ltd</strong>.
                </p>

                <p style="margin:0;">
                    Best regards,<br>
                    <strong style="color:#17243B;">' . $safeSenderName . '</strong>
                </p>

            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td style="background-color:#17243B;padding:22px 30px;text-align:center;">
                <p style="margin:0 0 7px;font-size:14px;font-weight:bold;color:#FFFFFF;">
                    invoicescheduler.com
                </p>
                <p style="margin:0;font-size:11px;line-height:1.7;color:#CBD5E1;">
                    This email contains your invoice as a PDF attachment.
                </p>
            </td>
        </tr>

    </table>

</td>
</tr>
</table>

</body>
</html>';

    $mail->AltBody =
        "Dear {$clientName},\r\n\r\n" .
        "Please find attached Invoice # {$invoiceNumber} from {$senderName}.\r\n\r\n" .
        "Please review the attached invoice and arrange payment by the due date. " .
        "If you have any questions regarding the invoice or services, " .
        "please feel free to contact us.\r\n\r\n" .
        "Thank you for your continued business and trust in RiseCore Technologies Pvt Ltd.\r\n\r\n" .
        "Best regards,\r\n" .
        $senderName;

    $mail->addAttachment(
        $pdfTmpPath,
        $filename,
        'base64',
        'application/pdf'
    );

    $mail->send();

    echo json_encode([
        'success' => true,
        'message' => 'Invoice PDF sent successfully.',
        'filename' => $filename
    ]);
    exit;

} catch (Exception $e) {
    error_log('Invoice email failed: ' . $mail->ErrorInfo);

    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Email could not be sent. Please check the SMTP configuration and try again.'
    ]);
    exit;
}