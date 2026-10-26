<?php

require '../includes/auth.php';
require '../config/db.php';

header('Content-Type: application/json');

if (!isLoggedIn()) {
    http_response_code(401);
    echo json_encode([
        'error' => 'Not logged in.'
    ]);
    exit;
}

$invoiceNumber = trim($_GET['invoice_number'] ?? '');

if ($invoiceNumber === '') {
    http_response_code(400);
    echo json_encode([
        'error' => 'Invoice number is required.'
    ]);
    exit;
}

$stmt = $pdo->prepare(
    'SELECT * FROM invoices WHERE invoice_number = ? AND user_id = ?'
);

$stmt->execute([
    $invoiceNumber,
    $_SESSION['user_id']
]);

$inv = $stmt->fetch();

if (!$inv) {
    http_response_code(404);
    echo json_encode([
        'error' => 'Invoice not found.'
    ]);
    exit;
}

echo json_encode([
    'id'                => (int)$inv['id'],
    'invoiceNumber'     => $inv['invoice_number'],
    'billFrom'          => $inv['bill_from'],
    'billTo'            => $inv['bill_to'],
    'shipTo'            => $inv['ship_to'],
    'invoiceDate'       => $inv['invoice_date'],
    'paymentTerms'      => $inv['payment_terms'],
    'dueDate'           => $inv['due_date'],
    'poNumber'          => $inv['po_number'],
    'status'            => $inv['status'],
    'isScheduled'       => (int)($inv['is_scheduled'] ?? 0),
    'scheduleFrequency' => $inv['schedule_frequency'] ?? '',
    'customerEmail'     => $inv['customer_email'] ?? '',
    'notes'             => $inv['notes'],
    'terms'             => $inv['terms'],
    'notesHeading'      => $inv['notes_heading'],
    'termsHeading'      => $inv['terms_heading'],
    'currency'          => $inv['currency'],
    'lineItems'         => json_decode($inv['line_items'] ?? '[]', true) ?: [],
    'discountValue'     => $inv['discount_value'],
    'discountType'      => $inv['discount_type'],
    'taxValue'          => $inv['tax_value'],
    'taxType'           => $inv['tax_type'],
    'shippingValue'     => $inv['shipping_value'],
    'shippingType'      => $inv['shipping_type'],
    'amountPaid'        => $inv['amount_paid'],
    'subtotal'          => $inv['subtotal'],
    'total'             => $inv['total'],
    'balance'           => $inv['balance'],
    'uploadedLogoData'  => $inv['logo_data']
]);