<?php
$pageTitle = 'Send by Email - invoicescheduler.com';
$pageBodyAttributes = ' class="bg-gray-100 dark:bg-dark-bg min-h-screen transition-colors duration-200"';
$pageHeader = 'send-invoice';
$pageExtraHead = <<<'HTML'
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
<script>
  tailwind.config = {
    darkMode: 'class',
    theme: {
      extend: {
        colors: {
          brand: { green: '#1AA260', greenDark: '#0E8A4E', greenSoft: '#DFF6E7' },
          ink: '#1E2838',
          dark: { bg: '#0B1220', card: '#141d33', field: '#1c2740', border: '#2a3650', text: '#e7ebf3', muted: '#8492ac' },
        }
      }
    }
  }
</script>
<style>
  body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif; }
  .field {
    border: 1px solid #D1D5DB; border-radius: 4px; padding: 0.6rem 0.85rem;
    font-size: 0.9rem; background-color: #fff; color: #1E2838;
  }
  .field:focus { outline: none; box-shadow: 0 0 0 1px #1AA260; border-color: #1AA260; }
  .dark .field { background-color: #1c2740; border-color: #2a3650; color: #e7ebf3; }
  .dropdown-menu { display: none; }
  .dropdown.open .dropdown-menu { display: block; }
</style>
HTML;
require __DIR__ . '/includes/meta.php';
require __DIR__ . '/includes/header.php';
?>
<main class="max-w-[1200px] mx-auto px-6 py-8">
    <div id="loadingState" class="text-center text-gray-400 dark:text-dark-muted text-sm py-16" data-i18n="invoice.loading">Loading invoice...</div>

    <div id="content" class="hidden bg-white dark:bg-dark-card border border-gray-200 dark:border-dark-border rounded-lg shadow-sm p-8">
      <h1 class="text-2xl font-bold text-ink dark:text-dark-text mb-1" data-i18n="send.title">Send by Email</h1>
      <div id="metaLine" class="text-sm text-gray-500 dark:text-dark-muted mb-6"></div>

      <div class="flex flex-col lg:flex-row gap-10">
        <form id="sendForm" class="flex-1 space-y-5">
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
              <label class="block text-sm text-ink dark:text-dark-text mb-1" data-i18n="send.recipientEmail">Recipient Email</label>
              <input id="recipientEmail" type="email" required placeholder="customer@example.com" class="field w-full">
              <p class="text-xs text-gray-500 dark:text-dark-muted mt-1" data-i18n="send.emailHelp">The email address where the document will be sent.</p>
            </div>
            <div>
              <label class="block text-sm text-ink dark:text-dark-text mb-1" data-i18n="send.recipientName">Recipient Name</label>
              <input id="recipientName" type="text" class="field w-full">
            </div>
          </div>
          <div>
            <label class="block text-sm text-ink dark:text-dark-text mb-1" data-i18n="send.message">Message</label>
            <textarea id="message" rows="5" placeholder="Add a personal message (optional)" class="field w-full resize-none" data-i18n-placeholder="send.messagePlaceholder"></textarea>
            <p class="text-xs text-gray-500 dark:text-dark-muted mt-1" data-i18n="send.messageHelp">Add a personal message to include in the email (optional).</p>
          </div>
          <div class="flex gap-3 pt-2">
            <button id="sendEmailBtn" type="submit" class="inline-flex items-center gap-2 bg-brand-green hover:bg-brand-greenDark text-white text-sm font-semibold px-5 py-2.5 rounded-md">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.769 59.769 0 0121.485 12 59.768 59.768 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg>
              <span id="sendEmailBtnLabel" data-i18n="send.sendEmail">Send Email</span>
            </button>
            <a id="cancelBtn" href="#" class="inline-flex items-center gap-2 border border-gray-300 dark:border-dark-border text-ink dark:text-dark-text text-sm font-semibold px-5 py-2.5 rounded-md hover:bg-gray-50 dark:hover:bg-dark-border" data-i18n="actions.cancel">Cancel</a>
          </div>
        </form>

        <aside class="w-full lg:w-72 flex-shrink-0">
          <p class="text-xs text-gray-500 dark:text-dark-muted uppercase tracking-wide mb-2" data-i18n="send.includes">The email will include</p>
          <ul class="text-sm text-gray-700 dark:text-dark-muted space-y-2 mb-6">
            <li class="flex items-center gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
              <span data-i18n="send.includeLink">Link to view and pay Invoice</span>
            </li>
            <li class="flex items-center gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
              <span data-i18n="send.includePdf">Invoice as a PDF attachment</span>
            </li>
            <li class="flex items-center gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
              <span data-i18n="send.includeReply">Your email as the reply-to address</span>
            </li>
          </ul>
          <div class="border-l-2 border-brand-green pl-3">
            <p class="text-sm text-ink dark:text-dark-text"><span id="remainingCount" class="font-bold">5</span> / <span id="limitCount">5</span></p>
            <p id="remainingText" class="text-sm text-gray-500 dark:text-dark-muted">You have <span id="remainingCount2">5</span> of <span id="limitCount2">5</span> email sends remaining this month.</p>
          </div>
        </aside>
      </div>
    </div>
  </main>

  <div id="printInvoice" style="position:absolute; left:-9999px; top:0; width:210mm;"></div>

  <script src="assets/invoice-pdf.js"></script>
  <script src="assets/theme-lang.js"></script>
  <script>
 const params = new URLSearchParams(window.location.search);
const invoiceNumber = params.get('send');
let invoiceId = null;
let invoiceData = null;
    let sendQuota = { remaining: 5, limit: 5 };
    const i18n = () => window.InvoiceGenI18n;
    const tr = (key, vars) => i18n()?.t(key, vars) || key;

    async function checkSession() {
      const res = await fetch('api/session_check.php');
      if (!res.ok) { window.location.href = 'signin'; return; }
      const data = await res.json();
      document.getElementById('userInitials').textContent = data.initials;
      document.getElementById('userName').textContent = `${data.firstName}.${data.lastName ? data.lastName[0].toLowerCase() : ''}`;
      document.getElementById('userNameFull').textContent = `${data.firstName} ${data.lastName}`.trim();
      document.getElementById('userEmail').textContent = data.email;
    }
    checkSession();

    document.addEventListener('click', (e) => {
      const toggle = e.target.closest('.dropdown-toggle');
      if (toggle) {
        e.stopPropagation();
        const dropdown = toggle.closest('.dropdown');
        const wasOpen = dropdown.classList.contains('open');
        document.querySelectorAll('.dropdown.open').forEach(d => d.classList.remove('open'));
        if (!wasOpen) dropdown.classList.add('open');
        return;
      }
      document.querySelectorAll('.dropdown.open').forEach(d => d.classList.remove('open'));
    });

async function loadInvoice() {
    if (!invoiceNumber) {
        console.error('❌ Invoice number is missing');
        return;
    }

    try {
        console.log('Loading invoice:', invoiceNumber);

        const invoiceUrl =
    `api/get_invoice_email.php?invoice_number=${encodeURIComponent(invoiceNumber)}`;

        const invRes = await fetch(invoiceUrl);

        if (!invRes.ok) {
            console.error('Invoice API failed:', invRes.status);
            return;
        }

        invoiceData = await invRes.json();

    

        invoiceId = invoiceData.id;

        if (!invoiceId) {
            console.error('❌ Invoice ID is missing:', invoiceData);
            return;
        }

        document
            .getElementById('loadingState')
            .classList
            .add('hidden');

        document
            .getElementById('content')
            .classList
            .remove('hidden');

        const customer =
            (invoiceData.billTo || '')
                .split('\n')[0]
                .trim();

        document
            .getElementById('metaLine')
            .textContent =
            `Invoice #${invoiceData.invoiceNumber || invoiceNumber} · ` +
            `${customer} · ` +
            `${invoiceData.invoiceDate || ''} · ` +
            `${invoiceData.total || ''}`;

        document
            .getElementById('recipientName')
            .value = customer;

        document
            .getElementById('cancelBtn')
            .href =
            `invoice-view?id=${invoiceId}`;

    } catch (err) {
        console.error('❌ loadInvoice error:', err);
    }
}

    document.getElementById('sendForm').addEventListener('submit', async (e) => {
      e.preventDefault();
      const btn = document.getElementById('sendEmailBtn');
      const label = document.getElementById('sendEmailBtnLabel');
      btn.disabled = true;
      label.textContent = tr('send.sending');

      try {
        const pdfBase64 = await InvoicePdf.getBase64(invoiceData, document.getElementById('printInvoice'));
        const res = await fetch('api/send_invoice.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({
            invoiceId,
            recipientEmail: document.getElementById('recipientEmail').value.trim(),
            recipientName: document.getElementById('recipientName').value.trim(),
            message: document.getElementById('message').value.trim(),
            pdfBase64,
          })
        });
        const data = await res.json();
        if (!res.ok) {
          alert(data.error || tr('alert.sendFailed'));
          btn.disabled = false;
          label.textContent = tr('send.sendEmail');
          return;
        }
        if (data.warning) alert(data.warning);
       window.location.href = 'dashboard';
      } catch (err) {
        alert(tr('alert.sendError'));
        btn.disabled = false;
        label.textContent = tr('send.sendEmail');
      }
    });

    window.addEventListener('invoicegen:languagechange', () => {
      document.getElementById('remainingText').textContent = tr('send.remaining', sendQuota);
    });

    loadInvoice();
  </script>
<?php require __DIR__ . '/includes/footer.php'; ?>
