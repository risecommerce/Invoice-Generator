<?php
// api/get_customer.php
require '../includes/auth.php';
require '../config/db.php';

header('Content-Type: application/json');

if (!isLoggedIn()) {
    http_response_code(401);
    echo json_encode(['error' => 'Not logged in.']);
    exit;
}

function parseNum($v) {
    if ($v === null) return 0.0;
    $v = preg_replace('/[^0-9.\-]/', '', (string)$v);
    return $v === '' ? 0.0 : (float)$v;
}

$id = (int)($_GET['id'] ?? 0);
$name = trim($_GET['name'] ?? '');

$customerRow = null;

if ($id) {
    $stmt = $pdo->prepare('SELECT * FROM customers WHERE id = ? AND user_id = ?');
    $stmt->execute([$id, $_SESSION['user_id']]);
    $customerRow = $stmt->fetch();
    if (!$customerRow) {
        http_response_code(404);
        echo json_encode(['error' => 'Customer not found.']);
        exit;
    }
    $name = $customerRow['name'];
} elseif ($name !== '') {
    // No id given (e.g. clicked from an invoice's Bill To name) - see if a
    // saved customer with this name already exists.
    $stmt = $pdo->prepare('SELECT * FROM customers WHERE user_id = ? AND deleted_at IS NULL AND LOWER(name) = LOWER(?)');
    $stmt->execute([$_SESSION['user_id'], $name]);
    $customerRow = $stmt->fetch() ?: null;
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Missing customer id or name.']);
    exit;
}

// Invoice history / totals are derived by matching invoices whose bill_to
// name matches this customer (invoices aren't linked to a customer_id yet).
$stmt = $pdo->prepare('SELECT * FROM invoices WHERE user_id = ? AND deleted_at IS NULL ORDER BY created_at ASC');
$stmt->execute([$_SESSION['user_id']]);
$all = $stmt->fetchAll();

$matches = array_values(array_filter($all, function ($row) use ($name) {
    $rowName = trim(explode("\n", $row['bill_to'] ?? '')[0]);
    return strcasecmp($rowName, $name) === 0;
}));

$totalInvoiced = 0.0;
$currencyCode = 'USD';
$derivedBillTo = '';
$derivedShipTo = '';
$invoices = [];

if (!empty($matches)) {
    $latest = end($matches);
    $derivedBillTo = $latest['bill_to'];
    $derivedShipTo = $latest['ship_to'];
    $currencyCode = explode(' ', $latest['currency'] ?: 'USD')[0];
    foreach ($matches as $m) $totalInvoiced += parseNum($m['total']);
    $invoices = array_map(function ($inv) {
        return [
            'id'            => (int)$inv['id'],
            'invoiceNumber' => $inv['invoice_number'] ?: ('INV-' . str_pad($inv['id'], 4, '0', STR_PAD_LEFT)),
            'invoiceDate'   => $inv['invoice_date'],
            'status'        => $inv['status'] ?: 'Open',
            'total'         => $inv['total'],
        ];
    }, array_reverse($matches));
}

// A saved bill_to/ship_to on the customer record itself always wins over the
// value derived from invoices, since the customer page is now the source of
// truth once someone has edited it there.
$billTo = ($customerRow && trim($customerRow['bill_to'] ?? '') !== '') ? $customerRow['bill_to'] : $derivedBillTo;
$shipTo = ($customerRow && trim($customerRow['ship_to'] ?? '') !== '') ? $customerRow['ship_to'] : $derivedShipTo;

echo json_encode([
    'id'            => $customerRow ? (int)$customerRow['id'] : null,
    'name'          => $name,
    'email'         => $customerRow['email'] ?? null,
    'createdAt'     => $customerRow['created_at'] ?? ($matches[0]['created_at'] ?? null),
    'billTo'        => $billTo,
    'shipTo'        => $shipTo,
    'invoiceCount'  => count($matches),
    'totalInvoiced' => number_format($totalInvoiced, 2, '.', ''),
    'currencyCode'  => $currencyCode,
    'invoices'      => $invoices,
]);