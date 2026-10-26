<?php
// api/get_invoices.php

require '../includes/auth.php';
require '../config/db.php';

header('Content-Type: application/json; charset=utf-8');

// --------------------------------------------------
// Authentication
// --------------------------------------------------

if (!isLoggedIn()) {
    http_response_code(401);

    echo json_encode([
        'error' => 'Not logged in.'
    ]);

    exit;
}


// --------------------------------------------------
// Current user
// --------------------------------------------------

$userId = (int) $_SESSION['user_id'];


// --------------------------------------------------
// View
// active = normal invoices
// deleted = deleted invoices
// --------------------------------------------------

$view = ($_GET['view'] ?? '') === 'deleted'
    ? 'deleted'
    : 'active';


// --------------------------------------------------
// Per-page
// --------------------------------------------------

$allowedPerPage = [10, 25, 50, 100];

$requestedPerPage = (int) ($_GET['per_page'] ?? 25);

$perPage = in_array(
    $requestedPerPage,
    $allowedPerPage,
    true
)
    ? $requestedPerPage
    : 25;


try {

    // --------------------------------------------------
    // TOTAL RECORDS
    // This counts ALL invoices for the current user.
    // It is NOT limited by per_page.
    // --------------------------------------------------

    if ($view === 'deleted') {

        $countSql = "
            SELECT COUNT(*)
            FROM invoices
            WHERE user_id = ?
              AND deleted_at IS NOT NULL
        ";

    } else {

        $countSql = "
            SELECT COUNT(*)
            FROM invoices
            WHERE user_id = ?
              AND deleted_at IS NULL
        ";
    }


    $countStmt = $pdo->prepare($countSql);

    $countStmt->execute([
        $userId
    ]);

    $totalRecords = (int) $countStmt->fetchColumn();


    // --------------------------------------------------
    // GET PAGINATED INVOICES
    // --------------------------------------------------

    if ($view === 'deleted') {

        $sql = "
            SELECT *
            FROM invoices
            WHERE user_id = ?
              AND deleted_at IS NOT NULL
            ORDER BY deleted_at DESC
            LIMIT ?
        ";

    } else {

        $sql = "
            SELECT *
            FROM invoices
            WHERE user_id = ?
              AND deleted_at IS NULL
            ORDER BY created_at DESC
            LIMIT ?
        ";
    }


    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(
        1,
        $userId,
        PDO::PARAM_INT
    );

    $stmt->bindValue(
        2,
        $perPage,
        PDO::PARAM_INT
    );

    $stmt->execute();

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);


    // --------------------------------------------------
    // Date formatter
    // --------------------------------------------------

    function fmtDate($value)
    {
        if (!$value) {
            return '';
        }

        $ts = strtotime($value);

        return $ts
            ? date('j M Y', $ts)
            : $value;
    }


    // --------------------------------------------------
    // Format invoice data
    // --------------------------------------------------

    $invoices = array_map(
        function ($inv) {

            return [

                // --------------------------------------
                // Basic
                // --------------------------------------

                'id' => (int) $inv['id'],

                'invoiceNumber' =>
                    !empty($inv['invoice_number'])
                        ? $inv['invoice_number']
                        : 'INV-' . str_pad(
                            $inv['id'],
                            4,
                            '0',
                            STR_PAD_LEFT
                        ),


                // --------------------------------------
                // Customer / Addresses
                // --------------------------------------

                'billFrom' =>
                    $inv['bill_from'] ?? '',

                'billTo' =>
                    $inv['bill_to'] ?? '',

                'shipTo' =>
                    $inv['ship_to'] ?? '',


                // --------------------------------------
                // Dates
                // --------------------------------------

                'invoiceDate' =>
                    fmtDate(
                        $inv['invoice_date'] ?? ''
                    ),

                'dueDate' =>
                    fmtDate(
                        $inv['due_date'] ?? ''
                    ),


                // --------------------------------------
                // Payment information
                // --------------------------------------

                'paymentTerms' =>
                    $inv['payment_terms'] ?? '',

                'poNumber' =>
                    $inv['po_number'] ?? '',


                // --------------------------------------
                // Status
                // --------------------------------------

                'status' =>
                    !empty($inv['status'])
                        ? $inv['status']
                        : 'Open',

           'isScheduled' => (int) ($inv['is_scheduled'] ?? 0),
'scheduleFrequency' => $inv['schedule_frequency'] ?? '',
'customerEmail' => $inv['customer_email'] ?? '',
                // --------------------------------------
                // Notes
                // --------------------------------------

                'notes' =>
                    $inv['notes'] ?? '',

                'terms' =>
                    $inv['terms'] ?? '',


                // --------------------------------------
                // Currency
                // --------------------------------------

                'currency' =>
                    $inv['currency'] ?? '',


                // --------------------------------------
                // Amounts
                // --------------------------------------

                'subtotal' =>
                    $inv['subtotal'] ?? '',

                'discountValue' =>
                    $inv['discount_value'] ?? '',

                'discountType' =>
                    $inv['discount_type'] ?? '',

                'taxValue' =>
                    $inv['tax_value'] ?? '',

                'taxType' =>
                    $inv['tax_type'] ?? '',

                'shippingValue' =>
                    $inv['shipping_value'] ?? '',

                'shippingType' =>
                    $inv['shipping_type'] ?? '',

                'amountPaid' =>
                    $inv['amount_paid'] ?? '',

                'total' =>
                    $inv['total'] ?? '',

                'balance' =>
                    $inv['balance'] ?? '',


                // --------------------------------------
                // Deleted flag
                // --------------------------------------

                'deleted' =>
                    !empty($inv['deleted_at'])
            ];
        },
        $rows
    );


    // --------------------------------------------------
    // JSON RESPONSE
    // --------------------------------------------------

    echo json_encode([

        'view' =>
            $view,

        'perPage' =>
            $perPage,

        'totalRecords' =>
            $totalRecords,

        'invoices' =>
            $invoices

    ]);


} catch (Throwable $e) {

    http_response_code(500);

    echo json_encode([

        'error' =>
            'Failed to load invoices.',

        'message' =>
            $e->getMessage()

    ]);

    exit;
}