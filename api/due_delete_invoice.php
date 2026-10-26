
<?php

require '../includes/auth.php';
require '../config/db.php';

header('Content-Type: application/json');

/**
 * JSON response
 */
function jsonResponse($success, $data = [], $statusCode = 200)
{
    http_response_code($statusCode);

    echo json_encode(
        array_merge(['success' => $success], $data)
    );

    exit;
}

/**
 * Check login
 */
if (!isLoggedIn()) {
    jsonResponse(false, [
        'error' => 'Not logged in.'
    ], 401);
}

$userId = (int)($_SESSION['user_id'] ?? 0);

if ($userId <= 0) {
    jsonResponse(false, [
        'error' => 'Invalid user session.'
    ], 401);
}

/**
 * POST only
 */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(false, [
        'error' => 'Invalid request method.'
    ], 405);
}

/**
 * Get invoice ID
 */
$data = json_decode(file_get_contents('php://input'), true);

$id = (int)($data['id'] ?? 0);

if ($id <= 0) {
    jsonResponse(false, [
        'error' => 'Invalid invoice ID.'
    ], 400);
}

try {

    // Start transaction
    $pdo->beginTransaction();

    /**
     * 1. Verify invoice belongs to logged-in user
     */
    $checkInvoice = $pdo->prepare(
        'SELECT id
         FROM invoices
         WHERE id = ?
           AND user_id = ?
         FOR UPDATE'
    );

    $checkInvoice->execute([
        $id,
        $userId
    ]);

    if (!$checkInvoice->fetch(PDO::FETCH_ASSOC)) {

        $pdo->rollBack();

        jsonResponse(false, [
            'error' => 'Invoice not found.'
        ], 404);
    }

    /**
     * 2. Delete invoice recreation logs
     *
     * source_invoice_id:
     * Original invoice that was recreated
     *
     * new_invoice_id:
     * Invoice created by recreation
     */
    $deleteRecreationLogs = $pdo->prepare(
        'DELETE FROM invoice_recreation_logs
         WHERE source_invoice_id = ?
            OR new_invoice_id = ?'
    );

    $deleteRecreationLogs->execute([
        $id,
        $id
    ]);

    /**
     * 3. Delete invoice reminder logs
     */
    $deleteReminderLogs = $pdo->prepare(
        'DELETE FROM invoice_reminder_logs
         WHERE invoice_id = ?'
    );

    $deleteReminderLogs->execute([
        $id
    ]);

    /**
     * 4. Delete invoice send records
     */
    $deleteInvoiceSends = $pdo->prepare(
        'DELETE FROM invoice_sends
         WHERE invoice_id = ?'
    );

    $deleteInvoiceSends->execute([
        $id
    ]);

    /**
     * 5. Delete invoice permanently
     */
    $deleteInvoice = $pdo->prepare(
        'DELETE FROM invoices
         WHERE id = ?
           AND user_id = ?'
    );

    $deleteInvoice->execute([
        $id,
        $userId
    ]);

    if ($deleteInvoice->rowCount() === 0) {
        throw new Exception('Invoice deletion failed.');
    }

    /**
     * Commit all database changes
     */
    $pdo->commit();

    jsonResponse(true, [
        'message' => 'Invoice and related records permanently deleted.',
        'id' => $id
    ]);

} catch (Throwable $e) {

    /**
     * Rollback if any query fails
     */
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    error_log(
        'Permanent invoice delete error: ' . $e->getMessage()
    );

    jsonResponse(false, [
        'error' => 'Delete failed. Database changes rolled back.'
    ], 500);
}
