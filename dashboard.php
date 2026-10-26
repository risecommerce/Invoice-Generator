

<?php
$pageTitle = 'My Invoices - invoicescheduler.com';
$pageBodyAttributes = ' class="bg-gray-100 dark:bg-dark-bg min-h-screen transition-colors duration-200"';
$pageHeader = 'dashboard';
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
  .dropdown-menu { display: none; z-index: 9999; }
</style>
HTML;
require __DIR__ . '/includes/meta.php';
require __DIR__ . '/includes/header.php';
?>
<!-- Header -->
  

  <main class="max-w-[1200px] mx-auto px-6 py-8">
    <div class="bg-white dark:bg-dark-card border border-gray-200 dark:border-dark-border rounded-lg shadow-sm p-8">

      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
          <h1 class="text-2xl font-bold text-ink dark:text-dark-text" data-i18n="dashboard.title">My Invoices</h1>
          <p id="deletedSubtitle" class="hidden text-sm text-brand-green font-medium mt-1" data-i18n="dashboard.deletedSubtitle">View Deleted Invoices</p>
        </div>
        <div class="flex flex-wrap gap-3">
      
            <input type="file" id="importFile" accept=".csv" class="hidden">
      
          <div id="activeOnlyActions" class="flex flex-wrap gap-3">
         
            <div class="dropdown relative">
              <div class="inline-flex rounded-md overflow-hidden">
                <a href="/" class="bg-[#B12F26] hover:bg-[#B12F26] text-white text-sm font-semibold px-4 py-2" data-i18n="actions.newInvoice">New Invoice</a>
              </div>
              <!-- Placeholder: additional "New Invoice" options TBD -->
            
            </div>
          </div>
        </div>
      </div>

    

      <div id="loadingState" class="py-16 text-center text-gray-400 dark:text-dark-muted text-sm" data-i18n="dashboard.loading">Loading invoices...</div>

      <div id="emptyState" class="hidden">
        <div class="border border-dashed border-gray-300 dark:border-dark-border rounded-md py-16 text-center text-gray-500 dark:text-dark-muted text-sm">
          <span data-i18n="dashboard.empty">No Invoices found.</span>
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
        <th class="py-3 font-semibold" data-i18n="dashboard.reference">
            Reference
        </th>

        <th class="py-3 font-semibold" data-i18n="dashboard.customer">
            Customer
        </th>

        <th class="py-3 font-semibold" data-i18n="dashboard.date">
            Date
        </th>

        <th class="py-3 font-semibold" data-i18n="dashboard.dueDate">
            Due Date
        </th>

        <th class="py-3 font-semibold" data-i18n="dashboard.status">
            Status
        </th>
        
        <th class="py-3 font-semibold">
            Is Scheduled
        </th>
        <th class="py-3 font-semibold" data-i18n="dashboard.total">
            Total
        </th>

        <th class="py-3"></th>
    </tr>
