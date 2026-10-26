<?php

declare(strict_types=1);

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

header('Content-Type: application/json; charset=UTF-8');

function jsonResponse(
    bool $success,
    string $message = '',
    int $statusCode = 200
): never {
    http_response_code($statusCode);

    echo json_encode(
        [
            'success' => $success,
            ...($message !== '' ? ['error' => $message] : [])
        ],
        JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
    );

    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(false, 'Method not allowed.', 405);
}

if (!empty($_POST['website'] ?? '')) {
    jsonResponse(true);
}

$allowedSubjects = [
    'General Inquiry',
    'Bug Report',
    'Feature Request',
    'Billing Question',
    'Other'
];

$name = trim((string)($_POST['name'] ?? ''));
$email = trim((string)($_POST['email'] ?? ''));
$subject = trim((string)($_POST['subject'] ?? ''));
$message = trim((string)($_POST['message'] ?? ''));

if (
    $name === '' ||
    $email === '' ||
    $subject === '' ||
    $message === ''
) {
    jsonResponse(
        false,
        'Please fill in all required fields.',
        400
    );
}

if (mb_strlen($name) > 150) {
    jsonResponse(false, 'Name is too long.', 400);
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    jsonResponse(
        false,
        'Please enter a valid email address.',
        400
    );
}

if (!in_array($subject, $allowedSubjects, true)) {
    jsonResponse(
        false,
        'Please select a valid subject.',
        400
    );
}

if (mb_strlen($message) > 5000) {
    jsonResponse(false, 'Message is too long.', 400);
}

$autoloadPath = dirname(__DIR__) . '/vendor/autoload.php';

if (!is_file($autoloadPath)) {
    error_log(
        'InvoiceScheduler: PHPMailer autoload not found at: ' .
        $autoloadPath
    );

    jsonResponse(
        false,
        'Server configuration error. Please try again later.',
        500
    );
}

require_once $autoloadPath;
require_once dirname(__DIR__) . '/includes/env.php';

$smtpHost = env('SMTP_HOST', 'smtp.hostinger.com');
$smtpPort = (int) env('SMTP_PORT', '587');
$smtpUsername = (string) env('SMTP_USERNAME', '');
$smtpPassword = (string) env('SMTP_PASSWORD', '');
$smtpFromEmail = (string) env('SMTP_FROM_EMAIL', $smtpUsername);

$toEmail = (string) env('CONTACT_TO_EMAIL', '');

if ($smtpUsername === '' || $smtpPassword === '' || $toEmail === '') {
    error_log('InvoiceScheduler: SMTP/contact settings missing from .env');

    jsonResponse(
        false,
        'Server configuration error. Please try again later.',
        500
    );
}

$cleanName = str_replace(
    ["\r", "\n"],
    '',
    $name
);

$cleanEmail = str_replace(
    ["\r", "\n"],
    '',
    $email
);

$cleanSubject = str_replace(
    ["\r", "\n"],
    '',
    $subject
);

$mailSubject = 'InvoiceScheduler Support — ' . $cleanSubject;

try {
    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = $smtpHost;
    $mail->Port = $smtpPort;
    $mail->SMTPAuth = true;
    $mail->Username = $smtpUsername;
    $mail->Password = $smtpPassword;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->CharSet = 'UTF-8';

    $mail->setFrom(
        $smtpFromEmail,
        'InvoiceScheduler'
    );

    $mail->addAddress(
        $toEmail,
        'InvoiceScheduler Support'
    );

    $mail->addReplyTo(
        $cleanEmail,
        $cleanName
    );

    $mail->Subject = $mailSubject;

    $safeName = htmlspecialchars(
        $name,
        ENT_QUOTES | ENT_SUBSTITUTE,
        'UTF-8'
    );

    $safeEmail = htmlspecialchars(
        $email,
        ENT_QUOTES | ENT_SUBSTITUTE,
        'UTF-8'
    );

    $safeSubject = htmlspecialchars(
        $subject,
        ENT_QUOTES | ENT_SUBSTITUTE,
        'UTF-8'
    );

    $safeMessage = nl2br(
        htmlspecialchars(
            $message,
            ENT_QUOTES | ENT_SUBSTITUTE,
            'UTF-8'
        )
    );

    $mail->isHTML(true);

    $mail->Body = '
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>InvoiceScheduler Contact</title>
</head>
<body style="
    margin:0;
    padding:0;
    background:#f5f6f8;
    font-family:Arial,Helvetica,sans-serif;
">
<div style="
    max-width:680px;
    margin:0 auto;
    padding:32px 20px;
">
    <div style="
        background:#ffffff;
        border:1px solid #e5e7eb;
        border-radius:16px;
        overflow:hidden;
    ">
        <div style="
            height:4px;
            background:#B12F26;
        "></div>

        <div style="padding:28px;">

            <h2 style="
                margin:0 0 24px;
                color:#182233;
                font-size:22px;
                line-height:1.3;
            ">
                New Contact Form Submission
            </h2>

            <div style="
                margin-bottom:12px;
                color:#374151;
                font-size:14px;
                line-height:1.6;
            ">
                <strong>Name:</strong>
                ' . $safeName . '
            </div>

            <div style="
                margin-bottom:12px;
                color:#374151;
                font-size:14px;
                line-height:1.6;
            ">
                <strong>Email:</strong>
                ' . $safeEmail . '
            </div>

            <div style="
                margin-bottom:20px;
                color:#374151;
                font-size:14px;
                line-height:1.6;
            ">
                <strong>Subject:</strong>
                ' . $safeSubject . '
            </div>

            <div style="
                padding:18px;
                background:#f8f9fa;
                border:1px solid #e5e7eb;
                border-radius:12px;
            ">
                <div style="
                    margin-bottom:10px;
                    color:#182233;
                    font-size:14px;
                    font-weight:bold;
                ">
                    Message
                </div>

                <div style="
                    color:#4b5563;
                    font-size:14px;
                    line-height:1.7;
                ">
                    ' . $safeMessage . '
                </div>
            </div>

        </div>
    </div>

    <div style="
        padding-top:16px;
        text-align:center;
        color:#9ca3af;
        font-size:12px;
    ">
        InvoiceScheduler Support
    </div>
</div>
</body>
</html>
';

    $mail->AltBody =
        "New contact form submission\n\n" .
        "Name: {$name}\n" .
        "Email: {$email}\n" .
        "Subject: {$subject}\n\n" .
        "Message:\n{$message}";

    $mail->send();

    jsonResponse(true);

} catch (Exception $e) {

    error_log(
        'InvoiceScheduler contact email error: ' .
        $e->getMessage()
    );

    jsonResponse(
        false,
        'We could not send your message right now. Please email us directly at support@invoicescheduler.com.',
        500
    );

} catch (\Throwable $e) {

    error_log(
        'InvoiceScheduler contact handler fatal error: ' .
        $e->getMessage()
    );

    jsonResponse(
        false,
        'We could not process your request right now. Please try again later.',
        500
    );
}