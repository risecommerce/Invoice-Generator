<?php

$pageTitle = 'Invoice Guides & Tutorials — How to Create, Schedule & Send Invoices | InvoiceScheduler';

$pageDescription = 'Step-by-step guides on creating invoices, scheduling recurring billing, sending invoices via email, and managing your invoicing workflow with InvoiceScheduler.';

$pageCanonical = 'https://invoicescheduler.com/guides';

$pageOgTitle = $pageTitle;

$pageOgDescription = $pageDescription;

$pageBodyAttributes = ' class="bg-gray-100 dark:bg-dark-bg min-h-screen transition-colors duration-200"';

$pageHeader = 'index';

$pageExtraHead = <<<'HTML'
<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    darkMode: 'class',
    theme: {
      extend: {
        colors: {
          brand: {
            green: '#B12F26',
            greenDark: '#8F241D',
            greenSoft: '#FCE8E6'
          },
          ink: '#1E2838',
          dark: {
            bg: '#0B1220',
            card: '#141D33',
            field: '#1C2740',
            border: '#2A3650',
            text: '#E7EBF3',
            muted: '#8492AC'
          }
        }
      }
    }
  };
</script>
HTML;

$pageJsonLd = <<<'HTML'
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    { "@type": "ListItem", "position": 1, "name": "Home", "item": "https://invoicescheduler.com/" },
    { "@type": "ListItem", "position": 2, "name": "Guides", "item": "https://invoicescheduler.com/guides" }
  ]
}
</script>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "How do I create an invoice with InvoiceScheduler?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Open invoicescheduler.com, fill in your Bill From and Bill To details, add line items, set your invoice and due dates, add notes and terms, choose a theme, then download the invoice as a PDF or send it by email."
      }
    },
    {
      "@type": "Question",
      "name": "How do I add my business logo to an invoice?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Click the Add Your Logo area at the top-left of the invoice form and upload a PNG or JPG image. It will appear on the invoice and every downloaded PDF. A transparent PNG works best."
      }
    },
    {
      "@type": "Question",
      "name": "How do I schedule recurring invoices?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Toggle Is Scheduled? to Yes, choose a frequency such as weekly, monthly, or yearly, enter your customer's email, fill out the rest of the invoice, and click Save & Send. A free Cloud Mode account is required to schedule invoices."
      }
    },
    {
      "@type": "Question",
      "name": "What is Cloud Mode?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Cloud Mode is a free InvoiceScheduler account that automatically saves your invoices online so you can access your invoice history, resend past invoices, and sync across devices."
      }
    },
    {
      "@type": "Question",
      "name": "How do I send an invoice by email?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Complete your invoice, click Save & Send, enter the recipient's email address in the popup, then click Send. The invoice is delivered as a PDF attachment and saved to your history."
      }
    },
    {
      "@type": "Question",
      "name": "How do I customize the appearance of my invoice?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Open Invoice Settings at the bottom of the form, choose a theme such as Classic or State, select your preferred currency, and click Save Default to save your preferences for future invoices."
      }
    }
  ]
}
</script>
HTML;

require __DIR__ . '/includes/meta.php';
require __DIR__ . '/includes/header.php';
?>