</thead>
            <tbody id="invoiceRows" class="divide-y divide-gray-100"></tbody>
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

  <div id="printInvoice" style="position:absolute; left:-9999px; top:0; width:210mm;"></div>

  <script src="assets/invoice-pdf.js"></script>
  <script src="assets/theme-lang.js"></script>
  <script>
    const params = new URLSearchParams(window.location.search);
    let currentView = params.get('view') === 'deleted' ? 'deleted' : 'active';
    let currentPerPage = params.get('per_page') || '25';

    const loadingState = document.getElementById('loadingState');
    const emptyState = document.getElementById('emptyState');
    const tableWrap = document.getElementById('tableWrap');
    const invoiceRows = document.getElementById('invoiceRows');
    const activeOnlyActions = document.getElementById('activeOnlyActions');
    const deletedSubtitle = document.getElementById('deletedSubtitle');
  
    const emptyStateToggleLink = document.getElementById('emptyStateToggleLink');
    const tableToggleLink = document.getElementById('tableToggleLink');
    const totalRecords = document.getElementById('totalRecords');
    const perPageSelect = document.getElementById('perPageSelect');
    const i18n = () => window.InvoiceGenI18n;
    const tr = (key, vars) => i18n()?.t(key, vars) || key;

    // ---------- Session check ----------
    async function checkSession() {
      const res = await fetch('api/session_check.php');
      if (!res.ok) {
        window.location.href = 'signin';
        return;
      }
      const data = await res.json();
      document.getElementById('userInitials').textContent = data.initials;
      document.getElementById('userName').textContent = `${data.firstName}.${data.lastName ? data.lastName[0].toLowerCase() : ''}`;
      document.getElementById('userNameFull').textContent = `${data.firstName} ${data.lastName}`.trim();
      document.getElementById('userEmail').textContent = data.email;
    }

    // ---------- Dropdowns ----------
    // Menus are repositioned as fixed-position elements anchored to their
    // toggle button's on-screen position, so a table's overflow-x-auto (or
    // any other clipping ancestor) can never cut them off.
    function closeAllDropdowns() {
      document.querySelectorAll('.dropdown-menu.dropdown-menu-open').forEach(menu => {
        menu.classList.remove('dropdown-menu-open');
        menu.style.display = 'none';
        menu.style.position = '';
        menu.style.top = '';
        menu.style.left = '';
        menu.style.right = '';
      });
    }

    function positionDropdownMenu(toggle, menu) {
      const rect = toggle.getBoundingClientRect();
      const menuWidth = menu.offsetWidth || 192;
      let left = rect.right - menuWidth;
      if (left < 8) left = rect.left;
      let top = rect.bottom + 6;

      menu.style.position = 'fixed';
      menu.style.display = 'block';
      menu.style.left = `${Math.max(8, left)}px`;
      menu.style.top = `${top}px`;

      // If it would overflow the bottom of the viewport, open it upward instead.
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


    // ---------- Render invoices ----------
    function statusBadge(inv) {
      if (currentView === 'deleted') {
        return `<span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-red-100 text-red-700 text-xs font-medium">${tr('dashboard.deleted')}</span>`;
      }
      return `<span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-indigo-100 text-indigo-700 text-xs font-medium">
        <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>${inv.status}
      </span>`;
    }

    function rowActionsMenu(inv) {
      if (currentView === 'deleted') {
        return `
          <div class="dropdown-menu w-40 bg-white dark:bg-dark-card border border-gray-200 dark:border-dark-border rounded-md shadow-lg py-2 text-sm">
            <a href="#" data-id="${inv.id}" class="restore-link block px-4 py-2 text-ink dark:text-dark-text hover:bg-gray-50 dark:hover:bg-dark-border">${tr('actions.restore')}</a>
            <a href="#" class="block px-4 py-2 text-gray-400 dark:text-dark-muted cursor-not-allowed">${tr('actions.deletePermanently')}</a>
          </div>`;
      }

      const view = `<a href="invoice-view?send=${encodeURIComponent(inv.invoiceNumber)}" class="flex items-center gap-2 px-4 py-2 text-ink dark:text-dark-text hover:bg-gray-50 dark:hover:bg-dark-border">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500 dark:text-dark-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
          ${tr('actions.view')}
        </a>`;
      const download = `<a href="#" data-id="${inv.id}" class="download-link flex items-center gap-2 px-4 py-2 text-ink dark:text-dark-text hover:bg-gray-50 dark:hover:bg-dark-border">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500 dark:text-dark-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3"/></svg>
          ${tr('actions.download')}
        </a>`;
     const send = `<a href="send-invoice?send=${encodeURIComponent(inv.invoiceNumber)}" class="flex items-center gap-2 px-4 py-2 text-ink dark:text-dark-text hover:bg-gray-50 dark:hover:bg-dark-border">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500 dark:text-dark-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.769 59.769 0 0121.485 12 59.768 59.768 0 013.27 20.876L5.999 12zm0 0h7.5"/>
    </svg>
    ${tr('actions.send')}
</a>`;
  
      const del = `<a href="#" data-id="${inv.id}" class="delete-link rajat flex items-center gap-2 px-4 py-2 text-red-600 hover:bg-gray-50">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.166 1.022.166m-1.022-.166L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397M4.772 5.79c.34-.059.68-.114 1.022-.166m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
          ${tr('actions.delete')}
        </a>`;

 

      const edit = `<a href="#" data-id="${inv.id}" class="edit-link flex items-center gap-2 px-4 py-2 text-ink dark:text-dark-text hover:bg-gray-50 dark:hover:bg-dark-border">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500 dark:text-dark-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
          ${tr('actions.edit')}
        </a>`;
      const markPaid = `<a href="#" data-id="${inv.id}" class="mark-paid-link flex items-center gap-2 px-4 py-2 text-ink dark:text-dark-text hover:bg-gray-50 dark:hover:bg-dark-border">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500 dark:text-dark-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
          ${tr('actions.markPaid')}
        </a>`;

return `<div class="dropdown-menu w-48 bg-white dark:bg-dark-card border border-gray-200 dark:border-dark-border rounded-md shadow-lg py-2 text-sm">${view}${download}${send}<div class="border-t border-gray-100 dark:border-dark-border my-1"></div>${edit}<div class="border-t border-gray-100 dark:border-dark-border my-1"></div>${del}</div>`;
    }

    function renderInvoices(data) {
      const invoices = data.invoices || [];

      activeOnlyActions.classList.toggle('hidden', currentView !== 'active');
      deletedSubtitle.classList.toggle('hidden', currentView !== 'active' ? currentView !== 'deleted' : true);
      if (currentView === 'deleted') deletedSubtitle.classList.remove('hidden');
      else deletedSubtitle.classList.add('hidden');

      const toggleLabel = currentView === 'deleted' ? tr('dashboard.viewActive') : tr('dashboard.deletedSubtitle');
      const toggleHref = currentView === 'deleted' ? 'dashboard' : 'dashboard?view=deleted';
      emptyStateToggleLink.textContent = toggleLabel;
      emptyStateToggleLink.href = toggleHref;
      tableToggleLink.textContent = toggleLabel;
      tableToggleLink.href = toggleHref;

      loadingState.classList.add('hidden');

      if (invoices.length === 0) {
        emptyState.classList.remove('hidden');
        tableWrap.classList.add('hidden');
        return;
      }

      emptyState.classList.add('hidden');
      tableWrap.classList.remove('hidden');

      invoiceRows.innerHTML = invoices.map(inv => {

    // Database:
    // 1    = Yes / ON
    // 0    = No / OFF
    // NULL = No / OFF
    const isScheduled = inv.isScheduled === 1 || inv.isScheduled === '1';

    return `
        <tr>

           <td class="py-4">
    <a href="./?edit=${encodeURIComponent(inv.invoiceNumber)}"
       data-id="${inv.id}"
       class="reference-link text-brand-green hover:underline">
        ${tr('dashboard.invoiceNumber', {
            number: inv.invoiceNumber
        })}
    </a>
</td>

            <td class="py-4 text-ink dark:text-dark-text">
                <a href="#"
                   data-id="${inv.id}"
                   class="customer-link hover:underline">
                    ${(inv.billTo || '').split('\n')[0] || '—'}
                </a>
            </td>

            <td class="py-4 text-ink dark:text-dark-text">
                ${inv.invoiceDate}
            </td>

            <td class="py-4 text-ink dark:text-dark-text">
                ${inv.dueDate}
            </td>

            <td class="py-4">
                ${statusBadge(inv)}
            </td>

            <!-- Is Scheduled -->
            <td class="py-4">
                <div class="flex items-center gap-2">

                    <button
                        type="button"
                        class="scheduled-toggle relative inline-flex h-6 w-11 items-center rounded-full transition-colors duration-200
                        ${isScheduled
                            ? 'bg-[#B12F26]'
                            : 'bg-gray-300 dark:bg-gray-600'}"
                        data-id="${inv.id}"
                        data-scheduled="${isScheduled ? '1' : '0'}"
                    >

                        <span
                            class="inline-block h-4 w-4 transform rounded-full bg-white shadow transition-transform duration-200
                            ${isScheduled
                                ? 'translate-x-6'
                                : 'translate-x-1'}">
                        </span>

                    </button>

                    <span class="schedule-label text-sm text-gray-600 dark:text-dark-muted">
                        ${isScheduled ? 'Yes' : 'No'}
                    </span>

                </div>
            </td>

         <td class="py-4 text-ink dark:text-dark-text">
    ${formatCurrency(inv.total, inv.currency ?? inv.currency_code ?? inv.currencyCode)}
</td>

            <td class="py-4 text-right">

                <div class="dropdown relative inline-block">

                    <button
                        type="button"
                        class="dropdown-toggle w-9 h-9 rounded-md border border-gray-200 dark:border-dark-border text-gray-500 dark:text-dark-muted hover:bg-gray-50 dark:hover:bg-dark-border flex items-center justify-center"
                    >
                        ...
                    </button>

                    ${rowActionsMenu(inv)}

                </div>

            </td>

        </tr>
    `;

}).join('');

      totalRecords.textContent = tr('dashboard.totalRecords', { count: invoices.length });
      attachRowHandlers();
    }

async function fetchFullInvoice(id) {

  try {
    const res = await fetch(
      `/api/get_invoice.php?id=${encodeURIComponent(id)}`,
      {
        method: 'GET',
        credentials: 'same-origin',
        cache: 'no-store',
        headers: {
          'Accept': 'application/json'
        }
      }
    );

    console.log('Status:', res.status);
    console.log('Content-Type:', res.headers.get('content-type'));

    const text = await res.text();



    if (!res.ok) {
      console.error('Invoice API failed');
      return null;
    }

    let data;

    try {
      data = JSON.parse(text);
    } catch (error) {
      console.error('JSON Parse Error:', error);
      return null;
    }

    console.log('INVOICE DATA:', data);

    data.uploadedLogoData =
      data.uploadedLogoData ||
      data.logo_data ||
      '';

    return data;

  } catch (error) {
    console.error('Fetch Invoice Error:', error);
    return null;
  }
}

    function attachRowHandlers() {
           // ---------- Scheduled Toggle ----------
document.querySelectorAll('.delete-link').forEach(link => {
    link.addEventListener('click', async (e) => {
        e.preventDefault();

        const id = link.dataset.id;

        if (!id) {
            alert('Invoice ID missing.');
            return;
        }

        // Ask confirmation only once
        if (!confirm('Are you sure you want to permanently delete this invoice?')) {
            return;
        }

        try {
            const res = await fetch('api/due_delete_invoice.php', {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    id: id
                })
            });

            const data = await res.json();

            if (!res.ok || !data.success) {
                alert(data.error || 'Invoice delete failed.');
                return;
            }

          
            await loadInvoices();

        } catch (error) {
            console.error('Delete error:', error);
            alert('Delete request failed.');
        }
    });
});

      document.querySelectorAll('.restore-link').forEach(link => {
        link.addEventListener('click', async (e) => {
          e.preventDefault();
          const id = link.dataset.id;
          const res = await fetch('api/restore_invoice.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id })
          });
          if (res.ok) loadInvoices();
          else alert(tr('alert.restoreFailed'));
        });
      });

      document.querySelectorAll('.download-link').forEach(link => {
        link.addEventListener('click', async (e) => {
          e.preventDefault();
          const data = await fetchFullInvoice(link.dataset.id);
          if (!data) return;
          await InvoicePdf.download(data, document.getElementById('printInvoice'), `invoice-${data.invoiceNumber || data.id}.pdf`);
        });
      });

