<?php

$pageTitle = 'Free Invoice Generator & Scheduler Online — Create, Send & Schedule Invoices | InvoiceScheduler';
$pageDescription = 'Create professional invoices for free with InvoiceScheduler. Schedule recurring invoices, add your logo, send via email, and download as PDF. No signup required — start invoicing instantly.';
$pageCanonical = 'https://invoicescheduler.com/';
$pageOgTitle = 'Free Invoice Generator & Scheduler — InvoiceScheduler.com';
$pageOgDescription = 'Create, schedule, and send professional invoices online for free. No signup needed.';
$pageBodyAttributes = ' class="bg-gray-100 dark:bg-dark-bg min-h-screen transition-colors duration-200"';
$pageHeader = 'index';

$pageJsonLd = <<<'HTML'
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebApplication",
  "name": "InvoiceScheduler",
  "url": "https://invoicescheduler.com",
  "description": "Free online invoice generator with scheduling, PDF download, email sending, and cloud storage.",
  "applicationCategory": "BusinessApplication",
  "operatingSystem": "Web",
  "offers": {
    "@type": "Offer",
    "price": "0",
    "priceCurrency": "USD"
  },
  "featureList": [
    "Create professional invoices",
    "Schedule recurring invoices",
    "Download invoices as PDF",
    "Send invoices via email",
    "Add custom logo",
    "Multiple currency support",
    "Cloud storage with account",
    "Dark mode"
  ]
}
</script>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "InvoiceScheduler",
  "url": "https://invoicescheduler.com",
  "logo": "https://invoicescheduler.com/assets/logo.png",
  "sameAs": []
}
</script>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {
      "@type": "ListItem",
      "position": 1,
      "name": "Home",
      "item": "https://invoicescheduler.com/"
    }
  ]
}
</script>
HTML;

$pageExtraHead = <<<'HTML'
<script src="/script.js"></script>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
<script>
  tailwind.config = {
    darkMode: 'class',
    theme: {
      extend: {
        colors: {
          brand: {
            green: '#1AA260',
            greenDark: '#0E8A4E',
            greenSoft: '#DFF6E7',
          },
          ink: '#1E2838',
          dark: {
            bg: '#0B1220',
            card: '#141d33',
            field: '#1c2740',
            border: '#2a3650',
            text: '#e7ebf3',
            muted: '#8492ac',
          }
        }
      }
    }
  }
</script>
<style>
  body {
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif;
  }

  input::placeholder,
  textarea::placeholder {
    color: #9CA3AF;
  }

  .dark input::placeholder,
  .dark textarea::placeholder {
    color: #5b6b8a;
  }

  select {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
  }

  .lineDescription {
    overflow: hidden;
    min-height: 42px;
    resize: none;
    line-height: 1.5;
  }
</style>
HTML;

