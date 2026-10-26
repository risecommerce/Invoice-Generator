<?php

require '../includes/auth.php';
require '../config/db.php';

header('Content-Type: application/json');

function jsonResponse($success, $data = [], $statusCode = 200)
{
    http_response_code($statusCode);

    echo json_encode(
        array_merge(
            ['success' => $success],
            $data
        )
    );

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

if (!isLoggedIn()) {
    jsonResponse(false, [
        'error' => 'Not logged in.'
    ], 401);
}

$userId = (int)($_SESSION['user_id'] ?? 0);

if (!$userId) {
    jsonResponse(false, [
        'error' => 'Invalid user session.'
    ], 401);
}

try {

    $data = json_decode(
        file_get_contents('php://input'),
        true
    );

    if (!is_array($data)) {
        jsonResponse(false, [
            'error' => 'Invalid invoice data.'
        ], 400);
    }

    $invoiceNumber = trim(
        (string)($data['invoiceNumber'] ?? '')
    );

    if ($invoiceNumber === '') {
        jsonResponse(false, [
            'error' => 'Invoice number is required.'
        ], 400);
    }

    $billFrom = (string)($data['billFrom'] ?? '');
    $billTo = (string)($data['billTo'] ?? '');
    $shipTo = (string)($data['shipTo'] ?? '');
    $invoiceDate = (string)($data['invoiceDate'] ?? '');
    $paymentTerms = (string)($data['paymentTerms'] ?? '');
    $dueDate = (string)($data['dueDate'] ?? '');
    $poNumber = (string)($data['poNumber'] ?? '');

    $status = trim(
        (string)($data['status'] ?? 'Open')
    );

    if ($status === '') {
        $status = 'Open';
    }

    $notes = (string)($data['notes'] ?? '');
    $terms = (string)($data['terms'] ?? '');

    $notesHeading = (string)(
        $data['notesHeading'] ?? 'Notes'
    );

    $termsHeading = (string)(
        $data['termsHeading'] ?? 'Terms'
    );

    $currency = (string)(
        $data['currency'] ?? 'USD ($)'
    );

    $lineItemsData = $data['lineItems'] ?? [];

    if (!is_array($lineItemsData)) {
        $lineItemsData = [];
    }

    $lineItems = json_encode(
        $lineItemsData,
        JSON_UNESCAPED_UNICODE
    );

    if ($lineItems === false) {
        $lineItems = '[]';
    }

    $discountValue = normalizeMoney(
        $data['discountValue'] ?? 0
    );

    $discountType = (string)(
        $data['discountType'] ?? 'amount'
    );

    $taxValue = normalizeMoney(
        $data['taxValue'] ?? 0
    );

    $taxType = (string)(
        $data['taxType'] ?? 'amount'
    );

    $shippingValue = normalizeMoney(
        $data['shippingValue'] ?? 0
    );

    $shippingType = (string)(
        $data['shippingType'] ?? 'amount'
    );

    $amountPaid = normalizeMoney(
        $data['amountPaid'] ?? 0
    );

    $subtotal = normalizeMoney(
        $data['subtotal'] ?? 0
    );

    $total = normalizeMoney(
        $data['total'] ?? 0
    );

    $balance = normalizeMoney(
        $data['balance'] ?? 0
    );

    $logoData = $data['uploadedLogoData'] ?? null;

    if ($logoData === '') {
        $logoData = null;
    }

    $pdo->beginTransaction();

    $checkStmt = $pdo->prepare(
        'SELECT id
         FROM invoices
         WHERE user_id = ?
           AND invoice_number = ?
         LIMIT 1'
    );

    $checkStmt->execute([
        $userId,
        $invoiceNumber
    ]);

    $existingInvoice = $checkStmt->fetch(
        PDO::FETCH_ASSOC
    );

    if ($existingInvoice) {

        $invoiceId = (int)$existingInvoice['id'];

        $stmt = $pdo->prepare(
            'UPDATE invoices SET
                bill_from = ?,
                bill_to = ?,
                ship_to = ?,
                invoice_date = ?,
                payment_terms = ?,
                due_date = ?,
                po_number = ?,
                status = ?,
                notes = ?,
                terms = ?,
                notes_heading = ?,
                terms_heading = ?,
                currency = ?,
                line_items = ?,
                discount_value = ?,
                discount_type = ?,
                tax_value = ?,
                tax_type = ?,
                shipping_value = ?,
                shipping_type = ?,
                amount_paid = ?,
                subtotal = ?,
                total = ?,
                balance = ?,
                logo_data = ?
             WHERE id = ?
               AND user_id = ?'
        );

        $stmt->execute([
            $billFrom,
            $billTo,
            $shipTo,
            $invoiceDate,
            $paymentTerms,
            $dueDate,
            $poNumber,
            $status,
            $notes,
            $terms,
            $notesHeading,
            $termsHeading,
            $currency,
            $lineItems,
            $discountValue,
            $discountType,
            $taxValue,
            $taxType,
            $shippingValue,
            $shippingType,
            $amountPaid,
            $subtotal,
            $total,
            $balance,
            $logoData,
            $invoiceId,
            $userId
        ]);

        $pdo->commit();

        jsonResponse(true, [
            'action' => 'updated',
            'id' => $invoiceId,
            'total' => number_format(
                $total,
                2,
                '.',
                ''
            ),
            'balance' => number_format(
                $balance,
                2,
                '.',
                ''
            ),
            'message' => 'Invoice updated successfully.'
        ]);
    }

    $stmt = $pdo->prepare(
        'INSERT INTO invoices (
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
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
            ?, ?, ?, ?, ?
        )'
    );

    $stmt->execute([
        $userId,
        $invoiceNumber,
        $billFrom,
        $billTo,
        $shipTo,
        $invoiceDate,
        $paymentTerms,
        $dueDate,
        $poNumber,
        $status,
        $notes,
        $terms,
        $notesHeading,
        $termsHeading,
        $currency,
        $lineItems,
        $discountValue,
        $discountType,
        $taxValue,
        $taxType,
        $shippingValue,
        $shippingType,
        $amountPaid,
        $subtotal,
        $total,
        $balance,
        $logoData
    ]);

    $newId = (int)$pdo->lastInsertId();

    $pdo->commit();

    jsonResponse(true, [
        'action' => 'created',
        'id' => $newId,
        'total' => number_format(
            $total,
            2,
            '.',
            ''
        ),
        'balance' => number_format(
            $balance,
            2,
            '.',
            ''
        ),
        'message' => 'Invoice created successfully.'
    ]);

} catch (Throwable $e) {

    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    error_log(
        'save_invoice.php error: ' .
        $e->getMessage() .
        ' in ' .
        $e->getFile() .
        ':' .
        $e->getLine()
    );

    jsonResponse(false, [
        'error' => 'Could not save invoice.',
        'details' => $e->getMessage()
    ], 500);
}