<main class="relative min-h-screen overflow-hidden bg-gradient-to-b from-gray-50 via-white to-gray-100 dark:from-[#101827] dark:via-[#0D1626] dark:to-[#09111E]">

  <!-- Decorative background glow -->
  <div class="pointer-events-none absolute left-1/2 top-[-180px] h-[420px] w-[420px] -translate-x-1/2 rounded-full bg-[#B12F26]/[0.06] blur-[80px] dark:bg-[#B12F26]/[0.12]"></div>
  <div class="pointer-events-none absolute -right-40 top-[35%] h-80 w-80 rounded-full bg-[#B12F26]/[0.025] blur-[70px] dark:bg-[#B12F26]/[0.05]"></div>

  <div class="relative z-10 mx-auto max-w-[1120px] px-5 py-10 sm:px-6 sm:py-14 lg:px-8">

    <!-- =====================================================
         HERO
    ====================================================== -->

    <div class="mx-auto mb-10 max-w-3xl text-center sm:mb-12">

      <div class="mb-5 inline-flex items-center gap-2 rounded-full border border-[#B12F26]/15 bg-white/80 px-3.5 py-1.5 text-[10px] font-extrabold uppercase tracking-[0.14em] text-[#8F241D] shadow-sm backdrop-blur dark:border-[#D94A40]/20 dark:bg-[#141D33]/70 dark:text-[#F17B72] sm:text-[11px]">
        <span class="h-1.5 w-1.5 rounded-full bg-[#B12F26] shadow-[0_0_0_4px_rgba(177,47,38,0.07)] dark:bg-[#D94A40]"></span>
        Guides &amp; Tutorials
      </div>

      <h1 class="text-3xl font-extrabold leading-tight tracking-tight text-[#1E2838] dark:text-dark-text sm:text-[42px]">
        InvoiceScheduler Guides &amp; Tutorials
      </h1>

      <p class="mx-auto mt-4 max-w-2xl text-sm leading-7 text-gray-600 dark:text-dark-muted sm:text-[16px]">
        Learn how to make the most of InvoiceScheduler with these step-by-step guides.
        Whether you're creating your first invoice or setting up automated recurring
        billing, we've got you covered.
      </p>

    </div>


    <!-- =====================================================
         GUIDE GRID
    ====================================================== -->

    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 sm:gap-6">

      <!-- GUIDE 01 -->
      <article class="group relative flex h-full flex-col overflow-hidden rounded-2xl border border-gray-200/80 bg-white shadow-[0_4px_14px_rgba(15,23,42,0.035),0_14px_32px_rgba(15,23,42,0.035)] transition-all duration-300 hover:-translate-y-1.5 hover:border-[#B12F26]/25 hover:shadow-[0_10px_24px_rgba(15,23,42,0.07),0_24px_48px_rgba(177,47,38,0.05)] dark:border-dark-border dark:bg-dark-card dark:shadow-[0_5px_14px_rgba(0,0,0,0.18),0_18px_38px_rgba(0,0,0,0.18)] dark:hover:border-[#D65A50]/35 dark:hover:shadow-[0_10px_24px_rgba(0,0,0,0.25),0_24px_50px_rgba(0,0,0,0.28)]">
        <div class="absolute inset-x-0 top-0 h-1 origin-center scale-x-[0.28] bg-gradient-to-r from-[#8F241D] via-[#B12F26] to-[#E06B61] opacity-50 transition-all duration-300 group-hover:scale-x-100 group-hover:opacity-100"></div>
        <div class="flex h-full flex-col p-6 sm:p-7">
          <div class="flex items-start gap-4">
            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl border border-[#B12F26]/10 bg-[#B12F26]/[0.07] text-[#8F241D] shadow-[inset_0_1px_0_rgba(255,255,255,0.9),0_4px_12px_rgba(177,47,38,0.07)] transition-transform duration-300 group-hover:-translate-y-0.5 group-hover:scale-105 dark:border-[#D65A50]/15 dark:bg-[#B12F26]/[0.12] dark:text-[#F17B72]">
              <span class="text-xs font-extrabold tracking-wider">01</span>
            </div>
            <div>
              <h2 class="text-[18px] font-extrabold leading-snug tracking-tight text-[#182233] transition-colors group-hover:text-[#8F241D] dark:text-dark-text dark:group-hover:text-[#F17B72]">
                How to Create an Invoice
              </h2>
              <p class="mt-1.5 text-xs leading-5 text-gray-500 dark:text-dark-muted">
                Create a polished invoice from start to finish.
              </p>
            </div>
          </div>

          <div class="my-5 h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent transition-colors group-hover:via-[#B12F26]/20 dark:via-dark-border dark:group-hover:via-[#D65A50]/20"></div>

          <ol class="space-y-3">
            <li class="relative pl-9 text-[13px] leading-6 text-gray-600 transition-transform duration-200 hover:translate-x-0.5 hover:text-gray-800 dark:text-[#A2ADBF] dark:hover:text-[#D4DAE4]">
              <span class="absolute left-0 top-0.5 flex h-6 w-6 items-center justify-center rounded-lg border border-[#E7D5D2] bg-[#FAFAFA] text-[10px] font-extrabold text-[#8F241D] shadow-sm dark:border-[#D65A50]/20 dark:bg-[#B12F26]/[0.08] dark:text-[#F17B72]">1</span>
              Open <a href="/" class="font-semibold text-[#8F241D] underline-offset-4 hover:underline dark:text-[#F17B72]">invoicescheduler.com</a> in your browser.
            </li>
            <li class="relative pl-9 text-[13px] leading-6 text-gray-600 transition-transform duration-200 hover:translate-x-0.5 hover:text-gray-800 dark:text-[#A2ADBF] dark:hover:text-[#D4DAE4]"><span class="absolute left-0 top-0.5 flex h-6 w-6 items-center justify-center rounded-lg border border-[#E7D5D2] bg-[#FAFAFA] text-[10px] font-extrabold text-[#8F241D] dark:border-[#D65A50]/20 dark:bg-[#B12F26]/[0.08] dark:text-[#F17B72]">2</span>Fill in "Bill From" with your business name, address, and email.</li>
            <li class="relative pl-9 text-[13px] leading-6 text-gray-600 transition-transform duration-200 hover:translate-x-0.5 hover:text-gray-800 dark:text-[#A2ADBF] dark:hover:text-[#D4DAE4]"><span class="absolute left-0 top-0.5 flex h-6 w-6 items-center justify-center rounded-lg border border-[#E7D5D2] bg-[#FAFAFA] text-[10px] font-extrabold text-[#8F241D] dark:border-[#D65A50]/20 dark:bg-[#B12F26]/[0.08] dark:text-[#F17B72]">3</span>Fill in "Bill To" with your client's name, address, and email.</li>
            <li class="relative pl-9 text-[13px] leading-6 text-gray-600 transition-transform duration-200 hover:translate-x-0.5 hover:text-gray-800 dark:text-[#A2ADBF] dark:hover:text-[#D4DAE4]"><span class="absolute left-0 top-0.5 flex h-6 w-6 items-center justify-center rounded-lg border border-[#E7D5D2] bg-[#FAFAFA] text-[10px] font-extrabold text-[#8F241D] dark:border-[#D65A50]/20 dark:bg-[#B12F26]/[0.08] dark:text-[#F17B72]">4</span>Add line items with a description, quantity, and rate for each product or service.</li>
            <li class="relative pl-9 text-[13px] leading-6 text-gray-600 transition-transform duration-200 hover:translate-x-0.5 hover:text-gray-800 dark:text-[#A2ADBF] dark:hover:text-[#D4DAE4]"><span class="absolute left-0 top-0.5 flex h-6 w-6 items-center justify-center rounded-lg border border-[#E7D5D2] bg-[#FAFAFA] text-[10px] font-extrabold text-[#8F241D] dark:border-[#D65A50]/20 dark:bg-[#B12F26]/[0.08] dark:text-[#F17B72]">5</span>Set the invoice date, due date, payment terms, and PO number.</li>
            <li class="relative pl-9 text-[13px] leading-6 text-gray-600 transition-transform duration-200 hover:translate-x-0.5 hover:text-gray-800 dark:text-[#A2ADBF] dark:hover:text-[#D4DAE4]"><span class="absolute left-0 top-0.5 flex h-6 w-6 items-center justify-center rounded-lg border border-[#E7D5D2] bg-[#FAFAFA] text-[10px] font-extrabold text-[#8F241D] dark:border-[#D65A50]/20 dark:bg-[#B12F26]/[0.08] dark:text-[#F17B72]">6</span>Add any notes and terms your client should know about.</li>
            <li class="relative pl-9 text-[13px] leading-6 text-gray-600 transition-transform duration-200 hover:translate-x-0.5 hover:text-gray-800 dark:text-[#A2ADBF] dark:hover:text-[#D4DAE4]"><span class="absolute left-0 top-0.5 flex h-6 w-6 items-center justify-center rounded-lg border border-[#E7D5D2] bg-[#FAFAFA] text-[10px] font-extrabold text-[#8F241D] dark:border-[#D65A50]/20 dark:bg-[#B12F26]/[0.08] dark:text-[#F17B72]">7</span>Choose a theme and color to match your brand.</li>
            <li class="relative pl-9 text-[13px] leading-6 text-gray-600 transition-transform duration-200 hover:translate-x-0.5 hover:text-gray-800 dark:text-[#A2ADBF] dark:hover:text-[#D4DAE4]"><span class="absolute left-0 top-0.5 flex h-6 w-6 items-center justify-center rounded-lg border border-[#E7D5D2] bg-[#FAFAFA] text-[10px] font-extrabold text-[#8F241D] dark:border-[#D65A50]/20 dark:bg-[#B12F26]/[0.08] dark:text-[#F17B72]">8</span>Download the invoice as a PDF or send it directly via email.</li>
          </ol>
        </div>
      </article>

      <!-- GUIDE 02 -->
      <article class="group relative flex h-full flex-col overflow-hidden rounded-2xl border border-gray-200/80 bg-white shadow-[0_4px_14px_rgba(15,23,42,0.035),0_14px_32px_rgba(15,23,42,0.035)] transition-all duration-300 hover:-translate-y-1.5 hover:border-[#B12F26]/25 hover:shadow-[0_10px_24px_rgba(15,23,42,0.07),0_24px_48px_rgba(177,47,38,0.05)] dark:border-dark-border dark:bg-dark-card dark:shadow-[0_5px_14px_rgba(0,0,0,0.18),0_18px_38px_rgba(0,0,0,0.18)] dark:hover:border-[#D65A50]/35">
        <div class="absolute inset-x-0 top-0 h-1 origin-center scale-x-[0.28] bg-gradient-to-r from-[#8F241D] via-[#B12F26] to-[#E06B61] opacity-50 transition-all duration-300 group-hover:scale-x-100 group-hover:opacity-100"></div>
        <div class="flex h-full flex-col p-6 sm:p-7">
          <div class="flex items-start gap-4"><div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl border border-[#B12F26]/10 bg-[#B12F26]/[0.07] text-[#8F241D] shadow-sm transition-transform duration-300 group-hover:-translate-y-0.5 group-hover:scale-105 dark:border-[#D65A50]/15 dark:bg-[#B12F26]/[0.12] dark:text-[#F17B72]"><span class="text-xs font-extrabold tracking-wider">02</span></div><div><h2 class="text-[18px] font-extrabold leading-snug tracking-tight text-[#182233] transition-colors group-hover:text-[#8F241D] dark:text-dark-text dark:group-hover:text-[#F17B72]">How to Add Your Business Logo</h2><p class="mt-1.5 text-xs leading-5 text-gray-500 dark:text-dark-muted">Give every invoice a consistent branded look.</p></div></div>
          <div class="my-5 h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent transition-colors group-hover:via-[#B12F26]/20 dark:via-dark-border dark:group-hover:via-[#D65A50]/20"></div>
          <ol class="space-y-3">
            <li class="relative pl-9 text-[13px] leading-6 text-gray-600 dark:text-[#A2ADBF]"><span class="absolute left-0 top-0.5 flex h-6 w-6 items-center justify-center rounded-lg border border-[#E7D5D2] bg-[#FAFAFA] text-[10px] font-extrabold text-[#8F241D] dark:border-[#D65A50]/20 dark:bg-[#B12F26]/[0.08] dark:text-[#F17B72]">1</span>Click the "Add Your Logo" area at the top-left of the invoice.</li>
            <li class="relative pl-9 text-[13px] leading-6 text-gray-600 dark:text-[#A2ADBF]"><span class="absolute left-0 top-0.5 flex h-6 w-6 items-center justify-center rounded-lg border border-[#E7D5D2] bg-[#FAFAFA] text-[10px] font-extrabold text-[#8F241D] dark:border-[#D65A50]/20 dark:bg-[#B12F26]/[0.08] dark:text-[#F17B72]">2</span>Upload your logo image (PNG or JPG recommended).</li>
            <li class="relative pl-9 text-[13px] leading-6 text-gray-600 dark:text-[#A2ADBF]"><span class="absolute left-0 top-0.5 flex h-6 w-6 items-center justify-center rounded-lg border border-[#E7D5D2] bg-[#FAFAFA] text-[10px] font-extrabold text-[#8F241D] dark:border-[#D65A50]/20 dark:bg-[#B12F26]/[0.08] dark:text-[#F17B72]">3</span>Your logo will appear on the invoice and on all downloaded PDFs.</li>
            <li class="relative pl-9 text-[13px] leading-6 text-gray-600 dark:text-[#A2ADBF]"><span class="absolute left-0 top-0.5 flex h-6 w-6 items-center justify-center rounded-lg border border-[#E7D5D2] bg-[#FAFAFA] text-[10px] font-extrabold text-[#8F241D] dark:border-[#D65A50]/20 dark:bg-[#B12F26]/[0.08] dark:text-[#F17B72]">4</span>Tip: use a transparent PNG for the best-looking result.</li>
          </ol>
        </div>
      </article>

      <!-- GUIDE 03 -->
      <article class="group relative flex h-full flex-col overflow-hidden rounded-2xl border border-gray-200/80 bg-white shadow-[0_4px_14px_rgba(15,23,42,0.035),0_14px_32px_rgba(15,23,42,0.035)] transition-all duration-300 hover:-translate-y-1.5 hover:border-[#B12F26]/25 hover:shadow-[0_10px_24px_rgba(15,23,42,0.07),0_24px_48px_rgba(177,47,38,0.05)] dark:border-dark-border dark:bg-dark-card dark:shadow-[0_5px_14px_rgba(0,0,0,0.18),0_18px_38px_rgba(0,0,0,0.18)] dark:hover:border-[#D65A50]/35">
        <div class="absolute inset-x-0 top-0 h-1 origin-center scale-x-[0.28] bg-gradient-to-r from-[#8F241D] via-[#B12F26] to-[#E06B61] opacity-50 transition-all duration-300 group-hover:scale-x-100 group-hover:opacity-100"></div>
        <div class="flex h-full flex-col p-6 sm:p-7">
          <div class="flex items-start gap-4"><div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl border border-[#B12F26]/10 bg-[#B12F26]/[0.07] text-[#8F241D] shadow-sm transition-transform duration-300 group-hover:-translate-y-0.5 group-hover:scale-105 dark:border-[#D65A50]/15 dark:bg-[#B12F26]/[0.12] dark:text-[#F17B72]"><span class="text-xs font-extrabold tracking-wider">03</span></div><div><h2 class="text-[18px] font-extrabold leading-snug tracking-tight text-[#182233] transition-colors group-hover:text-[#8F241D] dark:text-dark-text dark:group-hover:text-[#F17B72]">How to Schedule Recurring Invoices</h2><p class="mt-1.5 text-xs leading-5 text-gray-500 dark:text-dark-muted">Automate recurring billing with your preferred frequency.</p></div></div>
          <div class="my-5 h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent dark:via-dark-border"></div>
          <ol class="space-y-3">
            <li class="relative pl-9 text-[13px] leading-6 text-gray-600 dark:text-[#A2ADBF]"><span class="absolute left-0 top-0.5 flex h-6 w-6 items-center justify-center rounded-lg border border-[#E7D5D2] bg-[#FAFAFA] text-[10px] font-extrabold text-[#8F241D] dark:border-[#D65A50]/20 dark:bg-[#B12F26]/[0.08] dark:text-[#F17B72]">1</span>Toggle "Is Scheduled?" to Yes on the invoice form.</li>
            <li class="relative pl-9 text-[13px] leading-6 text-gray-600 dark:text-[#A2ADBF]"><span class="absolute left-0 top-0.5 flex h-6 w-6 items-center justify-center rounded-lg border border-[#E7D5D2] bg-[#FAFAFA] text-[10px] font-extrabold text-[#8F241D] dark:border-[#D65A50]/20 dark:bg-[#B12F26]/[0.08] dark:text-[#F17B72]">2</span>Select a frequency: Weekly, Bi-Weekly, Monthly, Bi-Monthly, Quarterly, Tri-Yearly, Half-Yearly, or Yearly.</li>
            <li class="relative pl-9 text-[13px] leading-6 text-gray-600 dark:text-[#A2ADBF]"><span class="absolute left-0 top-0.5 flex h-6 w-6 items-center justify-center rounded-lg border border-[#E7D5D2] bg-[#FAFAFA] text-[10px] font-extrabold text-[#8F241D] dark:border-[#D65A50]/20 dark:bg-[#B12F26]/[0.08] dark:text-[#F17B72]">3</span>Enter the customer's email address.</li>
            <li class="relative pl-9 text-[13px] leading-6 text-gray-600 dark:text-[#A2ADBF]"><span class="absolute left-0 top-0.5 flex h-6 w-6 items-center justify-center rounded-lg border border-[#E7D5D2] bg-[#FAFAFA] text-[10px] font-extrabold text-[#8F241D] dark:border-[#D65A50]/20 dark:bg-[#B12F26]/[0.08] dark:text-[#F17B72]">4</span>Fill out the rest of the invoice as usual.</li>
            <li class="relative pl-9 text-[13px] leading-6 text-gray-600 dark:text-[#A2ADBF]"><span class="absolute left-0 top-0.5 flex h-6 w-6 items-center justify-center rounded-lg border border-[#E7D5D2] bg-[#FAFAFA] text-[10px] font-extrabold text-[#8F241D] dark:border-[#D65A50]/20 dark:bg-[#B12F26]/[0.08] dark:text-[#F17B72]">5</span>Click "Save &amp; Send" — the invoice will be sent on schedule automatically.</li>
            <li class="relative pl-9 text-[13px] leading-6 text-gray-600 dark:text-[#A2ADBF]"><span class="absolute left-0 top-0.5 flex h-6 w-6 items-center justify-center rounded-lg border border-[#E7D5D2] bg-[#FAFAFA] text-[10px] font-extrabold text-[#8F241D] dark:border-[#D65A50]/20 dark:bg-[#B12F26]/[0.08] dark:text-[#F17B72]">6</span>Note: Cloud Mode (a free account) is required for scheduling.</li>
          </ol>
        </div>
      </article>

      <!-- GUIDE 04 -->
      <article class="group relative flex h-full flex-col overflow-hidden rounded-2xl border border-gray-200/80 bg-white shadow-[0_4px_14px_rgba(15,23,42,0.035),0_14px_32px_rgba(15,23,42,0.035)] transition-all duration-300 hover:-translate-y-1.5 hover:border-[#B12F26]/25 hover:shadow-[0_10px_24px_rgba(15,23,42,0.07),0_24px_48px_rgba(177,47,38,0.05)] dark:border-dark-border dark:bg-dark-card dark:shadow-[0_5px_14px_rgba(0,0,0,0.18),0_18px_38px_rgba(0,0,0,0.18)] dark:hover:border-[#D65A50]/35">
        <div class="absolute inset-x-0 top-0 h-1 origin-center scale-x-[0.28] bg-gradient-to-r from-[#8F241D] via-[#B12F26] to-[#E06B61] opacity-50 transition-all duration-300 group-hover:scale-x-100 group-hover:opacity-100"></div>
        <div class="flex h-full flex-col p-6 sm:p-7">
          <div class="flex items-start gap-4"><div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl border border-[#B12F26]/10 bg-[#B12F26]/[0.07] text-[#8F241D] shadow-sm transition-transform duration-300 group-hover:-translate-y-0.5 group-hover:scale-105 dark:border-[#D65A50]/15 dark:bg-[#B12F26]/[0.12] dark:text-[#F17B72]"><span class="text-xs font-extrabold tracking-wider">04</span></div><div><h2 class="text-[18px] font-extrabold leading-snug tracking-tight text-[#182233] transition-colors group-hover:text-[#8F241D] dark:text-dark-text dark:group-hover:text-[#F17B72]">How to Use Cloud Mode</h2><p class="mt-1.5 text-xs leading-5 text-gray-500 dark:text-dark-muted">Keep your invoice history available across devices.</p></div></div>
          <div class="my-5 h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent dark:via-dark-border"></div>
          <ol class="space-y-3">
            <li class="relative pl-9 text-[13px] leading-6 text-gray-600 dark:text-[#A2ADBF]"><span class="absolute left-0 top-0.5 flex h-6 w-6 items-center justify-center rounded-lg border border-[#E7D5D2] bg-[#FAFAFA] text-[10px] font-extrabold text-[#8F241D] dark:border-[#D65A50]/20 dark:bg-[#B12F26]/[0.08] dark:text-[#F17B72]">1</span>Click "Sign Up" to create a free InvoiceScheduler account.</li>
            <li class="relative pl-9 text-[13px] leading-6 text-gray-600 dark:text-[#A2ADBF]"><span class="absolute left-0 top-0.5 flex h-6 w-6 items-center justify-center rounded-lg border border-[#E7D5D2] bg-[#FAFAFA] text-[10px] font-extrabold text-[#8F241D] dark:border-[#D65A50]/20 dark:bg-[#B12F26]/[0.08] dark:text-[#F17B72]">2</span>Once signed in, your invoices are automatically saved to the cloud.</li>
            <li class="relative pl-9 text-[13px] leading-6 text-gray-600 dark:text-[#A2ADBF]"><span class="absolute left-0 top-0.5 flex h-6 w-6 items-center justify-center rounded-lg border border-[#E7D5D2] bg-[#FAFAFA] text-[10px] font-extrabold text-[#8F241D] dark:border-[#D65A50]/20 dark:bg-[#B12F26]/[0.08] dark:text-[#F17B72]">3</span>Access your invoice history from the "History" tab.</li>
            <li class="relative pl-9 text-[13px] leading-6 text-gray-600 dark:text-[#A2ADBF]"><span class="absolute left-0 top-0.5 flex h-6 w-6 items-center justify-center rounded-lg border border-[#E7D5D2] bg-[#FAFAFA] text-[10px] font-extrabold text-[#8F241D] dark:border-[#D65A50]/20 dark:bg-[#B12F26]/[0.08] dark:text-[#F17B72]">4</span>View, re-download, or resend any past invoice.</li>
            <li class="relative pl-9 text-[13px] leading-6 text-gray-600 dark:text-[#A2ADBF]"><span class="absolute left-0 top-0.5 flex h-6 w-6 items-center justify-center rounded-lg border border-[#E7D5D2] bg-[#FAFAFA] text-[10px] font-extrabold text-[#8F241D] dark:border-[#D65A50]/20 dark:bg-[#B12F26]/[0.08] dark:text-[#F17B72]">5</span>Your data is synced across devices.</li>
          </ol>
        </div>
      </article>

      <!-- GUIDE 05 -->
      <article class="group relative flex h-full flex-col overflow-hidden rounded-2xl border border-gray-200/80 bg-white shadow-[0_4px_14px_rgba(15,23,42,0.035),0_14px_32px_rgba(15,23,42,0.035)] transition-all duration-300 hover:-translate-y-1.5 hover:border-[#B12F26]/25 hover:shadow-[0_10px_24px_rgba(15,23,42,0.07),0_24px_48px_rgba(177,47,38,0.05)] dark:border-dark-border dark:bg-dark-card dark:shadow-[0_5px_14px_rgba(0,0,0,0.18),0_18px_38px_rgba(0,0,0,0.18)] dark:hover:border-[#D65A50]/35">
        <div class="absolute inset-x-0 top-0 h-1 origin-center scale-x-[0.28] bg-gradient-to-r from-[#8F241D] via-[#B12F26] to-[#E06B61] opacity-50 transition-all duration-300 group-hover:scale-x-100 group-hover:opacity-100"></div>
        <div class="flex h-full flex-col p-6 sm:p-7">
          <div class="flex items-start gap-4"><div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl border border-[#B12F26]/10 bg-[#B12F26]/[0.07] text-[#8F241D] shadow-sm transition-transform duration-300 group-hover:-translate-y-0.5 group-hover:scale-105 dark:border-[#D65A50]/15 dark:bg-[#B12F26]/[0.12] dark:text-[#F17B72]"><span class="text-xs font-extrabold tracking-wider">05</span></div><div><h2 class="text-[18px] font-extrabold leading-snug tracking-tight text-[#182233] transition-colors group-hover:text-[#8F241D] dark:text-dark-text dark:group-hover:text-[#F17B72]">How to Send an Invoice by Email</h2><p class="mt-1.5 text-xs leading-5 text-gray-500 dark:text-dark-muted">Send invoices directly to your customers as PDF attachments.</p></div></div>
          <div class="my-5 h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent dark:via-dark-border"></div>
          <ol class="space-y-3">
            <li class="relative pl-9 text-[13px] leading-6 text-gray-600 dark:text-[#A2ADBF]"><span class="absolute left-0 top-0.5 flex h-6 w-6 items-center justify-center rounded-lg border border-[#E7D5D2] bg-[#FAFAFA] text-[10px] font-extrabold text-[#8F241D] dark:border-[#D65A50]/20 dark:bg-[#B12F26]/[0.08] dark:text-[#F17B72]">1</span>Complete your invoice.</li>
            <li class="relative pl-9 text-[13px] leading-6 text-gray-600 dark:text-[#A2ADBF]"><span class="absolute left-0 top-0.5 flex h-6 w-6 items-center justify-center rounded-lg border border-[#E7D5D2] bg-[#FAFAFA] text-[10px] font-extrabold text-[#8F241D] dark:border-[#D65A50]/20 dark:bg-[#B12F26]/[0.08] dark:text-[#F17B72]">2</span>Click "Save &amp; Send".</li>
            <li class="relative pl-9 text-[13px] leading-6 text-gray-600 dark:text-[#A2ADBF]"><span class="absolute left-0 top-0.5 flex h-6 w-6 items-center justify-center rounded-lg border border-[#E7D5D2] bg-[#FAFAFA] text-[10px] font-extrabold text-[#8F241D] dark:border-[#D65A50]/20 dark:bg-[#B12F26]/[0.08] dark:text-[#F17B72]">3</span>Enter the recipient's email address in the popup.</li>
            <li class="relative pl-9 text-[13px] leading-6 text-gray-600 dark:text-[#A2ADBF]"><span class="absolute left-0 top-0.5 flex h-6 w-6 items-center justify-center rounded-lg border border-[#E7D5D2] bg-[#FAFAFA] text-[10px] font-extrabold text-[#8F241D] dark:border-[#D65A50]/20 dark:bg-[#B12F26]/[0.08] dark:text-[#F17B72]">4</span>Click "Send" — the invoice is delivered as a PDF attachment.</li>
            <li class="relative pl-9 text-[13px] leading-6 text-gray-600 dark:text-[#A2ADBF]"><span class="absolute left-0 top-0.5 flex h-6 w-6 items-center justify-center rounded-lg border border-[#E7D5D2] bg-[#FAFAFA] text-[10px] font-extrabold text-[#8F241D] dark:border-[#D65A50]/20 dark:bg-[#B12F26]/[0.08] dark:text-[#F17B72]">5</span>The invoice is also saved in your history.</li>
          </ol>
        </div>
      </article>

      <!-- GUIDE 06 -->
      <article class="group relative flex h-full flex-col overflow-hidden rounded-2xl border border-gray-200/80 bg-white shadow-[0_4px_14px_rgba(15,23,42,0.035),0_14px_32px_rgba(15,23,42,0.035)] transition-all duration-300 hover:-translate-y-1.5 hover:border-[#B12F26]/25 hover:shadow-[0_10px_24px_rgba(15,23,42,0.07),0_24px_48px_rgba(177,47,38,0.05)] dark:border-dark-border dark:bg-dark-card dark:shadow-[0_5px_14px_rgba(0,0,0,0.18),0_18px_38px_rgba(0,0,0,0.18)] dark:hover:border-[#D65A50]/35">
        <div class="absolute inset-x-0 top-0 h-1 origin-center scale-x-[0.28] bg-gradient-to-r from-[#8F241D] via-[#B12F26] to-[#E06B61] opacity-50 transition-all duration-300 group-hover:scale-x-100 group-hover:opacity-100"></div>
        <div class="flex h-full flex-col p-6 sm:p-7">
          <div class="flex items-start gap-4"><div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl border border-[#B12F26]/10 bg-[#B12F26]/[0.07] text-[#8F241D] shadow-sm transition-transform duration-300 group-hover:-translate-y-0.5 group-hover:scale-105 dark:border-[#D65A50]/15 dark:bg-[#B12F26]/[0.12] dark:text-[#F17B72]"><span class="text-xs font-extrabold tracking-wider">06</span></div><div><h2 class="text-[18px] font-extrabold leading-snug tracking-tight text-[#182233] transition-colors group-hover:text-[#8F241D] dark:text-dark-text dark:group-hover:text-[#F17B72]">How to Customize Invoice Appearance</h2><p class="mt-1.5 text-xs leading-5 text-gray-500 dark:text-dark-muted">Set your preferred theme and currency for future invoices.</p></div></div>
          <div class="my-5 h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent dark:via-dark-border"></div>
          <ol class="space-y-3">
            <li class="relative pl-9 text-[13px] leading-6 text-gray-600 dark:text-[#A2ADBF]"><span class="absolute left-0 top-0.5 flex h-6 w-6 items-center justify-center rounded-lg border border-[#E7D5D2] bg-[#FAFAFA] text-[10px] font-extrabold text-[#8F241D] dark:border-[#D65A50]/20 dark:bg-[#B12F26]/[0.08] dark:text-[#F17B72]">1</span>Click "Invoice Settings" at the bottom of the form.</li>
            <li class="relative pl-9 text-[13px] leading-6 text-gray-600 dark:text-[#A2ADBF]"><span class="absolute left-0 top-0.5 flex h-6 w-6 items-center justify-center rounded-lg border border-[#E7D5D2] bg-[#FAFAFA] text-[10px] font-extrabold text-[#8F241D] dark:border-[#D65A50]/20 dark:bg-[#B12F26]/[0.08] dark:text-[#F17B72]">2</span>Choose a theme (Classic, State, etc.).</li>
            <li class="relative pl-9 text-[13px] leading-6 text-gray-600 dark:text-[#A2ADBF]"><span class="absolute left-0 top-0.5 flex h-6 w-6 items-center justify-center rounded-lg border border-[#E7D5D2] bg-[#FAFAFA] text-[10px] font-extrabold text-[#8F241D] dark:border-[#D65A50]/20 dark:bg-[#B12F26]/[0.08] dark:text-[#F17B72]">3</span>Select your preferred currency.</li>
            <li class="relative pl-9 text-[13px] leading-6 text-gray-600 dark:text-[#A2ADBF]"><span class="absolute left-0 top-0.5 flex h-6 w-6 items-center justify-center rounded-lg border border-[#E7D5D2] bg-[#FAFAFA] text-[10px] font-extrabold text-[#8F241D] dark:border-[#D65A50]/20 dark:bg-[#B12F26]/[0.08] dark:text-[#F17B72]">4</span>Click "Save Default" to save your preferences for future invoices.</li>
          </ol>
        </div>
      </article>

      <!-- GUIDE 07 -->
      <article class="group relative flex h-full flex-col overflow-hidden rounded-2xl border border-gray-200/80 bg-white shadow-[0_4px_14px_rgba(15,23,42,0.035),0_14px_32px_rgba(15,23,42,0.035)] transition-all duration-300 hover:-translate-y-1.5 hover:border-[#B12F26]/25 hover:shadow-[0_10px_24px_rgba(15,23,42,0.07),0_24px_48px_rgba(177,47,38,0.05)] dark:border-dark-border dark:bg-dark-card dark:shadow-[0_5px_14px_rgba(0,0,0,0.18),0_18px_38px_rgba(0,0,0,0.18)] dark:hover:border-[#D65A50]/35 sm:col-span-2">
        <div class="absolute inset-x-0 top-0 h-1 origin-center scale-x-[0.28] bg-gradient-to-r from-[#8F241D] via-[#B12F26] to-[#E06B61] opacity-50 transition-all duration-300 group-hover:scale-x-100 group-hover:opacity-100"></div>
        <div class="flex h-full flex-col p-6 sm:p-7 lg:p-8">
          <div class="flex items-start gap-4"><div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl border border-[#B12F26]/10 bg-[#B12F26]/[0.07] text-[#8F241D] shadow-sm transition-transform duration-300 group-hover:-translate-y-0.5 group-hover:scale-105 dark:border-[#D65A50]/15 dark:bg-[#B12F26]/[0.12] dark:text-[#F17B72]"><span class="text-xs font-extrabold tracking-wider">07</span></div><div><h2 class="text-[18px] font-extrabold leading-snug tracking-tight text-[#182233] transition-colors group-hover:text-[#8F241D] dark:text-dark-text dark:group-hover:text-[#F17B72]">Tips for Professional Invoicing</h2><p class="mt-1.5 text-xs leading-5 text-gray-500 dark:text-dark-muted">Simple practices that help keep your invoicing organized.</p></div></div>
          <div class="my-5 h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent dark:via-dark-border"></div>
          <ul class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <li class="group/tip flex items-start gap-3 rounded-xl border border-gray-100 bg-gray-50/70 px-4 py-3 text-[13px] leading-6 text-gray-600 transition-all duration-200 hover:-translate-y-0.5 hover:border-[#B12F26]/15 hover:bg-white hover:shadow-sm dark:border-dark-border dark:bg-[#0F1828]/60 dark:text-[#A2ADBF] dark:hover:border-[#D65A50]/20 dark:hover:bg-[#B12F26]/[0.05]"><span class="mt-1 flex h-5 w-5 shrink-0 items-center justify-center rounded-md bg-[#FCE8E6] text-[10px] font-black text-[#B12F26] dark:bg-[#B12F26]/[0.14] dark:text-[#F17B72]">✓</span>Always include clear payment terms and due dates.</li>
            <li class="group/tip flex items-start gap-3 rounded-xl border border-gray-100 bg-gray-50/70 px-4 py-3 text-[13px] leading-6 text-gray-600 transition-all duration-200 hover:-translate-y-0.5 hover:border-[#B12F26]/15 hover:bg-white hover:shadow-sm dark:border-dark-border dark:bg-[#0F1828]/60 dark:text-[#A2ADBF] dark:hover:border-[#D65A50]/20 dark:hover:bg-[#B12F26]/[0.05]"><span class="mt-1 flex h-5 w-5 shrink-0 items-center justify-center rounded-md bg-[#FCE8E6] text-[10px] font-black text-[#B12F26] dark:bg-[#B12F26]/[0.14] dark:text-[#F17B72]">✓</span>Use a professional logo and consistent branding.</li>
            <li class="group/tip flex items-start gap-3 rounded-xl border border-gray-100 bg-gray-50/70 px-4 py-3 text-[13px] leading-6 text-gray-600 transition-all duration-200 hover:-translate-y-0.5 hover:border-[#B12F26]/15 hover:bg-white hover:shadow-sm dark:border-dark-border dark:bg-[#0F1828]/60 dark:text-[#A2ADBF] dark:hover:border-[#D65A50]/20 dark:hover:bg-[#B12F26]/[0.05]"><span class="mt-1 flex h-5 w-5 shrink-0 items-center justify-center rounded-md bg-[#FCE8E6] text-[10px] font-black text-[#B12F26] dark:bg-[#B12F26]/[0.14] dark:text-[#F17B72]">✓</span>Number your invoices sequentially for easy tracking.</li>
            <li class="group/tip flex items-start gap-3 rounded-xl border border-gray-100 bg-gray-50/70 px-4 py-3 text-[13px] leading-6 text-gray-600 transition-all duration-200 hover:-translate-y-0.5 hover:border-[#B12F26]/15 hover:bg-white hover:shadow-sm dark:border-dark-border dark:bg-[#0F1828]/60 dark:text-[#A2ADBF] dark:hover:border-[#D65A50]/20 dark:hover:bg-[#B12F26]/[0.05]"><span class="mt-1 flex h-5 w-5 shrink-0 items-center justify-center rounded-md bg-[#FCE8E6] text-[10px] font-black text-[#B12F26] dark:bg-[#B12F26]/[0.14] dark:text-[#F17B72]">✓</span>Include clear item descriptions so clients know what they're paying for.</li>
            <li class="group/tip flex items-start gap-3 rounded-xl border border-gray-100 bg-gray-50/70 px-4 py-3 text-[13px] leading-6 text-gray-600 transition-all duration-200 hover:-translate-y-0.5 hover:border-[#B12F26]/15 hover:bg-white hover:shadow-sm dark:border-dark-border dark:bg-[#0F1828]/60 dark:text-[#A2ADBF] dark:hover:border-[#D65A50]/20 dark:hover:bg-[#B12F26]/[0.05]"><span class="mt-1 flex h-5 w-5 shrink-0 items-center justify-center rounded-md bg-[#FCE8E6] text-[10px] font-black text-[#B12F26] dark:bg-[#B12F26]/[0.14] dark:text-[#F17B72]">✓</span>Follow up on overdue invoices promptly.</li>
            <li class="group/tip flex items-start gap-3 rounded-xl border border-gray-100 bg-gray-50/70 px-4 py-3 text-[13px] leading-6 text-gray-600 transition-all duration-200 hover:-translate-y-0.5 hover:border-[#B12F26]/15 hover:bg-white hover:shadow-sm dark:border-dark-border dark:bg-[#0F1828]/60 dark:text-[#A2ADBF] dark:hover:border-[#D65A50]/20 dark:hover:bg-[#B12F26]/[0.05]"><span class="mt-1 flex h-5 w-5 shrink-0 items-center justify-center rounded-md bg-[#FCE8E6] text-[10px] font-black text-[#B12F26] dark:bg-[#B12F26]/[0.14] dark:text-[#F17B72]">✓</span>Keep records — use Cloud Mode to maintain a complete invoice history.</li>
          </ul>
        </div>
      </article>

    </div>


    <!-- =====================================================
         BOTTOM MESSAGE
    ====================================================== -->

    <div class="pt-9 text-center sm:pt-11">
      <div class="inline-flex items-center gap-2 rounded-full border border-gray-200/70 bg-white/60 px-3.5 py-2 text-[11px] font-semibold tracking-wide text-gray-400 shadow-sm backdrop-blur dark:border-dark-border dark:bg-dark-card/60 dark:text-gray-500">
        <span class="h-1.5 w-1.5 rounded-full bg-[#B12F26] shadow-[0_0_0_4px_rgba(177,47,38,0.07)] dark:bg-[#D94A40]"></span>
        Simple invoicing. Professional results.
      </div>
    </div>

  </div>
</main>


<!-- =========================================================
     THEME + LANGUAGE
========================================================== -->

<script src="/assets/theme-lang.js"></script>

<script>
  const mobileMenuBtn = document.getElementById('mobileMenuBtn');
  const mobileMenu = document.getElementById('mobileMenu');

  function closeMobileMenu() {
    if (mobileMenu) mobileMenu.classList.add('hidden');
  }

  if (mobileMenuBtn && mobileMenu) {
    mobileMenuBtn.addEventListener('click', (event) => {
      event.stopPropagation();
      mobileMenu.classList.toggle('hidden');
    });

    mobileMenu.addEventListener('click', (event) => {
      event.stopPropagation();
    });

    document.addEventListener('click', closeMobileMenu);
  }

  document.getElementById('mobileThemeToggle')?.addEventListener('click', () => {
    closeMobileMenu();
    document.getElementById('themeToggle')?.click();
  });

  document.getElementById('mobileChangeLanguage')?.addEventListener('click', () => {
    closeMobileMenu();
    document.getElementById('langBtn')?.click();
  });
</script>

<?php require __DIR__ . '/includes/footer.php'; ?>
