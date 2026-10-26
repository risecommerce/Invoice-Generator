<?php
// api/export_invoices.php
require '../includes/auth.php';
require '../config/db.php';

if (!isLoggedIn()) {
    http_response_code(401);
    die('Not logged in.');
}

$stmt = $pdo->prepare(
    'SELECT * FROM invoices WHERE user_id = ? AND deleted_at IS NULL ORDER BY created_at DESC'
);
$stmt->execute([$_SESSION['user_id']]);
$invoices = $stmt->fetchAll();

function parseNum($v) {
    if ($v === null) return 0.0;
    $v = preg_replace('/[^0-9.\-]/', '', (string)$v);
    return $v === '' ? 0.0 : (float)$v;
}

function currencyCode($currencyString) {
    $parts = explode(' ', $currencyString ?: 'USD ($)');
    return $parts[0];
}

$headers = [
    'customer', 'type', 'number', 'date', 'due_date', 'payment_terms', 'purchase_order',
    'currency', 'total', 'amount_paid', 'balance', 'ship_to.name', 'notes', 'terms',
    'item', 'description', 'quantity', 'unit_cost', 'discount', 'tax', 'shipping'
];

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="invoice-history-' . date('Y-m-d') . '.csv"');

$out = fopen('php://output', 'w');
fputcsv($out, $headers);

foreach ($invoices as $inv) {
    $lineItems = json_decode($inv['line_items'] ?? '[]', true) ?: [];

    $subtotal = 0.0;
    foreach ($lineItems as $item) {
        $subtotal += parseNum($item['quantity'] ?? 0) * parseNum($item['rate'] ?? 0);
    }

    $discountAmount = $inv['discount_type'] === 'percent'
        ? $subtotal * parseNum($inv['discount_value']) / 100
        : parseNum($inv['discount_value']);

    $taxableBase = max(0, $subtotal - $discountAmount);
    $taxAmount = $inv['tax_type'] === 'percent'
        ? $taxableBase * parseNum($inv['tax_value']) / 100
        : parseNum($inv['tax_value']);

    $shippingAmount = $inv['shipping_type'] === 'percent'
        ? $subtotal * parseNum($inv['shipping_value']) / 100
        : parseNum($inv['shipping_value']);

    if (empty($lineItems)) {
        $lineItems = [['description' => '', 'quantity' => '', 'rate' => '']];
    }

    foreach ($lineItems as $item) {
        fputcsv($out, [
            $inv['bill_to'] ?? '',
            'invoice',
            $inv['invoice_number'] ?: ('INV-' . str_pad($inv['id'], 4, '0', STR_PAD_LEFT)),
            $inv['invoice_date'] ?? '',
            $inv['due_date'] ?? '',
            $inv['payment_terms'] ?? '',
            $inv['po_number'] ?? '',
            currencyCode($inv['currency']),
            $inv['total'] ?? '',
            $inv['amount_paid'] ?? '',
            $inv['balance'] ?? '',
            $inv['ship_to'] ?? '',
            $inv['notes'] ?? '',
            $inv['terms'] ?? '',
            '',
            $item['description'] ?? '',
            $item['quantity'] ?? '',
            $item['rate'] ?? '',
            number_format($discountAmount, 2, '.', ''),
            number_format($taxAmount, 2, '.', ''),
            number_format($shippingAmount, 2, '.', ''),
        ]);
    }
}

fclose($out);
exit;