document.querySelectorAll('.edit-link').forEach(link => {
  link.addEventListener('click', async (e) => {
    e.preventDefault();

    const data = await fetchFullInvoice(link.dataset.id);
    if (!data) return;

    // Prepare complete invoice data for edit page
    const editData = {
      ...data,

      // Scheduled status
      isScheduled: Number(
        data.is_scheduled ??
        data.isScheduled ??
        0
      ),

      // Schedule frequency
      scheduleFrequency:
        data.schedule_frequency ??
        data.scheduleFrequency ??
        '',

      // Customer email
      customerEmail:
        data.customer_email ??
        data.customerEmail ??
        ''
    };

    sessionStorage.setItem(
      'editInvoiceData',
      JSON.stringify(editData)
    );

    sessionStorage.setItem(
      'editInvoiceId',
      link.dataset.id
    );

    // Get invoice number
    const invoiceNumber =
      data.invoice_number ??
      data.invoiceNumber ??
      '';

    // Open edit page with invoice number in URL
    window.location.href =
      './?edit=' +
      encodeURIComponent(invoiceNumber);
  });
});

      document.querySelectorAll('.duplicate-link').forEach(link => {
        link.addEventListener('click', async (e) => {
          e.preventDefault();
          const data = await fetchFullInvoice(link.dataset.id);
          if (!data) return;
          delete data.id;
          data.invoiceNumber = '';
          data.status = 'Open';
          sessionStorage.setItem('duplicateInvoiceData', JSON.stringify(data));
          window.location.href = './?duplicate=1';
        });
      });

      document.querySelectorAll('.mark-paid-link').forEach(link => {
        link.addEventListener('click', async (e) => {
          e.preventDefault();
          const id = link.dataset.id;
          const res = await fetch('api/mark_paid.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id })
          });
          if (res.ok) loadInvoices();
          else alert(tr('alert.updateFailed'));
        });
      });

     // Reference number opens the invoice; customer name opens their customer page
