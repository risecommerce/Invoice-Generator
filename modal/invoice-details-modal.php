<div
    id="invoiceModal"
    class="fixed inset-0 z-[9999] hidden"
    aria-hidden="true"
>
    <div
        id="invoiceModalBackdrop"
        class="absolute inset-0 bg-black/60 backdrop-blur-sm"
    ></div>

    <div class="relative flex min-h-full items-center justify-center p-4 sm:p-6">
        <div
            id="invoiceModalPanel"
            class="relative flex max-h-[92vh] w-full max-w-5xl flex-col overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-2xl dark:border-gray-700 dark:bg-gray-900"
        >
            <div class="flex items-center justify-between border-b border-gray-200 px-5 py-4 dark:border-gray-700 sm:px-6">
                <div class="min-w-0">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#B12F26]/10 text-[#B12F26]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 14.25l6-6m-6.75 0h.008v.008H8.25V8.25zm7.5 7.5h.008v.008h-.008v-.008z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 3.75h9A2.25 2.25 0 0118.75 6v12A2.25 2.25 0 0116.5 20.25h-9A2.25 2.25 0 015.25 18V6A2.25 2.25 0 017.5 3.75z"/>
                            </svg>
                        </div>

                        <div class="min-w-0">
                            <h2
                                id="modalInvoiceNumber"
                                class="truncate text-lg font-bold text-gray-900 dark:text-white"
                            >
                                Invoice Details
                            </h2>

                            <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-400">
                                Scheduled invoice information
                            </p>
                        </div>
                    </div>
                </div>

                <button
                    type="button"
                    id="closeInvoiceModal"
                    class="ml-4 flex h-9 w-9 shrink-0 items-center justify-center rounded-lg text-gray-500 transition hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white"
                    aria-label="Close"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 6l12 12M18 6L6 18"/>
                    </svg>
                </button>
            </div>

            <div
                id="invoiceModalContent"
                class="overflow-y-auto px-5 py-5 sm:px-6 sm:py-6"
            ></div>

            <div class="flex items-center justify-end border-t border-gray-200 bg-gray-50 px-5 py-4 dark:border-gray-700 dark:bg-gray-800/50 sm:px-6">
                <button
                    type="button"
                    id="closeInvoiceModalBottom"
                    class="rounded-lg bg-[#B12F26] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#95261F] focus:outline-none focus:ring-2 focus:ring-[#B12F26]/30"
                >
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<script>
(function () {
    function escapeModalHtml(value) {
        if (value === null || value === undefined) {
            return '';
        }

        return String(value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function formatModalNumber(value) {
        const number = Number(value);

        if (!Number.isFinite(number)) {
            return '0.00';
        }

        return number.toLocaleString(undefined, {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    function formatModalDate(value) {
        if (!value) {
            return '—';
        }

        const date = new Date(value);

        if (Number.isNaN(date.getTime())) {
            return escapeModalHtml(value);
        }

        return date.toLocaleDateString(undefined, {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        });
    }

  function getCurrencySymbol(currency) {

    if (!currency) {
        return '$';
    }

    const value = String(currency).trim().toUpperCase();

    const symbols = {
        'INR': '₹',
        'INR (RS)': '₹',
        'INR (₹)': '₹',
        'INR (RS.)': '₹',

        'USD': '$',
        'USD ($)': '$',

        'EUR': '€',
        'EUR (€)': '€',

        'GBP': '£',
        'GBP (£)': '£',

        'CAD': 'CA$',
        'AUD': 'A$',
        'JPY': '¥'
    };

    return symbols[value] || currency;
}

    function formatModalFrequency(value) {
        if (!value) {
            return '—';
        }

        const frequency = String(value)
            .replace(/_/g, ' ')
            .replace(/-/g, ' ');

        return frequency
            .split(' ')
            .map(function (word) {
                return word.charAt(0).toUpperCase() + word.slice(1).toLowerCase();
            })
            .join(' ');
    }

    function getModalStatusClass(status) {
        const normalized = String(status || '').toLowerCase();

        if (
            normalized === 'paid' ||
            normalized === 'active' ||
            normalized === 'completed'
        ) {
            return 'bg-green-50 text-green-700 ring-green-600/20 dark:bg-green-500/10 dark:text-green-400';
        }

        if (
            normalized === 'pending' ||
            normalized === 'scheduled' ||
            normalized === 'sent'
        ) {
            return 'bg-blue-50 text-blue-700 ring-blue-600/20 dark:bg-blue-500/10 dark:text-blue-400';
        }

        if (
            normalized === 'overdue' ||
            normalized === 'failed' ||
            normalized === 'cancelled' ||
            normalized === 'canceled'
        ) {
            return 'bg-red-50 text-red-700 ring-red-600/20 dark:bg-red-500/10 dark:text-red-400';
        }

        if (
            normalized === 'draft' ||
            normalized === 'inactive'
        ) {
            return 'bg-gray-100 text-gray-700 ring-gray-500/20 dark:bg-gray-500/10 dark:text-gray-400';
        }

        return 'bg-gray-100 text-gray-700 ring-gray-500/20 dark:bg-gray-500/10 dark:text-gray-400';
    }

function getModalField(label, value) {
    if (
        value === null ||
        value === undefined ||
        String(value).trim() === '' ||
        String(value).trim().toLowerCase() === 'null'
    ) {
        return '';
    }

    return `
        <div class="rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-gray-900">
            <p class="text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">
                ${escapeModalHtml(label)}
            </p>
            <p class="mt-1.5 break-words text-sm font-semibold text-gray-900 dark:text-white">
                ${escapeModalHtml(value)}
            </p>
        </div>
    `;
}

function getModalAddress(title, value) {
    if (
        value === null ||
        value === undefined ||
        String(value).trim() === '' ||
        String(value).trim().toLowerCase() === 'null'
    ) {
        return '';
    }

    const content = escapeModalHtml(value).replace(/\n/g, '<br>');

    return `
        <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-800/50">
            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                ${escapeModalHtml(title)}
            </p>

            <div class="mt-2 text-sm leading-6 text-gray-700 dark:text-gray-300">
                ${content}
            </div>
        </div>
    `;
}

    function getModalAmountRow(label, value, extraClass) {
        return `
            <div class="flex items-center justify-between gap-4 py-2.5 ${extraClass || ''}">
                <span class="text-sm text-gray-600 dark:text-gray-400">
                    ${escapeModalHtml(label)}
                </span>

                <span class="text-sm font-semibold text-gray-900 dark:text-white">
                    ${escapeModalHtml(value)}
                </span>
            </div>
        `;
    }

    function parseLineItems(lineItems) {
        if (!lineItems) {
            return [];
        }

        if (Array.isArray(lineItems)) {
            return lineItems;
        }

        if (typeof lineItems === 'string') {
            try {
                const parsed = JSON.parse(lineItems);

                if (Array.isArray(parsed)) {
                    return parsed;
                }

                if (parsed && Array.isArray(parsed.items)) {
                    return parsed.items;
                }
            } catch (error) {
                return [];
            }
        }

        if (
            typeof lineItems === 'object' &&
            Array.isArray(lineItems.items)
        ) {
            return lineItems.items;
        }

        return [];
    }

    function getLineItemValue(item, keys, fallback) {
        for (let i = 0; i < keys.length; i++) {
            const key = keys[i];

            if (
                item &&
                item[key] !== undefined &&
                item[key] !== null &&
                item[key] !== ''
            ) {
                return item[key];
            }
        }

        return fallback;
    }

    function renderLineItems(invoice, currencySymbol) {
        const items = parseLineItems(invoice.line_items);

        if (!items.length) {
            return `
                <div class="rounded-xl border border-dashed border-gray-300 bg-gray-50 px-5 py-8 text-center dark:border-gray-700 dark:bg-gray-800/50">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        No line items available.
                    </p>
                </div>
            `;
        }

        let rows = '';

        items.forEach(function (item, index) {
            const description = getLineItemValue(
                item,
                ['description', 'name', 'item', 'title'],
                `Item ${index + 1}`
            );

            const quantity = getLineItemValue(
                item,
                ['quantity', 'qty'],
                1
            );

            const rate = getLineItemValue(
                item,
                ['rate', 'price', 'unit_price', 'unitPrice'],
                0
            );

            const amount = getLineItemValue(
                item,
                ['amount', 'total', 'line_total', 'lineTotal'],
                Number(quantity) * Number(rate)
            );

            rows += `
                <tr class="border-b border-gray-100 last:border-0 dark:border-gray-800">
                    <td class="px-4 py-3.5 text-sm text-gray-800 dark:text-gray-200">
                        ${escapeModalHtml(description)}
                    </td>

                    <td class="whitespace-nowrap px-4 py-3.5 text-right text-sm text-gray-600 dark:text-gray-400">
                        ${escapeModalHtml(quantity)}
                    </td>

                    <td class="whitespace-nowrap px-4 py-3.5 text-right text-sm text-gray-600 dark:text-gray-400">
                        ${escapeModalHtml(currencySymbol + formatModalNumber(rate))}
                    </td>

                    <td class="whitespace-nowrap px-4 py-3.5 text-right text-sm font-semibold text-gray-900 dark:text-white">
                        ${escapeModalHtml(currencySymbol + formatModalNumber(amount))}
                    </td>
                </tr>
            `;
        });

        return `
            <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-gray-700">
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gray-50 dark:bg-gray-800/70">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                    Description
                                </th>

                                <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                    Qty
                                </th>

                                <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                    Rate
                                </th>

                                <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                    Amount
                                </th>
                            </tr>
                        </thead>

                        <tbody class="bg-white dark:bg-gray-900">
                            ${rows}
                        </tbody>
                    </table>
                </div>
            </div>
        `;
    }

    function openInvoiceModal(invoice) {
        const modal = document.getElementById('invoiceModal');
        const content = document.getElementById('invoiceModalContent');
        const title = document.getElementById('modalInvoiceNumber');

        if (!modal || !content) {
            return;
        }

        const invoiceNumber = invoice.invoice_number || 'Invoice Details';
        const currency = invoice.currency || 'USD';
        const currencySymbol = getModalCurrencySymbol(currency);
        const status = invoice.status || 'Scheduled';

        if (title) {
            title.textContent = invoiceNumber;
        }

  const hasModalAmount = (value) => {
    if (
        value === null ||
        value === undefined ||
        String(value).trim() === '' ||
        String(value).trim().toLowerCase() === 'null'
    ) {
        return false;
    }

    return Number(value) !== 0;
};

const discountValue = invoice.discount_value;
const taxValue = invoice.tax_value;
const shippingValue = invoice.shipping_value;
const amountPaid = invoice.amount_paid;
const subtotal = invoice.subtotal;
const total = invoice.total;
const balance = invoice.balance;

        content.innerHTML = `
            <div class="space-y-6">

                <div class="flex flex-col gap-4 rounded-xl border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-800/50 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">
                            Invoice Number
                        </p>

                        <p class="mt-1 text-lg font-bold text-gray-900 dark:text-white">
                            ${escapeModalHtml(invoiceNumber)}
                        </p>
                    </div>

                    <div class="flex items-center gap-3">
                        <span class="inline-flex items-center rounded-full px-3 py-1.5 text-xs font-semibold ring-1 ring-inset ${getModalStatusClass(status)}">
                            ${escapeModalHtml(status)}
                        </span>
                    </div>
                </div>

                <section>
                    <div class="mb-3">
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white">
                            Invoice Information
                        </h3>
                    </div>

                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-3">
                        ${getModalField('Invoice Date', escapeModalHtml(formatModalDate(invoice.invoice_date)))}
                        ${getModalField('Due Date', escapeModalHtml(formatModalDate(invoice.due_date)))}
                        ${getModalField('Payment Terms', escapeModalHtml(invoice.payment_terms || '—'))}
                        ${getModalField('PO Number', escapeModalHtml(invoice.po_number || '—'))}
                        ${getModalField('Currency', escapeModalHtml(currency))}
                        ${getModalField('Customer Email', escapeModalHtml(invoice.customer_email || '—'))}
                        ${getModalField('Schedule Frequency', escapeModalHtml(formatModalFrequency(invoice.schedule_frequency)))}
                        ${getModalField('Created At', escapeModalHtml(formatModalDate(invoice.created_at)))}
                        ${getModalField('Updated At', escapeModalHtml(formatModalDate(invoice.updated_at)))}
                    </div>
                </section>

                <section>
                    <div class="mb-3">
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white">
                            Addresses
                        </h3>
                    </div>

                    <div class="grid grid-cols-1 gap-3 lg:grid-cols-3">
                        ${getModalAddress('Bill From', invoice.bill_from)}
                        ${getModalAddress('Bill To', invoice.bill_to)}
                        ${getModalAddress('Ship To', invoice.ship_to)}
                    </div>
                </section>

                <section>
                    <div class="mb-3 flex items-center justify-between gap-3">
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white">
                            Line Items
                        </h3>

                        <span class="text-xs font-medium text-gray-500 dark:text-gray-400">
                            ${escapeModalHtml(currency)}
                        </span>
                    </div>

                    ${renderLineItems(invoice, currencySymbol)}
                </section>

                <section>
                    <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">

                        <div class="rounded-xl border border-gray-200 bg-white p-5 dark:border-gray-700 dark:bg-gray-900">
                            <h3 class="text-sm font-bold text-gray-900 dark:text-white">
                                Notes
                            </h3>

                            ${
                                invoice.notes
                                    ? `<p class="mt-3 whitespace-pre-line text-sm leading-6 text-gray-600 dark:text-gray-400">${escapeModalHtml(invoice.notes)}</p>`
                                    : `<p class="mt-3 text-sm text-gray-400 dark:text-gray-500">No notes available.</p>`
                            }
                        </div>

                        <div class="rounded-xl border border-gray-200 bg-white p-5 dark:border-gray-700 dark:bg-gray-900">
                            <h3 class="text-sm font-bold text-gray-900 dark:text-white">
                                Terms
                            </h3>

                            ${
                                invoice.terms
                                    ? `<p class="mt-3 whitespace-pre-line text-sm leading-6 text-gray-600 dark:text-gray-400">${escapeModalHtml(invoice.terms)}</p>`
                                    : `<p class="mt-3 text-sm text-gray-400 dark:text-gray-500">No terms available.</p>`
                            }
                        </div>

                    </div>
                </section>

                <section>
    <div class="rounded-xl border border-gray-200 bg-white p-5 dark:border-gray-700 dark:bg-gray-900">
        <div class="mb-4">
            <h3 class="text-sm font-bold text-gray-900 dark:text-white">
                Payment Summary
            </h3>
        </div>

        <div class="space-y-0">

            ${
                hasModalAmount(subtotal)
                    ? getModalAmountRow(
                        'Subtotal',
                        currencySymbol + formatModalNumber(subtotal)
                    )
                    : ''
            }

            ${
                hasModalAmount(discountValue)
                    ? getModalAmountRow(
                        'Discount',
                        currencySymbol + formatModalNumber(discountValue)
                    )
                    : ''
            }

            ${
                hasModalAmount(taxValue)
                    ? getModalAmountRow(
                        'Tax',
                        currencySymbol + formatModalNumber(taxValue)
                    )
                    : ''
            }

            ${
                hasModalAmount(shippingValue)
                    ? getModalAmountRow(
                        'Shipping',
                        currencySymbol + formatModalNumber(shippingValue)
                    )
                    : ''
            }

            ${
                hasModalAmount(subtotal) ||
                hasModalAmount(discountValue) ||
                hasModalAmount(taxValue) ||
                hasModalAmount(shippingValue)
                    ? `<div class="my-2 border-t border-gray-200 dark:border-gray-700"></div>`
                    : ''
            }

            ${
                hasModalAmount(total)
                    ? getModalAmountRow(
                        'Total',
                        currencySymbol + formatModalNumber(total),
                        'text-base'
                    )
                    : ''
            }

            ${
                hasModalAmount(amountPaid)
                    ? getModalAmountRow(
                        'Amount Paid',
                        currencySymbol + formatModalNumber(amountPaid)
                    )
                    : ''
            }

            ${
                hasModalAmount(balance)
                    ? `
                        <div class="mt-2 rounded-lg bg-[#B12F26]/5 px-3">
                            ${getModalAmountRow(
                                'Balance',
                                currencySymbol + formatModalNumber(balance)
                            )}
                        </div>
                    `
                    : ''
            }

        </div>
    </div>
</section>

                ${
                    invoice.logo_data
                        ? `
                            <section>
                                <div class="mb-3">
                                    <h3 class="text-sm font-bold text-gray-900 dark:text-white">
                                        Invoice Logo
                                    </h3>
                                </div>

                                <div class="rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-gray-900">
                                    <img
                                        src="${escapeModalHtml(invoice.logo_data)}"
                                        alt="Invoice Logo"
                                        class="max-h-24 max-w-[220px] object-contain"
                                        onerror="this.parentElement.style.display='none';"
                                    >
                                </div>
                            </section>
                        `
                        : ''
                }

            </div>
        `;

        modal.classList.remove('hidden');
        modal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('overflow-hidden');
    }

    function closeInvoiceModal() {
        const modal = document.getElementById('invoiceModal');

        if (!modal) {
            return;
        }

        modal.classList.add('hidden');
        modal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('overflow-hidden');
    }

    window.openInvoiceModal = openInvoiceModal;
    window.closeInvoiceModal = closeInvoiceModal;

    document.addEventListener('DOMContentLoaded', function () {
        const closeButton = document.getElementById('closeInvoiceModal');
        const closeBottomButton = document.getElementById('closeInvoiceModalBottom');
        const backdrop = document.getElementById('invoiceModalBackdrop');

        if (closeButton) {
            closeButton.addEventListener('click', closeInvoiceModal);
        }

        if (closeBottomButton) {
            closeBottomButton.addEventListener('click', closeInvoiceModal);
        }

        if (backdrop) {
            backdrop.addEventListener('click', closeInvoiceModal);
        }

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                const modal = document.getElementById('invoiceModal');

                if (modal && !modal.classList.contains('hidden')) {
                    closeInvoiceModal();
                }
            }
        });
    });
})();
</script>