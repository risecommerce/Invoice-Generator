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


<main class="min-h-screen px-4 py-8 sm:px-6 lg:px-8">

    <div class="mx-auto max-w-7xl">


        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>

                <h1 class="text-2xl font-semibold tracking-tight text-gray-900 sm:text-3xl">
                    Scheduled Invoices
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    Manage your recurring and scheduled invoices.
                </p>

            </div>

            <div class="flex items-center gap-3">

                <a
                    href="./"
                    class="inline-flex items-center justify-center rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-sm transition hover:bg-gray-50"
                >

                    <svg
                        class="mr-2 h-4 w-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 19l-7-7 7-7M19 12H5"
                        />

                    </svg>

                    Create Invoice

                </a>

            </div>

        </div>

        <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-3">

            <!-- Total Scheduled -->

            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-sm font-medium text-gray-500">
                            Total Scheduled
                        </p>

                        <p
                            id="totalScheduled"
                            class="mt-2 text-2xl font-semibold text-gray-900"
                        >
                            0
                        </p>

                    </div>

                    <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-gray-100">

                        <svg
                            class="h-5 w-5 text-gray-700"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                            />

                        </svg>

                    </div>

                </div>

            </div>


            <!-- Active -->

            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-sm font-medium text-gray-500">
                            Active Schedules
                        </p>

                        <p
                            id="activeScheduled"
                            class="mt-2 text-2xl font-semibold text-gray-900"
                        >
                            0
                        </p>

                    </div>

                    <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-gray-100">

                        <svg
                            class="h-5 w-5 text-gray-700"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M5 13l4 4L19 7"
                            />

                        </svg>

                    </div>

                </div>

            </div>


            <!-- Outstanding -->

            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-sm font-medium text-gray-500">
                            Outstanding Balance
                        </p>

                        <p
                            id="totalBalance"
                            class="mt-2 text-2xl font-semibold text-gray-900"
                        >
                            0.00
                        </p>

                    </div>

                    <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-gray-100">

                        <svg
    class="h-5 w-5 text-gray-700"
    fill="none"
    stroke="currentColor"
    viewBox="0 0 24 24"
>
    <rect
        x="3"
        y="5"
        width="18"
        height="14"
        rx="2"
        stroke-width="2"
    />
    <path
        stroke-linecap="round"
        stroke-linejoin="round"
        stroke-width="2"
        d="M3 10h18M7 15h4"
    />