// Reference number opens the invoice edit page
document.querySelectorAll('.reference-link').forEach(link => {
    link.addEventListener('click', async (e) => {
        e.preventDefault();

        const id = link.dataset.id;
        const data = await fetchFullInvoice(id);

        if (!data) return;

        const editData = {
            ...data,
            isScheduled: Number(
                data.is_scheduled ?? data.isScheduled ?? 0
            ),
            scheduleFrequency:
                data.schedule_frequency ?? data.scheduleFrequency ?? '',
            customerEmail:
                data.customer_email ?? data.customerEmail ?? ''
        };

        sessionStorage.setItem(
            'editInvoiceData',
            JSON.stringify(editData)
        );

        sessionStorage.setItem('editInvoiceId', id);

        const invoiceNumber =
            data.invoice_number ?? data.invoiceNumber ?? '';

        window.location.href =
            './?edit=' + encodeURIComponent(invoiceNumber);
    });
});
      document.querySelectorAll('.customer-link').forEach(link => {
        link.addEventListener('click', (e) => {
          e.preventDefault();
          const name = (link.textContent || '').trim();
          if (name && name !== '—') {
            window.location.href = `customer-view?name=${encodeURIComponent(name)}`;
          }
        });
      });
    }

    // ---------- Load invoices ----------
