<?php

require '../includes/auth.php';
require '../config/db.php';

header('Content-Type: application/json; charset=utf-8');

function jsonResponse($data, $statusCode = 200)
{
    http_response_code($statusCode);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

function normalizeMoney($value)
{
    if ($value === null || $value === '') {
        return '0';
    }

    if (is_numeric($value)) {
        return (string)$value;
    }

    $value = trim((string)$value);
    $value = str_replace(',', '', $value);

    if (preg_match('/-?\d+(?:\.\d+)?/', $value, $matches)) {
        return $matches[0];
    }

    return '0';
}

if (!isLoggedIn()) {
    jsonResponse([
        'success' => false,
        'error' => 'Not logged in.'
    ], 401);
}

try {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!is_array($data)) {
        jsonResponse([
            'success' => false,
            'error' => 'Invalid request data.'
        ], 400);
    }

    $id = (int)($data['id'] ?? 0);
    $userId = (int)($_SESSION['user_id'] ?? 0);

    if (!$id) {
        jsonResponse([
            'success' => false,
            'error' => 'Missing invoice id.'
        ], 400);
    }

    if (!$userId) {
        jsonResponse([
            'success' => false,
            'error' => 'Invalid user session.'
        ], 401);
    }

    $invoiceNumber = trim((string)($data['invoiceNumber'] ?? ''));

    if ($invoiceNumber === '') {
        jsonResponse([
            'success' => false,
            'error' => 'Invoice number is required.'
        ], 400);
    }

    $stmt = $pdo->prepare("
        SELECT id, user_id, invoice_number
        FROM invoices
        WHERE id = ?
          AND user_id = ?
        LIMIT 1
    ");

    $stmt->execute([
        $id,
        $userId
    ]);

    $existingInvoice = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$existingInvoice) {
        jsonResponse([
            'success' => false,
            'error' => 'Invoice not found.'
        ], 404);
    }

    $oldInvoiceNumber = trim(
        (string)($existingInvoice['invoice_number'] ?? '')
    );

    $billFrom = $data['billFrom'] ?? '';
    $billTo = $data['billTo'] ?? '';
    $shipTo = $data['shipTo'] ?? '';

    $invoiceDate = $data['invoiceDate'] ?? '';
    $paymentTerms = $data['paymentTerms'] ?? '';
    $dueDate = $data['dueDate'] ?? '';
    $poNumber = $data['poNumber'] ?? '';

    $notes = $data['notes'] ?? '';
    $terms = $data['terms'] ?? '';

    $notesHeading = $data['notesHeading'] ?? 'Notes';
    $termsHeading = $data['termsHeading'] ?? 'Terms';

    $currency = $data['currency'] ?? 'USD ($)';

    $lineItems = json_encode(
        $data['lineItems'] ?? [],
        JSON_UNESCAPED_UNICODE
    );

    if ($lineItems === false) {
        $lineItems = '[]';
    }

    $discountValue = normalizeMoney($data['discountValue'] ?? '0');
    $discountType = $data['discountType'] ?? 'amount';

    $taxValue = normalizeMoney($data['taxValue'] ?? '0');
    $taxType = $data['taxType'] ?? 'amount';

    $shippingValue = normalizeMoney($data['shippingValue'] ?? '0');
    $shippingType = $data['shippingType'] ?? 'amount';

    $amountPaid = normalizeMoney($data['amountPaid'] ?? '0');
    $subtotal = normalizeMoney($data['subtotal'] ?? '0');
    $total = normalizeMoney($data['total'] ?? '0');
    $balance = normalizeMoney($data['balance'] ?? '0');

    $logoData = $data['uploadedLogoData'] ?? null;

    $rawIsScheduled =
        $data['isScheduled']
        ?? $data['is_scheduled']
        ?? $data['scheduled']
        ?? false;

    if (
        $rawIsScheduled === true ||
        $rawIsScheduled === 1 ||
        $rawIsScheduled === '1' ||
        strtolower(trim((string)$rawIsScheduled)) === 'true' ||
        strtolower(trim((string)$rawIsScheduled)) === 'yes' ||
        strtolower(trim((string)$rawIsScheduled)) === 'on'
    ) {
        $isScheduled = 1;
    } else {
        $isScheduled = 0;
    }

    $scheduleFrequency = trim(
        (string)(
            $data['scheduleFrequency']
            ?? $data['schedule_frequency']
            ?? ''
        )
    );

    $customerEmail = trim(
        (string)(
            $data['customerEmail']
            ?? $data['customer_email']
            ?? ''
        )
    );

    if ($isScheduled === 0) {
        $scheduleFrequency = null;
        $customerEmail = null;
    }

    $pdo->beginTransaction();

    if ($oldInvoiceNumber === $invoiceNumber) {

        $stmt = $pdo->prepare("
            UPDATE invoices SET

                invoice_number = ?,

                is_scheduled = ?,
                schedule_frequency = ?,
                customer_email = ?,

                bill_from = ?,
                bill_to = ?,
                ship_to = ?,

                invoice_date = ?,
                payment_terms = ?,
                due_date = ?,
                po_number = ?,

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
              AND user_id = ?
        ");

        $stmt->execute([
            $invoiceNumber,

            $isScheduled,
            $scheduleFrequency,
            $customerEmail,

            $billFrom,
            $billTo,
            $shipTo,

            $invoiceDate,
            $paymentTerms,
            $dueDate,
            $poNumber,

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

            $id,
            $userId
        ]);

        if ($isScheduled === 1) {

            $scheduledCheck = $pdo->prepare("
                SELECT id
                FROM scheduled_invoices
                WHERE original_invoice_id = ?
                  AND user_id = ?
                LIMIT 1
            ");

            $scheduledCheck->execute([
                $id,
                $userId
            ]);

            $scheduledInvoice = $scheduledCheck->fetch(PDO::FETCH_ASSOC);

            if ($scheduledInvoice) {

                $scheduledUpdate = $pdo->prepare("
                    UPDATE scheduled_invoices SET

                        invoice_number = ?,

                        is_scheduled = ?,
                        schedule_frequency = ?,
                        customer_email = ?,

                        bill_from = ?,
                        bill_to = ?,
                        ship_to = ?,

                        invoice_date = ?,
                        payment_terms = ?,
                        due_date = ?,
                        po_number = ?,

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
                      AND user_id = ?
                ");

                $scheduledUpdate->execute([
                    $invoiceNumber,

                    $isScheduled,
                    $scheduleFrequency,
                    $customerEmail,

                    $billFrom,
                    $billTo,
                    $shipTo,

                    $invoiceDate,
                    $paymentTerms,
                    $dueDate,
                    $poNumber,

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

                    $scheduledInvoice['id'],
                    $userId
                ]);

            } else {

                $scheduledInsert = $pdo->prepare("
                    INSERT INTO scheduled_invoices (
                        user_id,
                        original_invoice_id,
                        invoice_number,
                        is_scheduled,
                        schedule_frequency,
                        customer_email,
                        bill_from,
                        bill_to,
                        ship_to,
                        invoice_date,
                        payment_terms,
                        due_date,
                        po_number,
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
                        ?, ?, ?, ?, ?, ?,
                        ?, ?, ?,
                        ?, ?, ?, ?,
                        ?, ?, ?, ?,
                        ?, ?,
                        ?, ?,
                        ?, ?,
                        ?, ?,
                        ?, ?, ?, ?,
                        ?
                    )
                ");

                $scheduledInsert->execute([
                    $userId,
                    $id,
                    $invoiceNumber,

                    $isScheduled,
                    $scheduleFrequency,
                    $customerEmail,

                    $billFrom,
                    $billTo,
                    $shipTo,

                    $invoiceDate,
                    $paymentTerms,
                    $dueDate,
                    $poNumber,

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
            }

        } else {

            $scheduledDelete = $pdo->prepare("
                DELETE FROM scheduled_invoices
                WHERE original_invoice_id = ?
                  AND user_id = ?
            ");

            $scheduledDelete->execute([
                $id,
                $userId
            ]);
        }

        $pdo->commit();

        jsonResponse([
            'success' => true,
            'action' => 'updated',
            'id' => $id,
            'user_id' => $userId,
            'invoice_number' => $invoiceNumber,
            'is_scheduled' => $isScheduled,
            'schedule_frequency' => $scheduleFrequency,
            'customer_email' => $customerEmail,
            'total' => $total,
            'balance' => $balance
        ]);
    }

    $stmt = $pdo->prepare("
        INSERT INTO invoices (
            user_id,
            invoice_number,
            is_scheduled,
            schedule_frequency,
            customer_email,
            bill_from,
            bill_to,
            ship_to,
            invoice_date,
            payment_terms,
            due_date,
            po_number,
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
            ?, ?, ?, ?, ?,
            ?, ?, ?,
            ?, ?, ?, ?,
            ?, ?, ?, ?,
            ?, ?,
            ?, ?,
            ?, ?,
            ?, ?,
            ?, ?, ?, ?,
            ?
        )
    ");

    $stmt->execute([
        $userId,
        $invoiceNumber,

        $isScheduled,
        $scheduleFrequency,
        $customerEmail,

        $billFrom,
        $billTo,
        $shipTo,

        $invoiceDate,
        $paymentTerms,
        $dueDate,
        $poNumber,

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

    if ($isScheduled === 1) {

        $scheduledInsert = $pdo->prepare("
            INSERT INTO scheduled_invoices (
                user_id,
                original_invoice_id,
                invoice_number,
                is_scheduled,
                schedule_frequency,
                customer_email,
                bill_from,
                bill_to,
                ship_to,
                invoice_date,
                payment_terms,
                due_date,
                po_number,
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
                ?, ?, ?, ?, ?, ?,
                ?, ?, ?,
                ?, ?, ?, ?,
                ?, ?, ?, ?,
                ?, ?,
                ?, ?,
                ?, ?,
                ?, ?,
                ?, ?, ?, ?,
                ?
            )
        ");

        $scheduledInsert->execute([
            $userId,
            $newId,
            $invoiceNumber,

            $isScheduled,
            $scheduleFrequency,
            $customerEmail,

            $billFrom,
            $billTo,
            $shipTo,

            $invoiceDate,
            $paymentTerms,
            $dueDate,
            $poNumber,

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
    }

    $scheduledDeleteOld = $pdo->prepare("
        DELETE FROM scheduled_invoices
        WHERE original_invoice_id = ?
          AND user_id = ?
    ");

    $scheduledDeleteOld->execute([
        $id,
        $userId
    ]);

    $pdo->commit();

    jsonResponse([
        'success' => true,
        'action' => 'created',
        'old_id' => $id,
        'new_id' => $newId,
        'user_id' => $userId,
        'old_invoice_number' => $oldInvoiceNumber,
        'invoice_number' => $invoiceNumber,
        'is_scheduled' => $isScheduled,
        'schedule_frequency' => $scheduleFrequency,
        'customer_email' => $customerEmail,
        'total' => $total,
        'balance' => $balance
    ]);

} catch (Throwable $e) {

    if (isset($pdo) && $pdo instanceof PDO && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    error_log(
        'update_invoice.php: ' .
        $e->getMessage() .
        ' in ' .
        $e->getFile() .
        ':' .
        $e->getLine()
    );

    jsonResponse([
        'success' => false,
        'error' => 'Unable to update invoice.',
        'details' => $e->getMessage()
    ], 500);
}