</svg>

                    </div>

                </div>

            </div>

        </div>


        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

            <!-- Table Header -->

            <div class="border-b border-gray-200 px-5 py-4 sm:px-6">

                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                    <div>

                        <h2 class="text-base font-semibold text-gray-900">
                            Scheduled Invoices
                        </h2>

                        <p class="mt-1 text-xs text-gray-500">
                            Your recurring invoice schedules
                        </p>

                    </div>


                    <!-- Search -->

                    <div class="relative w-full sm:w-72">

                        <svg
                            class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M21 21l-4.35-4.35m1.35-5.65a7 7 0 11-14 0 7 7 0 0114 0z"
                            />

                        </svg>

                        <input
                            id="searchInput"
                            type="text"
                            placeholder="Search invoices..."
                            class="w-full rounded-lg border border-gray-200 bg-gray-50 py-2.5 pl-9 pr-3 text-sm outline-none transition focus:border-gray-400 focus:bg-white focus:ring-2 focus:ring-gray-100"
                        >

                    </div>

                </div>

            </div>


            <div class="table-scroll overflow-x-auto">

                <table class="invoice-table min-w-full text-left">

                    <thead class="border-b border-gray-200 bg-gray-50">

                        <tr>

                            <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wide text-gray-500">
                                Invoice
                            </th>

                            <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wide text-gray-500">
                                Customer
                            </th>

                            <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wide text-gray-500">
                                Frequency
                            </th>

                            <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wide text-gray-500">
                                Invoice Date
                            </th>

                            <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wide text-gray-500">
                                Due Date
                            </th>

                            <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wide text-gray-500">
                                Total
                            </th>

                            <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wide text-gray-500">
                                Balance
                            </th>

                            <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wide text-gray-500">
                                Status
                            </th>

                            <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wide text-gray-500">
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody
                        id="scheduledInvoicesBody"
                        class="divide-y divide-gray-100"
                    >

                        <tr id="loadingRow">

                            <td
                                colspan="9"
                                class="px-5 py-16 text-center"
                            >

                                <div class="flex flex-col items-center justify-center">

                                    <div class="loading-spinner"></div>

                                    <p class="mt-3 text-sm text-gray-500">
                                        Loading scheduled invoices...
                                    </p>

                                </div>

                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>


            <div
                id="emptyState"
                class="hidden px-6 py-16 text-center"
            >

                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-gray-100">

                    <svg
                        class="h-6 w-6 text-gray-500"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                        />

                    </svg>

                </div>

                <h3 class="mt-4 text-sm font-semibold text-gray-900">
                    No scheduled invoices
                </h3>

                <p class="mx-auto mt-1 max-w-sm text-sm text-gray-500">
                    You don't have any scheduled invoices yet.
                    Create an invoice and enable scheduling to see it here.
                </p>

                <a
                    href="./"
                    class="mt-5 inline-flex items-center rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-gray-800"
                >
                    Create Invoice
                </a>

            </div>


            <div
                id="errorState"
                class="hidden px-6 py-16 text-center"
            >

                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-red-50">

                    <svg
                        class="h-6 w-6 text-red-500"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 9v3m0 4h.01M12 3a9 9 0 100 18 9 9 0 000-18z"
                        />

                    </svg>

                </div>

                <h3 class="mt-4 text-sm font-semibold text-gray-900">
                    Unable to load invoices
                </h3>

                <p
                    id="errorMessage"
                    class="mt-1 text-sm text-gray-500"
                >
                    Something went wrong.
                </p>

                <button
                    onclick="loadScheduledInvoices()"
                    class="mt-5 rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-gray-800"
                >
                    Try Again
                </button>

            </div>

        </div>

    </div>

</main>
<?php include __DIR__ . '/modal/invoice-details-modal.php'; ?>
<script>

let scheduledInvoices = [];


async function loadHeaderUser() {

    try {

        const response = await fetch(
            'api/session_check.php',
            {
                method: 'GET',
                credentials: 'same-origin',
                cache: 'no-store',
                headers: {
                    'Accept': 'application/json'
                }
            }
        );

        if (!response.ok) {
            return;
        }

        const data = await response.json();

        /*
         * Support both possible response structures.
         */

        const user =
            data.user && typeof data.user === 'object'
                ? data.user
                : data;

        const firstName =
            String(
                user.firstName ||
                user.first_name ||
                ''
            ).trim();

        const lastName =
            String(
                user.lastName ||
                user.last_name ||
                ''
            ).trim();

        const email =
            String(
                user.email ||
                user.userEmail ||
                user.user_email ||
                ''
            ).trim();

       const fullName =
    lastName
        ? `${firstName}.${lastName.charAt(0).toLowerCase()}`
        : firstName || 'Account';

        /*
         * Create initials.
         */

        let initials = '';

        if (firstName) {
            initials += firstName.charAt(0).toUpperCase();
        }

        if (lastName) {
            initials += lastName.charAt(0).toUpperCase();
        }

        if (!initials && fullName) {

            const parts =
                fullName
                    .split(/\s+/)
                    .filter(Boolean);

            if (parts.length >= 2) {

                initials =
                    parts[0].charAt(0).toUpperCase() +
                    parts[parts.length - 1].charAt(0).toUpperCase();

            } else {

                initials =
                    fullName
                        .charAt(0)
                        .toUpperCase();

            }

        }

        initials = initials || 'U';


        /*
         * Header elements.
         */

        const initialsElement =
            document.getElementById('userInitials');

        const nameElement =
            document.getElementById('userName');

        const fullNameElement =
            document.getElementById('userNameFull');

        const emailElement =
            document.getElementById('userEmail');


        if (initialsElement) {
            initialsElement.textContent = initials;
        }

        if (nameElement) {
            nameElement.textContent = fullName;
        }

        if (fullNameElement) {
            fullNameElement.textContent = fullName;
        }

        if (emailElement) {
            emailElement.textContent = email;
        }


    } catch (error) {

        console.error(
            'Unable to load user information:',
            error
        );

    }

}