async function loadInvoices() {
  loadingState.classList.remove('hidden');
  emptyState.classList.add('hidden');
  tableWrap.classList.add('hidden');

  const url = `api/get_invoices.php?view=${currentView}&per_page=${currentPerPage}`;



  const res = await fetch(url, {
    cache: 'no-store'
  });



  if (!res.ok) {

    window.location.href = 'signin';
    return;
  }

  const data = await res.json();

 

  renderInvoices(data);
}
function formatCurrency(amount, currencyValue) {
    const currency = String(currencyValue || 'USD').trim();
    const code = currency.split(' ')[0];

   const symbols = {
    AED: 'د.إ',
    AFN: '؋',
    ALL: 'Lek',
    AMD: '֏',
    AOA: 'Kz',
    ARS: '$',
    AUD: 'A$',
    AWG: 'ƒ',
    AZN: '₼',
    BAM: 'KM',
    BBD: 'Bds$',
    BDT: '৳',
    BGN: 'лв',
    BHD: '.د.ب',
    BIF: 'FBu',
    BMD: 'BD$',
    BND: 'B$',
    BOB: 'Bs.',
    BOV: 'BOV',
    BRL: 'R$',
    BSD: 'B$',
    BTN: 'Nu.',
    BWP: 'P',
    BYN: 'Br',
    BZD: 'BZ$',
    CAD: 'CA$',
    CDF: 'FC',
    CHE: 'CHE',
    CHF: 'CHF',
    CHW: 'CHW',
    CLF: 'UF',
    CLP: '$',
    CNY: 'CN¥',
    COP: '$',
    COU: 'COU',
    CRC: '₡',
    CUP: '₱',
    CVE: 'CVE$',
    CZK: 'Kč',
    DJF: 'Fdj',
    DKK: 'kr',
    DOP: 'RD$',
    DZD: 'د.ج',
    EGP: 'E£',
    ERN: 'Nfk',
    ETB: 'Br',
    EUR: '€',
    FJD: 'FJ$',
    FKP: '£',
    GBP: '£',
    GEL: '₾',
    GHS: 'GH₵',
    GIP: '£',
    GMD: 'D',
    GNF: 'FG',
    GTQ: 'Q',
    GYD: 'G$',
    HKD: 'HK$',
    HNL: 'L',
    HTG: 'G',
    HUF: 'Ft',
    IDR: 'Rp',
    ILS: '₪',
    INR: 'Rs',
    IQD: 'ع.د',
    IRR: '﷼',
    ISK: 'kr',
    JMD: 'J$',
    JOD: 'د.ا',
    JPY: '¥',
    KES: 'KSh',
    KGS: 'сом',
    KHR: '៛',
    KMF: 'CF',
    KPW: '₩',
    KRW: '₩',
    KWD: 'د.ك',
    KYD: 'CI$',
    KZT: '₸',
    LAK: '₭',
    LBP: 'ل.ل',
    LKR: 'Rs',
    LRD: 'L$',
    LSL: 'L',
    LYD: 'ل.د',
    MAD: 'د.م.',
    MDL: 'L',
    MGA: 'Ar',
    MKD: 'ден',
    MMK: 'K',
    MNT: '₮',
    MOP: 'MOP$',
    MRU: 'UM',
    MUR: 'Rs',
    MVR: 'Rf',
    MWK: 'MK',
    MXN: 'MX$',
    MXV: 'MXV',
    MYR: 'RM',
    MZN: 'MT',
    NAD: 'N$',
    NGN: '₦',
    NIO: 'C$',
    NOK: 'kr',
    NPR: 'Rs',
    NZD: 'NZ$',
    OMR: 'ر.ع.',
    PAB: 'B/.',
    PEN: 'S/',
    PGK: 'K',
    PHP: '₱',
    PKR: 'Rs',
    PLN: 'zł',
    PYG: '₲',
    QAR: 'ر.ق',
    RON: 'lei',
    RSD: 'дин.',
    RUB: '₽',
    RWF: 'RF',
    SAR: 'ر.س',
    SBD: 'SI$',
    SCR: 'Rs',
    SDG: 'ج.س.',
    SEK: 'kr',
    SGD: 'S$',
    SHP: '£',
    SLE: 'Le',
    SOS: 'Sh',
    SRD: 'Sr$',
    SSP: '£',
    STN: 'Db',
    SVC: '$',
    SYP: '£',
    SZL: 'L',
    THB: '฿',
    TJS: 'ЅМ',
    TMT: 'm',
    TND: 'د.ت',
    TOP: 'T$',
    TRY: '₺',
    TTD: 'TT$',
    TWD: 'NT$',
    TZS: 'TSh',
    UAH: '₴',
    UGX: 'USh',
    USD: '$',
    USN: 'USN',
    UYI: 'UYI',
    UYU: '$U',
    UYW: 'UYW',
    UZS: 'soʻm',
    VED: 'VED',
    VES: 'Bs.',
    VND: '₫',
    VUV: 'VT',
    WST: 'WS$',
    XAD: 'XAD',
    XAF: 'FCFA',
    XAG: 'XAG',
    XAU: 'XAU',
    XBA: 'XBA',
    XBB: 'XBB',
    XBC: 'XBC',
    XBD: 'XBD',
    XCD: 'EC$',
    XCG: 'Cg',
    XDR: 'SDR',
    XOF: 'CFA',
    XPD: 'XPD',
    XPF: '₣',
    XPT: 'XPT',
    XSU: 'XSU',
    XTS: 'XTS',
    XUA: 'XUA',
    XXX: 'XXX',
    YER: '﷼',
    ZAR: 'R',
    ZMW: 'ZK',
    ZWG: 'ZiG'
};

    const symbol = symbols[code] || code;

    return `${symbol} ${Number(amount || 0).toLocaleString('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    })}`;
}
    // ---------- CSV Import ----------
    document.getElementById('importFile').addEventListener('change', async (e) => {
      const file = e.target.files[0];
      if (!file) return;
      const formData = new FormData();
      formData.append('csv', file);
      const res = await fetch('api/import_invoices.php', { method: 'POST', body: formData });
      const data = await res.json().catch(() => ({}));
      if (res.ok) {
        alert(tr('dashboard.imported', { count: data.imported ?? 0 }));
        loadInvoices();
      } else {
        alert(data.error || tr('alert.importFailed'));
      }
      e.target.value = '';
    });

    // ---------- Init ----------
    window.addEventListener('invoicegen:languagechange', () => loadInvoices());
    checkSession();

    loadInvoices();
  </script>
<?php require __DIR__ . '/includes/footer.php'; ?>
