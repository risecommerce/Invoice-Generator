<?php
// api/import_invoices.php
require '../includes/auth.php';
require '../config/db.php';

header('Content-Type: application/json');

if (!isLoggedIn()) {
    http_response_code(401);
    echo json_encode(['error' => 'Not logged in.']);
    exit;
}

if (empty($_FILES['csv']) || $_FILES['csv']['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    echo json_encode(['error' => 'No CSV file uploaded.']);
    exit;
}

$handle = fopen($_FILES['csv']['tmp_name'], 'r');
if (!$handle) {
    http_response_code(400);
    echo json_encode(['error' => 'Could not read the uploaded file.']);
    exit;
}

$header = fgetcsv($handle);
if (!$header) {
    http_response_code(400);
    echo json_encode(['error' => 'The CSV file appears to be empty.']);
    exit;
}
$header = array_map('trim', $header);

$rows = [];
while (($row = fgetcsv($handle)) !== false) {
    if (count($row) < count($header)) {
        $row = array_pad($row, count($header), '');
    }
    $rows[] = array_combine($header, $row);
}
fclose($handle);

// Group CSV rows into invoices. Rows belong to the same invoice when they
// share the same "number" (falls back to number+date+customer if blank).
$groups = [];
foreach ($rows as $row) {
    $key = trim($row['number'] ?? '');
    if ($key === '') {
        $key = trim(($row['date'] ?? '') . '|' . ($row['customer'] ?? ''));
    }
    $groups[$key][] = $row;
}

function parseNum($v) {
    if ($v === null) return 0.0;
    $v = preg_replace('/[^0-9.\-]/', '', (string)$v);
    return $v === '' ? 0.0 : (float)$v;
}

$insertStmt = $pdo->prepare(
    'INSERT INTO invoices (
        user_id, invoice_number, bill_from, bill_to, ship_to, invoice_date,
        payment_terms, due_date, po_number, status, notes, terms,
        notes_heading, terms_heading, currency, line_items,
        discount_value, discount_type, tax_value, tax_type,
        shipping_value, shipping_type, amount_paid, subtotal, total, balance
    ) VALUES (
        ?, ?, ?, ?, ?, ?,
        ?, ?, ?, ?, ?, ?,
        ?, ?, ?, ?,
        ?, ?, ?, ?,
        ?, ?, ?, ?, ?, ?
    )'
);

$imported = 0;

foreach ($groups as $groupRows) {
    $first = $groupRows[0];
    $currencyCode = trim($first['currency'] ?? 'USD');

    $lineItems = [];
    $subtotal = 0.0;
    foreach ($groupRows as $row) {
        $qty = $row['quantity'] ?? '1';
        $rate = $row['unit_cost'] ?? '0';
        $amount = parseNum($qty) * parseNum($rate);
        $subtotal += $amount;
        $lineItems[] = [
            'description' => $row['description'] ?? '',
            'quantity'    => $qty,
            'rate'        => $rate,
            'amount'      => $currencyCode . ' ' . number_format($amount, 2, '.', ''),
        ];
    }

    $discountAmount = parseNum($first['discount'] ?? 0);
    $taxAmount = parseNum($first['tax'] ?? 0);
    $shippingAmount = parseNum($first['shipping'] ?? 0);
    $amountPaid = parseNum($first['amount_paid'] ?? 0);
    $total = $subtotal - $discountAmount + $taxAmount + $shippingAmount;
    $balance = max(0, $total - $amountPaid);

    $insertStmt->execute([
        $_SESSION['user_id'],
        $first['number'] ?? '',
        '',
        $first['customer'] ?? '',
        $first['ship_to.name'] ?? '',
        $first['date'] ?? '',
        $first['payment_terms'] ?? '',
        $first['due_date'] ?? '',
        $first['purchase_order'] ?? '',
        'Open',
        $first['notes'] ?? '',
        $first['terms'] ?? '',
        'Notes',
        'Terms',
        $currencyCode,
        json_encode($lineItems),
        number_format($discountAmount, 2, '.', ''),
        'amount',
        number_format($taxAmount, 2, '.', ''),
        'amount',
        number_format($shippingAmount, 2, '.', ''),
        'amount',
        number_format($amountPaid, 2, '.', ''),
        $currencyCode . ' ' . number_format($subtotal, 2, '.', ''),
        $currencyCode . ' ' . number_format($total, 2, '.', ''),
        $currencyCode . ' ' . number_format($balance, 2, '.', ''),
    ]);

    $imported++;
}

echo json_encode(['success' => true, 'imported' => $imported]);