async function loadScheduledInvoices() {

    const tbody =
        document.getElementById(
            'scheduledInvoicesBody'
        );

    const loadingRow =
        document.getElementById(
            'loadingRow'
        );

    const emptyState =
        document.getElementById(
            'emptyState'
        );

    const errorState =
        document.getElementById(
            'errorState'
        );


    loadingRow.classList.remove('hidden');

    emptyState.classList.add('hidden');

    errorState.classList.add('hidden');


    tbody
        .querySelectorAll(
            'tr:not(#loadingRow)'
        )
        .forEach(
            row => row.remove()
        );


    try {

        const response =
            await fetch(
                'api/get_scheduled_invoices.php',
                {
                    method: 'GET',
                    credentials: 'same-origin',
                    headers: {
                        'Accept': 'application/json'
                    }
                }
            );


        const result =
            await response.json();


        if (
            !response.ok ||
            !result.success
        ) {

            throw new Error(
                result.error ||
                'Unable to load scheduled invoices.'
            );

        }


        scheduledInvoices =
            Array.isArray(result.data)
                ? result.data
                : [];


        loadingRow.classList.add('hidden');


        updateStats(
            scheduledInvoices
        );


        if (
            scheduledInvoices.length === 0
        ) {

            emptyState.classList.remove('hidden');

            return;
        }


        renderInvoices(
            scheduledInvoices
        );


    } catch (error) {

        console.error(
            'Scheduled invoice error:',
            error
        );


        loadingRow.classList.add('hidden');


        document.getElementById(
            'errorMessage'
        ).textContent =
            error.message;


        errorState.classList.remove(
            'hidden'
        );

    }

}



function updateStats(invoices) {

    document.getElementById('totalScheduled').textContent =
        invoices.length;

    document.getElementById('activeScheduled').textContent =
        invoices.filter(invoice =>
            Number(invoice.is_scheduled) === 1
        ).length;

    let totalBalance = 0;

    invoices.forEach(invoice => {

        const balance = parseFloat(invoice.balance);

        if (!Number.isNaN(balance)) {
            totalBalance += balance;
        }

    });

    const currency = invoices.length > 0
        ? invoices[0].currency
        : 'USD ($)';

    document.getElementById('totalBalance').textContent =
        formatMoney(totalBalance, currency);
}