require __DIR__ . '/includes/meta.php';
require __DIR__ . '/includes/header.php';
?>
<!-- Top Navbar -->
  

  <!-- Language Modal -->
  <div id="langModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 px-4">
    <div class="bg-white dark:bg-dark-card rounded-md shadow-xl w-full max-w-lg p-6 relative">
      <div class="flex items-center justify-between mb-5">
        <h2 id="langTitle" class="text-xl font-bold text-ink dark:text-dark-text" data-i18n="lang.title">Change Language</h2>
        <button id="langClose" class="text-gray-400 hover:text-gray-600 dark:text-dark-muted dark:hover:text-dark-text text-2xl leading-none">&times;</button>
      </div>
      <hr class="border-gray-200 dark:border-dark-border mb-5">
      <div id="langGrid" class="grid grid-cols-2 sm:grid-cols-3 gap-x-4 gap-y-4 text-sm">
        <!-- populated by JS -->
      </div>
    </div>
  </div>

  <!-- Main content -->
  <main class="max-w-[1400px] mx-auto px-6 py-8">

 <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-[#1E2838] dark:text-dark-text mb-6 leading-tight">
  Free Invoice Generator
  <span class="text-[#B12F26] dark:text-[#D94A40]">
    — Create &amp; Schedule Invoices Online
  </span>
</h1>

    <div class="flex flex-col lg:flex-row gap-6 items-start">

   <!-- Invoice Card -->
<section class="flex-1 w-full bg-white dark:bg-dark-card border border-gray-200 dark:border-dark-border rounded-sm shadow-sm p-10 transition-colors duration-200">

  <!-- Header row: logo box + Invoice title -->
  <div class="flex flex-col items-end sm:flex-row sm:items-start justify-between mb-8 gap-6">

    <div class="relative self-end">
      <button
        id="logoBtn"
        class="w-56 h-32 border border-gray-200 dark:border-dark-border bg-gray-50 dark:bg-dark-field flex items-center justify-center text-gray-500 dark:text-dark-muted hover:bg-gray-100 dark:hover:bg-dark-border/40 transition relative overflow-hidden"
      >
        <span class="flex items-center gap-1 text-sm" data-i18n="invoice.logo">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
            <path d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"/>
          </svg>
          Add Your Logo
        </span>
      </button>

      <button
        id="logoRemoveBtn"
        type="button"
        class="hidden absolute top-2 left-2 w-8 h-8 rounded-full bg-white text-gray-700 shadow-md hover:bg-gray-100 transition"
      >
        ×
      </button>
    </div>

    <input
      id="logoInput"
      type="file"
      accept="image/jpeg,image/png,image/gif"
      class="hidden"
    >

    <div
      id="logoErrorModal"
      class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 px-4"
    >
      <div class="bg-white dark:bg-dark-card rounded-md shadow-xl w-full max-w-sm p-6 relative text-center">

        <p class="text-ink dark:text-dark-text mb-4">
          The image you uploaded is not in a file type we accept.
          Please use a JPEG, PNG, or GIF
        </p>

        <button
          id="logoErrorOk"
          class="bg-[#DC143C] hover:bg-[#8F241D] text-white px-4 py-2 rounded-md transition-colors duration-200"
        >
          OK
        </button>

      </div>
    </div>

    <div class="w-full sm:w-auto text-right">

      <h2
        id="invoiceTitle"
        class="text-5xl font-bold text-ink dark:text-white tracking-tight mb-4"
        data-i18n="invoice.title"
      >
        INVOICE
      </h2>

      <input
        type="text"
        placeholder="#"
        class="field w-full sm:w-56 text-right focus:border-[#DC143C] focus:ring-[#DC143C]"
        id="invoiceNumberInput"
      >

    </div>
  </div>


<!-- Bill From + Schedule Information -->
<!-- Bill From + Schedule Information -->
<div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-6 items-start">

    <!-- Bill From -->
    <div>
        <textarea
            id="billFromInput"
            rows="3"
            placeholder="Who is this from?"
            class="field w-full resize-none focus:border-[#DC143C] focus:ring-[#DC143C]"
            data-i18n-placeholder="invoice.fromPlaceholder"
        ></textarea>

        <p
            id="billFromWarning"
            class="hidden text-sm text-red-600 mt-1"
        >
            Enter your business details in Bill From.
        </p>
    </div>


    <!-- Schedule Section -->
    <div id="editScheduleSection" class="hidden">

        <!-- Is Scheduled -->
        <div class="mb-5 flex items-center justify-end gap-3">

            <label
                class="block text-sm font-medium text-gray-700 dark:text-dark-muted mb-2"
            >
                Is Scheduled?
            </label>

            <div class="flex items-center gap-3">

                <button
                    type="button"
                    id="editScheduledToggle"
                    class="relative inline-flex h-6 w-11 items-center rounded-full
                           bg-gray-300 dark:bg-gray-600
                           transition-colors duration-200"
                    data-scheduled="0"
                >
                    <span
                        id="editScheduledToggleCircle"
                        class="inline-block h-4 w-4 transform rounded-full
                               bg-white shadow translate-x-1
                               transition-transform duration-200"
                    ></span>
                </button>

                <span
                    id="editScheduledLabel"
                    class="text-sm text-gray-600 dark:text-dark-muted"
                >
                    No
                </span>

            </div>
        </div>


        <!-- Frequency + Customer Email -->
        <div
            id="scheduleFields"
            class="hidden grid grid-cols-1 md:grid-cols-2 gap-6"
        >

            <!-- Schedule Frequency -->
            <div>
                <label
                    for="scheduleFrequency"
                    class="block text-sm font-medium text-gray-700 dark:text-dark-muted mb-2"
                >
                    Schedule Frequency
                </label>

                <div class="relative">

                    <select
                        id="scheduleFrequency"
                        class="field w-full appearance-none pr-10 cursor-pointer
                               focus:border-[#DC143C]
                               focus:ring-1 focus:ring-[#DC143C]
                               bg-white dark:bg-dark-field"
                    >
                        <option value="" selected disabled>
                            Select Frequency
                        </option>

                <option value="weekly">Weekly</option>
<option value="bi-weekly">Bi-Weekly</option>
<option value="monthly">Monthly</option>
<option value="bi-monthly">Bi-Monthly</option>
<option value="quarterly">Quarterly</option>
<option value="tri-yearly">Tri-Yearly</option>
<option value="half-yearly">Half-Yearly</option>
<option value="yearly">Yearly</option>
                                           </select>

                    <!-- Dropdown Arrow -->
                    <span
                        class="pointer-events-none absolute inset-y-0 right-0
                               flex items-center pr-3
                               text-gray-500 dark:text-dark-muted"
                    >
                        <svg
                            class="w-4 h-4"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M19 9l-7 7-7-7"
                            />
                        </svg>
                    </span>

                </div>
            </div>


            <!-- Customer Email -->
            <div>

                <label
                    for="customerEmail"
                    class="block text-sm font-medium text-gray-700 dark:text-dark-muted mb-2"
                >
                    Customer Email
                </label>

                <input
                    type="email"
                    id="customerEmail"
                    placeholder="customer@email.com"
                    class="field w-full
                           focus:border-[#DC143C]
                           focus:ring-1
                           focus:ring-[#DC143C]"
                >

            </div>

        </div>

    </div>

</div>
  <!-- Bill To / Ship To / Date fields -->
  <div class="flex flex-col md:flex-row justify-between gap-8 mb-8">

    <div class="flex gap-6 flex-1">

      <div class="flex-1 max-w-xs">

        <p
          class="text-sm text-gray-700 dark:text-dark-muted mb-2"
          data-i18n="invoice.billTo"
        >
          Bill To
        </p>

        <textarea
          id="billToInput"
          rows="3"
          placeholder="Who is this to?"
          class="field w-full resize-none focus:border-[#DC143C] focus:ring-[#DC143C]"
          data-i18n-placeholder="invoice.billToPlaceholder"
        ></textarea>

        <p
          id="billToWarning"
          class="hidden text-sm text-red-600 mt-1"
        >
          Enter your client's details in Bill To.
        </p>

      </div>


      <div class="flex-1 max-w-xs">

        <p
          class="text-sm text-gray-700 dark:text-dark-muted mb-2"
          data-i18n="invoice.shipTo"
        >
          Ship To
        </p>

        <textarea
          id="shipToInput"
          rows="3"
          placeholder="(optional)"
          class="field w-full resize-none focus:border-[#DC143C] focus:ring-[#DC143C]"
          data-i18n-placeholder="invoice.shipToPlaceholder"
        ></textarea>

      </div>

    </div>


    <div class="w-full md:w-80">

      <div class="grid grid-cols-2 gap-y-3 items-center text-sm text-gray-700 dark:text-dark-muted">

        <label data-i18n="invoice.date">Date</label>

        <input
          id="invoiceDateInput"
          type="text"
          class="field focus:border-[#DC143C] focus:ring-[#DC143C]"
          autocomplete="off"
          data-i18n-placeholder="invoice.datePlaceholder"
        >


        <label data-i18n="invoice.paymentTerms">
          Payment Terms
        </label>

        <input
          id="paymentTermsInput"
          type="text"
          class="field focus:border-[#DC143C] focus:ring-[#DC143C]"
          data-i18n-placeholder="invoice.paymentTermsPlaceholder"
        >


        <label data-i18n="invoice.dueDate">
          Due Date
        </label>

        <input
          id="dueDateInput"
          type="text"
          class="field focus:border-[#DC143C] focus:ring-[#DC143C]"
          autocomplete="off"
          data-i18n-placeholder="invoice.dueDatePlaceholder"
        >


        <label data-i18n="invoice.poNumber">
          PO Number
        </label>

        <input
          id="poNumberInput"
          type="text"
          class="field focus:border-[#DC143C] focus:ring-[#DC143C]"
          data-i18n-placeholder="invoice.poNumberPlaceholder"
        >

      </div>

    </div>

  </div>


  <!-- Line items table -->
  <div class="mb-1">

    <table class="w-full border-collapse">

      <thead class="hidden sm:table-header-group">

        <tr class="bg-[#b12f26] text-white text-sm">

          <th
            class="text-left font-semibold px-4 py-3 w-1/2"
            data-i18n="table.item"
          >
            Item
          </th>

          <th
            class="text-left font-semibold px-4 py-3"
            data-i18n="table.quantity"
          >
            Quantity
          </th>

          <th
            class="text-left font-semibold px-4 py-3"
            data-i18n="table.rate"
          >
            Rate
          </th>

          <th
            class="text-right font-semibold px-4 py-3"
            data-i18n="table.amount"
          >
            Amount
          </th>

        </tr>

      </thead>


      <tbody id="lineItemsBody">

        <!-- Desktop Line Item -->
        <tr class="hidden sm:table-row border-b border-gray-200 dark:border-dark-border group">

          <td class="p-2 align-top">

            <textarea
              rows="1"
              placeholder="Description of item/service..."
              class="field w-full min-w-0 resize-none lineDescription focus:border-[#DC143C] focus:ring-[#DC143C]"
              data-i18n-placeholder="table.itemPlaceholder"
            ></textarea>

          </td>


          <td class="p-2 align-top w-28">

            <input
              type="text"
              value="1"
              class="field w-full min-w-0 lineQty focus:border-[#DC143C] focus:ring-[#DC143C]"
            >

          </td>


          <td class="p-2 align-top w-28">

            <div class="field flex items-center focus-within:border-[#DC143C]">

              <span class="text-gray-500 dark:text-dark-muted mr-1 currencySymbol">
                $
              </span>

              <input
                type="text"
                value="0"
                class="w-full min-w-0 text-right bg-transparent focus:outline-none lineRate"
              >

            </div>

          </td>


          <td class="p-2 align-top w-32">

            <div class="relative flex items-center justify-end gap-2">

              <span class="lineAmount text-sm text-gray-800 dark:text-dark-text">
                $0.00
              </span>

              <button
                type="button"
                class="remove-line opacity:100 md:opacity-0 md:group-hover:opacity-100 transition-opacity duration-200 w-10 h-10 border border-gray-200 dark:border-dark-border bg-white dark:bg-dark-field text-gray-400 hover:text-red-600 flex items-center justify-center"
                title="Remove line"
              >

                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="w-4 h-4"
                  viewBox="0 0 20 20"
                  fill="currentColor"
                >
                  <path
                    fill-rule="evenodd"
                    d="M6.28 5.22a.75.75 0 011.06 0L10 7.94l2.66-2.72a.75.75 0 111.06 1.06L11.06 9l2.72 2.66a.75.75 0 11-1.06 1.06L10 10.06l-2.66 2.72a.75.75 0 11-1.06-1.06L8.94 9 6.22 6.34a.75.75 0 01.06-1.12z"
                    clip-rule="evenodd"
                  />
                </svg>

              </button>

            </div>

          </td>

        </tr>


        <!-- Mobile Line Item -->
        <tr class="sm:hidden border border-gray-200 dark:border-dark-border rounded-3xl overflow-hidden mb-3 bg-white dark:bg-dark-card group">

          <td colspan="4" class="p-4">

            <div class="mb-4">

              <div class="text-sm font-semibold text-gray-700 dark:text-dark-muted mb-2">
                Item
              </div>

              <textarea
                rows="1"
                placeholder="Description of item/service..."
                class="field w-full min-w-0 resize-none lineDescription focus:border-[#DC143C] focus:ring-[#DC143C]"
                data-i18n-placeholder="table.itemPlaceholder"
              ></textarea>

            </div>


            <div class="grid grid-cols-2 gap-3 mb-4">

              <div>

                <div class="text-sm font-semibold text-gray-700 dark:text-dark-muted mb-2">
                  Quantity
                </div>

                <input
                  type="text"
                  value="1"
                  class="field w-full min-w-0 lineQty focus:border-[#DC143C] focus:ring-[#DC143C]"
                >

              </div>


              <div>

                <div class="text-sm font-semibold text-gray-700 dark:text-dark-muted mb-2">
                  Rate
                </div>

                <div class="field flex items-center focus-within:border-[#DC143C]">

                  <span class="text-gray-500 dark:text-dark-muted mr-1 currencySymbol">
                    $
                  </span>

                  <input
                    type="text"
                    value="0"
                    class="w-full min-w-0 text-right bg-transparent focus:outline-none lineRate"
                  >

                </div>

              </div>

            </div>


            <div class="flex flex-col gap-2">

              <div class="text-sm font-semibold text-gray-700 dark:text-dark-muted">
                Amount
              </div>

              <div class="flex items-center justify-between">

                <span class="lineAmount text-sm text-gray-800 dark:text-dark-text">
                  $0.00
                </span>

                <button
                  type="button"
                  class="remove-line opacity:100 md:opacity-0 md:group-hover:opacity-100 transition-opacity duration-200 w-10 h-10 border border-gray-200 dark:border-dark-border bg-white dark:bg-dark-field text-gray-400 hover:text-red-600 flex items-center justify-center"
                  title="Remove line"
                >

                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-4 h-4"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M6.28 5.22a.75.75 0 011.06 0L10 7.94l2.66-2.72a.75.75 0 111.06 1.06L11.06 9l2.72 2.66a.75.75 0 11-1.06 1.06L10 10.06l-2.66 2.72a.75.75 0 11-1.06-1.06L8.94 9 6.22 6.34a.75.75 0 01.06-1.12z"
                      clip-rule="evenodd"
                    />
                  </svg>

                </button>

              </div>

            </div>

          </td>

        </tr>

      </tbody>

    </table>


    <!-- Add Line Item -->
    <button
      id="addLineItemBtn"
      class="w-full bg-gray-100 dark:bg-dark-field hover:bg-[#F8E8E6] dark:hover:bg-dark-border/60 text-ink dark:text-dark-text text-sm py-3 flex items-center justify-center gap-1 transition"
    >
      <span class="text-lg leading-none">+</span>
      <span data-i18n="table.addLineItem">Line Item</span>
    </button>

  </div>


  <!-- Notes / Terms + Totals -->
  <div class="flex flex-col md:flex-row justify-between gap-10 mt-10">

    <div class="flex-1 space-y-8">

      <!-- Notes -->
<div>

    <!-- Editable Notes Heading -->
  <input
    id="notesHeadingInput"
    type="text"
    value="Notes"
    class="mb-2 font-semibold text-gray-700 dark:text-gray-200 outline-none focus:outline-none border-none focus:border-none focus:ring-0"
    placeholder="Notes heading"
>

    <!-- Notes Content -->
    <textarea
        id="notesInput"
        rows="3"
        placeholder="Notes - any relevant information not already covered"
        class="field w-full resize-none focus:border-[#DC143C] focus:ring-[#DC143C]"
        data-i18n-placeholder="invoice.notesPlaceholder"
    ></textarea>

</div>


      <!-- Terms -->
    <div>

    <!-- Editable Terms Heading -->
    <input
        id="termsHeadingInput"
        type="text"
        value="Terms"
        class="mb-2 font-semibold text-gray-700 dark:text-gray-200 outline-none focus:outline-none border-none focus:border-none focus:ring-0"
        placeholder="Terms heading"
    >

    <!-- Terms Content -->
    <textarea
        id="termsInput"
        rows="3"
        placeholder="Terms and conditions - late fees, payment methods, delivery schedule"
        class="field w-full resize-none focus:border-[#DC143C] focus:ring-[#DC143C]"
        data-i18n-placeholder="invoice.termsPlaceholder"
    ></textarea>

</div>

    </div>


    <!-- Totals -->
    <div class="w-full md:w-96">

      <!-- Subtotal -->
      <div class="flex justify-between items-center py-2 text-sm">

        <span
          data-i18n="totals.subtotal"
          class="text-gray-700 dark:text-dark-muted"
        >
          Subtotal
        </span>

        <span
          id="subtotalValue"
          class="text-gray-800 dark:text-dark-text"
        >
          $0.00
        </span>

      </div>


      <!-- Discount -->
      <div
        id="discountSection"
        class="hidden group flex justify-between items-center py-2 text-sm"
      >

        <span
          class="text-gray-700 dark:text-dark-muted"
          data-i18n="totals.discount"
        >
          Discount
        </span>

        <div class="flex items-center gap-2">

          <div
            id="discountField"
            class="field flex items-center max-[370px]:w-16 w-28 py-1.5 focus-within:border-[#DC143C]"
          >

            <input
              id="discountInput"
              type="text"
              value="0"
              class="w-full text-right bg-transparent focus:outline-none"
            >

            <span
              id="discountPercentSign"
              class="text-gray-500 dark:text-dark-muted ml-1"
            >
              %
            </span>

          </div>


          <button
            id="discountToggleBtn"
            class="text-gray-400 dark:text-dark-muted hover:text-[#DC143C] transition-colors"
            title="Toggle % / amount"
          >

            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="w-4 h-4"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              stroke-width="2"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"
              />
            </svg>

          </button>


          <button
            id="discountCloseBtn"
            class="opacity:100 md:opacity-0 md:group-hover:opacity-100 transition-opacity duration-200 w-10 h-10 border border-gray-200 dark:border-dark-border bg-white dark:bg-dark-field text-gray-400 hover:text-red-600 flex items-center justify-center"
            title="Remove discount"
          >

            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="w-4 h-4"
              viewBox="0 0 20 20"
              fill="currentColor"
            >
              <path
                fill-rule="evenodd"
                d="M6.28 5.22a.75.75 0 011.06 0L10 7.94l2.66-2.72a.75.75 0 111.06 1.06L11.06 9l2.72 2.66a.75.75 0 11-1.06 1.06L10 10.06l-2.66 2.72a.75.75 0 11-1.06-1.06L8.94 9 6.22 6.34a.75.75 0 01.06-1.12z"
                clip-rule="evenodd"
              />
            </svg>

          </button>

        </div>

      </div>


      <!-- Tax -->
      <div
        id="taxRow"
        class="group flex justify-between items-center py-2 text-sm"
      >

        <span
          id="taxLabel"
          class="text-gray-700 dark:text-dark-muted"
          data-i18n="totals.tax"
        >
          Tax
        </span>

        <div class="flex items-center gap-2">

          <div
            id="taxField"
            class="field flex items-center max-[370px]:w-16 w-28 py-1.5 focus-within:border-[#DC143C]"
          >

            <input
              id="taxPercentInput"
              type="text"
              value="0"
              class="w-full text-right bg-transparent focus:outline-none"
            >

            <span
              id="taxPercentSign"
              class="text-gray-500 dark:text-dark-muted ml-1"
            >
              %
            </span>

          </div>


          <button
            id="taxToggleBtn"
            class="text-gray-400 dark:text-dark-muted hover:text-[#DC143C] transition-colors"
            title="Toggle % / amount"
          >

            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="w-4 h-4"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              stroke-width="2"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"
              />
            </svg>

          </button>


          <button
            id="taxCloseBtn"
            class="opacity:100 md:opacity-0 md:group-hover:opacity-100 transition-opacity duration-200 w-10 h-10 border border-gray-200 dark:border-dark-border bg-white dark:bg-dark-field text-gray-400 hover:text-red-600 flex items-center justify-center"
            title="Remove tax"
          >

            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="w-4 h-4"
              viewBox="0 0 20 20"
              fill="currentColor"
            >
              <path
                fill-rule="evenodd"
                d="M6.28 5.22a.75.75 0 011.06 0L10 7.94l2.66-2.72a.75.75 0 111.06 1.06L11.06 9l2.72 2.66a.75.75 0 11-1.06 1.06L10 10.06l-2.66 2.72a.75.75 0 11-1.06-1.06L8.94 9 6.22 6.34a.75.75 0 01.06-1.12z"
                clip-rule="evenodd"
              />
            </svg>

          </button>

        </div>

      </div>


      <!-- Shipping -->
      <div
        id="shippingSection"
        class="hidden group flex justify-between items-center py-2 text-sm"
      >

        <span
          class="text-gray-700 dark:text-dark-muted"
          data-i18n="totals.shipping"
        >
          Shipping
        </span>

        <div class="flex items-center gap-2">

          <div
            id="shippingField"
            class="field flex items-center max-[370px]:w-16 w-28 py-1.5 focus-within:border-[#DC143C]"
          >

            <span class="text-gray-500 dark:text-dark-muted mr-1 currencySymbol">
              $
            </span>

            <input
              id="shippingInput"
              type="text"
              value="0"
              class="w-full text-right bg-transparent focus:outline-none"
            >

          </div>


          <button
            id="shippingToggleBtn"
            class="text-gray-400 dark:text-dark-muted hover:text-[#DC143C] transition-colors"
            title="Toggle % / amount"
          >

            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="w-4 h-4"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              stroke-width="2"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"
              />
            </svg>

          </button>


          <button
            id="shippingCloseBtn"
            class="opacity:100 md:opacity-0 md:group-hover:opacity-100 transition-opacity duration-200 w-10 h-10 border border-gray-200 dark:border-dark-border bg-white dark:bg-dark-field text-gray-400 hover:text-red-600 flex items-center justify-center"
            title="Remove shipping"
          >

            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="w-4 h-4"
              viewBox="0 0 20 20"
              fill="currentColor"
            >
              <path
                fill-rule="evenodd"
                d="M6.28 5.22a.75.75 0 011.06 0L10 7.94l2.66-2.72a.75.75 0 111.06 1.06L11.06 9l2.72 2.66a.75.75 0 11-1.06 1.06L10 10.06l-2.66 2.72a.75.75 0 11-1.06-1.06L8.94 9 6.22 6.34a.75.75 0 01.06-1.12z"
                clip-rule="evenodd"
              />
            </svg>

          </button>

        </div>

      </div>


      <!-- Add Tax / Discount / Shipping -->
      <div class="flex gap-4 py-2 text-sm items-center">

        <button
          id="addTaxBtn"
          class="text-[#DC143C] hover:text-[#8F241D] flex items-center gap-1 transition-colors"
        >
          <span class="leading-none">+</span>
          <span>Tax</span>
        </button>


        <button
          id="addDiscountBtn"
          class="text-[#DC143C] hover:text-[#8F241D] flex items-center gap-1 transition-colors"
        >
          <span class="leading-none">+</span>
          <span data-i18n="actions.addDiscount">
            Discount
          </span>
        </button>


        <button
          id="addShippingBtn"
          class="text-[#DC143C] hover:text-[#8F241D] flex items-center gap-1 transition-colors"
        >
          <span class="leading-none">+</span>
          <span data-i18n="actions.addShipping">
            Shipping
          </span>
        </button>

      </div>


      <hr class="border-gray-300 dark:border-dark-border my-3">


      <!-- Total -->
      <div class="flex justify-between items-center py-2">

        <span
          id="totalLabel"
          class="font-bold text-ink dark:text-dark-text"
          data-i18n="totals.total"
        >
          Total
        </span>

        <span
          id="totalValue"
          class="font-bold text-[#DC143C] dark:text-[#D75A50]"
        >
          $0.00
        </span>

      </div>


      <!-- Amount Paid -->
      <div class="flex justify-between items-center py-2 text-sm">

        <span
          id="amountPaidLabel"
          class="text-gray-700 dark:text-dark-muted"
          data-i18n="totals.amountPaid"
        >
          Amount Paid
        </span>

        <div
          class="field flex items-center w-24 py-1.5 focus-within:border-[#DC143C]"
        >

          <span class="text-gray-500 dark:text-dark-muted mr-1 currencySymbol">
            $
          </span>

          <input
            id="amountPaidInput"
            type="text"
            value="0"
            class="w-full text-right bg-transparent focus:outline-none"
          >

        </div>

      </div>


      <hr class="border-gray-300 dark:border-dark-border my-3">


      <!-- Balance Due -->
      <div class="flex justify-between items-center py-2">

        <span
          id="balanceDueLabel"
          class="font-bold text-lg text-ink dark:text-dark-text"
          data-i18n="totals.balanceDue"
        >
          Balance Due
        </span>

        <span
          id="balanceDueValue"
          class="font-bold text-lg text-[#DC143C] dark:text-[#D75A50]"
        >
          $0.00
        </span>

      </div>

    </div>

  </div>

</section>

      <div id="datePicker" class="hidden absolute z-50 w-72 bg-white dark:bg-dark-card border border-gray-200 dark:border-dark-border rounded-lg shadow-xl p-4 text-sm">
        <div class="flex items-center justify-between mb-3">
          <button type="button" id="datePrevBtn" class="w-8 h-8 rounded-md text-gray-600 dark:text-dark-text hover:bg-gray-100 dark:hover:bg-dark-border transition">‹</button>
          <div class="font-semibold text-gray-800 dark:text-dark-text" id="dateMonthLabel">July 2026</div>
          <button type="button" id="dateNextBtn" class="w-8 h-8 rounded-md text-gray-600 dark:text-dark-text hover:bg-gray-100 dark:hover:bg-dark-border transition">›</button>
        </div>
        <div class="grid grid-cols-7 gap-1 text-center text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-dark-muted mb-2">
          <span>Su</span><span>Mo</span><span>Tu</span><span>We</span><span>Th</span><span>Fr</span><span>Sa</span>
        </div>
        <div id="dateGrid" class="grid grid-cols-7 gap-1"></div>
      </div>

      <!-- Right Sidebar -->
        <aside class="w-full lg:w-72 flex-shrink-0 space-y-4">
        
          <!-- Save & Send -->
          <button
            id="saveSendBtn"
            class="group w-full relative overflow-hidden bg-[#b12f26] hover:bg-[#982820] active:bg-[#84231C] text-white font-semibold py-3.5 px-5 rounded-lg shadow-[0_4px_12px_rgba(177,47,38,0.22)] hover:shadow-[0_7px_18px_rgba(177,47,38,0.30)] transition-all duration-200 hover:-translate-y-[1px] active:translate-y-0"
            data-i18n="sidebar.saveSend"
          >
            <span class="relative z-10 flex items-center justify-center gap-2">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="w-4.5 h-4.5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M3 8.5V19a2 2 0 002 2h14a2 2 0 002-2V8.5M16 3H8a2 2 0 00-2 2v3.5h12V5a2 2 0 00-2-2zM8 21v-5h8v5"
                />
              </svg>
        
              <span data-i18n="sidebar.saveSend">Save &amp; Send</span>
            </span>
          </button>
        
        
          <!-- Download -->
          <button
            id="downloadBtn"
            class="group w-full flex items-center justify-center gap-2 py-2.5 px-4 rounded-lg border border-[#DC143C]/20 bg-[#DC143C]/5 text-[#DC143C] hover:bg-[#DC143C] hover:text-white hover:border-[#DC143C] font-semibold text-sm transition-all duration-200 hover:shadow-[0_4px_12px_rgba(177,47,38,0.18)]"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="w-4 h-4 transition-transform duration-200 group-hover:translate-y-0.5"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              stroke-width="2"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3"
              />
            </svg>
        
            <span data-i18n="sidebar.download">Download</span>
          </button>
        
        
          <!-- Invoice Settings -->
          <div
            class="bg-white dark:bg-dark-card border border-gray-200 dark:border-dark-border rounded-xl shadow-[0_3px_12px_rgba(0,0,0,0.05)] overflow-hidden transition-all duration-200"
          >
        
            <!-- Settings Header -->
            <button
              id="settingsToggle"
              class="group w-full flex items-center justify-between px-5 py-4 text-ink dark:text-dark-text font-semibold text-sm hover:bg-gray-50 dark:hover:bg-dark-border/30 transition-colors duration-200"
            >
              <span class="flex items-center gap-2.5">
        
                <!-- Settings Icon -->
                <span
                  class="flex items-center justify-center w-8 h-8 rounded-lg bg-[#DC143C]/10 text-[#DC143C]"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-4 h-4"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M10.325 4.317a1.724 1.724 0 013.35 0 1.724 1.724 0 002.573 1.11 1.724 1.724 0 012.37 2.37 1.724 1.724 0 001.11 2.573 1.724 1.724 0 010 3.35 1.724 1.724 0 00-1.11 2.573 1.724 1.724 0 01-2.37 2.37 1.724 1.724 0 00-2.573 1.11 1.724 1.724 0 01-3.35 0 1.724 1.724 0 00-2.573-1.11 1.724 1.724 0 01-2.37-2.37 1.724 1.724 0 00-1.11-2.573 1.724 1.724 0 010-3.35 1.724 1.724 0 001.11-2.573 1.724 1.724 0 012.37-2.37 1.724 1.724 0 002.573-1.11z"
                    />
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                    />
                  </svg>
                </span>
        
                <span data-i18n="sidebar.invoiceSettings">
                  Invoice Settings
                </span>
              </span>
        
              <svg
                id="settingsChevron"
                xmlns="http://www.w3.org/2000/svg"
                class="w-4 h-4 text-gray-400 transition-transform duration-200"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M5 15l7-7 7 7"
                />
              </svg>
            </button>
        
        
            <!-- Settings Panel -->
            <div
              id="settingsPanel"
              class="px-5 pb-5 space-y-4 border-t border-gray-100 dark:border-dark-border pt-4"
            >
        
              <!-- Theme -->
              <div>
                <label
                  id="themeLabel"
                  class="block text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-dark-muted mb-2"
                  data-i18n="settings.theme"
                >
                  Theme
                </label>
        
                <select
                  id="themeSelect"
                  class="field w-full rounded-lg border border-gray-200 bg-gray-50 px-3.5 py-3 text-sm font-medium text-gray-700 outline-none transition-all duration-200 focus:border-[#DC143C] focus:ring-2 focus:ring-[#DC143C]/10 focus:bg-white"
                >
                  <option value="Classic" data-i18n-option="settings.classic">
                    Classic
                  </option>
        
                  <option value="State" data-i18n-option="settings.state">
                    State
                  </option>
                </select>
              </div>
        
        
              <!-- Currency -->
              <div>
                <label
                  id="currencyLabel"
                  class="block text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-dark-muted mb-2"
                  data-i18n="settings.currency"
                >
                  Currency
                </label>
        
                <select
                  id="currencySelect"
                  class="field w-full rounded-lg border border-gray-200 bg-gray-50 px-3.5 py-3 text-sm font-medium text-gray-700 outline-none transition-all duration-200 focus:border-[#DC143C] focus:ring-2 focus:ring-[#DC143C]/10 focus:bg-white"
                ></select>
              </div>
        
        
              <!-- Save Default -->
              <div class="pt-1">
                <button
                  id="saveDefaultBtn"
                  class="hidden w-full flex items-center justify-center gap-2 bg-[#DC143C] hover:bg-[#982820] active:bg-[#84231C] text-white text-sm font-semibold px-5 py-3 rounded-lg shadow-sm hover:shadow-md transition-all duration-200 hover:-translate-y-[1px] active:translate-y-0"
                  data-i18n="settings.saveDefault"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-4 h-4"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M5 13l4 4L19 7"
                    />
                  </svg>
        
                  <span data-i18n="settings.saveDefault">
                    Save Default
                  </span>
                </button>
              </div>
        
            </div>
          </div>
        
        </aside>

    </div>

    <!-- Homepage SEO Content -->

<section class="mt-16 sm:mt-20">

  <div class="mb-20">

    <!-- Section Heading -->
    <div class="max-w-2xl mx-auto text-center mb-10 sm:mb-12">

      <div class="inline-flex items-center gap-2 px-3 py-1.5 mb-4 rounded-full
                  bg-[#B12F26]/10 dark:bg-[#D94A40]/10
                  border border-[#B12F26]/15 dark:border-[#D94A40]/20">
        <span class="w-1.5 h-1.5 rounded-full bg-[#B12F26] dark:bg-[#D94A40]"></span>

        <span class="text-xs font-semibold uppercase tracking-wider
                     text-[#B12F26] dark:text-[#D94A40]">
          Why InvoiceScheduler
        </span>
      </div>

      <h2 class="text-2xl sm:text-3xl  font-extrabold tracking-tight
                 text-[#1E2838] dark:text-dark-text leading-tight">
        Everything You Need to
        <span class="text-[#B12F26] dark:text-[#D94A40]">
          Invoice Smarter
        </span>
      </h2>

      <p class="mt-4 text-sm sm:text-base leading-6
                text-gray-600 dark:text-dark-muted">
        Create professional invoices, automate recurring billing, and get paid
        faster with simple tools designed for freelancers and growing businesses.
      </p>

    </div>


    <!-- Benefits Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6">

      <!-- Card 1 -->
      <article class="group relative overflow-hidden
                      bg-white dark:bg-dark-card
                      border border-gray-200/80 dark:border-dark-border
                      rounded-2xl p-6 sm:p-7
                      shadow-sm
                      transition-all duration-300
                      hover:-translate-y-1
                      hover:shadow-xl hover:shadow-gray-200/50
                      dark:hover:shadow-black/20">

        <!-- Top Accent -->
        <div class="absolute inset-x-0 top-0 h-1
                    bg-gradient-to-r from-[#B12F26] to-[#D94A40]
                    opacity-0 group-hover:opacity-100
                    transition-opacity duration-300"></div>

        <!-- Icon -->
        <div class="w-12 h-12 mb-5 rounded-xl
                    bg-[#B12F26]/10 dark:bg-[#D94A40]/10
                    text-[#B12F26] dark:text-[#D94A40]
                    flex items-center justify-center
                    transition-transform duration-300
                    group-hover:scale-105">

          <svg class="w-6 h-6" fill="none" stroke="currentColor"
               viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round"
                  stroke-width="1.8"
                  d="M9 14l2 2 4-4m4.5-5.5L12 2 4.5 6.5v11L12 22l7.5-4.5v-11z"/>
          </svg>
        </div>

        <h3 class="text-lg font-bold text-[#1E2838] dark:text-dark-text
                   leading-snug mb-3">
          Create Professional Invoices Instantly
        </h3>

        <p class="text-sm leading-6 text-gray-600 dark:text-dark-muted">
          Generate clean, professional invoices in seconds. Add your business
          logo, customize colors, and choose from multiple themes — no design
          skills needed.
        </p>

      </article>


      <!-- Card 2 -->
      <article class="group relative overflow-hidden
                      bg-white dark:bg-dark-card
                      border border-gray-200/80 dark:border-dark-border
                      rounded-2xl p-6 sm:p-7
                      shadow-sm
                      transition-all duration-300
                      hover:-translate-y-1
                      hover:shadow-xl hover:shadow-gray-200/50
                      dark:hover:shadow-black/20">

        <div class="absolute inset-x-0 top-0 h-1
                    bg-gradient-to-r from-[#B12F26] to-[#D94A40]
                    opacity-0 group-hover:opacity-100
                    transition-opacity duration-300"></div>

        <div class="w-12 h-12 mb-5 rounded-xl
                    bg-[#B12F26]/10 dark:bg-[#D94A40]/10
                    text-[#B12F26] dark:text-[#D94A40]
                    flex items-center justify-center
                    transition-transform duration-300
                    group-hover:scale-105">

          <svg class="w-6 h-6" fill="none" stroke="currentColor"
               viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round"
                  stroke-width="1.8"
                  d="M12 8v4l2.5 1.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
        </div>

        <h3 class="text-lg font-bold text-[#1E2838] dark:text-dark-text
                   leading-snug mb-3">
          Schedule Recurring Invoices Automatically
        </h3>

        <p class="text-sm leading-6 text-gray-600 dark:text-dark-muted">
          Set up weekly, bi-weekly, monthly, quarterly, or yearly invoice
          schedules. InvoiceScheduler sends them automatically so you never
          miss a billing cycle.
        </p>

      </article>


      <!-- Card 3 -->
      <article class="group relative overflow-hidden
                      bg-white dark:bg-dark-card
                      border border-gray-200/80 dark:border-dark-border
                      rounded-2xl p-6 sm:p-7
                      shadow-sm
                      transition-all duration-300
                      hover:-translate-y-1
                      hover:shadow-xl hover:shadow-gray-200/50
                      dark:hover:shadow-black/20">

        <div class="absolute inset-x-0 top-0 h-1
                    bg-gradient-to-r from-[#B12F26] to-[#D94A40]
                    opacity-0 group-hover:opacity-100
                    transition-opacity duration-300"></div>

        <div class="w-12 h-12 mb-5 rounded-xl
                    bg-[#B12F26]/10 dark:bg-[#D94A40]/10
                    text-[#B12F26] dark:text-[#D94A40]
                    flex items-center justify-center
                    transition-transform duration-300
                    group-hover:scale-105">

          <svg class="w-6 h-6" fill="none" stroke="currentColor"
               viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round"
                  stroke-width="1.8"
                  d="M7 3h10a2 2 0 012 2v14a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"/>
            <path stroke-linecap="round" stroke-linejoin="round"
                  stroke-width="1.8"
                  d="M8.5 8h7M8.5 12h7M8.5 16h4"/>
          </svg>
        </div>

        <h3 class="text-lg font-bold text-[#1E2838] dark:text-dark-text
                   leading-snug mb-3">
          Download PDF &amp; Send via Email
        </h3>

        <p class="text-sm leading-6 text-gray-600 dark:text-dark-muted">
          Download your invoices as polished PDF files or send them directly
          to your client's inbox with one click.
        </p>

      </article>


      <!-- Card 4 -->
      <article class="group relative overflow-hidden
                      bg-white dark:bg-dark-card
                      border border-gray-200/80 dark:border-dark-border
                      rounded-2xl p-6 sm:p-7
                      shadow-sm
                      transition-all duration-300
                      hover:-translate-y-1
                      hover:shadow-xl hover:shadow-gray-200/50
                      dark:hover:shadow-black/20">

        <div class="absolute inset-x-0 top-0 h-1
                    bg-gradient-to-r from-[#B12F26] to-[#D94A40]
                    opacity-0 group-hover:opacity-100
                    transition-opacity duration-300"></div>

        <div class="w-12 h-12 mb-5 rounded-xl
                    bg-[#B12F26]/10 dark:bg-[#D94A40]/10
                    text-[#B12F26] dark:text-[#D94A40]
                    flex items-center justify-center
                    transition-transform duration-300
                    group-hover:scale-105">

          <svg class="w-6 h-6" fill="none" stroke="currentColor"
               viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round"
                  stroke-width="1.8"
                  d="M4 7h16M4 12h16M4 17h10"/>
            <path stroke-linecap="round" stroke-linejoin="round"
                  stroke-width="1.8"
                  d="M18 15v5m-2.5-2.5H20.5"/>
          </svg>
        </div>

        <h3 class="text-lg font-bold text-[#1E2838] dark:text-dark-text
                   leading-snug mb-3">
          Cloud Mode — Access Invoices Anywhere
        </h3>

        <p class="text-sm leading-6 text-gray-600 dark:text-dark-muted">
          Sign up for a free account to save invoices securely in the cloud.
          Access your invoice history from any device, anytime.
        </p>

      </article>


      <!-- Card 5 -->
      <article class="group relative overflow-hidden
                      bg-white dark:bg-dark-card
                      border border-gray-200/80 dark:border-dark-border
                      rounded-2xl p-6 sm:p-7
                      shadow-sm
                      transition-all duration-300
                      hover:-translate-y-1
                      hover:shadow-xl hover:shadow-gray-200/50
                      dark:hover:shadow-black/20">

        <div class="absolute inset-x-0 top-0 h-1
                    bg-gradient-to-r from-[#B12F26] to-[#D94A40]
                    opacity-0 group-hover:opacity-100
                    transition-opacity duration-300"></div>

        <div class="w-12 h-12 mb-5 rounded-xl
                    bg-[#B12F26]/10 dark:bg-[#D94A40]/10
                    text-[#B12F26] dark:text-[#D94A40]
                    flex items-center justify-center
                    transition-transform duration-300
                    group-hover:scale-105">

          <svg class="w-6 h-6" fill="none" stroke="currentColor"
               viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round"
                  stroke-width="1.8"
                  d="M12 15a3 3 0 100-6 3 3 0 000 6z"/>
            <path stroke-linecap="round" stroke-linejoin="round"
                  stroke-width="1.8"
                  d="M19.4 15a1.7 1.7 0 00.3 1.9l.1.1-1.8 1.8-.1-.1a1.7 1.7 0 00-1.9-.3 1.7 1.7 0 00-1 1.6V20h-2.6v-.1a1.7 1.7 0 00-1-1.6 1.7 1.7 0 00-1.9.3l-.1.1-1.8-1.8.1-.1a1.7 1.7 0 00.3-1.9 1.7 1.7 0 00-1.6-1H6V11h.1a1.7 1.7 0 001.6-1 1.7 1.7 0 00-.3-1.9l-.1-.1 1.8-1.8.1.1a1.7 1.7 0 001.9.3 1.7 1.7 0 001-1.6V3.9h2.6V4a1.7 1.7 0 001 1.6 1.7 1.7 0 001.9-.3l.1-.1 1.8 1.8-.1.1a1.7 1.7 0 00-.3 1.9 1.7 1.7 0 001.6 1h.1v2.6h-.1a1.7 1.7 0 00-1.6 1z"/>
          </svg>
        </div>

        <h3 class="text-lg font-bold text-[#1E2838] dark:text-dark-text
                   leading-snug mb-3">
          No Signup Required to Start
        </h3>

        <p class="text-sm leading-6 text-gray-600 dark:text-dark-muted">
          Start creating invoices immediately — no account needed. Your
          invoices are saved locally in your browser until you're ready to
          upgrade to Cloud Mode.
        </p>

      </article>


      <!-- Card 6 -->
      <article class="group relative overflow-hidden
                      bg-white dark:bg-dark-card
                      border border-gray-200/80 dark:border-dark-border
                      rounded-2xl p-6 sm:p-7
                      shadow-sm
                      transition-all duration-300
                      hover:-translate-y-1
                      hover:shadow-xl hover:shadow-gray-200/50
                      dark:hover:shadow-black/20">

        <div class="absolute inset-x-0 top-0 h-1
                    bg-gradient-to-r from-[#B12F26] to-[#D94A40]
                    opacity-0 group-hover:opacity-100
                    transition-opacity duration-300"></div>

        <div class="w-12 h-12 mb-5 rounded-xl
                    bg-[#B12F26]/10 dark:bg-[#D94A40]/10
                    text-[#B12F26] dark:text-[#D94A40]
                    flex items-center justify-center
                    transition-transform duration-300
                    group-hover:scale-105">

          <svg class="w-6 h-6" fill="none" stroke="currentColor"
               viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round"
                  stroke-width="1.8"
                  d="M12 21a9 9 0 100-18 9 9 0 000 18z"/>
            <path stroke-linecap="round" stroke-linejoin="round"
                  stroke-width="1.8"
                  d="M3 12h18M12 3c2.2 2.4 3.3 5.4 3.3 9S14.2 18.6 12 21c-2.2-2.4-3.3-5.4-3.3-9S9.8 5.4 12 3z"/>
          </svg>
        </div>

        <h3 class="text-lg font-bold text-[#1E2838] dark:text-dark-text
                   leading-snug mb-3">
          Multi-Currency &amp; Multi-Language Support
        </h3>

        <p class="text-sm leading-6 text-gray-600 dark:text-dark-muted">
          Invoice clients worldwide with support for multiple currencies and
          languages built right in.
        </p>

      </article>

    </div>
  </div>


  <!-- =========================
       HOW IT WORKS
       ========================= -->
  <div class="mb-20">

    <div class="max-w-2xl mx-auto text-center mb-10 sm:mb-12">

      <div class="inline-flex items-center gap-2 px-3 py-1.5 mb-4 rounded-full
                  bg-[#B12F26]/10 dark:bg-[#D94A40]/10
                  border border-[#B12F26]/15 dark:border-[#D94A40]/20">

        <svg class="w-3.5 h-3.5 text-[#B12F26] dark:text-[#D94A40]"
             fill="none" stroke="currentColor" viewBox="0 0 24 24"
             aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round"
                stroke-width="2"
                d="M13 10V3L4 14h7v7l9-11h-7z"/>
        </svg>

        <span class="text-xs font-semibold uppercase tracking-wider
                     text-[#B12F26] dark:text-[#D94A40]">
          Simple Process
        </span>
      </div>

      <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight
                 text-[#1E2838] dark:text-dark-text leading-tight">
        How It
        <span class="text-[#B12F26] dark:text-[#D94A40]">
          Works
        </span>
      </h2>

      <p class="mt-4 text-sm sm:text-base leading-6
                text-gray-600 dark:text-dark-muted">
        Create and send a professional invoice in just three simple steps.
      </p>

    </div>


    <!-- Steps -->
    <div class="relative grid grid-cols-1 md:grid-cols-3 gap-5 sm:gap-6">

      <!-- Connector -->
      <div class="hidden md:block absolute top-10 left-[16%] right-[16%]
                  h-px bg-gray-200 dark:bg-dark-border"></div>


      <!-- Step 1 -->
      <article class="relative bg-white dark:bg-dark-card
                      border border-gray-200/80 dark:border-dark-border
                      rounded-2xl p-6 sm:p-7 text-center
                      shadow-sm
                      transition-all duration-300
                      hover:-translate-y-1 hover:shadow-xl">

        <div class="relative z-10 w-12 h-12 mx-auto mb-5
                    rounded-full
                    bg-[#B12F26] dark:bg-[#D94A40]
                    text-white
                    flex items-center justify-center
                    text-lg font-extrabold
                    ring-8 ring-white dark:ring-dark-bg
                    shadow-lg shadow-[#B12F26]/20">
          1
        </div>

        <h3 class="text-lg font-bold text-[#1E2838] dark:text-dark-text mb-3">
          Fill In Your Details
        </h3>

        <p class="text-sm leading-6 text-gray-600 dark:text-dark-muted">
          Enter your business info, client details, and line items in the
          invoice form above.
        </p>

      </article>


      <!-- Step 2 -->
      <article class="relative bg-white dark:bg-dark-card
                      border border-gray-200/80 dark:border-dark-border
                      rounded-2xl p-6 sm:p-7 text-center
                      shadow-sm
                      transition-all duration-300
                      hover:-translate-y-1 hover:shadow-xl">

        <div class="relative z-10 w-12 h-12 mx-auto mb-5
                    rounded-full
                    bg-[#B12F26] dark:bg-[#D94A40]
                    text-white
                    flex items-center justify-center
                    text-lg font-extrabold
                    ring-8 ring-white dark:ring-dark-bg
                    shadow-lg shadow-[#B12F26]/20">
          2
        </div>

        <h3 class="text-lg font-bold text-[#1E2838] dark:text-dark-text mb-3">
          Customize &amp; Schedule
        </h3>

        <p class="text-sm leading-6 text-gray-600 dark:text-dark-muted">
          Add your logo, pick a theme, set payment terms, and optionally
          schedule recurring invoices.
        </p>

      </article>


      <!-- Step 3 -->
      <article class="relative bg-white dark:bg-dark-card
                      border border-gray-200/80 dark:border-dark-border
                      rounded-2xl p-6 sm:p-7 text-center
                      shadow-sm
                      transition-all duration-300
                      hover:-translate-y-1 hover:shadow-xl">

        <div class="relative z-10 w-12 h-12 mx-auto mb-5
                    rounded-full
                    bg-[#B12F26] dark:bg-[#D94A40]
                    text-white
                    flex items-center justify-center
                    text-lg font-extrabold
                    ring-8 ring-white dark:ring-dark-bg
                    shadow-lg shadow-[#B12F26]/20">
          3
        </div>

        <h3 class="text-lg font-bold text-[#1E2838] dark:text-dark-text mb-3">
          Download or Send
        </h3>

        <p class="text-sm leading-6 text-gray-600 dark:text-dark-muted">
          Download your invoice as a PDF or email it directly to your client.
        </p>

      </article>

    </div>
  </div>


  <!-- =========================
       TRUST / FINAL SEO BLOCK
       ========================= -->
  <div class="relative overflow-hidden
              bg-white dark:bg-dark-card
              border border-gray-200/80 dark:border-dark-border
              rounded-2xl sm:rounded-3xl
              p-7 sm:p-10 lg:p-12
              shadow-sm">

    <!-- Decorative Background -->
    <div class="absolute -top-24 -right-24 w-64 h-64
                rounded-full bg-[#B12F26]/5 dark:bg-[#D94A40]/5
                blur-3xl pointer-events-none"></div>

    <div class="absolute -bottom-24 -left-24 w-64 h-64
                rounded-full bg-[#B12F26]/5 dark:bg-[#D94A40]/5
                blur-3xl pointer-events-none"></div>


    <div class="relative max-w-4xl mx-auto text-center">

      <!-- Badge -->
      <div class="inline-flex items-center gap-2 px-3 py-1.5 mb-5 rounded-full
                  bg-[#B12F26]/10 dark:bg-[#D94A40]/10
                  border border-[#B12F26]/15 dark:border-[#D94A40]/20">

        <svg class="w-4 h-4 text-[#B12F26] dark:text-[#D94A40]"
             fill="none" stroke="currentColor" viewBox="0 0 24 24"
             aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round"
                stroke-width="2"
                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 12c0 5.591 3.824 10.29 9 11.622C17.176 22.29 21 17.591 21 12c0-1.343-.22-2.634-.618-3.016z"/>
        </svg>

        <span class="text-xs font-semibold uppercase tracking-wider
                     text-[#B12F26] dark:text-[#D94A40]">
          Built for Modern Invoicing
        </span>

      </div>


      <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold
                 tracking-tight text-[#1E2838] dark:text-dark-text
                 leading-tight">
        Trusted by Freelancers,
        <span class="text-[#B12F26] dark:text-[#D94A40]">
          Small Businesses &amp; Agencies
        </span>
      </h2>


      <p class="max-w-3xl mx-auto mt-5 text-sm sm:text-base
                leading-7 text-gray-600 dark:text-dark-muted">
        Whether you're a freelancer sending your first invoice or a growing
        agency managing dozens of clients, InvoiceScheduler gives you the
        tools to bill professionally — completely free. No hidden fees, no
        credit card required.
      </p>


      <!-- Trust Points -->
      <div class="mt-8 flex flex-wrap items-center justify-center
                  gap-x-6 gap-y-3">

        <div class="inline-flex items-center gap-2
                    text-sm font-medium text-[#1E2838] dark:text-dark-text">
          <span class="flex w-5 h-5 items-center justify-center rounded-full
                       bg-[#B12F26]/10 dark:bg-[#D94A40]/10
                       text-[#B12F26] dark:text-[#D94A40]">

            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                 viewBox="0 0 24 24" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="3" d="M5 13l4 4L19 7"/>
            </svg>

          </span>
          No hidden fees
        </div>


        <div class="inline-flex items-center gap-2
                    text-sm font-medium text-[#1E2838] dark:text-dark-text">
          <span class="flex w-5 h-5 items-center justify-center rounded-full
                       bg-[#B12F26]/10 dark:bg-[#D94A40]/10
                       text-[#B12F26] dark:text-[#D94A40]">

            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                 viewBox="0 0 24 24" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="3" d="M5 13l4 4L19 7"/>
            </svg>

          </span>
          No credit card required
        </div>


        <div class="inline-flex items-center gap-2
                    text-sm font-medium text-[#1E2838] dark:text-dark-text">
          <span class="flex w-5 h-5 items-center justify-center rounded-full
                       bg-[#B12F26]/10 dark:bg-[#D94A40]/10
                       text-[#B12F26] dark:text-[#D94A40]">

            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                 viewBox="0 0 24 24" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="3" d="M5 13l4 4L19 7"/>
            </svg>

          </span>
          Start for free
        </div>

      </div>

    </div>
  </div>

</section>



  </main>

  <div id="printInvoice" style="position:absolute; left:-9999px; top:0; width:210mm; display:none;"></div>

  

  <div id="emailPromptModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 p-6 min-h-screen">
    <div class="bg-white dark:bg-dark-card rounded-xl shadow-xl w-full max-w-md p-6">
      <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-semibold text-ink dark:text-dark-text">Send Invoice</h2>
        <button type="button" id="emailPromptClose" class="text-gray-500 dark:text-dark-muted hover:text-gray-900 dark:hover:text-white">×</button>
      </div>
      <p class="text-sm text-gray-600 dark:text-dark-muted mb-4">Enter the email address to send this invoice.</p>
      <input id="emailPromptInput" type="email" class="field w-full mb-4" placeholder="Enter email address">
      <div class="flex justify-end gap-3">
        <button type="button" id="emailPromptCancel" class="px-4 py-2 rounded-md border border-gray-300 dark:border-dark-border text-sm text-gray-700 dark:text-dark-text hover:bg-gray-100 transition">Cancel</button>
        <button type="button" id="emailPromptSend" class="px-4 py-2 rounded-md bg-brand-green hover:bg-brand-greenDark text-white text-sm transition">Send</button>
      </div>
    </div>
  </div>

<div id="historyModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 p-6">

  <div class="bg-white dark:bg-dark-card rounded-xl shadow-xl w-full max-w-5xl p-6 overflow-auto max-h-[90vh]">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-start gap-4 mb-6">

      <!-- Cancel / Close Button -->
 <button
  id="historyCancelBtn"
  type="button"
  aria-label="Close History"
  title="Close"
  class="shrink-0 flex items-center justify-center w-8 h-8 rounded-full bg-white border border-gray-200 text-gray-400 hover:text-gray-700 hover:bg-gray-50 hover:border-gray-300 shadow-sm transition-all duration-200"
>
  <svg
    xmlns="http://www.w3.org/2000/svg"
    viewBox="0 0 20 20"
    fill="none"
    class="w-3.5 h-3.5"
    stroke="currentColor"
    stroke-width="1.8"
    stroke-linecap="round"
  >
    <path d="M5 5L15 15"/>
    <path d="M15 5L5 15"/>
  </svg>
</button>

      <!-- Title + Description -->
      <div class="flex-1 min-w-0">
        <h2 class="text-2xl font-semibold text-ink dark:text-dark-text">
          History
        </h2>

        <p class="text-sm text-gray-600 dark:text-dark-muted mt-1 leading-relaxed">
          We automatically save invoices that you created recently to your device.
          This is useful when you need to quickly make an edit to an invoice.
        </p>
      </div>

      <!-- Header Actions -->
      <div class="flex flex-wrap gap-3 sm:ml-auto shrink-0">

        <!-- Export -->
        <button
          id="historyExportBtn"
          type="button"
          class="inline-flex items-center gap-2 px-4 py-2 rounded-md border border-gray-200 dark:border-dark-border text-sm text-ink dark:text-dark-text hover:bg-gray-100 dark:hover:bg-dark-border transition"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="w-4 h-4"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
          >
            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
            <polyline points="7 10 12 15 17 10"></polyline>
            <line x1="12" y1="15" x2="12" y2="3"></line>
          </svg>

          Export
        </button>

        <!-- New Invoice -->
        <button
          id="historyNewBtn"
          type="button"
          class="inline-flex items-center gap-2 px-4 py-2 rounded-md bg-brand-green hover:bg-brand-greenDark text-white text-sm transition"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="w-4 h-4"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
          >
            <line x1="12" y1="5" x2="12" y2="19"></line>
            <line x1="5" y1="12" x2="19" y2="12"></line>
          </svg>

          New Invoice
        </button>

      </div>
    </div>


    <!-- Cloud Mode Banner -->
    <div
      id="cloudModeBanner"
      class="rounded-xl border border-green-200 bg-green-50 dark:bg-green-950/10 dark:border-green-800 p-4 mb-4 text-sm text-green-900 dark:text-green-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4"
    >

      <div class="max-w-3xl leading-relaxed">
        Introducing Cloud Mode! Now you can securely save your invoices to the
        cloud and access them from any device using your invoicescheduler.com
        account. Enjoy seamless, convenient, and secure invoicing wherever you go!
      </div>

      <div class="flex gap-3 shrink-0">

        <!-- Sign Up -->
        <button
          id="historySignUpBtn"
          type="button"
          class="inline-flex items-center gap-2 px-4 py-2 rounded-md bg-brand-green hover:bg-brand-greenDark text-white text-sm transition whitespace-nowrap"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="w-4 h-4"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
          >
            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
            <circle cx="9" cy="7" r="4"></circle>
            <line x1="19" y1="8" x2="19" y2="14"></line>
            <line x1="22" y1="11" x2="16" y2="11"></line>
          </svg>

          Sign Up
        </button>

        <!-- Close -->
        <button
          id="historyClose"
          type="button"
          class="inline-flex items-center gap-2 px-4 py-2 rounded-md border border-gray-200 dark:border-dark-border text-sm text-ink dark:text-dark-text hover:bg-gray-100 dark:hover:bg-dark-border transition"
        >
          Close
        </button>

      </div>
    </div>


    <!-- Search -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-4">

      <div class="flex-1">
        <div class="relative">

          <input
            id="historySearchInput"
            type="search"
            placeholder="Search invoices..."
            class="field w-full pr-10"
          />

        </div>
      </div>

    </div>


    <!-- Invoice Table -->
    <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-dark-border">

      <table class="min-w-full text-left text-sm text-gray-700 dark:text-dark-text">

        <thead class="border-b border-gray-200 dark:border-dark-border bg-gray-50 dark:bg-dark-bg">

          <tr>

            <th class="px-4 py-3 font-semibold">
              Reference
            </th>

            <th class="px-4 py-3 font-semibold">
              Customer
            </th>

            <th class="px-4 py-3 font-semibold">
              Date
            </th>

            <th class="px-4 py-3 font-semibold">
              Due Date
            </th>

            <th class="px-4 py-3 font-semibold">
              Total
            </th>

            <th class="px-4 py-3 font-semibold">
            </th>

          </tr>

        </thead>

        <tbody
          id="historyList"
          class="divide-y divide-gray-200 dark:divide-dark-border"
        ></tbody>

      </table>

    </div>


    <!-- Warning / Erase Section -->
    <div
      class="mt-6 rounded-xl border border-yellow-200 bg-yellow-50 dark:bg-yellow-950/10 dark:border-yellow-800 p-4 text-sm text-yellow-900 dark:text-yellow-200"
    >

      <div class="flex items-start gap-3">

        <!-- Warning Icon -->
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="w-5 h-5 mt-0.5 shrink-0"
          viewBox="0 0 24 24"
          fill="none"
          stroke="currentColor"
          stroke-width="2"
          stroke-linecap="round"
          stroke-linejoin="round"
        >
          <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
          <line x1="12" y1="9" x2="12" y2="13"></line>
          <line x1="12" y1="17" x2="12.01" y2="17"></line>
        </svg>

        <div class="flex-1">

          <p class="font-semibold">
            These invoices are stored on your device only.
          </p>

          <p class="mt-1">
            Clearing your browser's history will erase these invoices.
            We recommend hanging on to a copy of each invoice you generate
            or using Cloud Mode.
          </p>

          <!-- Erase Everything -->
          <button
            id="historyEraseBtn"
            type="button"
            class="mt-3 inline-flex items-center gap-2 px-4 py-2 rounded-md border border-red-200 text-red-700 hover:bg-red-50 dark:border-red-800 dark:text-red-200 dark:hover:bg-red-950 transition"
          >

            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="w-4 h-4"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
            >
              <polyline points="3 6 5 6 21 6"></polyline>
              <path d="M19 6l-1 14H6L5 6"></path>
              <path d="M10 11v6"></path>
              <path d="M14 11v6"></path>
              <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"></path>
            </svg>

            Erase Everything

          </button>

        </div>

      </div>

    </div>

  </div>
</div>


<!-- History Modal Close Script -->
<script>
  function closeHistoryModal() {
    const modal = document.getElementById('historyModal');

    if (modal) {
      modal.classList.add('hidden');
      modal.classList.remove('flex');
    }
  }

  // Top-left X / Cancel button
  document.getElementById('historyCancelBtn')?.addEventListener('click', function () {
    closeHistoryModal();
  });

  // Existing Cloud Mode Close button
  document.getElementById('historyClose')?.addEventListener('click', function () {
    closeHistoryModal();
  });
</script>

  <style>
    .field {
      border: 1px solid #D1D5DB;
      border-radius: 2px;
      padding: 0.5rem 0.75rem;
      font-size: 0.875rem;
      background-color: #fff;
      color: #1E2838;
    }
    .field:focus, .field:focus-within {
      outline: none;
      box-shadow: 0 0 0 1px #1AA260;
      border-color: #1AA260;
    }
    .dark .field {
      background-color: #1c2740;
      border-color: #2a3650;
      color: #e7ebf3;
    }
  </style>

  <script>
    // ---------- Dark mode ----------
    const htmlEl = document.documentElement;
    const themeToggle = document.getElementById('themeToggle');
    const iconSun = document.getElementById('iconSun');
    const iconMoon = document.getElementById('iconMoon');

    function applyTheme(isDark) {
      htmlEl.classList.toggle('dark', isDark);
      iconSun.classList.toggle('hidden', isDark);
      iconMoon.classList.toggle('hidden', !isDark);
      localStorage.setItem('invoicegen-theme', isDark ? 'dark' : 'light');
    }

    const savedTheme = localStorage.getItem('invoicegen-theme');
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    applyTheme(savedTheme ? savedTheme === 'dark' : prefersDark);

    themeToggle.addEventListener('click', () => {
      applyTheme(!htmlEl.classList.contains('dark'));
    });

    // ---------- Language modal ----------
    const langBtn = document.getElementById('langBtn');
    const langModal = document.getElementById('langModal');
    const langClose = document.getElementById('langClose');
    const langGrid = document.getElementById('langGrid');

    const languages = [
      'dansk', 'Deutsch', 'English',
      'español', 'français', 'Indonesia',
      'italiano', 'Nederlands', 'norsk',
      'polski', 'português', 'română',
      'svenska', 'ไทย', 'Türkçe',
      'українська'
    ];

    let selectedLanguage = localStorage.getItem('invoicegen-language') || 'English';

    function renderLanguages() {
      langGrid.innerHTML = '';
      languages.forEach(lang => {
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.textContent = lang;
        const isSelected = lang === selectedLanguage;
        btn.className = isSelected
          ? 'text-left px-3 py-2 rounded-md bg-brand-greenSoft dark:bg-brand-green/20 text-brand-greenDark dark:text-brand-green font-medium'
          : 'text-left px-3 py-2 rounded-md text-gray-700 dark:text-dark-muted hover:bg-gray-100 dark:hover:bg-dark-field transition';
        btn.addEventListener('click', () => {
          setLanguage(lang);
          setTimeout(() => langModal.classList.add('hidden'), 150);
        });
        langGrid.appendChild(btn);
      });
    }
    renderLanguages();

    langBtn.addEventListener('click', () => {
      langModal.classList.remove('hidden');
      langModal.classList.add('flex');
    });
    langClose.addEventListener('click', () => {
      langModal.classList.add('hidden');
      langModal.classList.remove('flex');
    });
    langModal.addEventListener('click', (e) => {
      if (e.target === langModal) {
        langModal.classList.add('hidden');
        langModal.classList.remove('flex');
      }
    });

    // ---------- Mobile menu ----------
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    const mobileChangeLanguage = document.getElementById('mobileChangeLanguage');
    const mobileThemeToggle = document.getElementById('mobileThemeToggle');
    const mobileSignIn = document.getElementById('mobileSignIn');
    const mobileSignUp = document.getElementById('mobileSignUp');

    function toggleMobileMenu() {
      mobileMenu.classList.toggle('hidden');
    }

    function closeMobileMenu() {
      if (!mobileMenu.classList.contains('hidden')) {
        mobileMenu.classList.add('hidden');
      }
    }

    mobileMenuBtn.addEventListener('click', (event) => {
      event.stopPropagation();
      toggleMobileMenu();
    });

    mobileMenu.addEventListener('click', (event) => {
      event.stopPropagation();
    });

    document.addEventListener('click', () => {
      closeMobileMenu();
    });

    mobileChangeLanguage.addEventListener('click', () => {
      closeMobileMenu();
      langModal.classList.remove('hidden');
      langModal.classList.add('flex');
    });

    mobileThemeToggle.addEventListener('click', () => {
      closeMobileMenu();
      applyTheme(!htmlEl.classList.contains('dark'));
    });

   mobileSignIn.addEventListener('click', () => {
      closeMobileMenu();
    });

    mobileSignUp.addEventListener('click', () => {
      closeMobileMenu();
    });

    mobileMenu.querySelectorAll('a[data-mobile-action]').forEach(link => {
      link.addEventListener('click', (event) => {
        const action = link.dataset.mobileAction;
        if (action === 'history') {
          event.preventDefault();
          closeMobileMenu();
          showHistoryModal();
          return;
        }
        closeMobileMenu();
      });
    });

    // ---------- Invoice Settings collapse ----------
    const settingsToggle = document.getElementById('settingsToggle');
    const settingsPanel = document.getElementById('settingsPanel');
    const settingsChevron = document.getElementById('settingsChevron');
    settingsToggle.addEventListener('click', () => {
      const isHidden = settingsPanel.classList.toggle('hidden');
      settingsChevron.style.transform = isHidden ? 'rotate(180deg)' : 'rotate(0deg)';
    });

    // ---------- Currency list ----------
    const currencies = [
      'AED','AFN','ALL (Lek)','AMD','AOA (Kz)','ARS ($)','AUD ($)','AWG (ƒ)','AZN (ман)','BAM (KM)',
      'BBD ($)','BDT (Tk)','BGN (лв)','BHD','BIF','BMD ($)','BND ($)','BOB ($b)','BOV','BRL (R$)',
      'BSD ($)','BTN','BWP (P)','BYN (Br)','BZD (BZ$)','CAD ($)','CDF','CHE','CHF','CHW','CLF',
      'CLP ($)','CNY (¥)','COP (p.)','COU','CRC (₡)','CUP (₱)','CVE','CZK (Kč)','DJF (CHF)','DKK (kr)',
      'DOP (RD$)','DZD','EGP (E£)','ERN','ETB','EUR (€)','FJD ($)','FKP (£)','GBP (£)','GEL',
      'GHS (GH¢)','GIP (£)','GMD','GNF','GTQ (Q)','GYD ($)','HKD (HK$)','HNL (L)','HTG','HUF (Ft)',
      'IDR (Rp)','ILS (₪)','INR (Rs)','IQD','IRR','ISK (kr)','JMD (J$)','JOD','JPY (¥)','KES (KSh)',
      'KGS (лв)','KHR (៛)','KMF','KPW (₩)','KRW (₩)','KWD (د.ك)','KYD ($)','KZT (лв)','LAK (₭)','LBP (£)',
      'LKR (Rs)','LRD ($)','LSL','LYD (LD)','MAD','MDL','MGA','MKD (ден)','MMK','MNT (₮)',
      'MOP','MRU','MUR (Rs)','MVR','MWK','MXN ($)','MXV','MYR (RM)','MZN (MT)','NAD (N$)',
      'NGN (₦)','NIO (C$)','NOK (kr)','NPR (Rs)','NZD ($)','OMR','PAB (B/.)','PEN (S/.)','PGK','PHP (₱)',
      'PKR (Rs)','PLN (zł)','PYG (Gs)','QAR','RON (lei)','RSD (Дин.)','RUB (руб)','RWF','SAR','SBD ($)',
      'SCR (Rs)','SDG','SEK (kr)','SGD ($)','SHP (£)','SLE','SOS (S)','SRD ($)','SSP','STN',
      'SVC ($)','SYP (£)','SZL','THB (฿)','TJS','TMT','TND (DT)','TOP','TRY','TTD (TT$)',
      'TWD (NT$)','TZS (TSh)','UAH (₴)','UGX (USh)','USD ($)','USN','UYI','UYU ($U)','UYW','UZS (лв)',
      'VED','VES','VND (₫)','VUV','WST','XAD','XAF','XAG','XAU','XBA',
      'XBB','XBC','XBD','XCD ($)','XCG (Cg)','XDR','XOF','XPD','XPF','XPT',
      'XSU','XTS','XUA','XXX','YER','ZAR (R)','ZMW (ZK)','ZWG'
    ];
const currencySelect = document.getElementById('currencySelect');

currencies.forEach(currency => {
    const option = document.createElement('option');

    option.value = currency;
    option.textContent = currency;

    currencySelect.appendChild(option);
});

// Default currency
currencySelect.value = 'USD ($)';

async function setCurrencyFromIP() {
    try {

        // Only detect currency for NON-LOGGED-IN users
        if (
            typeof currentUser !== 'undefined' &&
            currentUser &&
            currentUser.loggedIn === true
        ) {
            console.log('Logged-in user: keeping saved currency');
            return;
        }

        const response = await fetch(
            'api/get-location.php',
            {
                method: 'GET',
                cache: 'no-store'
            }
        );

        if (!response.ok) {
            throw new Error('Location API failed');
        }

        const data = await response.json();

        if (data.status !== 'success') {
            throw new Error(
                data.message || 'Location detection failed'
            );
        }

        const currencyCode =
            String(data.currency || 'USD').toUpperCase();

        console.log(
            'Detected currency from IP:',
            currencyCode
        );

        // Find currency from currencies array
        const matchingCurrency = currencies.find(currency => {

            const code =
                String(currency)
                    .trim()
                    .split(/\s+/)[0]
                    .toUpperCase();

            return code === currencyCode;
        });

        if (matchingCurrency) {

            currencySelect.value = matchingCurrency;

            currencySelect.dispatchEvent(
                new Event('change', {
                    bubbles: true
                })
            );

            console.log(
                'Currency selected:',
                matchingCurrency
            );

        } else {

            currencySelect.value = 'USD ($)';

            currencySelect.dispatchEvent(
                new Event('change', {
                    bubbles: true
                })
            );

            console.log(
                'Currency not found. Using USD.'
            );
        }

    } catch (error) {

        console.error(
            'Currency detection error:',
            error
        );

        currencySelect.value = 'USD ($)';
    }
}

// Detect currency for guest user
setCurrencyFromIP();

    const saveDefaultBtn = document.getElementById('saveDefaultBtn');
    const themeSelect = document.getElementById('themeSelect');
    const lineItemsBody = document.getElementById('lineItemsBody');
    const addLineItemBtn = document.getElementById('addLineItemBtn');
    const discountSection = document.getElementById('discountSection');
    const shippingSection = document.getElementById('shippingSection');
    const addDiscountBtn = document.getElementById('addDiscountBtn');
    const addShippingBtn = document.getElementById('addShippingBtn');
    const saveSendBtn = document.getElementById('saveSendBtn');
    const downloadBtn = document.getElementById('downloadBtn');
    const thankYouScreen = document.getElementById('thankYouScreen');
    const thankYouEditBtn = document.getElementById('thankYouEditBtn');
    const thankYouHistoryBtn = document.getElementById('thankYouHistoryBtn');
    const thankYouNewBtn = document.getElementById('thankYouNewBtn');
    const thankYouSignUpBtn = document.getElementById('thankYouSignUpBtn');
    const emailPromptModal = document.getElementById('emailPromptModal');
    const emailPromptClose = document.getElementById('emailPromptClose');
    const emailPromptCancel = document.getElementById('emailPromptCancel');
    const emailPromptSend = document.getElementById('emailPromptSend');
    const emailPromptInput = document.getElementById('emailPromptInput');
    const historyModal = document.getElementById('historyModal');
    const historyClose = document.getElementById('historyClose');
    const historySearchInput = document.getElementById('historySearchInput');
    const historyExportBtn = document.getElementById('historyExportBtn');
    const historyNewBtn = document.getElementById('historyNewBtn');
    const historyEraseBtn = document.getElementById('historyEraseBtn');
    const historyList = document.getElementById('historyList');
    const navHistoryLink = document.getElementById('navHistory');
    const printInvoice = document.getElementById('printInvoice');
        let invoiceHistory = JSON.parse(localStorage.getItem('invoiceHistory') || '[]');
    let pendingSendInvoice = null;

    // ---------- Logged-in state ----------
let currentUser = null;

async function checkLoginStatus() {

    try {

        const res = await fetch('api/session_check.php');

        if (res.ok) {

            currentUser = await res.json();

            const name = currentUser.firstName || 'Account';

            // ==============================
            // DYNAMIC USER NAME
            // ==============================

            const firstName = currentUser.firstName || '';
            const lastName = currentUser.lastName || '';
            const initials = currentUser.initials || '';

            const userInitials =
                document.getElementById('userInitials');

            if (userInitials) {
                userInitials.textContent = initials;
            }

            const userDisplayName =
                document.getElementById('userDisplayName');

            if (userDisplayName) {

                const displayName = lastName
                    ? `${firstName}.${lastName.charAt(0).toLowerCase()}`
                    : firstName;

                userDisplayName.textContent = displayName;
            }

            // ==============================
            // MOBILE
            // ==============================

            const mobileSignIn =
                document.getElementById('mobileSignIn');

            const mobileSignUp =
                document.getElementById('mobileSignUp');

            if (mobileSignIn) {
                mobileSignIn.style.display = 'none';
            }

            if (mobileSignUp) {
                mobileSignUp.textContent = name;
                mobileSignUp.href = 'dashboard.php';
            }

            // ==============================
            // DASHBOARD NAV
            // ==============================

            const dashboardNav = `
                <a href="dashboard.php"
                   class="hover:text-ink dark:hover:text-dark-text">
                    My Invoices
                </a>
                       <a href="/scheduled-invoices.php" class="hover:text-ink dark:hover:text-dark-text">Scheduled Invoices </a>
                <a href="customers.php"
                   class="hover:text-ink dark:hover:text-dark-text">
                    Customers
                </a>

            

             
            `;

            const dashboardMobileNav = `
                <a href="dashboard.php"
                   class="px-3 py-2 rounded-md hover:bg-gray-100 dark:hover:bg-dark-border">
                    My Invoices
                </a>

                <a href="customers.php"
                   class="px-3 py-2 rounded-md hover:bg-gray-100 dark:hover:bg-dark-border">
                    Customers
                </a>

                <a href="#"
                   class="px-3 py-2 rounded-md hover:bg-gray-100 dark:hover:bg-dark-border">
                    Settings
                </a>

            
            `;

            const mainNav =
                document.getElementById('mainNav');

            const mobileNavLinks =
                document.getElementById('mobileNavLinks');

            if (mainNav) {
                mainNav.innerHTML = dashboardNav;
            }

            if (mobileNavLinks) {
                mobileNavLinks.innerHTML =
                    dashboardMobileNav;
            }
        }

    } catch (e) {

        console.log('Login check failed:', e);

    }

    applyPendingInvoiceFromDashboard();
}

checkLoginStatus();

    // ---------- Handle Edit / Duplicate coming from the dashboard ----------
    // ---------- Handle Edit / Duplicate coming from the dashboard ----------
  let editingInvoiceId = null;

function applyPendingInvoiceFromDashboard() {
    const params = new URLSearchParams(window.location.search);

    const invoiceNumberFromUrl = params.get('edit');

    if (invoiceNumberFromUrl) {

        const raw = sessionStorage.getItem('editInvoiceData');
        const id = sessionStorage.getItem('editInvoiceId');

        if (raw && id) {

            // Set edit mode FIRST
            editingInvoiceId = id;

            const editScheduleSection =
                document.getElementById('editScheduleSection');

            const editScheduledToggle =
                document.getElementById('editScheduledToggle');

            const editScheduledToggleCircle =
                document.getElementById('editScheduledToggleCircle');

            const editScheduledLabel =
                document.getElementById('editScheduledLabel');

            const scheduleFields =
                document.getElementById('scheduleFields');

            const scheduleFrequency =
                document.getElementById('scheduleFrequency');

            const customerEmail =
                document.getElementById('customerEmail');

            const invoiceData = JSON.parse(raw);

            // ==========================================
            // CHECK SCHEDULE
            // ==========================================

            const isScheduled =
                Number(
                    invoiceData.isScheduled ??
                    invoiceData.is_scheduled ??
                    0
                ) === 1;

            const frequency =
                invoiceData.scheduleFrequency ??
                invoiceData.schedule_frequency ??
                '';

            const email =
                invoiceData.customerEmail ??
                invoiceData.customer_email ??
                '';

            // ==========================================
            // ALWAYS SHOW SCHEDULE SECTION IN EDIT MODE
            // ==========================================

            if (editScheduleSection) {
                editScheduleSection.classList.remove('hidden');
            }

            // ==========================================
            // SET SCHEDULE TOGGLE
            // ==========================================

            if (editScheduledToggle) {

                editScheduledToggle.dataset.scheduled =
                    isScheduled ? '1' : '0';

                if (isScheduled) {

                    editScheduledToggle.classList.remove(
                        'bg-gray-300',
                        'dark:bg-gray-600'
                    );

                    editScheduledToggle.classList.add(
                        'bg-[#B12F26]'
                    );

                    if (editScheduledToggleCircle) {
                        editScheduledToggleCircle.classList.remove(
                            'translate-x-1'
                        );

                        editScheduledToggleCircle.classList.add(
                            'translate-x-6'
                        );
                    }

                    if (editScheduledLabel) {
                        editScheduledLabel.textContent = 'Yes';
                    }

                    if (scheduleFields) {
                        scheduleFields.classList.remove('hidden');
                    }

                } else {

                    editScheduledToggle.classList.remove(
                        'bg-[#B12F26]'
                    );

                    editScheduledToggle.classList.add(
                        'bg-gray-300',
                        'dark:bg-gray-600'
                    );

                    if (editScheduledToggleCircle) {
                        editScheduledToggleCircle.classList.remove(
                            'translate-x-6'
                        );

                        editScheduledToggleCircle.classList.add(
                            'translate-x-1'
                        );
                    }

                    if (editScheduledLabel) {
                        editScheduledLabel.textContent = 'No';
                    }

                    if (scheduleFields) {
                        scheduleFields.classList.add('hidden');
                    }
                }
            }

            // ==========================================
            // FILL DATABASE VALUES
            // ==========================================

            if (scheduleFrequency) {
                scheduleFrequency.value = frequency;
            }

            if (customerEmail) {
                customerEmail.value = email;
            }

            // ==========================================
            // LOAD REST OF INVOICE
            // ==========================================

            loadInvoiceEntry(invoiceData);

            console.log(
                'Editing invoice:',
                invoiceNumberFromUrl,
                'DB ID:',
                editingInvoiceId
            );

        } else {
            console.error(
                'EDIT DATA OR EDIT ID MISSING FROM SESSION STORAGE'
            );
        }

        // ==========================================
        // CLEAN SESSION STORAGE
        // ==========================================

        sessionStorage.removeItem('editInvoiceData');
        sessionStorage.removeItem('editInvoiceId');

    } else if (params.get('duplicate') === '1') {

        const raw =
            sessionStorage.getItem('duplicateInvoiceData');

        if (raw) {
            const data = JSON.parse(raw);

            data.invoiceNumber = '';

            loadInvoiceEntry(data);
        }

        sessionStorage.removeItem('duplicateInvoiceData');
    }
}


    
    const translations = {
      English: {
        'nav.history': 'History',
        'nav.guides': 'Guides',
        'nav.help': 'Help',
        'lang.title': 'Change Language',
        'invoice.logo': 'Add Your Logo',
        'invoice.title': 'INVOICE',
        'invoice.fromPlaceholder': 'Who is this from?',
        'invoice.billTo': 'Bill To',
        'invoice.billToPlaceholder': 'Who is this to?',
        'invoice.shipTo': 'Ship To',
        'invoice.shipToPlaceholder': '(optional)',
        'invoice.date': 'Date',
        'invoice.datePlaceholder': 'MM DD,YYYY',
        'invoice.paymentTerms': 'Payment Terms',
        'invoice.paymentTermsPlaceholder': 'Net 30',
        'invoice.dueDate': 'Due Date',
        'invoice.dueDatePlaceholder': 'MM DD,YYYY',
        'invoice.poNumber': 'PO Number',
        'invoice.poNumberPlaceholder': '12345',
        'invoice.notes': 'Notes',
        'invoice.notesPlaceholder': 'Notes - any relevant information not already covered',
        'invoice.terms': 'Terms',
        'invoice.termsPlaceholder': 'Terms and conditions - late fees, payment methods, delivery schedule',
        'table.item': 'Item',
        'table.quantity': 'Quantity',
        'table.rate': 'Rate',
        'table.amount': 'Amount',
        'table.addLineItem': 'Line Item',
        'table.itemPlaceholder': 'Description of item/service...',
        'totals.subtotal': 'Subtotal',
        'totals.tax': 'Tax',
        'totals.discount': 'Discount',
        'totals.shipping': 'Shipping',
        'actions.addDiscount': 'Discount',
        'actions.addShipping': 'Shipping',
        'totals.total': 'Total',
        'totals.amountPaid': 'Amount Paid',
        'totals.balanceDue': 'Balance Due',
        'sidebar.saveSend': 'Save & Send',
        'sidebar.download': 'Download',
        'sidebar.invoiceSettings': 'Invoice Settings',
        'settings.theme': 'Theme',
        'settings.currency': 'Currency',
        'settings.saveDefault': 'Save Default',
        'confirm.title': 'Save Default Invoice',
        'confirm.message': 'Do you want to make this invoice the default template, overwriting the current one?',
        'confirm.ok': 'OK',
        'confirm.cancel': 'Cancel'
      },
      español: {
        'nav.history': 'Historial',
        'nav.guides': 'Guías',
        'nav.help': 'Ayuda',
        'lang.title': 'Cambiar idioma',
        'invoice.logo': 'Agregar su logo',
        'invoice.title': 'FACTURA',
        'invoice.fromPlaceholder': '¿De quién es esto?',
        'invoice.billTo': 'Facturar a',
        'invoice.billToPlaceholder': '¿A quién es esto?',
        'invoice.shipTo': 'Enviar a',
        'invoice.shipToPlaceholder': '(opcional)',
        'invoice.date': 'Fecha',
        'invoice.datePlaceholder': 'DD/MM/AAAA',
        'invoice.paymentTerms': 'Términos de pago',
        'invoice.paymentTermsPlaceholder': 'Net 30',
        'invoice.dueDate': 'Fecha de vencimiento',
        'invoice.dueDatePlaceholder': 'DD/MM/AAAA',
        'invoice.poNumber': 'N.º de orden',
        'invoice.poNumberPlaceholder': '12345',
        'invoice.notes': 'Notas',
        'invoice.notesPlaceholder': 'Notas - cualquier información relevante no ya cubierta',
        'invoice.terms': 'Términos',
        'invoice.termsPlaceholder': 'Términos y condiciones - cargos por demora, métodos de pago, entrega',
        'table.item': 'Artículo',
        'table.quantity': 'Cantidad',
        'table.rate': 'Precio',
        'table.amount': 'Importe',
        'table.addLineItem': 'Línea',
        'table.itemPlaceholder': 'Descripción del artículo/servicio...',
        'totals.subtotal': 'Subtotal',
        'totals.tax': 'Impuesto',
        'totals.discount': 'Descuento',
        'totals.shipping': 'Envío',
        'actions.addDiscount': 'Descuento',
        'actions.addShipping': 'Envío',
        'totals.total': 'Total',
        'totals.amountPaid': 'Importe pagado',
        'totals.balanceDue': 'Saldo adeudado',
        'sidebar.saveSend': 'Guardar y enviar',
        'sidebar.download': 'Descargar',
        'sidebar.invoiceSettings': 'Configuración de factura',
        'settings.theme': 'Tema',
        'settings.currency': 'Moneda',
        'settings.saveDefault': 'Guardar como predeterminado',
        'confirm.title': 'Guardar factura predeterminada',
        'confirm.message': '¿Desea hacer esta factura la plantilla predeterminada, sobrescribiendo la actual?',
        'confirm.ok': 'Aceptar',
        'confirm.cancel': 'Cancelar'
      },
      français: {
        'nav.history': 'Historique',
        'nav.guides': 'Guides',
        'nav.help': 'Aide',
        'lang.title': 'Changer de langue',
        'invoice.logo': 'Ajoutez votre logo',
        'invoice.title': 'FACTURE',
        'invoice.fromPlaceholder': 'De qui est-ce ?',
        'invoice.billTo': 'Facturer à',
        'invoice.billToPlaceholder': 'À qui est-ce ?',
        'invoice.shipTo': 'Expédier à',
        'invoice.shipToPlaceholder': '(facultatif)',
        'invoice.date': 'Date',
        'invoice.datePlaceholder': 'JJ/MM/AAAA',
        'invoice.paymentTerms': 'Conditions de paiement',
        'invoice.paymentTermsPlaceholder': 'Net 30',
        'invoice.dueDate': 'Date d’échéance',
        'invoice.dueDatePlaceholder': 'JJ/MM/AAAA',
        'invoice.poNumber': 'Nº de commande',
        'invoice.poNumberPlaceholder': '12345',
        'invoice.notes': 'Notes',
        'invoice.notesPlaceholder': 'Notes - toute information pertinente déjà non couverte',
        'invoice.terms': 'Conditions',
        'invoice.termsPlaceholder': 'Conditions - frais de retard, méthodes de paiement, livraison',
        'table.item': 'Article',
        'table.quantity': 'Quantité',
        'table.rate': 'Tarif',
        'table.amount': 'Montant',
        'table.addLineItem': 'Ligne',
        'table.itemPlaceholder': 'Description de l’article/service...',
        'totals.subtotal': 'Sous-total',
        'totals.tax': 'Taxe',
        'totals.discount': 'Remise',
        'totals.shipping': 'Expédition',
        'actions.addDiscount': 'Remise',
        'actions.addShipping': 'Expédition',
        'totals.total': 'Total',
        'totals.amountPaid': 'Montant payé',
        'totals.balanceDue': 'Solde dû',
        'sidebar.saveSend': 'Enregistrer et envoyer',
        'sidebar.download': 'Télécharger',
        'sidebar.invoiceSettings': 'Paramètres de facture',
        'settings.theme': 'Thème',
        'settings.currency': 'Devise',
        'settings.saveDefault': 'Enregistrer par défaut',
        'confirm.title': 'Enregistrer par défaut',
        'confirm.message': 'Voulez-vous faire de cette facture le modèle par défaut et écraser l’actuel ?',
        'confirm.ok': 'OK',
        'confirm.cancel': 'Annuler'
      },
      Deutsch: {
        'nav.history': 'Verlauf',
        'nav.guides': 'Anleitungen',
        'nav.help': 'Hilfe',
        'lang.title': 'Sprache ändern',
        'invoice.logo': 'Logo hinzufügen',
        'invoice.title': 'RECHNUNG',
        'invoice.fromPlaceholder': 'Von wem ist das?',
        'invoice.billTo': 'Rechnung an',
        'invoice.billToPlaceholder': 'Wem gehört das?',
        'invoice.shipTo': 'Lieferadresse',
        'invoice.shipToPlaceholder': '(optional)',
        'invoice.date': 'Datum',
        'invoice.datePlaceholder': 'TT.MM.JJJJ',
        'invoice.paymentTerms': 'Zahlungsbedingungen',
        'invoice.paymentTermsPlaceholder': 'Netto 30',
        'invoice.dueDate': 'Fälligkeitsdatum',
        'invoice.dueDatePlaceholder': 'TT.MM.JJJJ',
        'invoice.poNumber': 'Bestellnummer',
        'invoice.poNumberPlaceholder': '12345',
        'invoice.notes': 'Notizen',
        'invoice.notesPlaceholder': 'Notizen – alle relevanten Informationen, die noch nicht abgedeckt sind',
        'invoice.terms': 'Bedingungen',
        'invoice.termsPlaceholder': 'Bedingungen – Verzugsgebühren, Zahlungsmethoden, Lieferung',
        'table.item': 'Artikel',
        'table.quantity': 'Menge',
        'table.rate': 'Preis',
        'table.amount': 'Betrag',
        'table.addLineItem': 'Position',
        'table.itemPlaceholder': 'Beschreibung des Artikels/Dienstleistung...',
        'totals.subtotal': 'Zwischensumme',
        'totals.tax': 'Steuer',
        'totals.discount': 'Rabatt',
        'totals.shipping': 'Versand',
        'actions.addDiscount': 'Rabatt',
        'actions.addShipping': 'Versand',
        'totals.total': 'Gesamt',
        'totals.amountPaid': 'Bereits bezahlt',
        'totals.balanceDue': 'Restbetrag',
        'sidebar.saveSend': 'Speichern & Senden',
        'sidebar.download': 'Herunterladen',
        'sidebar.invoiceSettings': 'Rechnungseinstellungen',
        'settings.theme': 'Thema',
        'settings.currency': 'Währung',
        'settings.saveDefault': 'Als Standard speichern',
        'confirm.title': 'Als Standard speichern',
        'confirm.message': 'Möchten Sie diese Rechnung als Standardvorlage speichern und die aktuelle überschreiben?',
        'confirm.ok': 'OK',
        'confirm.cancel': 'Abbrechen'
      },
      italiano: {
        'nav.history': 'Cronologia',
        'nav.guides': 'Guide',
        'nav.help': 'Aiuto',
        'lang.title': 'Cambia lingua',
        'invoice.logo': 'Aggiungi il tuo logo',
        'invoice.title': 'FATTURA',
        'invoice.fromPlaceholder': 'Da chi è questo?',
        'invoice.billTo': 'Fatturare a',
        'invoice.billToPlaceholder': 'A chi è questo?',
        'invoice.shipTo': 'Spedire a',
        'invoice.shipToPlaceholder': '(facoltativo)',
        'invoice.date': 'Data',
        'invoice.datePlaceholder': 'GG/MM/AAAA',
        'invoice.paymentTerms': 'Termini di pagamento',
        'invoice.paymentTermsPlaceholder': 'Net 30',
        'invoice.dueDate': 'Data di scadenza',
        'invoice.dueDatePlaceholder': 'GG/MM/AAAA',
        'invoice.poNumber': 'Numero ordine',
        'invoice.poNumberPlaceholder': '12345',
        'invoice.notes': 'Note',
        'invoice.notesPlaceholder': 'Note - qualsiasi informazione rilevante non già coperta',
        'invoice.terms': 'Termini',
        'invoice.termsPlaceholder': 'Termini e condizioni - commissioni per ritardi, metodi di pagamento, consegna',
        'table.item': 'Voce',
        'table.quantity': 'Quantità',
        'table.rate': 'Tariffa',
        'table.amount': 'Importo',
        'table.addLineItem': 'Voce',
        'table.itemPlaceholder': 'Descrizione dell’articolo/servizio...',
        'totals.subtotal': 'Subtotale',
        'totals.tax': 'Tasse',
        'totals.discount': 'Sconto',
        'totals.shipping': 'Spedizione',
        'actions.addDiscount': 'Sconto',
        'actions.addShipping': 'Spedizione',
        'totals.total': 'Totale',
        'totals.amountPaid': 'Importo pagato',
        'totals.balanceDue': 'Saldo dovuto',
        'sidebar.saveSend': 'Salva e invia',
        'sidebar.download': 'Scarica',
        'sidebar.invoiceSettings': 'Impostazioni fattura',
        'settings.theme': 'Tema',
        'settings.currency': 'Valuta',
        'settings.saveDefault': 'Salva predefinito',
        'confirm.title': 'Salva predefinito',
        'confirm.message': 'Vuoi rendere questa fattura il modello predefinito e sovrascrivere quello corrente?',
        'confirm.ok': 'OK',
        'confirm.cancel': 'Annulla'
      },
      Nederlands: {
        'nav.history': 'Geschiedenis',
        'nav.guides': 'Handleidingen',
        'nav.help': 'Help',
        'lang.title': 'Taal wijzigen',
        'invoice.logo': 'Voeg uw logo toe',
        'invoice.title': 'FACTUUR',
        'invoice.fromPlaceholder': 'Van wie is dit?',
        'invoice.billTo': 'Factureren aan',
        'invoice.billToPlaceholder': 'Voor wie is dit?',
        'invoice.shipTo': 'Verzenden naar',
        'invoice.shipToPlaceholder': '(optioneel)',
        'invoice.date': 'Datum',
        'invoice.datePlaceholder': 'DD-MM-JJJJ',
        'invoice.paymentTerms': 'Betalingsvoorwaarden',
        'invoice.paymentTermsPlaceholder': 'Netto 30',
        'invoice.dueDate': 'Vervaldatum',
        'invoice.dueDatePlaceholder': 'DD-MM-JJJJ',
        'invoice.poNumber': 'Bestelnummer',
        'invoice.poNumberPlaceholder': '12345',
        'invoice.notes': 'Notities',
        'invoice.notesPlaceholder': 'Notities - alle relevante informatie die niet eerder is behandeld',
        'invoice.terms': 'Voorwaarden',
        'invoice.termsPlaceholder': 'Voorwaarden - boetes, betaalmethoden, levering',
        'table.item': 'Item',
        'table.quantity': 'Aantal',
        'table.rate': 'Tarief',
        'table.amount': 'Bedrag',
        'table.addLineItem': 'Regel',
        'table.itemPlaceholder': 'Beschrijving van artikel/dienst...',
        'totals.subtotal': 'Subtotaal',
        'totals.tax': 'Belasting',
        'totals.discount': 'Korting',
        'totals.shipping': 'Verzending',
        'actions.addDiscount': 'Korting',
        'actions.addShipping': 'Verzending',
        'totals.total': 'Totaal',
        'totals.amountPaid': 'Betaald bedrag',
        'totals.balanceDue': 'Verschuldigd bedrag',
        'sidebar.saveSend': 'Opslaan & Verzenden',
        'sidebar.download': 'Downloaden',
        'sidebar.invoiceSettings': 'Factuurinstellingen',
        'settings.theme': 'Thema',
        'settings.currency': 'Valuta',
        'settings.saveDefault': 'Standaard opslaan',
        'confirm.title': 'Als standaard opslaan',
        'confirm.message': 'Wilt u deze factuur als standaard sjabloon gebruiken en de huidige overschrijven?',
        'confirm.ok': 'OK',
        'confirm.cancel': 'Annuleren'
      },
      português: {
        'nav.history': 'Histórico',
        'nav.guides': 'Guias',
        'nav.help': 'Ajuda',
        'lang.title': 'Mudar idioma',
        'invoice.logo': 'Adicione seu logo',
        'invoice.title': 'FATURA',
        'invoice.fromPlaceholder': 'De quem é isto?',
        'invoice.billTo': 'Faturar para',
        'invoice.billToPlaceholder': 'Para quem é isto?',
        'invoice.shipTo': 'Enviar para',
        'invoice.shipToPlaceholder': '(opcional)',
        'invoice.date': 'Data',
        'invoice.datePlaceholder': 'DD/MM/AAAA',
        'invoice.paymentTerms': 'Condições de pagamento',
        'invoice.paymentTermsPlaceholder': 'Net 30',
        'invoice.dueDate': 'Data de vencimento',
        'invoice.dueDatePlaceholder': 'DD/MM/AAAA',
        'invoice.poNumber': 'Nº do pedido',
        'invoice.poNumberPlaceholder': '12345',
        'invoice.notes': 'Notas',
        'invoice.notesPlaceholder': 'Notas - qualquer informação relevante não coberta',
        'invoice.terms': 'Termos',
        'invoice.termsPlaceholder': 'Termos e condições - multas, métodos de pagamento, entrega',
        'table.item': 'Item',
        'table.quantity': 'Quantidade',
        'table.rate': 'Valor',
        'table.amount': 'Montante',
        'table.addLineItem': 'Linha',
        'table.itemPlaceholder': 'Descrição do item/serviço...',
        'totals.subtotal': 'Subtotal',
        'totals.tax': 'Imposto',
        'totals.discount': 'Desconto',
        'totals.shipping': 'Frete',
        'actions.addDiscount': 'Desconto',
        'actions.addShipping': 'Frete',
        'totals.total': 'Total',
        'totals.amountPaid': 'Valor pago',
        'totals.balanceDue': 'Saldo devido',
        'sidebar.saveSend': 'Salvar e enviar',
        'sidebar.download': 'Baixar',
        'sidebar.invoiceSettings': 'Configurações da fatura',
        'settings.theme': 'Tema',
        'settings.currency': 'Moeda',
        'settings.saveDefault': 'Salvar padrão',
        'confirm.title': 'Salvar padrão',
        'confirm.message': 'Deseja tornar esta fatura o modelo padrão, substituindo a atual?',
        'confirm.ok': 'OK',
        'confirm.cancel': 'Cancelar'
      },
      dansk: {
        'nav.history': 'Historik',
        'nav.guides': 'Guides',
        'nav.help': 'Hjælp',
        'lang.title': 'Skift sprog',
        'invoice.logo': 'Tilføj dit logo',
        'invoice.title': 'FAKTURA',
        'invoice.fromPlaceholder': 'Hvem er dette fra?',
        'invoice.billTo': 'Fakturer til',
        'invoice.billToPlaceholder': 'Hvem er dette til?',
        'invoice.shipTo': 'Send til',
        'invoice.shipToPlaceholder': '(valgfrit)',
        'invoice.date': 'Dato',
        'invoice.datePlaceholder': 'DD-MM-ÅÅÅÅ',
        'invoice.paymentTerms': 'Betalingsbetingelser',
        'invoice.paymentTermsPlaceholder': 'Net 30',
        'invoice.dueDate': 'Forfaldsdato',
        'invoice.dueDatePlaceholder': 'DD-MM-ÅÅÅÅ',
        'invoice.poNumber': 'PO-nummer',
        'invoice.poNumberPlaceholder': '12345',
        'invoice.notes': 'Noter',
        'invoice.notesPlaceholder': 'Noter - alle relevante oplysninger ikke allerede dækket',
        'invoice.terms': 'Vilkår',
        'invoice.termsPlaceholder': 'Vilkår - gebyrer ved forsinkelse, betalingsmetoder, levering',
        'table.item': 'Vare',
        'table.quantity': 'Antal',
        'table.rate': 'Pris',
        'table.amount': 'Beløb',
        'table.addLineItem': 'Linje',
        'table.itemPlaceholder': 'Beskrivelse af vare/ydelse...',
        'totals.subtotal': 'Subtotal',
        'totals.tax': 'Moms',
        'totals.discount': 'Rabat',
        'totals.shipping': 'Forsendelse',
        'actions.addDiscount': 'Rabat',
        'actions.addShipping': 'Forsendelse',
        'totals.total': 'Total',
        'totals.amountPaid': 'Betalt beløb',
        'totals.balanceDue': 'Skyldigt beløb',
        'sidebar.saveSend': 'Gem & Send',
        'sidebar.download': 'Download',
        'sidebar.invoiceSettings': 'Fakturaindstillinger',
        'settings.theme': 'Tema',
        'settings.currency': 'Valuta',
        'settings.saveDefault': 'Gem standard',
        'confirm.title': 'Gem som standard',
        'confirm.message': 'Vil du gøre denne faktura til standardskabelonen og overskrive den aktuelle?',
        'confirm.ok': 'OK',
        'confirm.cancel': 'Annuller'
      },
      norsk: {
        'nav.history': 'Historie',
        'nav.guides': 'Guider',
        'nav.help': 'Hjelp',
        'lang.title': 'Endre språk',
        'invoice.logo': 'Legg til din logo',
        'invoice.title': 'FAKTURA',
        'invoice.fromPlaceholder': 'Hvem er dette fra?',
        'invoice.billTo': 'Fakturer til',
        'invoice.billToPlaceholder': 'Hvem er dette til?',
        'invoice.shipTo': 'Send til',
        'invoice.shipToPlaceholder': '(valgfritt)',
        'invoice.date': 'Dato',
        'invoice.datePlaceholder': 'DD.MM.ÅÅÅÅ',
        'invoice.paymentTerms': 'Betalingsbetingelser',
        'invoice.paymentTermsPlaceholder': 'Netto 30',
        'invoice.dueDate': 'Forfallsdato',
        'invoice.dueDatePlaceholder': 'DD.MM.ÅÅÅÅ',
        'invoice.poNumber': 'Ordrenummer',
        'invoice.poNumberPlaceholder': '12345',
        'invoice.notes': 'Notater',
        'invoice.notesPlaceholder': 'Notater - all relevant informasjon som ikke allerede er dekket',
        'invoice.terms': 'Vilkår',
        'invoice.termsPlaceholder': 'Vilkår - gebyrer for forsinkelse, betalingsmetoder, levering',
        'table.item': 'Vare',
        'table.quantity': 'Antall',
        'table.rate': 'Pris',
        'table.amount': 'Beløp',
        'table.addLineItem': 'Linje',
        'table.itemPlaceholder': 'Beskrivelse av vare/tjeneste...',
        'totals.subtotal': 'Delsum',
        'totals.tax': 'Skatt',
        'totals.discount': 'Rabatt',
        'totals.shipping': 'Frakt',
        'actions.addDiscount': 'Rabatt',
        'actions.addShipping': 'Frakt',
        'totals.total': 'Total',
        'totals.amountPaid': 'Betalt beløp',
        'totals.balanceDue': 'Skyldig beløp',
        'sidebar.saveSend': 'Lagre & Send',
        'sidebar.download': 'Last ned',
        'sidebar.invoiceSettings': 'Faktura-innstillinger',
        'settings.theme': 'Tema',
        'settings.currency': 'Valuta',
        'settings.saveDefault': 'Lagre standard',
        'confirm.title': 'Lagre som standard',
        'confirm.message': 'Vil du gjøre denne fakturaen til standardmalen og overskrive den nåværende?',
        'confirm.ok': 'OK',
        'confirm.cancel': 'Avbryt'
      },
      svenska: {
        'nav.history': 'Historik',
        'nav.guides': 'Guider',
        'nav.help': 'Hjälp',
        'lang.title': 'Byt språk',
        'invoice.logo': 'Lägg till din logotyp',
        'invoice.title': 'FAKTURA',
        'invoice.fromPlaceholder': 'Vem är detta ifrån?',
        'invoice.billTo': 'Fakturera till',
        'invoice.billToPlaceholder': 'Vem är detta till?',
        'invoice.shipTo': 'Leverera till',
        'invoice.shipToPlaceholder': '(valfritt)',
        'invoice.date': 'Datum',
        'invoice.datePlaceholder': 'ÅÅÅÅ-MM-DD',
        'invoice.paymentTerms': 'Betalningsvillkor',
        'invoice.paymentTermsPlaceholder': 'Netto 30',
        'invoice.dueDate': 'Förfallodatum',
        'invoice.dueDatePlaceholder': 'ÅÅÅÅ-MM-DD',
        'invoice.poNumber': 'Beställningsnummer',
        'invoice.poNumberPlaceholder': '12345',
        'invoice.notes': 'Anteckningar',
        'invoice.notesPlaceholder': 'Anteckningar - all relevant information som inte redan täcks',
        'invoice.terms': 'Villkor',
        'invoice.termsPlaceholder': 'Villkor - förseningsavgifter, betalningsmetoder, leverans',
        'table.item': 'Artikel',
        'table.quantity': 'Antal',
        'table.rate': 'Pris',
        'table.amount': 'Summa',
        'table.addLineItem': 'Rad',
        'table.itemPlaceholder': 'Beskrivning av artikel/tjänst...',
        'totals.subtotal': 'Delsumma',
        'totals.tax': 'Skatt',
        'totals.discount': 'Rabatt',
        'totals.shipping': 'Frakt',
        'actions.addDiscount': 'Rabatt',
        'actions.addShipping': 'Frakt',
        'totals.total': 'Totalt',
        'totals.amountPaid': 'Betalt belopp',
        'totals.balanceDue': 'Skuld',
        'sidebar.saveSend': 'Spara & Skicka',
        'sidebar.download': 'Ladda ner',
        'sidebar.invoiceSettings': 'Fakturainställningar',
        'settings.theme': 'Tema',
        'settings.currency': 'Valuta',
        'settings.saveDefault': 'Spara som standard',
        'confirm.title': 'Spara som standard',
        'confirm.message': 'Vill du göra denna faktura till standardmallen och skriva över den nuvarande?',
        'confirm.ok': 'OK',
        'confirm.cancel': 'Avbryt'
      },
      română: {
        'nav.history': 'Istoric',
        'nav.guides': 'Ghiduri',
        'nav.help': 'Ajutor',
        'lang.title': 'Schimbă limba',
        'invoice.logo': 'Adăugați logo-ul',
        'invoice.title': 'FACTURĂ',
        'invoice.fromPlaceholder': 'De la cine este acesta?',
        'invoice.billTo': 'Facturați către',
        'invoice.billToPlaceholder': 'Cui este acesta?',
        'invoice.shipTo': 'Livrați către',
        'invoice.shipToPlaceholder': '(opțional)',
        'invoice.date': 'Data',
        'invoice.datePlaceholder': 'ZZ/LL/AAAA',
        'invoice.paymentTerms': 'Termeni de plată',
        'invoice.paymentTermsPlaceholder': 'Net 30',
        'invoice.dueDate': 'Data scadenței',
        'invoice.dueDatePlaceholder': 'ZZ/LL/AAAA',
        'invoice.poNumber': 'Număr comandă',
        'invoice.poNumberPlaceholder': '12345',
        'invoice.notes': 'Note',
        'invoice.notesPlaceholder': 'Note - orice informație relevantă care nu este deja acoperită',
        'invoice.terms': 'Termeni',
        'invoice.termsPlaceholder': 'Termeni și condiții - taxe de întârziere, metode de plată, livrare',
        'table.item': 'Articol',
        'table.quantity': 'Cantitate',
        'table.rate': 'Tarif',
        'table.amount': 'Sumă',
        'table.addLineItem': 'Linie',
        'table.itemPlaceholder': 'Descrierea articolului/serviciului...',
        'totals.subtotal': 'Subtotal',
        'totals.tax': 'Taxă',
        'totals.discount': 'Reducere',
        'totals.shipping': 'Transport',
        'actions.addDiscount': 'Reducere',
        'actions.addShipping': 'Transport',
        'totals.total': 'Total',
        'totals.amountPaid': 'Sumă plătită',
        'totals.balanceDue': 'Sold restant',
        'sidebar.saveSend': 'Salvează și trimite',
        'sidebar.download': 'Descarcă',
        'sidebar.invoiceSettings': 'Setări factură',
        'settings.theme': 'Tema',
        'settings.currency': 'Monedă',
        'settings.saveDefault': 'Salvează implicit',
        'confirm.title': 'Salvează implicit',
        'confirm.message': 'Doriți să faceți această factură modelul implicit, suprascriind actualul?',
        'confirm.ok': 'OK',
        'confirm.cancel': 'Anulează'
      },
      polski: {
        'nav.history': 'Historia',
        'nav.guides': 'Poradniki',
        'nav.help': 'Pomoc',
        'lang.title': 'Zmień język',
        'invoice.logo': 'Dodaj swoje logo',
        'invoice.title': 'FAKTURA',
        'invoice.fromPlaceholder': 'Od kogo jest ta faktura?',
        'invoice.billTo': 'Nabywca',
        'invoice.billToPlaceholder': 'Dla kogo jest ta faktura?',
        'invoice.shipTo': 'Wysyłka do',
        'invoice.shipToPlaceholder': '(opcjonalnie)',
        'invoice.date': 'Data',
        'invoice.datePlaceholder': 'DD/MM/RRRR',
        'invoice.paymentTerms': 'Warunki płatności',
        'invoice.paymentTermsPlaceholder': 'Net 30',
        'invoice.dueDate': 'Termin płatności',
        'invoice.dueDatePlaceholder': 'DD/MM/RRRR',
        'invoice.poNumber': 'Numer zamówienia',
        'invoice.poNumberPlaceholder': '12345',
        'invoice.notes': 'Uwagi',
        'invoice.notesPlaceholder': 'Uwagi - wszelkie istotne informacje jeszcze nieuwzględnione',
        'invoice.terms': 'Warunki',
        'invoice.termsPlaceholder': 'Warunki - opłaty za zwłokę, metody płatności, dostawa',
        'table.item': 'Pozycja',
        'table.quantity': 'Ilość',
        'table.rate': 'Cena',
        'table.amount': 'Kwota',
        'table.addLineItem': 'Wiersz',
        'table.itemPlaceholder': 'Opis towaru/usługi...',
        'totals.subtotal': 'Suma częściowa',
        'totals.tax': 'Podatek',
        'totals.discount': 'Rabat',
        'totals.shipping': 'Wysyłka',
        'actions.addDiscount': 'Rabat',
        'actions.addShipping': 'Wysyłka',
        'totals.total': 'Razem',
        'totals.amountPaid': 'Kwota zapłacona',
        'totals.balanceDue': 'Pozostało do zapłaty',
        'sidebar.saveSend': 'Zapisz i wyślij',
        'sidebar.download': 'Pobierz',
        'sidebar.invoiceSettings': 'Ustawienia faktury',
        'settings.theme': 'Motyw',
        'settings.currency': 'Waluta',
        'settings.saveDefault': 'Zapisz jako domyślne',
        'confirm.title': 'Zapisz domyślną fakturę',
        'confirm.message': 'Czy chcesz uczynić tę fakturę domyślnym szablonem, nadpisując obecny?',
        'confirm.ok': 'OK',
        'confirm.cancel': 'Anuluj'
      },
      Türkçe: {
        'nav.history': 'Geçmiş',
        'nav.guides': 'Kılavuzlar',
        'nav.help': 'Yardım',
        'lang.title': 'Dili değiştir',
        'invoice.logo': 'Logonuzu ekleyin',
        'invoice.title': 'FATURA',
        'invoice.fromPlaceholder': 'Bu kimin?',
        'invoice.billTo': 'Fatura edilecek',
        'invoice.billToPlaceholder': 'Bu kime?',
        'invoice.shipTo': 'Gönderilecek',
        'invoice.shipToPlaceholder': '(isteğe bağlı)',
        'invoice.date': 'Tarih',
        'invoice.datePlaceholder': 'GG/AA/YYYY',
        'invoice.paymentTerms': 'Ödeme Koşulları',
        'invoice.paymentTermsPlaceholder': 'Net 30',
        'invoice.dueDate': 'Vade Tarihi',
        'invoice.dueDatePlaceholder': 'GG/AA/YYYY',
        'invoice.poNumber': 'Satın Alma Numarası',
        'invoice.poNumberPlaceholder': '12345',
        'invoice.notes': 'Notlar',
        'invoice.notesPlaceholder': 'Henüz kapsanmayan ilgili bilgiler',
        'invoice.terms': 'Koşullar',
        'invoice.termsPlaceholder': 'Geç ödeme ücretleri, ödeme yöntemleri, teslimat',
        'table.item': 'Kalem',
        'table.quantity': 'Adet',
        'table.rate': 'Birim Fiyat',
        'table.amount': 'Tutar',
        'table.addLineItem': 'Satır',
        'table.itemPlaceholder': 'Ürün/hizmet açıklaması...',
        'totals.subtotal': 'Ara Toplam',
        'totals.tax': 'Vergi',
        'totals.discount': 'İndirim',
        'totals.shipping': 'Kargo',
        'actions.addDiscount': 'İndirim',
        'actions.addShipping': 'Kargo',
        'totals.total': 'Toplam',
        'totals.amountPaid': 'Ödenen Tutar',
        'totals.balanceDue': 'Bakiye',
        'sidebar.saveSend': 'Kaydet ve Gönder',
        'sidebar.download': 'İndir',
        'sidebar.invoiceSettings': 'Fatura Ayarları',
        'settings.theme': 'Tema',
        'settings.currency': 'Para Birimi',
        'settings.saveDefault': 'Varsayılanı Kaydet',
        'confirm.title': 'Varsayılanı Kaydet',
        'confirm.message': 'Bu faturayı varsayılan şablon yapmak ve mevcut olanın üzerine yazmak ister misiniz?',
        'confirm.ok': 'Tamam',
        'confirm.cancel': 'İptal'
      },
      українська: {
        'nav.history': 'Історія',
        'nav.guides': 'Посібники',
        'nav.help': 'Допомога',
        'lang.title': 'Змінити мову',
        'invoice.logo': 'Додайте свій логотип',
        'invoice.title': 'РАХУНОК',
        'invoice.fromPlaceholder': 'Від кого це?',
        'invoice.billTo': 'Виставити рахунок',
        'invoice.billToPlaceholder': 'Кому це?',
        'invoice.shipTo': 'Доставити до',
        'invoice.shipToPlaceholder': '(необов’язково)',
        'invoice.date': 'Дата',
        'invoice.datePlaceholder': 'ДД/ММ/РРРР',
        'invoice.paymentTerms': 'Умови оплати',
        'invoice.paymentTermsPlaceholder': 'Net 30',
        'invoice.dueDate': 'Дата оплати',
        'invoice.dueDatePlaceholder': 'ДД/ММ/РРРР',
        'invoice.poNumber': 'Номер замовлення',
        'invoice.poNumberPlaceholder': '12345',
        'invoice.notes': 'Нотатки',
        'invoice.notesPlaceholder': 'Нотатки - будь-яка релевантна інформація, що ще не покрита',
        'invoice.terms': 'Умови',
        'invoice.termsPlaceholder': 'Умови - штрафи за запізнення, методи оплати, доставка',
        'table.item': 'Товар',
        'table.quantity': 'Кількість',
        'table.rate': 'Ціна',
        'table.amount': 'Сума',
        'table.addLineItem': 'Рядок',
        'table.itemPlaceholder': 'Опис товару/послуги...',
        'totals.subtotal': 'Підсумок',
        'totals.tax': 'Податок',
        'totals.discount': 'Знижка',
        'totals.shipping': 'Доставка',
        'actions.addDiscount': 'Знижка',
        'actions.addShipping': 'Доставка',
        'totals.total': 'Всього',
        'totals.amountPaid': 'Сплачено',
        'totals.balanceDue': 'Залишок',
        'sidebar.saveSend': 'Зберегти та надіслати',
        'sidebar.download': 'Завантажити',
        'sidebar.invoiceSettings': 'Налаштування рахунку',
        'settings.theme': 'Тема',
        'settings.currency': 'Валюта',
        'settings.saveDefault': 'Зберегти за замовчуванням',
        'confirm.title': 'Зберегти за замовчуванням',
        'confirm.message': 'Бажаєте зробити цей рахунок шаблоном за замовчуванням, перезаписавши поточний?',
        'confirm.ok': 'OK',
        'confirm.cancel': 'Скасувати'
      },
      ไทย: {
        'nav.history': 'ประวัติ',
        'nav.guides': 'คู่มือ',
        'nav.help': 'ช่วยเหลือ',
        'lang.title': 'เปลี่ยนภาษา',
        'invoice.logo': 'เพิ่มโลโก้ของคุณ',
        'invoice.title': 'ใบแจ้งหนี้',
        'invoice.fromPlaceholder': 'นี่มาจากใคร?',
        'invoice.billTo': 'เรียกเก็บเงินถึง',
        'invoice.billToPlaceholder': 'นี่คือใคร?',
        'invoice.shipTo': 'จัดส่งถึง',
        'invoice.shipToPlaceholder': '(ไม่บังคับ)',
        'invoice.date': 'วันที่',
        'invoice.datePlaceholder': 'DD/MM/YYYY',
        'invoice.paymentTerms': 'เงื่อนไขการชำระเงิน',
        'invoice.paymentTermsPlaceholder': 'Net 30',
        'invoice.dueDate': 'วันที่ครบกำหนด',
        'invoice.dueDatePlaceholder': 'DD/MM/YYYY',
        'invoice.poNumber': 'หมายเลขสั่งซื้อ',
        'invoice.poNumberPlaceholder': '12345',
        'invoice.notes': 'หมายเหตุ',
        'invoice.notesPlaceholder': 'หมายเหตุ - ข้อมูลที่เกี่ยวข้องซึ่งยังไม่ครอบคลุม',
        'invoice.terms': 'เงื่อนไข',
        'invoice.termsPlaceholder': 'เงื่อนไข - ค่าปรับล่าช้า วิธีการชำระเงิน การจัดส่ง',
        'table.item': 'รายการ',
        'table.quantity': 'จำนวน',
        'table.rate': 'อัตรา',
        'table.amount': 'จำนวนเงิน',
        'table.addLineItem': 'แถว',
        'table.itemPlaceholder': 'คำอธิบายสินค้า/บริการ...',
        'totals.subtotal': 'รวมย่อย',
        'totals.tax': 'ภาษี',
        'totals.discount': 'ส่วนลด',
        'totals.shipping': 'จัดส่ง',
        'actions.addDiscount': 'ส่วนลด',
        'actions.addShipping': 'จัดส่ง',
        'totals.total': 'ยอดรวม',
        'totals.amountPaid': 'จำนวนเงินที่ชำระ',
        'totals.balanceDue': 'ยอดคงเหลือ',
        'sidebar.saveSend': 'บันทึกและส่ง',
        'sidebar.download': 'ดาวน์โหลด',
        'sidebar.invoiceSettings': 'การตั้งค่าใบแจ้งหนี้',
        'settings.theme': 'ธีม',
        'settings.currency': 'สกุลเงิน',
        'settings.saveDefault': 'บันทึกค่าเริ่มต้น',
        'confirm.title': 'บันทึกค่าเริ่มต้น',
        'confirm.message': 'คุณต้องการใช้ใบแจ้งหนี้นี้เป็นเทมเพลตเริ่มต้นโดยเขียนทับเทมเพลตปัจจุบันหรือไม่?',
        'confirm.ok': 'ตกลง',
        'confirm.cancel': 'ยกเลิก'
      },
      Indonesia: {
        'nav.history': 'Riwayat',
        'nav.guides': 'Panduan',
        'nav.help': 'Bantuan',
        'lang.title': 'Ganti bahasa',
        'invoice.logo': 'Tambahkan logo Anda',
        'invoice.title': 'FAKTUR',
        'invoice.fromPlaceholder': 'Ini dari siapa?',
        'invoice.billTo': 'Tagih ke',
        'invoice.billToPlaceholder': 'Ini untuk siapa?',
        'invoice.shipTo': 'Kirim ke',
        'invoice.shipToPlaceholder': '(opsional)',
        'invoice.date': 'Tanggal',
        'invoice.datePlaceholder': 'DD/MM/YYYY',
        'invoice.paymentTerms': 'Syarat Pembayaran',
        'invoice.paymentTermsPlaceholder': 'Net 30',
        'invoice.dueDate': 'Tanggal Jatuh Tempo',
        'invoice.dueDatePlaceholder': 'DD/MM/YYYY',
        'invoice.poNumber': 'No. PO',
        'invoice.poNumberPlaceholder': '12345',
        'invoice.notes': 'Catatan',
        'invoice.notesPlaceholder': 'Catatan - informasi relevan yang belum tercakup',
        'invoice.terms': 'Ketentuan',
        'invoice.termsPlaceholder': 'Ketentuan - biaya keterlambatan, metode pembayaran, pengiriman',
        'table.item': 'Item',
        'table.quantity': 'Jumlah',
        'table.rate': 'Tarif',
        'table.amount': 'Jumlah',
        'table.addLineItem': 'Baris',
        'table.itemPlaceholder': 'Deskripsi item/layanan...',
        'totals.subtotal': 'Subtotal',
        'totals.tax': 'Pajak',
        'totals.discount': 'Diskon',
        'totals.shipping': 'Pengiriman',
        'actions.addDiscount': 'Diskon',
        'actions.addShipping': 'Pengiriman',
        'totals.total': 'Total',
        'totals.amountPaid': 'Jumlah Dibayar',
        'totals.balanceDue': 'Saldo Terutang',
        'sidebar.saveSend': 'Simpan & Kirim',
        'sidebar.download': 'Unduh',
        'sidebar.invoiceSettings': 'Pengaturan Faktur',
        'settings.theme': 'Tema',
        'settings.currency': 'Mata Uang',
        'settings.saveDefault': 'Simpan Default',
        'confirm.title': 'Simpan Default',
        'confirm.message': 'Apakah Anda ingin menjadikan faktur ini template default, menimpa yang saat ini?',
        'confirm.ok': 'OK',
        'confirm.cancel': 'Batal'
      }
    };

    const i18nElements = Array.from(document.querySelectorAll('[data-i18n]'));
    const i18nPlaceholders = Array.from(document.querySelectorAll('[data-i18n-placeholder]'));

    function translatePage(lang) {
      const dictionary = translations[lang] || translations.English;
      i18nElements.forEach(el => {
        const key = el.dataset.i18n;
        if (dictionary[key]) el.textContent = dictionary[key];
      });
      i18nPlaceholders.forEach(el => {
        const key = el.dataset.i18nPlaceholder;
        if (dictionary[key]) el.placeholder = dictionary[key];
      });
      const confirmTitle = document.getElementById('confirmTitle');
      const confirmMessage = document.getElementById('confirmMessage');
      const confirmOk = document.getElementById('confirmOk');
      const confirmCancel = document.getElementById('confirmCancel');
      if (confirmTitle) confirmTitle.textContent = dictionary['confirm.title'] || '';
      if (confirmMessage) confirmMessage.textContent = dictionary['confirm.message'] || '';
      if (confirmOk) confirmOk.textContent = dictionary['confirm.ok'] || '';
      if (confirmCancel) confirmCancel.textContent = dictionary['confirm.cancel'] || '';
      document.querySelectorAll('[data-i18n-option]').forEach(opt => {
        const key = opt.dataset.i18nOption;
        if (dictionary[key]) opt.textContent = dictionary[key];
      });
    }

     function getCurrencySymbol(currencyString) {
      const match = currencyString.match(/\(([^)]+)\)$/);
      return match ? match[1] : '$';
    }

    function getCurrencyCode(currencyString) {
      return currencyString.split(' ')[0];
    }

    function updateCurrencySymbols() {
      const code = getCurrencyCode(currencySelect.value);
      document.querySelectorAll('.currencySymbol').forEach(el => {
        el.textContent = code;
      });
    }

    function showSaveDefaultButton() {
      if (saveDefaultBtn) saveDefaultBtn.classList.remove('hidden');
    }

    const saveConfirmModal = document.createElement('div');
    saveConfirmModal.id = 'saveConfirmModal';
    saveConfirmModal.className = 'fixed inset-0 z-50 hidden items-center justify-center bg-black/40 px-4';
    saveConfirmModal.innerHTML = `
      <div class="bg-white dark:bg-dark-card rounded-md shadow-xl w-full max-w-md p-6 relative">
        <div class="flex items-center justify-between mb-5">
          <h2 id="confirmTitle" class="text-xl font-bold text-ink dark:text-dark-text"></h2>
          <button id="confirmClose" class="text-gray-400 hover:text-gray-600 dark:text-dark-muted dark:hover:text-dark-text text-2xl leading-none">&times;</button>
        </div>
        <p id="confirmMessage" class="text-sm text-gray-700 dark:text-dark-muted mb-6"></p>
        <div class="flex justify-end gap-3">
          <button id="confirmCancel" class="px-4 py-2 rounded border border-gray-300 dark:border-dark-border text-gray-700 dark:text-dark-text hover:bg-gray-100 dark:hover:bg-dark-border">Cancel</button>
          <button id="confirmOk" class="px-4 py-2 rounded bg-brand-green text-white hover:bg-brand-greenDark">OK</button>
        </div>
      </div>
    `;
    document.body.appendChild(saveConfirmModal);

    const confirmClose = document.getElementById('confirmClose');
    const confirmOk = document.getElementById('confirmOk');
    const confirmCancel = document.getElementById('confirmCancel');

    function showSaveConfirm() {
      translatePage(selectedLanguage);
      saveConfirmModal.classList.remove('hidden');
      saveConfirmModal.classList.add('flex');
    }

    function hideSaveConfirm() {
      saveConfirmModal.classList.add('hidden');
      saveConfirmModal.classList.remove('flex');
    }

    confirmClose.addEventListener('click', hideSaveConfirm);
    confirmCancel.addEventListener('click', hideSaveConfirm);

    confirmOk.addEventListener('click', () => {
      const defaults = {
        theme: themeSelect.value,
        currency: currencySelect.value
      };
      localStorage.setItem('invoicegen-defaults', JSON.stringify(defaults));
      saveDefaultBtn.classList.add('hidden');
      hideSaveConfirm();
    });

    function loadDefaults() {
      const saved = localStorage.getItem('invoicegen-defaults');
      if (saved) {
        try {
          const defaults = JSON.parse(saved);
          if (defaults.theme) themeSelect.value = defaults.theme;
          if (defaults.currency) currencySelect.value = defaults.currency;
        } catch (err) {
          console.warn('Invalid default settings', err);
        }
      }
      updateCurrencySymbols();
    }

    function isMobileScreen() {
      return window.matchMedia('(max-width: 767px)').matches;
    }

    function createLineItemRow() {
      const row = document.createElement('tr');
      row.className = isMobileScreen() ? 'sm:hidden border border-gray-200 dark:border-dark-border rounded-3xl overflow-hidden mb-3 bg-white dark:bg-dark-card group' : 'hidden sm:table-row border-b border-gray-200 dark:border-dark-border group';
      if (isMobileScreen()) {
        row.innerHTML = `
          <td colspan="4" class="p-4">
            <div class="mb-4">
              <div class="text-sm font-semibold text-gray-700 dark:text-dark-muted mb-2">Item</div>
              <textarea rows="1" placeholder="${translations[selectedLanguage]?.['table.itemPlaceholder'] || translations.English['table.itemPlaceholder']}" class="field w-full min-w-0 resize-none lineDescription" data-i18n-placeholder="table.itemPlaceholder"></textarea>
            <div class="grid grid-cols-2 gap-3 mb-4">
              <div>
                <div class="text-sm font-semibold text-gray-700 dark:text-dark-muted mb-2">Quantity</div>
                <input type="text" value="1" class="field w-full min-w-0 lineQty">
              </div>
              <div>
                <div class="text-sm font-semibold text-gray-700 dark:text-dark-muted mb-2">Rate</div>
                <div class="field flex items-center">
                  <span class="text-gray-500 dark:text-dark-muted mr-1 currencySymbol">${getCurrencyCode(currencySelect.value)}</span>
                  <input type="text" value="0" class="w-full min-w-0 text-right bg-transparent focus:outline-none lineRate">
                </div>
              </div>
            </div>
            <div class="flex flex-col gap-2">
              <div class="text-sm font-semibold text-gray-700 dark:text-dark-muted">Amount</div>
              <div class="flex items-center justify-between">
                <span class="lineAmount text-sm text-gray-800 dark:text-dark-text">${getCurrencyCode(currencySelect.value)} 0.00</span>
                <button type="button" class="remove-line opacity:100 md:opacity-0 md:group-hover:opacity-100 transition-opacity duration-200 w-10 h-10 border border-gray-200 dark:border-dark-border bg-white dark:bg-dark-field text-gray-400 hover:text-red-600 flex items-center justify-center" title="Remove line">
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M6.28 5.22a.75.75 0 011.06 0L10 7.94l2.66-2.72a.75.75 0 111.06 1.06L11.06 9l2.72 2.66a.75.75 0 11-1.06 1.06L10 10.06l-2.66 2.72a.75.75 0 11-1.06-1.06L8.94 9 6.22 6.34a.75.75 0 01.06-1.12z" clip-rule="evenodd" />
                  </svg>
                </button>
              </div>
            </div>
          </td>
        `;
      } else {
        row.innerHTML = `
          <td class="p-2 align-top">
            <textarea rows="1" placeholder="${translations[selectedLanguage]?.['table.itemPlaceholder'] || translations.English['table.itemPlaceholder']}" class="field w-full min-w-0 resize-none lineDescription" data-i18n-placeholder="table.itemPlaceholder"></textarea>
          </td>
          <td class="p-2 align-top w-28">
            <input type="text" value="1" class="field w-full min-w-0 lineQty">
          </td>
          <td class="p-2 align-top w-28">
            <div class="field flex items-center">
             <span class="text-gray-500 dark:text-dark-muted mr-1 currencySymbol">${getCurrencyCode(currencySelect.value)}</span>
              <input type="text" value="0" class="w-full min-w-0 text-right bg-transparent focus:outline-none lineRate">
            </div>
          </td>
          <td class="p-2 align-top w-32">
            <div class="relative flex items-center justify-end gap-2">
              <span class="lineAmount text-sm text-gray-800 dark:text-dark-text">${getCurrencyCode(currencySelect.value)} 0.00</span>
              <button type="button" class="remove-line opacity:100 md:opacity-0 md:group-hover:opacity-100 transition-opacity duration-200 w-10 h-10 border border-gray-200 dark:border-dark-border bg-white dark:bg-dark-field text-gray-400 hover:text-red-600 flex items-center justify-center" title="Remove line">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M6.28 5.22a.75.75 0 011.06 0L10 7.94l2.66-2.72a.75.75 0 111.06 1.06L11.06 9l2.72 2.66a.75.75 0 11-1.06 1.06L10 10.06l-2.66 2.72a.75.75 0 11-1.06-1.06L8.94 9 6.22 6.34a.75.75 0 01.06-1.12z" clip-rule="evenodd" />
                </svg>
              </button>
            </div>
          </td>
        `;
      }
      return row;
    }

    // --- New behavior: logo upload validation, section toggles, line item removal, totals ---
    const logoBtnEl = document.getElementById('logoBtn');
    const logoRemoveBtn = document.getElementById('logoRemoveBtn');
    const logoInput = document.getElementById('logoInput');
    const logoErrorModal = document.getElementById('logoErrorModal');
    const logoErrorOk = document.getElementById('logoErrorOk');
    let uploadedLogoData = null;

    logoBtnEl.addEventListener('click', () => logoInput.click());
    logoErrorOk.addEventListener('click', () => {
      logoErrorModal.classList.add('hidden');
    });
    logoInput.addEventListener('change', (e) => {
      const f = e.target.files && e.target.files[0];
      if (!f) return;
      const okTypes = ['image/jpeg','image/png','image/gif'];
      if (!okTypes.includes(f.type)) {
        logoErrorModal.classList.remove('hidden');
        return;
      }
      // If valid, show simple preview by setting button background
      const reader = new FileReader();
      reader.onload = () => {
        uploadedLogoData = reader.result;
        logoBtnEl.style.backgroundImage = `url(${reader.result})`;
        logoBtnEl.style.backgroundSize = 'contain';
        logoBtnEl.style.backgroundRepeat = 'no-repeat';
        logoBtnEl.style.backgroundPosition = 'center';
        logoBtnEl.querySelector('span').style.opacity = '0';
        logoRemoveBtn.classList.remove('hidden');
      };
      reader.readAsDataURL(f);
    });

    logoRemoveBtn.addEventListener('click', () => {
      uploadedLogoData = null;
      logoBtnEl.style.backgroundImage = '';
      logoBtnEl.querySelector('span').style.opacity = '1';
      logoRemoveBtn.classList.add('hidden');
      logoInput.value = '';
    });

    function parseNum(v) {
      if (v === null || v === undefined) return 0;
      v = String(v).replace(/[^0-9.\-]/g,'');
      const n = parseFloat(v);
      return isNaN(n) ? 0 : n;
    }

    function formatNumber(n) {
      const sign = n < 0 ? '-' : '';
      const absValue = Math.abs(n);
      const [integerPart, decimalPart] = absValue.toFixed(2).split('.');
      const formattedInteger = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
      return sign + formattedInteger + '.' + decimalPart;
    }

    function formatCurrency(n) {
      return getCurrencyCode(currencySelect.value) + ' ' + formatNumber(n);
    }

    function updateLineAmounts() {
      const rows = Array.from(lineItemsBody.querySelectorAll('tr'));
      let subtotal = 0;
      rows.forEach(row => {
        const qtyEl = row.querySelector('.lineQty');
        const rateEl = row.querySelector('.lineRate');
        const amountEl = row.querySelector('.lineAmount');
        const qty = parseNum(qtyEl?.value || 0);
        const rate = parseNum(rateEl?.value || 0);
        const amt = qty * rate;
        subtotal += amt;
        if (amountEl) amountEl.textContent = formatCurrency(amt);
      });
      document.getElementById('subtotalValue').textContent = formatCurrency(subtotal);
      return subtotal;
    }

    function updateTotals() {
      const subtotal = updateLineAmounts();
      // discount
      let discount = 0;
      if (!document.getElementById('discountSection').classList.contains('hidden')) {
        const discIsPercent = document.getElementById('discountPercentSign')?.textContent === '%';
        const dVal = parseNum(document.getElementById('discountInput')?.value || 0);
        discount = discIsPercent ? subtotal * dVal / 100 : dVal;
      }
      const taxableBase = Math.max(0, subtotal - discount);
      // tax
      let tax = 0;
      const taxFieldIsPercent = document.getElementById('taxPercentSign')?.textContent === '%';
      const taxVal = parseNum(document.getElementById('taxPercentInput')?.value || 0);
      if (taxFieldIsPercent) tax = taxableBase * taxVal / 100;
      else tax = taxVal;
      // shipping
      let shipping = 0;
      if (!document.getElementById('shippingSection').classList.contains('hidden')) {
        const shipIsPercent = document.getElementById('shippingPercentSign')?.textContent === '%';
        const sVal = parseNum(document.getElementById('shippingInput')?.value || 0);
        shipping = shipIsPercent ? subtotal * sVal / 100 : sVal;
      }
      const amountPaid = parseNum(document.getElementById('amountPaidInput')?.value || 0);
      const invoiceTotal = subtotal - discount + tax + shipping;
      const balance = Math.max(0, invoiceTotal - amountPaid);
      document.getElementById('totalValue').textContent = formatCurrency(invoiceTotal);
      document.getElementById('balanceDueValue').textContent = formatCurrency(balance);
    }

    // event delegation for line item changes and remove
    lineItemsBody.addEventListener('input', (e) => {
      if (e.target.classList.contains('lineQty') || e.target.classList.contains('lineRate')) {
        updateTotals();
      }
    });
    lineItemsBody.addEventListener('click', (e) => {
      const rem = e.target.closest('.remove-line');
      if (rem) {
        const row = rem.closest('tr');
        row.remove();
        updateTotals();
      }
    });

    // Add handlers for add buttons to hide themselves when section shown
    const addTaxBtn = document.getElementById('addTaxBtn');
    const taxSectionEl = document.getElementById('taxRow');
    const taxToggleBtn = document.getElementById('taxToggleBtn');
    const taxCloseBtn = document.getElementById('taxCloseBtn');
    const addTax = () => {
      taxSectionEl.classList.remove('hidden');
      addTaxBtn.style.display = 'none';
      updateTotals();
    };
    addTaxBtn.addEventListener('click', (e) => { e.preventDefault(); addTax(); });
    taxCloseBtn.addEventListener('click', () => { taxSectionEl.classList.add('hidden'); addTaxBtn.style.display = ''; updateTotals(); });

    addDiscountBtn.addEventListener('click', (event) => {
      event.preventDefault();
      discountSection.classList.remove('hidden');
      addDiscountBtn.style.display = 'none';
      updateTotals();
    });
    document.getElementById('discountCloseBtn').addEventListener('click', () => { discountSection.classList.add('hidden'); addDiscountBtn.style.display = ''; updateTotals(); });

    addShippingBtn.addEventListener('click', (event) => {
      event.preventDefault();
      shippingSection.classList.remove('hidden');
      addShippingBtn.style.display = 'none';
      updateTotals();
    });
    document.getElementById('shippingCloseBtn').addEventListener('click', () => { shippingSection.classList.add('hidden'); addShippingBtn.style.display = ''; updateTotals(); });

    // toggle percent/currency for sections
    function togglePercent(section) {
      const subtotal = updateLineAmounts();
      if (section === 'tax') {
        const signEl = document.getElementById('taxPercentSign');
        const input = document.getElementById('taxPercentInput');
        if (signEl.textContent === '%') {
          // convert percent -> amount
          const pct = parseNum(input.value);
          const amt = subtotal * pct / 100;
          input.value = amt.toFixed(2);
          signEl.textContent = getCurrencyCode(currencySelect.value);
        } else {
          const amt = parseNum(input.value);
          const pct = subtotal === 0 ? 0 : (amt / subtotal) * 100;
          input.value = pct.toFixed(2);
          signEl.textContent = '%';
        }
      } else if (section === 'discount') {
        const signEl = document.getElementById('discountPercentSign');
        const input = document.getElementById('discountInput');
        if (signEl.textContent === '%') {
          const pct = parseNum(input.value);
          const amt = subtotal * pct / 100;
          input.value = amt.toFixed(2);
          signEl.textContent = getCurrencyCode(currencySelect.value);
        } else {
          const amt = parseNum(input.value);
          const pct = subtotal === 0 ? 0 : (amt / subtotal) * 100;
          input.value = pct.toFixed(2);
          signEl.textContent = '%';
        }
      } else if (section === 'shipping') {
        const signWrap = document.querySelector('#shippingField .currencySymbol');
        const input = document.getElementById('shippingInput');
        // shipping is normally currency; we'll keep toggle but simply switch between code and % sign
        // Indicate percent by adding a percent sign span if necessary
        const percentSpan = document.getElementById('shippingPercentSign');
        if (percentSpan && percentSpan.textContent === '%') {
          // percent -> currency
          const pct = parseNum(input.value);
          const amt = subtotal * pct / 100;
          input.value = amt.toFixed(2);
          // replace percent sign with currency code
          if (percentSpan) percentSpan.textContent = '';
          if (!document.querySelector('#shippingField .currencySymbol')) {
            const span = document.createElement('span');
            span.className = 'text-gray-500 dark:text-dark-muted mr-1 currencySymbol';
            span.textContent = getCurrencyCode(currencySelect.value);
            document.getElementById('shippingField').insertBefore(span, input);
          }
        } else {
          // currency -> percent
          const amt = parseNum(input.value);
          const pct = subtotal === 0 ? 0 : (amt / subtotal) * 100;
          input.value = pct.toFixed(2);
          // remove currency code if present and show percent
          const cspan = document.querySelector('#shippingField .currencySymbol');
          if (cspan) cspan.remove();
          let ps = document.getElementById('shippingPercentSign');
          if (!ps) {
            ps = document.createElement('span');
            ps.id = 'shippingPercentSign';
            ps.className = 'text-gray-500 dark:text-dark-muted ml-1';
            document.getElementById('shippingField').appendChild(ps);
          }
          ps.textContent = '%';
        }
      }
      updateTotals();
    }

    taxToggleBtn.addEventListener('click', () => togglePercent('tax'));
    document.getElementById('discountToggleBtn').addEventListener('click', () => togglePercent('discount'));
    document.getElementById('shippingToggleBtn').addEventListener('click', () => togglePercent('shipping'));

    const datePicker = document.getElementById('datePicker');
    const dateGrid = document.getElementById('dateGrid');
    const dateMonthLabel = document.getElementById('dateMonthLabel');
    const datePrevBtn = document.getElementById('datePrevBtn');
    const dateNextBtn = document.getElementById('dateNextBtn');
    const invoiceDateInput = document.getElementById('invoiceDateInput');
    const dueDateInput = document.getElementById('dueDateInput');
    let activeDateInput = null;
    let calendarDate = new Date();

const MONTH_NAMES = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

    function pad2(value) {
      return String(value).padStart(2, '0');
    }

    function formatDateValue(date) {
      return `${MONTH_NAMES[date.getMonth()]} ${date.getDate()}, ${date.getFullYear()}`;
    }

    function parseInputDate(value) {
      if (!value) return null;
      // "Jul 3, 2026" style
      const namedMatch = String(value).trim().match(/^([A-Za-z]{3,})\s+(\d{1,2}),?\s*(\d{4})$/);
      if (namedMatch) {
        const monthIndex = MONTH_NAMES.findIndex(m => m.toLowerCase() === namedMatch[1].slice(0, 3).toLowerCase());
        if (monthIndex !== -1) {
          return new Date(Number(namedMatch[3]), monthIndex, Number(namedMatch[2]));
        }
      }
      // Fallback: numeric MM/DD/YYYY (in case of older saved invoices/history entries)
      const parts = String(value).split(/[-\/]/).map(Number);
      if (parts.length === 3 && parts.every(n => !Number.isNaN(n))) {
        const [m, d, y] = parts;
        if (m >= 1 && m <= 12 && d >= 1 && d <= 31) {
          return new Date(y, m - 1, d);
        }
      }
      return null;
    }

    function renderDatePicker(date) {
      calendarDate = new Date(date.getFullYear(), date.getMonth(), 1);
      const year = calendarDate.getFullYear();
      const month = calendarDate.getMonth();
      const firstDay = new Date(year, month, 1).getDay();
      const daysInMonth = new Date(year, month + 1, 0).getDate();
      dateMonthLabel.textContent = calendarDate.toLocaleDateString('en-US', { month: 'long', year: 'numeric' });
      dateGrid.innerHTML = '';
      for (let i = 0; i < firstDay; i += 1) {
        dateGrid.appendChild(document.createElement('span'));
      }
      const selectedDate = activeDateInput ? parseInputDate(activeDateInput.value) : null;
      for (let day = 1; day <= daysInMonth; day += 1) {
        const cell = document.createElement('button');
        cell.type = 'button';
        cell.className = 'rounded-md py-2 text-center transition hover:bg-brand-greenSoft dark:hover:bg-brand-green/20';
        const cellDate = new Date(year, month, day);
        if (selectedDate && cellDate.toDateString() === selectedDate.toDateString()) {
          cell.className += ' bg-brand-green text-white';
        } else {
          cell.className += ' text-gray-700 dark:text-dark-text';
        }
        cell.textContent = String(day);
        cell.addEventListener('click', () => {
          if (activeDateInput) {
            activeDateInput.value = formatDateValue(cellDate);
            activeDateInput.dispatchEvent(new Event('input'));
          }
          hideDatePicker();
        });
        dateGrid.appendChild(cell);
      }
    }

    function positionDatePicker(input) {
      const rect = input.getBoundingClientRect();
      const top = rect.bottom + window.scrollY + 6;
      const left = rect.left + window.scrollX;
      datePicker.style.top = `${top}px`;
      datePicker.style.left = `${left}px`;
    }

    function showDatePicker(input) {
      activeDateInput = input;
      const parsed = parseInputDate(input.value);
      renderDatePicker(parsed || new Date());
      positionDatePicker(input);
      datePicker.classList.remove('hidden');
    }

    function hideDatePicker() {
      activeDateInput = null;
      datePicker.classList.add('hidden');
    }

    datePrevBtn.addEventListener('click', () => {
      calendarDate.setMonth(calendarDate.getMonth() - 1);
      renderDatePicker(calendarDate);
    });
    dateNextBtn.addEventListener('click', () => {
      calendarDate.setMonth(calendarDate.getMonth() + 1);
      renderDatePicker(calendarDate);
    });

    [invoiceDateInput, dueDateInput].forEach(input => {
      if (!input) return;
      input.addEventListener('focus', () => showDatePicker(input));
      input.addEventListener('click', () => showDatePicker(input));
    });

    document.addEventListener('click', (event) => {
      if (!datePicker.contains(event.target) && event.target !== invoiceDateInput && event.target !== dueDateInput) {
        hideDatePicker();
      }
    });

    document.addEventListener('keydown', (event) => {
      if (event.key === 'Escape') hideDatePicker();
    });

    // ensure required fields (except those explicitely optional)
    function enforceRequiredFields() {
      const optionalPlaceholders = ['(optional)'];
      document.querySelectorAll('input, textarea, select').forEach(el => {
        if (el === logoInput) return;
        if (el.type === 'file' || el.type === 'button' || el.type === 'submit') return;
        const ph = el.getAttribute('placeholder') || '';
        if (optionalPlaceholders.some(o => ph.includes(o))) {
          el.removeAttribute('required');
        } else {
          el.setAttribute('required','true');
        }
      });
      // Make notes and terms optional
      document.querySelectorAll('textarea').forEach(t => {
        if (t.placeholder && t.placeholder.toLowerCase().includes('notes')) t.removeAttribute('required');
        if (t.placeholder && t.placeholder.toLowerCase().includes('terms')) t.removeAttribute('required');
      });
    }

    function showValidationWarning(messageId) {
      const el = document.getElementById(messageId);
      if (el) {
        el.classList.remove('hidden');
      }
    }

    function hideValidationWarnings() {
      ['billFromWarning', 'billToWarning'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.classList.add('hidden');
      });
    }

    function validateInvoiceFields() {
      hideValidationWarnings();
      let valid = true;
      const billFrom = document.getElementById('billFromInput');
      const billTo = document.getElementById('billToInput');
      if (!billFrom || !billFrom.value.trim()) {
        showValidationWarning('billFromWarning');
        valid = false;
      }
      if (!billTo || !billTo.value.trim()) {
        showValidationWarning('billToWarning');
        valid = false;
      }
      return valid;
    }

    // wire up amount paid changes
    document.getElementById('amountPaidInput').addEventListener('input', updateTotals);
    document.getElementById('taxPercentInput').addEventListener('input', updateTotals);
    document.getElementById('discountInput').addEventListener('input', updateTotals);
    document.getElementById('shippingInput').addEventListener('input', updateTotals);

    // make sure currency symbol updates totals
    currencySelect.addEventListener('change', () => { updateTotals(); updateCurrencySymbols(); });

    // initialize
    enforceRequiredFields();
    updateTotals();

    // Load the last saved invoice when the website opens
function loadLastInvoiceOnStart() {
    try {
        if (location.hash && location.hash.replace(/^#\/?/, '')) {
            return;
        }

        const params = new URLSearchParams(window.location.search);

        if (params.get('edit') === '1' || params.get('duplicate') === '1') {
            return;
        }

        const savedHistory = localStorage.getItem('invoiceHistory');

        if (!savedHistory) {
            return;
        }

        const history = JSON.parse(savedHistory);

        if (!Array.isArray(history) || history.length === 0) {
            return;
        }

        const lastInvoice = history[0];

        if (!lastInvoice) {
            return;
        }

        loadInvoiceEntry(lastInvoice);
        updateTotals();

        

    } catch (error) {
        console.warn('Could not load last saved invoice:', error);
    }
}

loadLastInvoiceOnStart();

    // initial visibility for + buttons
    try {
      if (!taxSectionEl.classList.contains('hidden')) addTaxBtn.style.display = 'none';
      if (!discountSection.classList.contains('hidden')) addDiscountBtn.style.display = 'none';
      if (!shippingSection.classList.contains('hidden')) addShippingBtn.style.display = 'none';
    } catch (e) {}

    function appendLineItem() {
      lineItemsBody.appendChild(createLineItemRow());
    }

    lineItemsBody.addEventListener('click', (event) => {
      if (event.target.closest('input, textarea, select, button, svg, path')) return;
      const row = event.target.closest('tr');
      if (row) appendLineItem();
    });

    addLineItemBtn.addEventListener('click', (event) => {
      event.preventDefault();
      appendLineItem();
    });

    

    themeSelect.addEventListener('change', showSaveDefaultButton);
    currencySelect.addEventListener('change', () => {
      showSaveDefaultButton();
      updateCurrencySymbols();
    });

    saveDefaultBtn.addEventListener('click', (event) => {
      event.preventDefault();
      showSaveConfirm();
    });

    function getInvoiceData() {
      // The editor contains both desktop and mobile versions of the initial
      // line-item row. Only one of them is visible at a time. Reading every
      // <tr> here was causing the hidden mobile/desktop template to be saved
      // as an extra blank line item in the PDF.
      const rows = Array.from(lineItemsBody.querySelectorAll('tr')).filter(row => {
        const style = window.getComputedStyle(row);
        return style.display !== 'none' && row.offsetParent !== null;
      });

      const lineItems = rows.map(row => ({
        description: row.querySelector('.lineDescription')?.value || '',
        quantity: row.querySelector('.lineQty')?.value || '0',
        rate: row.querySelector('.lineRate')?.value || '0',
        amount: row.querySelector('.lineAmount')?.textContent || '',
      }));
      const discountEl = document.getElementById('discountInput');
      const taxEl = document.getElementById('taxPercentInput');
      const shippingEl = document.getElementById('shippingInput');
      return {
    invoiceNumber: document.getElementById('invoiceNumberInput')?.value || '',

    // =========================
    // SCHEDULE DATA
    // =========================
    isScheduled:
        document.getElementById('editScheduledToggle')?.dataset.scheduled === '1'
            ? 1
            : 0,

    scheduleFrequency:
        document.getElementById('scheduleFrequency')?.value || '',

    customerEmail:
        document.getElementById('customerEmail')?.value.trim() || '',

    billFrom: document.getElementById('billFromInput')?.value || '',
    billTo: document.getElementById('billToInput')?.value || '',
    shipTo: document.getElementById('shipToInput')?.value || '',
    invoiceDate: document.getElementById('invoiceDateInput')?.value || '',
    paymentTerms: document.getElementById('paymentTermsInput')?.value || '',
    dueDate: document.getElementById('dueDateInput')?.value || '',
    poNumber: document.getElementById('poNumberInput')?.value || '',

    notes: document.getElementById('notesInput')?.value || '',
    terms: document.getElementById('termsInput')?.value || '',
    notesHeading: document.getElementById('notesHeadingInput')?.value || 'Notes',
    termsHeading: document.getElementById('termsHeadingInput')?.value || 'Terms',

    currency: currencySelect.value,
    uploadedLogoData,
    lineItems,

    discountValue: discountEl?.value || '0',
    discountType:
        document.getElementById('discountPercentSign')?.textContent === '%'
            ? 'percent'
            : 'amount',

    taxValue: taxEl?.value || '0',
    taxType:
        document.getElementById('taxPercentSign')?.textContent === '%'
            ? 'percent'
            : 'amount',

    shippingValue: shippingEl?.value || '0',
    shippingType:
        document.getElementById('shippingPercentSign')?.textContent === '%'
            ? 'percent'
            : 'amount',

    amountPaid: document.getElementById('amountPaidInput')?.value || '0',
    subtotal: document.getElementById('subtotalValue')?.textContent || '',
    total: document.getElementById('totalValue')?.textContent || '',
    balance: document.getElementById('balanceDueValue')?.textContent || '',

    createdAt: new Date().toISOString(),
};
    }



    function saveHistoryEntry(entry) {
      // ensure a stable id so invoices can be referenced by URL/hash
      if (!entry.id) entry.id = `inv-${Date.now()}-${Math.floor(Math.random()*10000)}`;
      invoiceHistory.unshift(entry);
      localStorage.setItem('invoiceHistory', JSON.stringify(invoiceHistory));
    }

    // Load an invoice entry into the form (re-usable)
 function loadInvoiceEntry(item) {
    if (!item) return;

    currencySelect.value = item.currency || currencySelect.value;
    updateCurrencySymbols();

    const invoiceNumberInput = document.getElementById('invoiceNumberInput');

    invoiceNumberInput.value = item.invoiceNumber || '';

    // Make invoice number read-only when editing existing invoice
 invoiceNumberInput.value = item.invoiceNumber || '';

invoiceNumberInput.readOnly = false;
invoiceNumberInput.classList.remove('bg-gray-100', 'cursor-not-allowed');

document.getElementById('billFromInput').value = item.billFrom || '';
document.getElementById('billToInput').value = item.billTo || '';
document.getElementById('shipToInput').value = item.shipTo || '';
document.getElementById('invoiceDateInput').value = item.invoiceDate || '';
document.getElementById('paymentTermsInput').value = item.paymentTerms || '';
document.getElementById('dueDateInput').value = item.dueDate || '';
document.getElementById('poNumberInput').value = item.poNumber || '';
document.getElementById('notesInput').value = item.notes || '';
document.getElementById('termsInput').value = item.terms || '';

// Load Notes & Terms headings from database
document.getElementById('notesHeadingInput').value =
    item.notesHeading || item.notes_heading || 'Notes';

document.getElementById('termsHeadingInput').value =
    item.termsHeading || item.terms_heading || 'Terms';

document.getElementById('amountPaidInput').value = item.amountPaid || '0';
document.getElementById('amountPaidInput').value = item.amountPaid || '0';

const logoData = item.uploadedLogoData || item.logo_data || '';



if (logoData) {
   
      uploadedLogoData = logoData;

    logoBtnEl.style.backgroundImage = `url("${logoData}")`;
    logoBtnEl.style.backgroundSize = 'contain';
    logoBtnEl.style.backgroundRepeat = 'no-repeat';
    logoBtnEl.style.backgroundPosition = 'center';
    
    const logoText = logoBtnEl.querySelector('span');
    if (logoText) {
        logoText.style.opacity = '0';
    }
    logoRemoveBtn.classList.remove('hidden');

} else {
    console.warn('❌ No logo data found');

    uploadedLogoData = null;
    logoBtnEl.style.backgroundImage = '';

    const logoText = logoBtnEl.querySelector('span');

    if (logoText) {
        logoText.style.opacity = '1';
    }

    logoRemoveBtn.classList.add('hidden');
} 
      // =========================
// LOAD SCHEDULE DATA
// =========================

const editScheduledToggle =
    document.getElementById('editScheduledToggle');

const editScheduledToggleCircle =
    document.getElementById('editScheduledToggleCircle');

const editScheduledLabel =
    document.getElementById('editScheduledLabel');

const scheduleFields =
    document.getElementById('scheduleFields');

const scheduleFrequency =
    document.getElementById('scheduleFrequency');

const customerEmail =
    document.getElementById('customerEmail');

// Support both API names and database-style names
const isScheduled =
    Number(item.isScheduled ?? item.is_scheduled ?? 0) === 1;

const frequency =
    item.scheduleFrequency ??
    item.schedule_frequency ??
    '';

const email =
    item.customerEmail ??
    item.customer_email ??
    '';

// -------------------------
// Toggle
// -------------------------

if (editScheduledToggle) {

    editScheduledToggle.dataset.scheduled =
        isScheduled ? '1' : '0';

    if (isScheduled) {

        // ON
        editScheduledToggle.classList.remove(
            'bg-gray-300',
            'dark:bg-gray-600'
        );

        editScheduledToggle.classList.add(
            'bg-[#B12F26]'
        );

        if (editScheduledToggleCircle) {
            editScheduledToggleCircle.classList.remove(
                'translate-x-1'
            );

            editScheduledToggleCircle.classList.add(
                'translate-x-6'
            );
        }

        if (editScheduledLabel) {
            editScheduledLabel.textContent = 'Yes';
        }

        // Show frequency + email
        if (scheduleFields) {
            scheduleFields.classList.remove('hidden');
        }

    } else {

        // OFF
        editScheduledToggle.classList.remove(
            'bg-[#B12F26]'
        );

        editScheduledToggle.classList.add(
            'bg-gray-300',
            'dark:bg-gray-600'
        );

        if (editScheduledToggleCircle) {
            editScheduledToggleCircle.classList.remove(
                'translate-x-6'
            );

            editScheduledToggleCircle.classList.add(
                'translate-x-1'
            );
        }

        if (editScheduledLabel) {
            editScheduledLabel.textContent = 'No';
        }

        // Hide frequency + email
        if (scheduleFields) {
            scheduleFields.classList.add('hidden');
        }
    }
}

// -------------------------
// Frequency
// -------------------------

if (scheduleFrequency) {
    scheduleFrequency.value = frequency || '';
}

// -------------------------
// Customer Email
// -------------------------

if (customerEmail) {
    customerEmail.value = email || '';
}


      // Line items
      lineItemsBody.innerHTML = '';
      const items = item.lineItems && item.lineItems.length ? item.lineItems : [{ description: '', quantity: '1', rate: '0', amount: '$0.00' }];
      items.forEach(rowData => {
        const newRow = createLineItemRow();
        const desc = newRow.querySelector('.lineDescription'); if (desc) desc.value = rowData.description || '';
        const qty = newRow.querySelector('.lineQty'); if (qty) qty.value = rowData.quantity || '1';
        const rate = newRow.querySelector('.lineRate'); if (rate) rate.value = rowData.rate || '0';
        lineItemsBody.appendChild(newRow);
      });

      // Discount / Tax / Shipping values and signs
      const discountSignEl = document.getElementById('discountPercentSign');
      const taxSignEl = document.getElementById('taxPercentSign');
      let shippingSignEl = document.getElementById('shippingPercentSign');
      const discountInput = document.getElementById('discountInput'); if (discountInput) discountInput.value = item.discountValue || '0';
      const taxInput = document.getElementById('taxPercentInput'); if (taxInput) taxInput.value = item.taxValue || '0';
      const shippingInput = document.getElementById('shippingInput'); if (shippingInput) shippingInput.value = item.shippingValue || '0';

      if (item.discountType === 'percent') {
        if (discountSignEl) discountSignEl.textContent = '%';
      } else {
        if (discountSignEl) discountSignEl.textContent = getCurrencySymbol(item.currency);
      }
      if (item.taxType === 'percent') {
        if (taxSignEl) taxSignEl.textContent = '%';
      } else {
        if (taxSignEl) taxSignEl.textContent = getCurrencySymbol(item.currency);
      }

      if (item.shippingType === 'percent') {
        if (!shippingSignEl) {
          shippingSignEl = document.createElement('span');
          shippingSignEl.id = 'shippingPercentSign';
          shippingSignEl.className = 'text-gray-500 dark:text-dark-muted ml-1';
          document.getElementById('shippingField').appendChild(shippingSignEl);
        }
        shippingSignEl.textContent = '%';
        const cspan = document.querySelector('#shippingField .currencySymbol'); if (cspan) cspan.remove();
      } else {
        const signWrap = document.querySelector('#shippingField .currencySymbol');
        if (!signWrap) {
          const span = document.createElement('span');
          span.className = 'text-gray-500 dark:text-dark-muted mr-1 currencySymbol';
          span.textContent = getCurrencySymbol(item.currency);
          const shippingField = document.getElementById('shippingField');
          const shippingInputEl = document.getElementById('shippingInput');
          if (shippingField && shippingInputEl) shippingField.insertBefore(span, shippingInputEl);
        }
        if (shippingSignEl) shippingSignEl.textContent = '';
      }

      // Ensure discount/tax/shipping sections visibility
      try {
        if (parseNum(item.discountValue || 0) !== 0) { discountSection.classList.remove('hidden'); addDiscountBtn.style.display = 'none'; } else { discountSection.classList.add('hidden'); addDiscountBtn.style.display = ''; }
        if (parseNum(item.taxValue || 0) !== 0) { taxSectionEl.classList.remove('hidden'); addTaxBtn.style.display = 'none'; } else { taxSectionEl.classList.add('hidden'); addTaxBtn.style.display = ''; }
        if (parseNum(item.shippingValue || 0) !== 0) { shippingSection.classList.remove('hidden'); addShippingBtn.style.display = 'none'; } else { shippingSection.classList.add('hidden'); addShippingBtn.style.display = ''; }
      } catch(e) {}

      // Dispatch input events so any listeners update their state
            ['invoiceNumberInput','billFromInput','billToInput','shipToInput','invoiceDateInput','paymentTermsInput','dueDateInput','poNumberInput','notesInput','termsInput','notesHeadingInput','termsHeadingInput','amountPaidInput','discountInput','taxPercentInput','shippingInput'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.dispatchEvent(new Event('input', { bubbles: true }));
      });

      // Recalculate totals
      updateTotals();
    }

    function loadInvoiceById(id) {
      if (!id) return;
      // remove possible leading #/ or #
      id = id.replace(/^#\/?/, '');
      invoiceHistory = JSON.parse(localStorage.getItem('invoiceHistory') || '[]');
      const entry = invoiceHistory.find(e => e.id === id);
      if (entry) {
        loadInvoiceEntry(entry);
        // ensure history modal is closed when loading from URL
        try { hideHistoryModal(); } catch(e) {}
      }
    }

    function getHistoryExportRows(items) {
      const rows = [];
      items.forEach(item => {
        const subtotal = item.lineItems.reduce((total, row) => total + parseNum(row.quantity) * parseNum(row.rate), 0);
        const discountAmount = item.discountType === 'percent' ? subtotal * parseNum(item.discountValue) / 100 : parseNum(item.discountValue);
        const taxableBase = Math.max(0, subtotal - discountAmount);
        const taxAmount = item.taxType === 'percent' ? taxableBase * parseNum(item.taxValue) / 100 : parseNum(item.taxValue);
        const shippingAmount = item.shippingType === 'percent' ? subtotal * parseNum(item.shippingValue) / 100 : parseNum(item.shippingValue);
        item.lineItems.forEach(line => {
          rows.push({
            customer: item.billTo,
            type: 'invoice',
            number: item.invoiceNumber || item.poNumber || '',
            date: item.invoiceDate || '',
            due_date: item.dueDate || '',
            payment_terms: item.paymentTerms || '',
            purchase_order: item.poNumber || '',
            currency: item.currency || '',
            total: item.total || '',
            amount_paid: item.amountPaid || '',
            balance: item.balance || '',
            'ship_to.name': item.shipTo || '',
            notes: item.notes || '',
            terms: item.terms || '',
            item: '',
            description: line.description || '',
            quantity: line.quantity || '',
            unit_cost: line.rate || '',
            discount: discountAmount.toFixed(2),
            tax: taxAmount.toFixed(2),
            shipping: shippingAmount.toFixed(2),
          });
        });
      });
      return rows;
    }

    function downloadCsv(filename, rows) {
      const headers = [
        'customer','type','number','date','due_date','payment_terms','purchase_order','currency','total','amount_paid','balance','ship_to.name','notes','terms','item','description','quantity','unit_cost','discount','tax','shipping'
      ];
      const csv = [headers.join(',')].concat(rows.map(row => headers.map(key => {
        const value = row[key] ?? '';
        const safe = String(value).replace(/"/g, '""');
        return `"${safe}"`;
      }).join(',')));
      const blob = new Blob([csv.join('\n')], { type: 'text/csv;charset=utf-8;' });
      const link = document.createElement('a');
      link.href = URL.createObjectURL(blob);
      link.download = filename;
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);
    }

    function renderPrintableInvoice(data) {
 
            const escapeHtml = (str) => String(str || '').replace(/[&<>"']/g, (c) => ({
        '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
      }[c]));

      // Detects http(s):// and www. links inside a line of free text and
      // wraps them in a real <a> tag, escaping everything else safely.
      const linkifyText = (rawLine) => {
        const line = String(rawLine || '');
        const urlRegex = /(https?:\/\/[^\s]+)|(www\.[^\s]+)/gi;
        let result = '';
        let lastIndex = 0;
        let match;
        while ((match = urlRegex.exec(line)) !== null) {
          const matchedText = match[0].replace(/[.,;:)]+$/, ''); // trim trailing punctuation
          const start = match.index;
          result += escapeHtml(line.slice(lastIndex, start));
          const href = /^https?:\/\//i.test(matchedText) ? matchedText : `https://${matchedText}`;
          result += `<a href="${escapeHtml(href)}" style="color:#1AA260;" target="_blank" rel="noopener">${escapeHtml(matchedText)}</a>`;
          lastIndex = start + matchedText.length;
        }
        result += escapeHtml(line.slice(lastIndex));
        return result;
      };

           // Keep the PDF in sync with the actual visible line items. Older saved
      // invoices can contain the hidden default desktop/mobile row, so remove
      // only rows that have no description and no monetary value. Real dynamic
      // line items are preserved.
      const printableLineItems = (Array.isArray(data.lineItems) ? data.lineItems : []).filter(item => {
        const description = String(item?.description || '').trim();
        const rate = parseNum(item?.rate || 0);
        const amountText = String(item?.amount || '');
        const amount = parseNum(amountText);
        return description !== '' || rate !== 0 || amount !== 0;
      });

      const lineRows = printableLineItems.map(item => {
        const descriptionLines = String(item.description || '').split('\n').map((line, idx) => {
          const content = linkifyText(line);
          return idx === 0
            ? `<div style="font-weight:700; color:#111827;">${content}</div>`
            : `<div>${content}</div>`;
        }).join('');
        return `
        <tr>
          <td style="padding:10px 12px; border-bottom:1px solid #E5E7EB; font-size:13px; color:#374151; text-align:left;">${descriptionLines}</td>
          <td style="padding:10px 12px; border-bottom:1px solid #E5E7EB; font-size:13px; color:#374151; text-align:right;">${escapeHtml(item.quantity)}</td>
          <td style="padding:10px 12px; border-bottom:1px solid #E5E7EB; font-size:13px; color:#374151; text-align:right;">${getCurrencyCode(data.currency)} ${parseNum(item.rate).toFixed(2)}</td>
          <td style="padding:10px 12px; border-bottom:1px solid #E5E7EB; font-size:13px; color:#374151; text-align:right;">${escapeHtml(item.amount)}</td>
        </tr>
      `;
      }).join('');

   const logoData = data.uploadedLogoData || data.logo_data || '';

const logoHtml = logoData
    ? `<img src="${logoData}" alt="Logo" style="max-width:140px; max-height:90px; object-fit:contain; display:block;"/>`
    : '';

      const totalsRow = (label, value, bold) => `
        <div style="display:flex; justify-content:space-between; padding:6px 0; font-size:13px; ${bold ? 'font-weight:700;' : ''} color:#1E2838;">
          <span>${label}</span><span>${value}</span>
        </div>`;

     printInvoice.innerHTML = `
  <div style="
    width:100%;
    box-sizing:border-box;
    padding:38px 42px;
    background:#ffffff;
    color:#111827;
    font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Helvetica,Arial,sans-serif;
    font-size:13px;
    line-height:1.5;
  ">

    <!-- ================= HEADER ================= -->
    <div style="
      display:flex;
      justify-content:space-between;
      align-items:flex-start;
      gap:30px;
      padding-bottom:6px;
      border-bottom:1px solid #E5E7EB;
    ">

      <!-- LOGO / COMPANY -->
      <div style="
        display:flex;
        align-items:center;
        gap:18px;
        min-width:0;
      ">
        <div style="
          width:150px;
          height:78px;
          display:flex;
          align-items:center;
          justify-content:flex-start;
        ">
          ${logoHtml}
        </div>

       
      </div>

      <!-- INVOICE INFO -->
      <div style="
        text-align:right;
        min-width:240px;
      ">
        <div style="
          font-size:11px;
          font-weight:700;
          letter-spacing:0.14em;
          color:#6B7280;
          text-transform:uppercase;
          margin-bottom:4px;
        ">
          Invoice
        </div>

        <div style="
          font-size:30px;
          line-height:1.1;
          font-weight:800;
          color:#111827;
          letter-spacing:-0.02em;
        ">
          #${escapeHtml(data.invoiceNumber || data.poNumber || 'INV-0001')}
        </div>
      </div>
    </div>


    <!-- ================= BILL TO / DATE / DUE / BALANCE ================= -->
    <div style="
      display:flex;
      gap:14px;
      margin:6px 0px 26px 0px;
      align-items:stretch;
    ">

     <!-- BILL TO -->
<div style="
  flex:1 1 0;
  min-width:0;
  box-sizing:border-box;
  padding:15px;
  overflow:hidden;
">
  
<!-- Bill From -->
<div style="
  font-size:12px;
  color:#000;
  line-height:1.55;
">
  ${String(data.billFrom || '').split('\n').map((line, idx) => {
    const content = linkifyText(line);

    return idx === 0
      ? `<div style="font-size:13px; font-weight:700; color:#000;">${content}</div>`
      : `<div style="font-weight:400; color:#000;">${content}</div>`;
  }).join('')}
</div>

  <!-- BILL TO + SHIP TO -->
  <div style="
    display:flex;
    width:100%;
    gap:30px;
    margin-top:20px;
    box-sizing:border-box;
    align-items:flex-start;
  ">

   <!-- BILL TO -->
<div style="
  flex:1 1 0;
  min-width:0;
  box-sizing:border-box;
">
  <div style="
    font-size:12px;
    font-weight:400;
    color:#6B7280;
    margin:0 0 2px 0;
    line-height:1.2;
  ">
    Bill To:
  </div>

  <div style="
    color:#000;
    font-size:12px;
    line-height:1.35;
    white-space:normal;
    overflow-wrap:anywhere;
    word-break:break-word;
    max-width:100%;
    box-sizing:border-box;
  ">
    ${String(data.billTo || '').split('\n').map((line, idx) => {
      const content = escapeHtml(line);

      return idx === 0
        ? `<div style="font-weight:700;">${content}</div>`
        : `<div style="font-weight:400;">${content}</div>`;
    }).join('')}
  </div>
</div>

    <!-- SHIP TO -->
 ${data.shipTo ? `
  <div style="
    flex:1 1 0;
    min-width:0;
    box-sizing:border-box;
  ">
    <div style="
      font-size:12px;
      font-weight:400;
      color:#6B7280;
      margin:0 0 2px 0;
      line-height:1.2;
    ">
      Ship To:
    </div>

    <div style="
      color:#000;
      font-size:12px;
      line-height:1.35;
      white-space:normal;
      overflow-wrap:anywhere;
      word-break:break-word;
      max-width:100%;
      box-sizing:border-box;
    ">
      ${String(data.shipTo || '').split('\n').map((line, idx) => {
        const content = escapeHtml(line);

        return idx === 0
          ? `<div style="font-weight:700;">${content}</div>`
          : `<div style="font-weight:400;">${content}</div>`;
      }).join('')}
    </div>
  </div>
` : ''}

  </div>
</div>

      <!-- DATE / DUE DATE / BALANCE -->
      <div style="
        flex:1 1 0;
        min-width:0;
        padding:17px 0 17px 18px;
      ">
        <table style="width:100%; border-collapse:collapse; font-size:12px;">
          <tr>
            <td style="color:#6B7280; padding:4px 0; text-align:right;">Date:</td>
            <td style="color:#111827; padding:4px 0 4px 14px; text-align:right; width:140px;">
              ${escapeHtml(data.invoiceDate || '')}
            </td>
          </tr>
          <tr>
            <td style="color:#6B7280; padding:4px 0; text-align:right;">Due Date:</td>
            <td style="color:#111827; padding:4px 0 4px 14px; text-align:right;">
              ${escapeHtml(data.dueDate || '')}
            </td>
          </tr>
          ${data.paymentTerms ? `
          <tr>
            <td style="color:#6B7280; padding:4px 0; text-align:right;">Terms:</td>
            <td style="color:#111827; padding:4px 0 4px 14px; text-align:right;">
              ${escapeHtml(data.paymentTerms || '')}
            </td>
          </tr>
          ` : ''}
          ${data.poNumber ? `
          <tr>
            <td style="color:#6B7280; padding:4px 0; text-align:right;">PO:</td>
            <td style="color:#111827; padding:4px 0 4px 14px; text-align:right;">
              ${escapeHtml(data.poNumber || '')}
            </td>
          </tr>
          ` : ''}
          <tr>
            <td colspan="2" style="padding:8px 0 0 0;">
              <div style="
                background:#F3F4F6;
                border-radius:5px;
                padding:8px 12px;
                display:flex;
                justify-content:space-between;
                align-items:center;
              ">
                <span style="color:#6B7280; font-size:12px;">Balance Due:</span>
                <span style="color:#111827; font-size:15px; font-weight:800;">
                  ${escapeHtml(data.balance || '')}
                </span>
              </div>
            </td>
          </tr>
        </table>
      </div>

    </div>


    <!-- ================= ITEMS ================= -->
    <div style="margin-top:8px; overflow:hidden;">

      <table style="
        width:100%;
        border-collapse:collapse;
        margin:0;
      ">

        <thead>
          <tr>
            <th style="
              text-align:left;
              padding:11px 15px;
              background:#1F2937;
              color:#FFFFFF;
              font-size:11px;
              font-weight:700;
              letter-spacing:0.02em;
              border:none;
            ">
              Item
            </th>

            <th style="
              width:90px;
              text-align:right;
              padding:11px 15px;
              background:#1F2937;
              color:#FFFFFF;
              font-size:11px;
              font-weight:700;
              letter-spacing:0.02em;
              border:none;
            ">
              Quantity
            </th>

            <th style="
              width:110px;
              text-align:right;
              padding:11px 15px;
              background:#1F2937;
              color:#FFFFFF;
              font-size:11px;
              font-weight:700;
              letter-spacing:0.02em;
              border:none;
            ">
              Rate
            </th>

            <th style="
              width:120px;
              text-align:right;
              padding:11px 15px;
              background:#1F2937;
              color:#FFFFFF;
              font-size:11px;
              font-weight:700;
              letter-spacing:0.02em;
              border:none;
            ">
              Amount
            </th>
          </tr>
        </thead>

        <tbody>
          ${lineRows}
        </tbody>

      </table>
    </div>


    <!-- ================= TOTALS ================= -->
    <div style="
      display:flex;
      justify-content:flex-end;
      margin-top:16px;
      margin-bottom:30px;
    ">

      <div style="width:280px; padding:6px 4px;">

      ${totalsRow('Subtotal', data.subtotal)}

${
  parseNum(data.discountValue) !== 0
    ? totalsRow(
        `Discount${data.discountType === 'percent' ? ` (${data.discountValue}%)` : ''}`,
        data.discountType === 'percent'
          ? data.discountValue + '%'
          : getCurrencyCode(data.currency) + ' ' + parseNum(data.discountValue).toFixed(2)
      )
    : ''
}

${
  parseNum(data.taxValue) !== 0
    ? totalsRow(
        `Tax${data.taxType === 'percent' ? ` (${data.taxValue}%)` : ''}`,
        data.taxType === 'percent'
          ? data.taxValue + '%'
          : getCurrencyCode(data.currency) + ' ' + parseNum(data.taxValue).toFixed(2)
      )
    : ''
}

${
  parseNum(data.shippingValue) !== 0
    ? totalsRow(
        'Shipping',
        data.shippingType === 'percent'
          ? data.shippingValue + '%'
          : getCurrencyCode(data.currency) + ' ' + parseNum(data.shippingValue).toFixed(2)
      )
    : ''
}

        <div style="border-top:1px solid #D1D5DB; margin:9px 0;"></div>

        <div style="display:flex; justify-content:space-between; align-items:center; padding:4px 0;">
          <span style="font-size:13px; font-weight:800; color:#111827;">Total:</span>
          <span style="font-size:14px; font-weight:800; color:#111827;">
            ${escapeHtml(data.total || '')}
          </span>
        </div>

     ${
  parseNum(data.amountPaid) !== 0
    ? totalsRow(
        'Amount Paid',
        getCurrencyCode(data.currency) + ' ' + parseNum(data.amountPaid).toFixed(2)
      )
    : ''
}

      </div>
    </div>


    <!-- ================= PAYMENT DETAILS / TERMS ================= -->
    <div style="
      margin-top:10px;
      padding-top:22px;
      border-top:1px solid #E5E7EB;
    ">

      <div style="font-size:10px; font-weight:800; letter-spacing:0.1em; color:#6B7280; text-transform:uppercase; margin:18px 0 7px 0;">
        ${escapeHtml(data.notesHeading || 'Payment Details')}
      </div>

      <div style="font-size:11.5px; color:#4B5563; line-height:1.7;">
        ${escapeHtml(data.notes || '').replace(/\n/g, '<br>')}
      </div>

      ${data.terms ? `
      <div style="font-size:10px; font-weight:800; letter-spacing:0.1em; color:#6B7280; text-transform:uppercase; margin:18px 0 7px 0;">
        ${escapeHtml(data.termsHeading || 'Terms')}
      </div>
      <div style="font-size:11px; color:#4B5563; line-height:1.65;">
        ${escapeHtml(data.terms || '').replace(/\n/g, '<br>')}
      </div>
      ` : ''}

    </div>

  </div>
`;
    }

    function renderHistory() {
      const query = historySearchInput?.value?.trim().toLowerCase() || '';
      const filtered = invoiceHistory.map((item, index) => ({ item, index })).filter(entry => {
        const invoiceLabel = (entry.item.invoiceNumber || '').toLowerCase();
        const customer = (entry.item.billTo || '').toLowerCase();
        const date = (entry.item.invoiceDate || '').toLowerCase();
        const dueDate = (entry.item.dueDate || '').toLowerCase();
        const total = (entry.item.total || '').toLowerCase();
        return [invoiceLabel, customer, date, dueDate, total].some(field => field.includes(query));
      });

      historyList.innerHTML = '';
      if (filtered.length === 0) {
        const emptyRow = document.createElement('tr');
        emptyRow.innerHTML = '<td colspan="6" class="px-4 py-5 text-sm text-gray-500 dark:text-dark-muted">No invoices found.</td>';
        historyList.appendChild(emptyRow);
        return;
      }

      filtered.forEach(entry => {
        const item = entry.item;
        const originalIndex = entry.index;
        const row = document.createElement('tr');
        row.className = 'border-b border-gray-200 dark:border-dark-border';
        row.innerHTML = `
          <td class="px-4 py-4"><a href="#/${item.id || ''}" data-index="${originalIndex}" class="history-load text-brand-green hover:underline text-sm text-left">${item.invoiceNumber || 'Invoice'}</a></td>
          <td class="px-4 py-4 text-sm text-gray-700 dark:text-dark-text">${item.billTo || ''}</td>
          <td class="px-4 py-4 text-sm text-gray-700 dark:text-dark-text">${item.invoiceDate || ''}</td>
          <td class="px-4 py-4 text-sm text-gray-700 dark:text-dark-text">${item.dueDate || ''}</td>
          <td class="px-4 py-4 text-sm text-gray-700 dark:text-dark-text">${item.total || ''}</td>
          <td class="px-4 py-4 text-right"><button type="button" data-index="${originalIndex}" class="history-delete text-red-600 hover:underline text-sm">🗑</button></td>
        `;
        historyList.appendChild(row);
      });

      historyList.querySelectorAll('.history-load').forEach(btn => {
        btn.addEventListener('click', (event) => {
          event.preventDefault();
          const idx = Number(event.currentTarget.dataset.index);
          const item = invoiceHistory[idx];
          if (!item) return;
          // navigate to hash URL for this invoice and load it
          location.hash = '#/' + item.id;
          loadInvoiceEntry(item);
          hideHistoryModal();
        });
      });
      historyList.querySelectorAll('.history-delete').forEach(btn => {
        btn.addEventListener('click', (event) => {
          const idx = Number(event.currentTarget.dataset.index);
          invoiceHistory.splice(idx, 1);
          localStorage.setItem('invoiceHistory', JSON.stringify(invoiceHistory));
          renderHistory();
        });
      });
    }

    function showHistoryModal() {
      renderHistory();
      historyModal.classList.remove('hidden');
      historyModal.classList.add('flex');
    }

    historySearchInput?.addEventListener('input', () => renderHistory());
    historyExportBtn?.addEventListener('click', () => {
      const rows = getHistoryExportRows(invoiceHistory);
      downloadCsv(`invoice-history-${new Date().toISOString().slice(0,10)}.csv`, rows);
    });
    historyNewBtn?.addEventListener('click', () => {
      hideHistoryModal();
      window.location.href= 'index.php';
    });
    historySignUpBtn?.addEventListener('click', () => {
      window.location.href = 'signup.php';
    });
    historyClose?.addEventListener('click', hideCloudModeBanner);
    historyEraseBtn?.addEventListener('click', () => {
      if (!confirm('Erase all saved invoices from browser history?')) return;
      invoiceHistory = [];
      localStorage.setItem('invoiceHistory', JSON.stringify(invoiceHistory));
      renderHistory();
    });

        function hideCloudModeBanner() {
      const banner = document.getElementById('cloudModeBanner');
      if (banner) banner.classList.add('hidden');
    }

    function hideHistoryModal() {
      historyModal.classList.add('hidden');
      historyModal.classList.remove('flex');
    }

    // If the URL contains an invoice id in the hash (e.g. #/inv-123), load it on start
    if (location.hash === '#history') {
      showHistoryModal();
    } else if (location.hash && location.hash.replace(/^#\/?/, '')) {
      try { loadInvoiceById(location.hash); } catch (e) { /* ignore */ }
    }
    // React to future hash changes
    window.addEventListener('hashchange', () => {
      if (location.hash === '#history') {
        showHistoryModal();
        return;
      }
      try { loadInvoiceById(location.hash); } catch (e) { }
    });

    navHistoryLink.addEventListener('click', (event) => {
      event.preventDefault();
      showHistoryModal();
    });

    historyClose.addEventListener('click', hideCloudModeBanner);
    historyModal.addEventListener('click', (event) => {
      if (event.target === historyModal) hideHistoryModal();
    });

    function showEmailPrompt() {
      emailPromptModal.classList.remove('hidden');
      emailPromptModal.classList.add('flex');
    }
    function hideEmailPrompt() {
      emailPromptModal.classList.add('hidden');
      emailPromptModal.classList.remove('flex');
    }
    emailPromptClose.addEventListener('click', hideEmailPrompt);
    emailPromptCancel.addEventListener('click', hideEmailPrompt);

    emailPromptSend.addEventListener('click', async () => {
      const email = emailPromptInput.value.trim();
      if (!email) {
        emailPromptInput.classList.add('border-red-500');
        return;
      }
      emailPromptInput.classList.remove('border-red-500');
            if (pendingSendInvoice) {
        if (currentUser) {
          try {
            if (editingInvoiceId) {
              pendingSendInvoice.id = editingInvoiceId;
              await fetch('api/update_invoice.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(pendingSendInvoice)
              });
            } else {
              await fetch('api/save_invoice.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(pendingSendInvoice)
              });
            }
          } catch (e) {
            console.warn('Could not save to your account, saving locally instead.', e);
            saveHistoryEntry(pendingSendInvoice);
          }
        } else {
          saveHistoryEntry(pendingSendInvoice);
        }
        pendingSendInvoice = null;
      }
      emailPromptModal.classList.add('hidden');
      alert(`Invoice send requested to ${email}.`);
    });

    saveSendBtn.addEventListener('click', (event) => {
      event.preventDefault();
      if (!validateInvoiceFields()) return;
      const invoiceData = getInvoiceData();
      pendingSendInvoice = invoiceData;
      emailPromptInput.value = '';
      showEmailPrompt();
      emailPromptInput.focus();
    });

       downloadBtn.addEventListener('click', async (event) => {
    event.preventDefault();

    if (!validateInvoiceFields()) return;

    // IMPORTANT:
    // Recalculate everything before collecting data for the PDF.
    updateTotals();

    // Get the latest values directly from the current form
    const invoiceData = getInvoiceData();



    if (currentUser) {
        try {
            if (editingInvoiceId) {
                invoiceData.id = editingInvoiceId;

                const response = await fetch('api/update_invoice.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(invoiceData)
                });

                const result = await response.json();

                if (!response.ok || !result.success) {
                    console.error('Invoice update failed:', result);
                    alert(result.error || 'Could not update invoice.');
                    return;
                }


            } else {
                const response = await fetch('api/save_invoice.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(invoiceData)
                });

                const result = await response.json();

                if (!response.ok || !result.success) {
                    console.error('Invoice save failed:', result);
                    alert(result.error || 'Could not save invoice.');
                    return;
                }

            }
        } catch (e) {
            console.error('Could not save invoice:', e);
            alert('Could not save invoice. Please try again.');
            return;
        }
    } else {
        saveHistoryEntry(invoiceData);
    }

    // IMPORTANT:
    // Generate PDF using the SAME updated invoiceData
    renderPrintableInvoice(invoiceData);

    const clone = printInvoice.cloneNode(true);
    clone.id = 'printInvoiceClone';

    clone.style.position = 'static';
    clone.style.width = '210mm';
    clone.style.maxWidth = 'none';
    clone.style.opacity = '1';
    clone.style.pointerEvents = 'none';
    clone.style.display = 'block';
    clone.style.background = '#ffffff';

    document.body.appendChild(clone);

    try {
        if (document.fonts && document.fonts.ready) {
            await document.fonts.ready;
        }
    } catch (e) {}

    const imgs = Array.from(clone.querySelectorAll('img'));

    if (imgs.length) {
        await Promise.all(
            imgs.map(img => new Promise(resolve => {
                if (img.complete) {
                    resolve();
                } else {
                    img.onload = resolve;
                    img.onerror = resolve;
                }
            }))
        );
    }

    await new Promise(resolve =>
        requestAnimationFrame(() =>
            requestAnimationFrame(() =>
                setTimeout(resolve, 140)
            )
        )
    );

    try {
        await html2pdf()
            .set({
                margin: 0,
                filename: `${invoiceData.invoiceNumber || 'invoice'}.pdf`,
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    scale: 2,
                    useCORS: true,
                    backgroundColor: '#ffffff',
                    allowTaint: false
                },
                jsPDF: {
                    unit: 'in',
                    format: 'a4',
                    orientation: 'portrait'
                }
            })
            .from(clone)
            .save();

    } catch (err) {
        console.error('PDF generation failed:', err);
        alert('PDF generation failed. Check console for details.');
    }

    if (clone && clone.parentNode) {
    clone.parentNode.removeChild(clone);
}

const invoiceNumber = invoiceData.invoiceNumber || '';

window.location.href = `/thanks.php?Invoice=${encodeURIComponent(invoiceNumber)}`;
});

  

   function setLanguage(lang) {
      selectedLanguage = lang;
      localStorage.setItem('invoicegen-language', lang);
      translatePage(lang);
      renderLanguages();
    }

    function renderLanguages() {
      langGrid.innerHTML = '';
      languages.forEach(lang => {
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.textContent = lang;
        btn.className = lang === selectedLanguage
          ? 'text-left px-3 py-2 rounded-md bg-brand-greenSoft dark:bg-brand-green/20 text-brand-greenDark dark:text-brand-green font-medium'
          : 'text-left px-3 py-2 rounded-md text-gray-700 dark:text-dark-muted hover:bg-gray-100 dark:hover:bg-dark-field transition';
        btn.addEventListener('click', () => {
          setLanguage(lang);
          setTimeout(() => langModal.classList.add('hidden'), 150);
        });
        langGrid.appendChild(btn);
      });
    }
    renderLanguages();
    loadDefaults();
    translatePage(selectedLanguage);
  </script>
  
  
  <script>
      
const editScheduledToggle =
    document.getElementById('editScheduledToggle');

const editScheduledToggleCircle =
    document.getElementById('editScheduledToggleCircle');

const editScheduledLabel =
    document.getElementById('editScheduledLabel');

const scheduleFields =
    document.getElementById('scheduleFields');


if (editScheduledToggle) {

    editScheduledToggle.addEventListener('click', function () {

        const currentValue = this.dataset.scheduled === '1';
        const newValue = !currentValue;

        this.dataset.scheduled = newValue ? '1' : '0';

        if (newValue) {

            // Toggle ON
            this.classList.remove(
                'bg-gray-300',
                'dark:bg-gray-600'
            );

            this.classList.add('bg-[#B12F26]');

            editScheduledToggleCircle.classList.remove(
                'translate-x-1'
            );

            editScheduledToggleCircle.classList.add(
                'translate-x-6'
            );

            editScheduledLabel.textContent = 'Yes';

            // Show frequency + email
            scheduleFields.classList.remove('hidden');

        } else {

            // Toggle OFF
            this.classList.remove('bg-[#B12F26]');

            this.classList.add(
                'bg-gray-300',
                'dark:bg-gray-600'
            );

            editScheduledToggleCircle.classList.remove(
                'translate-x-6'
            );

            editScheduledToggleCircle.classList.add(
                'translate-x-1'
            );

            editScheduledLabel.textContent = 'No';

            // Hide frequency + email
            scheduleFields.classList.add('hidden');

        }

    });

}      
      
  /* =========================================================
   USER DROPDOWN
   ========================================================= */

document.addEventListener('DOMContentLoaded', function () {

    const dropdown = document.querySelector('.dropdown');
    const button = document.querySelector('.dropdown-toggle');
    const menu = document.querySelector('.dropdown-menu');

  

    if (!dropdown || !button || !menu) {
        console.log('❌ Dropdown elements NOT found');
        return;
    }


    // Start closed
    menu.classList.add('hidden');

    // Open / close dropdown
    button.addEventListener('click', function (e) {

        e.preventDefault();
        e.stopPropagation();

        // Close other dropdown menus
        document.querySelectorAll('.dropdown-menu').forEach(function (otherMenu) {
            if (otherMenu !== menu) {
                otherMenu.classList.add('hidden');
            }
        });

        // Toggle current menu
        menu.classList.toggle('hidden');

        console.log(
            'Dropdown visible:',
            !menu.classList.contains('hidden')
        );
    });

    // Close when clicking outside
    document.addEventListener('click', function (e) {

        if (!dropdown.contains(e.target)) {
            menu.classList.add('hidden');
        }

    });

});

function autoResizeDescription(textarea) {
    textarea.style.height = 'auto';
    textarea.style.height = textarea.scrollHeight + 'px';
}

document.addEventListener('input', function (event) {
    if (event.target.classList.contains('lineDescription')) {
        autoResizeDescription(event.target);
    }
});

function resizeAllDescriptions() {
    document.querySelectorAll('.lineDescription').forEach(textarea => {
        autoResizeDescription(textarea);
    });
}

resizeAllDescriptions();
  </script>
<?php require __DIR__ . '/includes/footer.php'; ?>
