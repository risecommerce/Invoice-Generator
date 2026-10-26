<?php
$pageTitle = 'Customer - invoicescheduler.com';
$pageBodyAttributes = ' class="bg-gray-100 dark:bg-dark-bg min-h-screen transition-colors duration-200"';
$pageHeader = 'customer-view';
$pageExtraHead = <<<'HTML'
<script src="https://cdn.tailwindcss.com"></script>
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
  .dropdown-menu { display: none; z-index: 9999; }
  .dropdown.open .dropdown-menu { display: block; }
</style>
HTML;
require __DIR__ . '/includes/meta.php';
require __DIR__ . '/includes/header.php';
?>
<!-- Header -->
  

  <main class="max-w-[1200px] mx-auto px-6 py-8">
    <div id="loadingState" class="text-center text-gray-400 dark:text-dark-muted text-sm py-16" data-i18n="customers.loading">Loading customer…</div>

    <div id="content" class="hidden bg-white dark:bg-dark-card border border-gray-200 dark:border-dark-border rounded-lg shadow-sm p-8">

      <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-4">
          <span id="customerInitials" class="w-14 h-14 rounded-lg bg-brand-greenSoft dark:bg-brand-green/20 text-brand-greenDark dark:text-brand-green flex items-center justify-center font-bold text-lg"></span>
          <h1 id="customerName" class="text-2xl font-bold text-ink dark:text-dark-text"></h1>
        </div>
        <div class="flex gap-3">
          <a id="editBtn" href="#" class="inline-flex items-center gap-2 px-4 py-2 rounded-md border border-gray-300 dark:border-dark-border text-sm text-ink dark:text-dark-text hover:bg-gray-50 dark:hover:bg-dark-border">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
            <span data-i18n="actions.edit">Edit</span>
          </a>
          <div class="dropdown relative ">
            <button type="button" class="dropdown-toggle w-10 h-10 rounded-md border border-gray-300 dark:border-dark-border text-gray-500 dark:text-dark-muted hover:bg-gray-50 dark:hover:bg-dark-border flex items-center justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor"><path d="M4 10a2 2 0 114 0 2 2 0 01-4 0zM8 10a2 2 0 114 0 2 2 0 01-4 0zM12 10a2 2 0 114 0 2 2 0 01-4 0z"/></svg>
            </button>
            <div id="headerActionsMenu" class="dropdown-menu absolute right-0 mt-2 w-44 bg-white dark:bg-dark-card border border-gray-200 dark:border-dark-border rounded-md shadow-lg z-50 py-2 text-sm">
              <!-- Placeholder: does not yet prefill this customer's info on the new invoice form -->
              <a href="./" class="flex items-center gap-2 px-4 py-2 text-ink dark:text-dark-text hover:bg-gray-50 dark:hover:bg-dark-border">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500 dark:text-dark-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                <span data-i18n="customers.newInvoice">New Invoice</span>
              </a>
              <a href="#" id="deleteCustomerBtn" class="flex items-center gap-2 px-4 py-2 text-red-600 hover:bg-gray-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.166 1.022.166m-1.022-.166L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397M4.772 5.79c.34-.059.68-.114 1.022-.166m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                <span data-i18n="actions.delete">Delete</span>
              </a>
            </div>
          </div>
        </div>
      </div>

      <div class="grid grid-cols-2 sm:grid-cols-4 gap-6 border-t border-b border-gray-100 dark:border-dark-border py-4 mb-6">
        <div>
          <p class="text-xs text-gray-500 dark:text-dark-muted uppercase tracking-wide mb-1" data-i18n="customers.invoices">Invoices</p>
          <p id="statInvoices" class="text-lg font-bold text-ink dark:text-dark-text"></p>
        </div>
        <div>
          <p class="text-xs text-gray-500 dark:text-dark-muted uppercase tracking-wide mb-1" data-i18n="customers.payments">Payments</p>
          <p class="text-lg font-bold text-ink dark:text-dark-text">0</p>
        </div>
        <div>
          <p class="text-xs text-gray-500 dark:text-dark-muted uppercase tracking-wide mb-1" data-i18n="customers.totalInvoiced">Total Invoiced</p>
          <p id="statTotalInvoiced" class="text-lg font-bold text-ink dark:text-dark-text"></p>
        </div>
        <div>
          <p class="text-xs text-gray-500 dark:text-dark-muted uppercase tracking-wide mb-1" data-i18n="customers.totalPaid">Total Paid</p>
          <p class="text-lg font-bold text-ink dark:text-dark-text">—</p>
        </div>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="space-y-6">
          <div class="border border-gray-200 dark:border-dark-border rounded-lg p-5">
            <p class="font-semibold text-ink dark:text-dark-text mb-3 flex items-center gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500 dark:text-dark-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.964 0a9 9 0 10-11.964 0m11.964 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
              <span data-i18n="customers.details">Details</span>
            </p>
            <div class="flex justify-between text-sm">
              <span class="text-gray-500 dark:text-dark-muted" data-i18n="customers.created">Created</span>
              <span id="createdAt" class="text-ink dark:text-dark-text"></span>
            </div>
          </div>

          <div class="border border-gray-200 dark:border-dark-border rounded-lg p-5">
            <p class="font-semibold text-ink dark:text-dark-text mb-3 flex items-center gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500 dark:text-dark-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21"/></svg>
              <span data-i18n="customers.billTo">Bill To</span>
            </p>
            <p id="billToText" class="text-sm text-ink dark:text-dark-text leading-relaxed whitespace-pre-line"></p>
          </div>

          <div id="shipToCard" class="border border-gray-200 dark:border-dark-border rounded-lg p-5">
            <p class="font-semibold text-ink dark:text-dark-text mb-3 flex items-center gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500 dark:text-dark-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 0h-12"/></svg>
              <span data-i18n="customers.shipTo">Ship To</span>
            </p>
            <p id="shipToText" class="text-sm text-ink dark:text-dark-text leading-relaxed whitespace-pre-line"></p>
          </div>
        </div>

        <div class="space-y-6">
          <div class="border border-gray-200 dark:border-dark-border rounded-lg p-5">
            <div class="flex items-center justify-between mb-3">
              <p class="font-semibold text-ink dark:text-dark-text flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500 dark:text-dark-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                <span data-i18n="customers.invoicesHeading">Invoices</span>
                <span id="invoicesCount" class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-gray-100 dark:bg-dark-field text-xs text-gray-600 dark:text-dark-muted"></span>
              </p>
              <!-- Placeholder: does not yet prefill this customer's info on the new invoice form -->
              <a id="newInvoiceLink" href="./" class="text-sm text-brand-green hover:text-brand-greenDark font-medium flex items-center gap-1">
                <span class="text-base leading-none">+</span> <span data-i18n="customers.new">New</span>
              </a>
            </div>
            <table class="w-full text-left text-sm">
              <thead class="border-b border-gray-100 dark:border-dark-border text-gray-500 dark:text-dark-muted">
                <tr>
                  <th class="pb-2 font-medium" data-i18n="dashboard.reference">Reference</th>
                  <th class="pb-2 font-medium" data-i18n="dashboard.date">Date</th>
                  <th class="pb-2 font-medium" data-i18n="dashboard.status">Status</th>
                  <th class="pb-2 font-medium text-right" data-i18n="dashboard.total">Total</th>
                </tr>
              </thead>
              <tbody id="invoicesTableBody" class="divide-y divide-gray-100 dark:divide-dark-border"></tbody>
            </table>
          </div>

          <div class="border border-gray-200 dark:border-dark-border rounded-lg p-5">
            <p class="font-semibold text-ink dark:text-dark-text mb-3 flex items-center gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500 dark:text-dark-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/></svg>
              <span data-i18n="customers.payments">Payments</span>
              <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-gray-100 dark:bg-dark-field text-xs text-gray-600 dark:text-dark-muted">0</span>
            </p>
            <div class="border border-dashed border-gray-300 dark:border-dark-border rounded-md py-8 text-center text-gray-500 dark:text-dark-muted text-sm" data-i18n="customers.noPayments">
              No Payments found.
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <script src="assets/theme-lang.js"></script>
  <script>
    const params = new URLSearchParams(window.location.search);
    const customerId = params.get('id');
    const customerName = params.get('name');
    if (!customerId && !customerName) window.location.href = 'customers';

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

    function formatDate(value) {
      if (!value) return '';
      // MySQL returns "YYYY-MM-DD HH:MM:SS" - normalize to something every
      // browser's Date parser accepts reliably.
      let normalized = String(value).trim().replace(' ', 'T');
      let d = new Date(normalized);
      if (isNaN(d.getTime())) {
        // Fall back to parsing just the date portion (YYYY-MM-DD or
        // YYYY-MM-DDTHH:MM:SS) if the full string didn't parse.
        const datePart = normalized.split('T')[0];
        const parts = datePart.split('-').map(Number);
        if (parts.length === 3 && !parts.some(isNaN)) {
          d = new Date(parts[0], parts[1] - 1, parts[2]);
        }
      }
      if (isNaN(d.getTime())) return value;
      return d.toLocaleDateString(undefined, { day: 'numeric', month: 'short', year: 'numeric' });
    }

    function statusBadge(status) {
      const map = { Open: 'bg-indigo-100 text-indigo-700', Viewed: 'bg-blue-100 text-blue-700', Paid: 'bg-green-100 text-green-700' };
      const cls = map[status] || 'bg-gray-100 text-gray-700';
      return `<span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full ${cls} text-xs font-medium">
        <span class="w-1.5 h-1.5 rounded-full bg-current"></span>${status}
      </span>`;
    }

    async function loadCustomer() {
      const query = customerId ? `id=${customerId}` : `name=${encodeURIComponent(customerName)}`;
      const res = await fetch(`api/get_customer.php?${query}`);
      if (!res.ok) { window.location.href = 'customers'; return; }
      const data = await res.json();

      document.getElementById('loadingState').classList.add('hidden');
      document.getElementById('content').classList.remove('hidden');

      const initials = data.name.split(' ').map(w => w[0]).slice(0, 2).join('').toUpperCase();
      document.getElementById('customerInitials').textContent = initials;
      document.getElementById('customerName').textContent = data.name;
      document.getElementById('statInvoices').textContent = data.invoiceCount;
      document.getElementById('statTotalInvoiced').textContent = `${data.currencyCode} ${data.totalInvoiced}`;
      document.getElementById('createdAt').textContent = formatDate(data.createdAt);
      document.getElementById('billToText').textContent = data.billTo || '—';
      document.getElementById('shipToText').textContent = data.shipTo || '—';
      document.getElementById('shipToCard').classList.toggle('hidden', !data.shipTo);
      document.getElementById('invoicesCount').textContent = data.invoiceCount;

      document.getElementById('invoicesTableBody').innerHTML = data.invoices.map(inv => `
        <tr>
          <td class="py-3"><a href="invoice-view?id=${inv.id}" class="text-brand-green hover:underline">Invoice #${inv.invoiceNumber}</a></td>
          <td class="py-3 text-ink dark:text-dark-text">${formatDate(inv.invoiceDate)}</td>
          <td class="py-3">${statusBadge(inv.status)}</td>
          <td class="py-3 text-right text-ink dark:text-dark-text">${inv.total}</td>
        </tr>
      `).join('');

      const editBtn = document.getElementById('editBtn');
      const deleteBtn = document.getElementById('deleteCustomerBtn');
      if (data.id) {
        editBtn.href = `customer-new?id=${data.id}`;
        deleteBtn.addEventListener('click', async (e) => {
          e.preventDefault();
          if (!confirm(tr('customers.deleteConfirm'))) return;
          const res = await fetch('api/delete_customer.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: data.id })
          });
          if (res.ok) window.location.href = 'customers';
          else alert(tr('alert.deleteFailed'));
        });
      } else {
        // This customer only exists as a name on invoices - nothing saved to edit/delete yet.
        editBtn.closest('.flex.gap-3').classList.add('hidden');
      }
    }

    checkSession();
    loadCustomer();
  </script>
<?php require __DIR__ . '/includes/footer.php'; ?>