function renderInvoices(invoices) {

    const tbody =
        document.getElementById(
            'scheduledInvoicesBody'
        );


    invoices.forEach(
        invoice => {

            const row =
                document.createElement(
                    'tr'
                );


            row.className =
                'transition hover:bg-gray-50';


            const frequency =
                formatFrequency(
                    invoice.schedule_frequency
                );


            const total = formatNumber(invoice.total);


           const balance = formatNumber(invoice.balance);


            row.innerHTML = `

                <!-- Invoice -->

                <td class="px-5 py-4">

                    <div class="flex items-center gap-3">

                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-gray-100">

                            <svg
                                class="h-4 w-4 text-gray-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M7 3h8l4 4v14H7a2 2 0 01-2-2V5a2 2 0 012-2z"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M15 3v5h5"
                                />

                            </svg>

                        </div>


                        <div>

                            <div class="font-medium text-gray-900">
                                ${escapeHtml(
                                    invoice.invoice_number || '—'
                                )}
                            </div>


                        </div>

                    </div>

                </td>


                <!-- Customer -->

                <td class="px-5 py-4">

                    <div class="max-w-[220px]">

                        <div class="truncate text-sm font-medium text-gray-800">

                            ${escapeHtml(
                                invoice.customer_email ||
                                'No email'
                            )}

                        </div>

                    </div>

                </td>


                <!-- Frequency -->

                <td class="px-5 py-4">

                    <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-700">

                        ${escapeHtml(frequency)}

                    </span>

                </td>


                <!-- Invoice Date -->

                <td class="px-5 py-4 text-sm text-gray-600">

                    ${escapeHtml(
                        formatDate(
                            invoice.invoice_date
                        )
                    )}

                </td>


                <!-- Due Date -->

                <td class="px-5 py-4 text-sm text-gray-600">

                    ${escapeHtml(
                        formatDate(
                            invoice.due_date
                        )
                    )}

                </td>


                <!-- Total -->

                <td class="px-5 py-4">

                    <span class="text-sm font-semibold text-gray-900">

                        ${escapeHtml(total)}

                    </span>

                </td>


                <!-- Balance -->

                <td class="px-5 py-4">

                    <span class="text-sm font-medium text-gray-700">

                        ${escapeHtml(balance)}

                    </span>

                </td>


                <!-- Status -->

                <td class="px-5 py-4">

                    <span class="inline-flex items-center gap-1.5 rounded-full bg-green-50 px-2.5 py-1 text-xs font-medium text-green-700">

                        <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>

                        Active

                    </span>

                </td>


                <!-- Actions -->

              <td class="px-5 py-4 text-right">

  <button
    type="button"
    class="view-invoice-btn inline-flex items-center gap-1.5 rounded-lg border border-gray-200 bg-white px-3 py-2 text-xs font-medium text-gray-700 shadow-sm transition hover:border-[#B12F26] hover:bg-red-50 hover:text-[#B12F26]"
    data-invoice-id="${escapeHtml(invoice.id)}"
    onclick="viewInvoice(${Number(invoice.id)})"
>

        <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-3.5 w-3.5"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="1.8"
        >
   
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M2.25 12s3.75-7 9.75-7 9.75 7 9.75 7-3.75 7-9.75 7-9.75-7-9.75-7z"
            />

            <circle
                cx="12"
                cy="12"
                r="2.5"
            />

        </svg>

        View

    </button>

</td>
            `;
            tbody.appendChild(
                row
            ); 

        }
    );

}


document
    .getElementById('searchInput')
    .addEventListener(
        'input',
        function () {

            const search =
                this.value
                    .toLowerCase()
                    .trim();


            if (!search) {

                renderSearchResults(
                    scheduledInvoices
                );

                return;

            }


            const filtered =
                scheduledInvoices.filter(
                    invoice => {

                        const invoiceNumber =
                            String(
                                invoice.invoice_number || ''
                            ).toLowerCase();


                        const email =
                            String(
                                invoice.customer_email || ''
                            ).toLowerCase();


                        const frequency =
                            String(
                                invoice.schedule_frequency || ''
                            ).toLowerCase();


                        return (
                            invoiceNumber.includes(search) ||
                            email.includes(search) ||
                            frequency.includes(search)
                        );

                    }
                );


            renderSearchResults(
                filtered
            );

        }
    );


function renderSearchResults(
    invoices
) {

    const tbody =
        document.getElementById(
            'scheduledInvoicesBody'
        );


    tbody
        .querySelectorAll(
            'tr:not(#loadingRow)'
        )
        .forEach(
            row => row.remove()
        );


    if (
        invoices.length === 0
    ) {

        const row =
            document.createElement(
                'tr'
            );


        row.innerHTML = `

            <td
                colspan="9"
                class="px-5 py-12 text-center"
            >

                <p class="text-sm font-medium text-gray-700">
                    No invoices found
                </p>

                <p class="mt-1 text-xs text-gray-500">
                    Try a different search term.
                </p>

            </td>

        `;


        tbody.appendChild(
            row
        );


        return;

    }


    renderInvoices(
        invoices
    );

}

