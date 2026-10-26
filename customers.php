<?php
$pageTitle = 'Customers - invoicescheduler.com';
$pageBodyAttributes = ' class="bg-gray-100 dark:bg-dark-bg min-h-screen transition-colors duration-200"';
$pageHeader = 'customers';
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
</style>
HTML;
require __DIR__ . '/includes/meta.php';
require __DIR__ . '/includes/header.php';
?>
<main class="max-w-[1200px] mx-auto px-6 py-8">
    <div class="bg-white dark:bg-dark-card border border-gray-200 dark:border-dark-border rounded-lg shadow-sm p-8">

      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
          <h1 class="text-2xl font-bold text-ink dark:text-dark-text" data-i18n="nav.customers">Customers</h1>
          <p id="deletedSubtitle" class="hidden text-sm text-brand-green font-medium mt-1" data-i18n="customers.deletedSubtitle">View Deleted Customers</p>
        </div>
        <a id="newCustomerBtn" href="customer-new" class="bg-[#B12F26] hover:bg-[#B12F26] text-white text-sm font-semibold px-4 py-2 rounded-md" data-i18n="customers.newCustomer">New Customer</a>
      </div>

      <div id="loadingState" class="py-16 text-center text-gray-400 dark:text-dark-muted text-sm" data-i18n="customers.loadingList">Loading customers…</div>

      <div id="emptyState" class="hidden">
        <div class="border border-dashed border-gray-300 dark:border-dark-border rounded-md py-16 text-center text-gray-500 dark:text-dark-muted text-sm">
          <span data-i18n="customers.noCustomers">No customers found yet. They'll appear here once you add one.</span>
        </div>
        <div class="mt-4">
          <a id="emptyStateToggleLink" href="#" class="text-brand-green hover:text-brand-greenDark text-sm font-medium"></a>
        </div>
      </div>

      <div id="tableWrap" class="hidden">
        <div class="overflow-x-auto">
          <table class="min-w-full text-left text-sm">
            <thead class="border-b border-gray-200 dark:border-dark-border text-gray-600 dark:text-dark-muted">
              <tr>
                <th class="py-3 font-semibold" data-i18n="dashboard.customer">Name</th>
                <th class="py-3 font-semibold">Email</th>
                <th class="py-3 font-semibold" data-i18n="customers.created">Created</th>
                <th class="py-3"></th>
              </tr>
            </thead>
            <tbody id="customerRows" class="divide-y divide-gray-100 dark:divide-dark-border"></tbody>
          </table>
        </div>

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mt-4 pt-4 border-t border-gray-100 dark:border-dark-border text-sm text-gray-600 dark:text-dark-muted">
          <div class="flex items-center gap-2">
            <span data-i18n="dashboard.perPage">Per page</span>
            <select id="perPageSelect" class="border border-gray-300 dark:border-dark-border dark:bg-dark-field dark:text-dark-text rounded-md px-2 py-1">
              <option value="10">10</option>
              <option value="25" selected>25</option>
              <option value="50">50</option>
              <option value="100">100</option>
            </select>
          </div>
          <div id="totalRecords">Total 0 records</div>
        </div>

        <div class="mt-6">
          <a id="tableToggleLink" href="#" class="text-brand-green hover:text-brand-greenDark text-sm font-medium"></a>
        </div>
      </div>

    </div>
  </main>

  <script src="assets/theme-lang.js"></script>
  <script>
    const params = new URLSearchParams(window.location.search);
    let currentView = params.get('view') === 'deleted' ? 'deleted' : 'active';
    let currentPerPage = params.get('per_page') || '25';

    const loadingState = document.getElementById('loadingState');
    const emptyState = document.getElementById('emptyState');
    const tableWrap = document.getElementById('tableWrap');
    const customerRows = document.getElementById('customerRows');
    const deletedSubtitle = document.getElementById('deletedSubtitle');
    const newCustomerBtn = document.getElementById('newCustomerBtn');
    const emptyStateToggleLink = document.getElementById('emptyStateToggleLink');
    const tableToggleLink = document.getElementById('tableToggleLink');
    const totalRecords = document.getElementById('totalRecords');
    const perPageSelect = document.getElementById('perPageSelect');
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

    // ---------- Dropdowns (fixed-position, can never be clipped) ----------
    function closeAllDropdowns() {
      document.querySelectorAll('.dropdown-menu.dropdown-menu-open').forEach(menu => {
        menu.classList.remove('dropdown-menu-open');
        menu.style.display = 'none';
        menu.style.position = '';
        menu.style.top = '';
        menu.style.left = '';
      });
    }
    function positionDropdownMenu(toggle, menu) {
      const rect = toggle.getBoundingClientRect();
      const menuWidth = menu.offsetWidth || 176;
      let left = rect.right - menuWidth;
      if (left < 8) left = rect.left;
      let top = rect.bottom + 6;
      menu.style.position = 'fixed';
      menu.style.display = 'block';
      menu.style.left = `${Math.max(8, left)}px`;
      menu.style.top = `${top}px`;
      const menuRect = menu.getBoundingClientRect();
      if (menuRect.bottom > window.innerHeight - 8) {
        menu.style.top = `${rect.top - menuRect.height - 6}px`;
      }
    }
    document.addEventListener('click', (e) => {
      const toggle = e.target.closest('.dropdown-toggle');
      if (toggle) {
        e.stopPropagation();
        const menu = toggle.closest('.dropdown').querySelector('.dropdown-menu');
        const wasOpen = menu.classList.contains('dropdown-menu-open');
        closeAllDropdowns();
        if (!wasOpen) {
          menu.classList.add('dropdown-menu-open');
          positionDropdownMenu(toggle, menu);
        }
        return;
      }
      if (!e.target.closest('.dropdown-menu')) closeAllDropdowns();
    });
    window.addEventListener('scroll', closeAllDropdowns, true);
    window.addEventListener('resize', closeAllDropdowns);

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

    function customerViewHref(c) {
      const name = String(c.name || '').trim();
      return name ? `customer-view?name=${encodeURIComponent(name)}` : `customer-view?id=${c.id}`;
    }

    function rowActionsMenu(c) {
      if (currentView === 'deleted') {
        return `
          <div class="dropdown-menu w-44 bg-white dark:bg-dark-card border border-gray-200 dark:border-dark-border rounded-md shadow-lg py-2 text-sm">
            <a href="${customerViewHref(c)}" class="flex items-center gap-2 px-4 py-2 text-ink dark:text-dark-text hover:bg-gray-50 dark:hover:bg-dark-border">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500 dark:text-dark-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
              ${tr('actions.view')}
            </a>
            <!-- Placeholder: does not yet prefill this customer's info on the new invoice form -->
            <a href="./" class="flex items-center gap-2 px-4 py-2 text-ink dark:text-dark-text hover:bg-gray-50 dark:hover:bg-dark-border">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500 dark:text-dark-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
              ${tr('customers.newInvoice')}
            </a>
            <a href="#" data-id="${c.id}" class="restore-link flex items-center gap-2 px-4 py-2 text-ink dark:text-dark-text hover:bg-gray-50 dark:hover:bg-dark-border">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500 dark:text-dark-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3"/></svg>
              ${tr('actions.restore')}
            </a>
          </div>`;
      }
      return `
        <div class="dropdown-menu w-44 bg-white dark:bg-dark-card border border-gray-200 dark:border-dark-border rounded-md shadow-lg py-2 text-sm">
          <a href="${customerViewHref(c)}" class="flex items-center gap-2 px-4 py-2 text-ink dark:text-dark-text hover:bg-gray-50 dark:hover:bg-dark-border">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500 dark:text-dark-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            ${tr('actions.view')}
          </a>
          <!-- Placeholder: does not yet prefill this customer's info on the new invoice form -->
          <a href="./" class="flex items-center gap-2 px-4 py-2 text-ink dark:text-dark-text hover:bg-gray-50 dark:hover:bg-dark-border">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500 dark:text-dark-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
            ${tr('customers.newInvoice')}
          </a>
          <a href="customer-new?id=${c.id}" class="flex items-center gap-2 px-4 py-2 text-ink dark:text-dark-text hover:bg-gray-50 dark:hover:bg-dark-border">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500 dark:text-dark-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
            ${tr('actions.edit')}
          </a>
          <a href="#" data-id="${c.id}" class="delete-link flex items-center gap-2 px-4 py-2 text-red-600 hover:bg-gray-50">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.166 1.022.166m-1.022-.166L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397M4.772 5.79c.34-.059.68-.114 1.022-.166m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
            ${tr('actions.delete')}
          </a>
        </div>`;
    }

    function renderCustomers(data) {
      const customers = data.customers || [];

      newCustomerBtn.classList.toggle('hidden', currentView !== 'active');
      deletedSubtitle.classList.toggle('hidden', currentView !== 'deleted');

      const toggleLabel = currentView === 'deleted' ? tr('customers.viewActive') : tr('customers.deletedSubtitle');
      const toggleHref = currentView === 'deleted' ? 'customers' : 'customers?view=deleted';
      emptyStateToggleLink.textContent = toggleLabel;
      emptyStateToggleLink.href = toggleHref;
      tableToggleLink.textContent = toggleLabel;
      tableToggleLink.href = toggleHref;

      loadingState.classList.add('hidden');

      if (customers.length === 0) {
        emptyState.classList.remove('hidden');
        tableWrap.classList.add('hidden');
        return;
      }

      emptyState.classList.add('hidden');
      tableWrap.classList.remove('hidden');

      customerRows.innerHTML = customers.map(c => `
        <tr>
          <td class="py-4">
            <a href="${customerViewHref(c)}" class="text-brand-green hover:underline font-medium">${c.name}</a>
            ${currentView === 'deleted' ? `<span class="ml-2 inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-red-100 text-red-700 text-xs font-medium">${tr('dashboard.deleted')}</span>` : ''}
          </td>
          <td class="py-4 text-ink dark:text-dark-text">${c.email || ''}</td>
          <td class="py-4 text-ink dark:text-dark-text">${formatDate(c.createdAt)}</td>
          <td class="py-4 text-right">
            <div class="dropdown relative inline-block">
              <button type="button" class="dropdown-toggle w-9 h-9 rounded-md border border-gray-200 dark:border-dark-border text-gray-500 dark:text-dark-muted hover:bg-gray-50 dark:hover:bg-dark-border flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor"><path d="M4 10a2 2 0 114 0 2 2 0 01-4 0zM8 10a2 2 0 114 0 2 2 0 01-4 0zM12 10a2 2 0 114 0 2 2 0 01-4 0z"/></svg>
              </button>
              ${rowActionsMenu(c)}
            </div>
          </td>
        </tr>
      `).join('');

      totalRecords.textContent = `${tr('dashboard.totalRecords', { count: customers.length })}`;
      attachRowHandlers();
    }

    function attachRowHandlers() {
      document.querySelectorAll('.delete-link').forEach(link => {
        link.addEventListener('click', async (e) => {
          e.preventDefault();
          if (!confirm(tr('customers.deleteConfirm'))) return;
          const id = link.dataset.id;
          const res = await fetch('api/delete_customer.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id })
          });
          if (res.ok) loadCustomers();
          else alert(tr('alert.deleteFailed'));
        });
      });
      document.querySelectorAll('.restore-link').forEach(link => {
        link.addEventListener('click', async (e) => {
          e.preventDefault();
          const id = link.dataset.id;
          const res = await fetch('api/restore_customer.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id })
          });
          if (res.ok) loadCustomers();
          else alert(tr('alert.restoreFailed'));
        });
      });
    }

    async function loadCustomers() {
      loadingState.classList.remove('hidden');
      emptyState.classList.add('hidden');
      tableWrap.classList.add('hidden');

      const res = await fetch(`api/get_customers.php?view=${currentView}&per_page=${currentPerPage}`);
      if (!res.ok) { window.location.href = 'signin'; return; }
      const data = await res.json();
      renderCustomers(data);
    }

    perPageSelect.value = currentPerPage;
    perPageSelect.addEventListener('change', (e) => {
      currentPerPage = e.target.value;
      loadCustomers();
    });

    checkSession();
    loadCustomers();
  </script>
<?php require __DIR__ . '/includes/footer.php'; ?>
