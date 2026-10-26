<?php
// public-invoice.php
require 'config/db.php';

$token = $_GET['token'] ?? '';

$stmt = $pdo->prepare(
    'SELECT s.recipient_name, i.*, u.first_name, u.last_name
     FROM invoice_sends s
     JOIN invoices i ON i.id = s.invoice_id
     JOIN users u ON u.id = s.user_id
     WHERE s.view_token = ?'
);
$stmt->execute([$token]);
$row = $stmt->fetch();

if (!$row) {
    http_response_code(404);
    die('This invoice link is invalid or has expired.');
}

$senderName = trim($row['first_name'] . ' ' . $row['last_name']);

$invoiceData = [
    'invoiceNumber' => $row['invoice_number'],
    'billFrom'      => $row['bill_from'],
    'billTo'        => $row['bill_to'],
    'shipTo'        => $row['ship_to'],
    'invoiceDate'   => $row['invoice_date'],
    'paymentTerms'  => $row['payment_terms'],
    'dueDate'       => $row['due_date'],
    'poNumber'      => $row['po_number'],
    'notes'         => $row['notes'],
    'terms'         => $row['terms'],
    'notesHeading'  => $row['notes_heading'],
    'termsHeading'  => $row['terms_heading'],
    'currency'      => $row['currency'],
    'lineItems'     => json_decode($row['line_items'] ?? '[]', true) ?: [],
    'discountValue' => $row['discount_value'],
    'discountType'  => $row['discount_type'],
    'taxValue'      => $row['tax_value'],
    'taxType'       => $row['tax_type'],
    'shippingValue' => $row['shipping_value'],
    'shippingType'  => $row['shipping_type'],
    'amountPaid'    => $row['amount_paid'],
    'subtotal'      => $row['subtotal'],
    'total'         => $row['total'],
    'balance'       => $row['balance'],
    'uploadedLogoData' => $row['logo_data'],
];
$pageTitle = 'Invoice #' . ($invoiceData['invoiceNumber'] ?: $row['id']) . ' - invoicescheduler.com';
$pageBodyAttributes = ' class="bg-gray-100 dark:bg-dark-bg min-h-screen py-8 px-4 transition-colors duration-200"';
$pageHeader = 'none';
$pageExtraHead = <<<'HTML'
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
<script>
  tailwind.config = {
    darkMode: 'class',
    theme: {
      extend: {
        colors: {
          brand: { green: '#1AA260', greenDark: '#0E8A4E' },
          ink: '#1E2838',
          dark: { bg: '#0B1220', card: '#141d33', field: '#1c2740', border: '#2a3650', text: '#e7ebf3', muted: '#8492ac' },
        }
      }
    }
  }
</script>
<style>body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif; }</style>
HTML;
require __DIR__ . '/includes/meta.php';
require __DIR__ . '/includes/header.php';
?>

  <div class="max-w-[1100px] mx-auto flex justify-end gap-3 mb-4">
    <button id="langBtn" class="w-8 h-8 flex items-center justify-center rounded bg-gray-800 dark:bg-dark-field text-white text-[10px] font-bold hover:opacity-80 transition">文A</button>
    <button id="themeToggle" class="w-8 h-8 flex items-center justify-center bg-white dark:bg-dark-card border border-gray-200 dark:border-dark-border rounded text-gray-500 dark:text-dark-muted hover:text-ink dark:hover:text-dark-text transition">
      <svg id="iconSun" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1.5M12 19.5V21M4.22 4.22l1.06 1.06M18.72 18.72l1.06 1.06M3 12h1.5M19.5 12H21M4.22 19.78l1.06-1.06M18.72 5.28l1.06-1.06M12 7.5a4.5 4.5 0 100 9 4.5 4.5 0 000-9z"/></svg>
      <svg id="iconMoon" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/></svg>
    </button>
  </div>

  <div class="max-w-[1100px] mx-auto flex flex-col lg:flex-row gap-6 items-start">
    <div id="invoiceRender" class="flex-1 w-full bg-white dark:bg-dark-card border border-gray-200 dark:border-dark-border rounded-lg shadow-sm overflow-hidden"></div>

    <aside class="w-full lg:w-72 flex-shrink-0">
      <div class="bg-white dark:bg-dark-card border border-gray-200 dark:border-dark-border rounded-lg shadow-sm p-5">
        <p id="publicInvoiceFrom" class="text-sm text-gray-500 dark:text-dark-muted mb-1" data-number="<?= htmlspecialchars($invoiceData['invoiceNumber'] ?: $row['id']) ?>" data-sender="<?= htmlspecialchars($senderName) ?>">Invoice #<?= htmlspecialchars($invoiceData['invoiceNumber'] ?: $row['id']) ?> from <?= htmlspecialchars($senderName) ?></p>
        <p class="text-xs text-gray-500 dark:text-dark-muted uppercase tracking-wide mb-1 mt-4" data-i18n="invoice.amountDue">Amount Due</p>
        <p class="text-2xl font-bold text-ink dark:text-dark-text mb-4"><?= htmlspecialchars($invoiceData['balance'] ?: $invoiceData['total']) ?></p>
        <p class="text-sm text-gray-500 dark:text-dark-muted mb-4" data-i18n="invoice.publicNoPayment">Online payment is not available for this invoice.</p>
        <button id="downloadBtn" class="w-full inline-flex items-center justify-center gap-2 border border-gray-300 dark:border-dark-border text-ink dark:text-dark-text text-sm font-semibold px-4 py-2.5 rounded-md hover:bg-gray-50 dark:hover:bg-dark-border">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3"/></svg>
          <span data-i18n="actions.downloadInvoice">Download invoice</span>
        </button>
      </div>
    </aside>
  </div>

  <div id="printInvoice" style="position:absolute; left:-9999px; top:0; width:210mm;"></div>

  <script src="assets/invoice-pdf.js"></script>
  <script src="assets/theme-lang.js"></script>
  <script>
    const invoiceData = <?= json_encode($invoiceData) ?>;
    const i18n = () => window.InvoiceGenI18n;
    const tr = (key, vars) => i18n()?.t(key, vars) || key;

    function translateDynamicText() {
      const from = document.getElementById('publicInvoiceFrom');
      from.textContent = tr('invoice.publicFrom', { number: from.dataset.number, sender: from.dataset.sender });
    }

    function currentTheme() {
      if (document.documentElement.classList.contains('dark')) return 'dark';
      const saved = localStorage.getItem('invoicegen-theme');
      if (saved) return saved;
      return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
    }

    document.getElementById('invoiceRender').innerHTML = InvoicePdf.renderHtml(invoiceData, currentTheme());
    translateDynamicText();

    document.getElementById('themeToggle')?.addEventListener('click', () => {
      setTimeout(() => {
        document.getElementById('invoiceRender').innerHTML = InvoicePdf.renderHtml(invoiceData, currentTheme());
      }, 0);
    });

    document.getElementById('downloadBtn').addEventListener('click', () => {
      InvoicePdf.download(invoiceData, document.getElementById('printInvoice'), `invoice-${invoiceData.invoiceNumber || 'download'}.pdf`);
    });
    window.addEventListener('invoicegen:languagechange', () => {
      document.getElementById('invoiceRender').innerHTML = InvoicePdf.renderHtml(invoiceData, currentTheme());
      translateDynamicText();
    });
  </script>

<?php require __DIR__ . '/includes/footer.php'; ?>