function formatFrequency(value) {

    if (!value) {
        return '—';
    }


    const frequencies = {

        'weekly': 'Weekly',

        'bi-weekly': 'Bi-Weekly',

        'monthly': 'Monthly',

        'bi-monthly': 'Bi-Monthly',

        'quarterly': 'Quarterly',

        'tri-yearly': 'Tri-Yearly',

        'triannually': 'Tri-Yearly',

        'half-yearly': 'Half-Yearly',

        'yearly': 'Yearly'

    };


    return frequencies[value] ||
        String(value)
            .replace(/-/g, ' ')
            .replace(/\b\w/g, letter =>
                letter.toUpperCase()
            );

}


function formatDate(value) {

    if (!value) {
        return '—';
    }


    const date =
        new Date(value);


    if (
        Number.isNaN(
            date.getTime()
        )
    ) {

        return String(value);

    }


    return date.toLocaleDateString(
        undefined,
        {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        }
    );

}

function formatMoney(value, currency) {
    const amount = parseFloat(value || 0);

    return getCurrencySymbol(currency) +
        formatNumber(amount);
}


function formatNumber(value) {

    return Number(
        value || 0
    ).toLocaleString(
        undefined,
        {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }
    );

}

function getCurrencySymbol(currency) {

    if (!currency) {
        return '$';
    }

    const symbols = {
        'USD ($)': '$',
        'USD': '$',

        'EUR (€)': '€',
        'EUR': '€',

        'GBP (£)': '£',
        'GBP': '£',

        'INR (Rs)': 'Rs',
        'INR (Rs)': 'Rs',
        'INR': 'Rs',

        'CAD ($)': 'CA$',
        'CAD': 'CA$',

        'AUD ($)': 'A$',
        'AUD': 'A$',

        'JPY (¥)': '¥',
        'JPY': '¥'
    };

    return symbols[String(currency).trim()] || currency;
}


function escapeHtml(value) {

    return String(
        value ?? ''
    )
        .replace(
            /&/g,
            '&amp;'
        )
        .replace(
            /</g,
            '&lt;'
        )
        .replace(
            />/g,
            '&gt;'
        )
        .replace(
            /"/g,
            '&quot;'
        )
        .replace(
            /'/g,
            '&#039;'
        );

}


function viewInvoice(id) {
    if (!id) {
        return;
    }

    const invoice = scheduledInvoices.find(function (item) {
        return Number(item.id) === Number(id);
    });

    if (!invoice) {
        return;
    }

    if (typeof openInvoiceModal === 'function') {
        openInvoiceModal(invoice);
    }
}

function editInvoice(id) {

    if (!id) {
        return;
    }


    window.location.href =
        `./?edit=${encodeURIComponent(id)}`;

}


document.addEventListener('click', function (e) {

    const toggle = e.target.closest('.dropdown-toggle');

    if (toggle) {

        e.preventDefault();
        e.stopPropagation();

        const dropdown = toggle.closest('.dropdown');

        if (!dropdown) {
            return;
        }

        const menu = dropdown.querySelector('.dropdown-menu');

        if (!menu) {
            return;
        }

        const wasOpen =
            menu.classList.contains('dropdown-menu-open');

        // Close all dropdowns
        document.querySelectorAll('.dropdown-menu').forEach(item => {
            item.classList.remove('dropdown-menu-open');
            item.style.display = 'none';
        });

        // Open clicked dropdown
        if (!wasOpen) {

            menu.classList.add('dropdown-menu-open');
            menu.style.display = 'block';
            menu.style.zIndex = '99999';

        }

        return;
    }

    // Close when clicking outside
    if (!e.target.closest('.dropdown-menu')) {

        document.querySelectorAll('.dropdown-menu').forEach(menu => {

            menu.classList.remove('dropdown-menu-open');
            menu.style.display = 'none';

        });

    }

});


document.addEventListener('DOMContentLoaded', function () {

    loadHeaderUser();

    loadScheduledInvoices();

});

</script>



</html>