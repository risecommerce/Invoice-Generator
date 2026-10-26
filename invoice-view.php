<?php
$pageTitle = 'Invoice - invoicescheduler.com';
$pageBodyAttributes = ' class="bg-gray-100 dark:bg-dark-bg min-h-screen transition-colors duration-200"';
$pageHeader = 'invoice-view';
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
  .dropdown-menu { display: none; }
  .dropdown.open .dropdown-menu { display: block; }
</style>
HTML;
require __DIR__ . '/includes/meta.php';
require __DIR__ . '/includes/header.php';
?>
<!-- Header -->
  

  <main class="max-w-[1200px] mx-auto px-6 py-8">
    <div id="loadingState" class="text-center text-gray-400 dark:text-dark-muted text-sm py-16" data-i18n="invoice.loading">Loading invoice...</div>

    <div id="content" class="hidden">
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-4">
        <div>
          <div class="flex items-center gap-3">
            <h1 id="invoiceTitle" class="text-2xl font-bold text-ink dark:text-dark-text"></h1>
            <span id="statusBadge"></span>
          </div>
          <div id="metaLine" class="text-sm text-gray-500 dark:text-dark-muted mt-1"></div>
        </div>
        <div class="flex gap-3">
          <a id="sendBtn" href="#" class="inline-flex items-center gap-2 bg-brand-green hover:bg-brand-greenDark text-white text-sm font-semibold px-4 py-2 rounded-md">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.769 59.769 0 0121.485 12 59.768 59.768 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg>
            <span data-i18n="actions.send">Send</span>
          </a>
          <button id="downloadBtn" class="inline-flex items-center gap-2 border border-gray-300 dark:border-dark-border text-ink dark:text-dark-text text-sm font-semibold px-4 py-2 rounded-md hover:bg-gray-50 dark:hover:bg-dark-border">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3"/></svg>
            <span data-i18n="actions.download">Download</span>
          </button>
        
        </div>
      </div>

      <div class="flex flex-col lg:flex-row gap-6 items-start">
        <div id="invoiceRender" class="flex-1 w-full bg-white dark:bg-dark-card border border-gray-200 dark:border-dark-border rounded-lg shadow-sm overflow-hidden"></div>

        <aside class="w-full lg:w-72 flex-shrink-0 space-y-4">
          <div class="bg-white dark:bg-dark-card border border-gray-200 dark:border-dark-border rounded-lg shadow-sm p-5">
            <p class="text-xs text-gray-500 dark:text-dark-muted uppercase tracking-wide mb-1" data-i18n="invoice.amountDue">Amount Due</p>
            <p id="amountDue" class="text-2xl font-bold text-ink dark:text-dark-text mb-4"></p>
            <hr class="border-gray-200 dark:border-dark-border mb-4">
            <p class="text-xs text-gray-500 dark:text-dark-muted uppercase tracking-wide mb-1" data-i18n="invoice.dueDate">Due Date</p>
            <p id="dueDateVal" class="text-sm text-ink dark:text-dark-text mb-3"></p>
            <div class="flex justify-between text-sm text-gray-600 dark:text-dark-muted">
              <span data-i18n="invoice.total">Total</span>
              <span id="totalVal" class="text-ink dark:text-dark-text"></span>
            </div>
          </div>

          <div class="bg-blue-50 dark:bg-blue-950/20 border border-blue-100 dark:border-blue-900 rounded-lg p-5">
            <p id="collectFasterText" class="font-semibold text-ink dark:text-dark-text mb-1">Collect <span id="collectAmount"></span> faster</p>
            <p class="text-sm text-gray-600 dark:text-dark-muted mb-3" data-i18n="invoice.noOnlinePayments">This invoice does not accept online payments yet.</p>
            <ul class="text-sm text-gray-600 dark:text-dark-muted space-y-1 mb-4 list-disc list-inside">
              <li data-i18n="invoice.acceptCard">Accept card and bank payments</li>
              <li data-i18n="invoice.securePay">Give clients a secure way to pay</li>
              <li data-i18n="invoice.trackStatus">Track payment status automatically</li>
            </ul>
            <!-- Placeholder: payments flow not yet defined -->
            <button class="w-full inline-flex items-center justify-center gap-1 bg-brand-green hover:bg-brand-greenDark text-white text-sm font-semibold px-4 py-2 rounded-md">
              <span data-i18n="dashboard.enablePayments">Enable payments</span>
              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </button>
          </div>

          <div class="bg-white dark:bg-dark-card border border-gray-200 dark:border-dark-border rounded-lg shadow-sm p-5">
            <p class="font-semibold text-ink dark:text-dark-text mb-3" data-i18n="invoice.payments">Payments</p>
            <div class="border border-dashed border-gray-300 dark:border-dark-border rounded-md py-8 text-center text-gray-500 dark:text-dark-muted text-sm">
              <span data-i18n="invoice.noPayments">No Payments found.</span>
            </div>
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
    const i18n = () => window.InvoiceGenI18n;
    const tr = (key, vars) => i18n()?.t(key, vars) || key;

    function currentTheme() {
      if (document.documentElement.classList.contains('dark')) return 'dark';
      const saved = localStorage.getItem('invoicegen-theme');
      if (saved) return saved;
      return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
    }

    document.getElementById('themeToggle')?.addEventListener('click', () => {
      // Runs after theme-lang.js's own click handler has toggled the class.
      setTimeout(() => {
        if (invoiceData) document.getElementById('invoiceRender').innerHTML = InvoicePdf.renderHtml(invoiceData, currentTheme());
      }, 0);
    });

    async function checkSession() {
      const res = await fetch('api/session_check.php');
      if (!res.ok) { window.location.href = 'signin'; return; }
      const data = await res.json();
      document.getElementById('userInitials').textContent = data.initials;
      document.getElementById('userName').textContent = `${data.firstName}.${data.lastName ? data.lastName[0].toLowerCase() : ''}`;
      document.getElementById('userNameFull').textContent = `${data.firstName} ${data.lastName}`.trim();
      document.getElementById('userEmail').textContent = data.email;
    }

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

    function statusBadgeHtml(status) {
      const map = {
        Open:   'bg-indigo-100 text-indigo-700',
        Viewed: 'bg-blue-100 text-blue-700',
        Paid:   'bg-green-100 text-green-700',
      };
      const cls = map[status] || 'bg-gray-100 text-gray-700';
      return `<span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full ${cls} text-xs font-medium">
        <span class="w-1.5 h-1.5 rounded-full bg-current"></span>${status}
      </span>`;
    }

    function actionsMenuHtml(status) {
      const download = `<a href="#" id="menuDownload" class="block px-4 py-2 text-ink hover:bg-gray-50 dark:text-dark-text dark:hover:bg-dark-border">${tr('actions.download')}</a>`;
      const send = `<a href="send-invoice?send=${encodeURIComponent(invoiceData.invoiceNumber)}" class="block px-4 py-2 text-ink hover:bg-gray-50 dark:text-dark-text dark:hover:bg-dark-border">${tr('actions.send')}</a>`;
      const duplicate = `<a href="#" id="menuDuplicate" class="block px-4 py-2 text-ink hover:bg-gray-50 dark:text-dark-text dark:hover:bg-dark-border">${tr('actions.duplicate')}</a>`;
      const del = `<a href="#" id="menuDelete" class="block px-4 py-2 text-red-600 hover:bg-gray-50 dark:hover:bg-dark-border">${tr('actions.delete')}</a>`;
      if (status === 'Paid') {
        return download + send + duplicate + del;
      }
      const edit = `<a href="#" id="menuEdit" class="block px-4 py-2 text-ink hover:bg-gray-50 dark:text-dark-text dark:hover:bg-dark-border">${tr('actions.edit')}</a>`;
      const markPaid = `<a href="#" id="menuMarkPaid" class="block px-4 py-2 text-ink hover:bg-gray-50 dark:text-dark-text dark:hover:bg-dark-border">${tr('actions.markPaid')}</a>`;
      return download + send + `<div class="border-t border-gray-100 my-1"></div>` + edit + markPaid + duplicate + `<div class="border-t border-gray-100 my-1"></div>` + del;
    }

    function renderInvoiceDetails() {
      document.getElementById('invoiceTitle').textContent = tr('invoice.titleNumber', { number: invoiceData.invoiceNumber || invoiceId });
      document.getElementById('statusBadge').innerHTML = statusBadgeHtml(invoiceData.status);
      document.getElementById('metaLine').textContent =
        `${invoiceData.invoiceDate || ''} · ${(invoiceData.billTo || '').split('\n')[0] || '—'} · ${invoiceData.total || ''}`;

      document.getElementById('amountDue').textContent = invoiceData.balance || invoiceData.total || '';
      document.getElementById('dueDateVal').textContent = invoiceData.dueDate || '—';
      document.getElementById('totalVal').textContent = invoiceData.total || '';
      document.getElementById('collectFasterText').textContent = tr('invoice.collectFaster', { amount: invoiceData.balance || invoiceData.total || '' });

      document.getElementById('invoiceRender').innerHTML = InvoicePdf.renderHtml(invoiceData, currentTheme());
      document.getElementById('sendBtn').href = `send-invoice?send=${encodeURIComponent(invoiceData.invoiceNumber)}`;
      document.getElementById('actionsMenu').innerHTML = actionsMenuHtml(invoiceData.status);

      attachActionHandlers();
    }

   async function loadInvoice() {
  if (!invoiceNumber) {
    console.error('Invoice number is missing');
    return;
  }

  const res = await fetch(
    `api/get_invoice_email.php?invoice_number=${encodeURIComponent(invoiceNumber)}`
  );

  if (!res.ok) {
    console.error('Invoice API failed:', res.status);
    return;
  }

  invoiceData = await res.json();
  invoiceId = invoiceData.id;

  document.getElementById('loadingState').classList.add('hidden');
  document.getElementById('content').classList.remove('hidden');

  renderInvoiceDetails();
}

    function attachActionHandlers() {
      const doDownload = async () => {
        await InvoicePdf.download(invoiceData, document.getElementById('printInvoice'), `invoice-${invoiceData.invoiceNumber || invoiceId}.pdf`);
      };
      document.getElementById('downloadBtn').onclick = doDownload;
      document.getElementById('menuDownload')?.addEventListener('click', (e) => { e.preventDefault(); doDownload(); });

      document.getElementById('menuEdit')?.addEventListener('click', (e) => {
        e.preventDefault();
        sessionStorage.setItem('editInvoiceData', JSON.stringify(invoiceData));
        sessionStorage.setItem('editInvoiceId', invoiceId);
        window.location.href = './?edit=1';
      });

      document.getElementById('menuDuplicate')?.addEventListener('click', (e) => {
        e.preventDefault();
        const copy = { ...invoiceData };
        delete copy.id;
        copy.invoiceNumber = '';
        copy.status = 'Open';
        sessionStorage.setItem('duplicateInvoiceData', JSON.stringify(copy));
        window.location.href = './?duplicate=1';
      });

      document.getElementById('menuMarkPaid')?.addEventListener('click', async (e) => {
        e.preventDefault();
        await fetch('api/mark_paid.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ id: invoiceId })
        });
        loadInvoice();
      });

      document.getElementById('menuDelete')?.addEventListener('click', async (e) => {
        e.preventDefault();
        if (!confirm(tr('alert.deleteConfirm'))) return;
        await fetch('api/delete_invoice.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ id: invoiceId })
        });
        window.location.href = 'dashboard';
      });
    }

  if (!invoiceNumber) {
  console.error('Invoice number is missing');
}else {
      window.addEventListener('invoicegen:languagechange', () => {
        if (invoiceData) renderInvoiceDetails();
      });
      checkSession();
      loadInvoice();
    }
  </script>
<?php require __DIR__ . '/includes/footer.php'; ?>
