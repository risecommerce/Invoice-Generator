<?php

$pageTitle = 'Help & Support — InvoiceScheduler';

$pageDescription = 'Need help with InvoiceScheduler? Find answers to common questions, troubleshooting tips, and contact our support team.';

$pageCanonical = 'https://invoicescheduler.com/help';

$pageOgTitle = $pageTitle;

$pageOgDescription = $pageDescription;

$pageBodyAttributes = ' class="font-sans bg-gray-50 dark:bg-dark-bg min-h-screen antialiased transition-colors duration-200"';

$pageHeader = 'index';


/* =========================================================
   EXTRA HEAD
========================================================= */

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


/* =========================================================
   JSON-LD
========================================================= */

$pageJsonLd = <<<'HTML'

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
    },
    {
      "@type": "ListItem",
      "position": 2,
      "name": "Help",
      "item": "https://invoicescheduler.com/help"
    }
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
      "name": "Is InvoiceScheduler really free?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes! You can create, download, and send invoices completely free. No credit card required. Cloud Mode for saving invoices online is also free with a registered account."
      }
    },
    {
      "@type": "Question",
      "name": "Do I need to create an account?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "No. You can start creating invoices immediately without signing up. However, creating a free account unlocks Cloud Mode, invoice history, and scheduled invoicing."
      }
    },
    {
      "@type": "Question",
      "name": "Are my invoices stored securely?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Invoices created without an account are stored locally in your browser. With Cloud Mode, invoices are stored securely on our servers and accessible from any device."
      }
    },
    {
      "@type": "Question",
      "name": "Can I schedule recurring invoices?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes. Toggle Is Scheduled? to Yes, select a frequency, and enter the customer email. A free account is required for scheduling."
      }
    },
    {
      "@type": "Question",
      "name": "What currencies are supported?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "InvoiceScheduler supports multiple currencies including USD, EUR, GBP, INR, CAD, AUD, and many more."
      }
    },
    {
      "@type": "Question",
      "name": "Can I add my company logo?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Absolutely. Click the Add Your Logo area on the invoice form to upload your business logo."
      }
    },
    {
      "@type": "Question",
      "name": "How do I send an invoice by email?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Click Save & Send, enter the recipient's email, and click Send. The invoice is delivered as a PDF."
      }
    },
    {
      "@type": "Question",
      "name": "What happens if I clear my browser data?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "If you're not using Cloud Mode, locally stored invoices will be lost. We strongly recommend using Cloud Mode or downloading copies of every invoice."
      }
    },
    {
      "@type": "Question",
      "name": "Can I edit an invoice after saving it?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes. Open the invoice from your History, make changes, and save again."
      }
    },
    {
      "@type": "Question",
      "name": "How do I contact support?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Use the contact form on this page or email us at support@invoicescheduler.com."
      }
    }
  ]
}
</script>

HTML;


/* =========================================================
   HEADER
========================================================= */

require __DIR__ . '/includes/meta.php';

require __DIR__ . '/includes/header.php';


/* =========================================================
   FAQ DATA
========================================================= */

$faqs = [

    [
        'Is InvoiceScheduler really free?',
        'Yes! You can create, download, and send invoices completely free. No credit card required. Cloud Mode for saving invoices online is also free with a registered account.'
    ],

    [
        'Do I need to create an account?',
        'No. You can start creating invoices immediately without signing up. However, creating a free account unlocks Cloud Mode, invoice history, and scheduled invoicing.'
    ],

    [
        'Are my invoices stored securely?',
        'Invoices created without an account are stored locally in your browser. With Cloud Mode, invoices are stored securely on our servers and accessible from any device.'
    ],

    [
        'Can I schedule recurring invoices?',
        'Yes. Toggle "Is Scheduled?" to Yes, select a frequency, and enter the customer email. A free account is required for scheduling.'
    ],

    [
        'What currencies are supported?',
        'InvoiceScheduler supports multiple currencies including USD, EUR, GBP, INR, CAD, AUD, and many more.'
    ],
];

?>



<!-- =========================================================
     MAIN
========================================================== -->

<main class="relative min-h-screen overflow-hidden bg-[radial-gradient(circle_at_50%_-12%,rgba(177,47,38,0.10),transparent_36%),radial-gradient(circle_at_0%_35%,rgba(177,47,38,0.035),transparent_28%),radial-gradient(circle_at_100%_65%,rgba(177,47,38,0.025),transparent_28%),linear-gradient(180deg,#fafafa_0%,#f6f7f9_48%,#f1f3f5_100%)] dark:bg-[radial-gradient(circle_at_50%_-12%,rgba(177,47,38,0.17),transparent_38%),radial-gradient(circle_at_0%_40%,rgba(177,47,38,0.06),transparent_30%),radial-gradient(circle_at_100%_65%,rgba(177,47,38,0.045),transparent_28%),linear-gradient(180deg,#101827_0%,#0d1626_50%,#09111e_100%)]">

  <div class="pointer-events-none absolute -top-32 left-1/2 h-72 w-72 -translate-x-1/2 rounded-full bg-[#B12F26]/5 dark:bg-[#D94A40]/8 blur-3xl"></div>

  <div class="pointer-events-none absolute right-[-8rem] top-[35%] h-72 w-72 rounded-full bg-[#B12F26]/[0.025] dark:bg-[#D94A40]/[0.04] blur-3xl"></div>

  <div class="relative z-10 mx-auto w-full max-w-[1360px] px-4 sm:px-6 lg:px-8 py-10 sm:py-14 lg:py-16">


    <!-- =====================================================
         HERO
    ====================================================== -->

    <section class="mx-auto max-w-3xl text-center mb-10 sm:mb-12">

      <div class="inline-flex items-center gap-2 px-3.5 py-1.5 mb-5 rounded-full border border-[#B12F26]/15 bg-white/90 dark:bg-[#B12F26]/10 dark:border-[#D94A40]/20 text-[#8F241D] dark:text-[#F17B72] text-[10px] sm:text-[11px] font-extrabold uppercase tracking-[0.12em] shadow-sm">

        <span class="h-1.5 w-1.5 shrink-0 rounded-full bg-[#B12F26] dark:bg-[#D94A40]"></span>

        <span>
          Help &amp; Support
        </span>

      </div>


      <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-[#182233] dark:text-dark-text leading-tight">
        Help &amp; Support
      </h1>


      <p class="mx-auto mt-4 max-w-2xl text-sm sm:text-[14px] leading-7 text-gray-600 dark:text-dark-muted">
        We're here to help. Browse common questions below or reach out
        to our team using the contact form.
      </p>

    </section>



        <!-- =====================================================
         FAQ + CONTACT
    ====================================================== -->

    <div class="grid grid-cols-1 lg:grid-cols-[minmax(0,1.08fr)_minmax(340px,0.92fr)] gap-8 lg:gap-10 items-start">

<!-- =====================================================
         FAQ SECTION
    ====================================================== -->

    <section class="w-full min-w-0">

      <!-- Section Header -->
      <div class="max-w-2xl mx-auto text-center mb-8 sm:mb-10">

        <div class="inline-flex items-center gap-2 px-3 py-1.5 mb-4 rounded-full bg-[#B12F26]/10 dark:bg-[#D94A40]/10 border border-[#B12F26]/15 dark:border-[#D94A40]/20">

          <span class="w-1.5 h-1.5 rounded-full bg-[#B12F26] dark:bg-[#D94A40]"></span>

          <span class="text-[11px] sm:text-xs font-bold uppercase tracking-[0.12em] text-[#8F241D] dark:text-[#F17B72]">
            FAQ
          </span>

        </div>


        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight text-[#182233] dark:text-dark-text leading-tight">
          Frequently Asked
          <span class="text-[#B12F26] dark:text-[#D94A40]">
            Questions
          </span>
        </h2>


        <p class="mt-3 sm:mt-4 text-sm sm:text-base leading-6 text-gray-600 dark:text-dark-muted">
          Find quick answers to common InvoiceScheduler questions.
        </p>

      </div>


      <!-- FAQ LIST -->
      <div id="faqAccordion"
           class="w-full space-y-3">


        <?php foreach ($faqs as $index => $faq): ?>

          <div
            class="faq-card group overflow-hidden rounded-2xl border border-gray-200 dark:border-dark-border bg-white dark:bg-dark-card shadow-sm transition-all duration-300 hover:border-[#B12F26]/25 hover:shadow-md dark:hover:border-[#D94A40]/30"
            data-faq-item
          >
            <div class="faq-accent pointer-events-none absolute inset-x-0 top-0 h-1 origin-center scale-x-0 bg-gradient-to-r from-[#8F241D] via-[#B12F26] to-[#E06B61] transition-transform duration-300 group-hover:scale-x-100"></div>

            <!-- QUESTION BUTTON -->
            <button
              type="button"
              class="faq-toggle relative z-10 w-full flex items-center gap-3 sm:gap-4 px-4 sm:px-5 py-4 sm:py-5 text-left cursor-pointer select-none focus:outline-none focus-visible:ring-2 focus-visible:ring-[#B12F26]/30 focus-visible:ring-inset"
              aria-expanded="false"
              aria-controls="faq-answer-<?= $index ?>"
            >

              <!-- Number -->
              <span
                class="faq-number flex-shrink-0 flex items-center justify-center w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-[#B12F26]/10 dark:bg-[#D94A40]/10 text-[#8F241D] dark:text-[#F17B72] text-xs sm:text-sm font-extrabold border border-[#B12F26]/10 dark:border-[#D94A40]/15 transition-all duration-300"
              >
                <?= sprintf('%02d', $index + 1) ?>
              </span>


              <!-- Question -->
              <span
                class="faq-question flex-1 min-w-0 pr-1 text-sm sm:text-[15px] font-bold leading-6 text-[#202938] dark:text-dark-text transition-colors duration-300"
              >
                <?= htmlspecialchars(
                    $faq[0],
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>
              </span>


              <!-- Plus / Minus -->
              <span
                class="faq-icon flex-shrink-0 flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 dark:bg-dark-field text-gray-500 dark:text-dark-muted transition-all duration-300"
                aria-hidden="true"
              >

                <!-- Plus -->
                <svg
                  class="faq-plus w-4 h-4 transition-transform duration-300"
                  xmlns="http://www.w3.org/2000/svg"
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


                <!-- Minus -->
                <svg
                  class="faq-minus hidden w-4 h-4"
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                >
                  <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>

              </span>

            </button>


            <!-- ANSWER -->
            <div
              id="faq-answer-<?= $index ?>"
              class="faq-answer-wrapper grid grid-rows-[0fr] transition-[grid-template-rows] duration-300 ease-in-out"
              aria-hidden="true"
            >

              <div class="overflow-hidden">

                <div
                  class="mx-4 sm:mx-5 border-t border-gray-100 dark:border-dark-border"
                >

                  <div
                    class="flex gap-3 sm:gap-4 py-4 sm:py-5"
                  >

                    <!-- Answer Indicator -->
                    <span
                      class="flex-shrink-0 w-9 sm:w-10 flex justify-center"
                    >
                      <span
                        class="w-1 h-full min-h-[24px] rounded-full bg-[#B12F26]/20 dark:bg-[#D94A40]/25"
                      ></span>
                    </span>


                    <!-- Answer Text -->
                    <p
                      class="flex-1 text-sm leading-6 sm:leading-7 text-gray-600 dark:text-dark-muted"
                    >
                      <?= htmlspecialchars(
                          $faq[1],
                          ENT_QUOTES,
                          'UTF-8'
                      ) ?>
                    </p>

                  </div>

                </div>

              </div>

            </div>

          </div>

        <?php endforeach; ?>

      </div>


      <!-- Bottom Helper -->
      <div class="flex items-center justify-center gap-2 mt-5 lg:justify-start">

        <span
          class="w-1.5 h-1.5 rounded-full bg-[#B12F26] dark:bg-[#D94A40]"
        ></span>

        <span
          class="text-xs sm:text-sm text-gray-500 dark:text-dark-muted"
        >
          Still have questions? Contact our support team below.
        </span>

      </div>

    </section>



    

<!-- =====================================================
         CONTACT SECTION
    ====================================================== -->

    <section class="w-full min-w-0 lg:sticky lg:top-24">

      <div class="mb-6">

        <div>

          <h2 class="text-xl sm:text-2xl font-extrabold tracking-tight text-[#182233] dark:text-dark-text leading-tight">
            Contact Us
          </h2>

          <p class="mt-1.5 text-sm text-gray-500 dark:text-dark-muted leading-6">
            Can't find what you're looking for? Send us a message.
          </p>

        </div>

      </div>


      <div class="relative overflow-hidden rounded-2xl border border-gray-200/80 dark:border-dark-border bg-white dark:bg-dark-card p-5 sm:p-6 lg:p-7 shadow-[0_4px_12px_rgba(15,23,42,0.035),0_16px_36px_rgba(15,23,42,0.05)]">

        <div class="pointer-events-none absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-[#8F241D] via-[#B12F26] to-[#E06B61]"></div>


        <!-- CONTACT HEADER -->

        <div class="flex items-start gap-3.5 mb-6">

          <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border border-[#B12F26]/10 bg-[#B12F26]/10 text-[#8F241D] dark:bg-[#D94A40]/10 dark:text-[#F17B72] shadow-sm">

            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="21"
              height="21"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="1.8"
              stroke-linecap="round"
              stroke-linejoin="round"
              aria-hidden="true"
            >

              <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>

              <polyline points="22,6 12,13 2,6"/>

            </svg>

          </div>


          <div>

            <h3 class="text-lg sm:text-xl font-extrabold tracking-tight text-[#182233] dark:text-dark-text">
              Send us a message
            </h3>

            <p class="mt-1 text-xs sm:text-sm leading-6 text-gray-500 dark:text-dark-muted">
              Tell us what you need help with and our team will get back to you.
            </p>

          </div>

        </div>



        <!-- SUCCESS MESSAGE -->

        <div
          id="contactSuccess"
          class="mb-4 rounded-xl border px-4 py-3 text-sm leading-6 hidden border border-green-200 dark:border-green-800 bg-green-50 dark:bg-green-950/20 text-green-700 dark:text-green-300"
        >
          Thanks for reaching out! We'll get back to you shortly.
        </div>



        <!-- ERROR MESSAGE -->

        <div
          id="contactError"
          class="mb-4 rounded-xl border px-4 py-3 text-sm leading-6 hidden border border-red-200 dark:border-red-800 bg-red-50 dark:bg-red-950/20 text-red-700 dark:text-red-300"
        ></div>



        <!-- CONTACT FORM -->

        <form
          id="contactForm"
          action="api/contact-handler.php"
          method="POST"
          class="flex flex-col gap-5"
          novalidate
        >


          <!-- Honeypot field for spam prevention -->

          <div
            class="absolute -left-[9999px] -top-[9999px]"
            aria-hidden="true"
          >

            <label for="website">
              Website
            </label>

            <input
              type="text"
              id="website"
              name="website"
              tabindex="-1"
              autocomplete="off"
            >

          </div>



          <!-- NAME + EMAIL -->

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">


            <div class="flex flex-col gap-1.5">

              <label
                for="contactName"
                class="text-xs font-bold text-gray-700 dark:text-gray-300"
              >
                Name
              </label>

              <input
                id="contactName"
                name="name"
                type="text"
                required
                class="w-full min-h-[44px] rounded-xl border border-gray-200 dark:border-dark-border bg-white dark:bg-dark-field px-3.5 py-2.5 text-sm text-[#1E2838] dark:text-dark-text placeholder:text-gray-400 dark:placeholder:text-gray-500 outline-none shadow-sm transition focus:border-[#B12F26] dark:focus:border-[#D65A50] focus:ring-4 focus:ring-[#B12F26]/10 dark:focus:ring-[#D65A50]/10"
                autocomplete="name"
                placeholder="Enter your name"
              >

            </div>



            <div class="flex flex-col gap-1.5">

              <label
                for="contactEmail"
                class="text-xs font-bold text-gray-700 dark:text-gray-300"
              >
                Email
              </label>

              <input
                id="contactEmail"
                name="email"
                type="email"
                required
                class="w-full min-h-[44px] rounded-xl border border-gray-200 dark:border-dark-border bg-white dark:bg-dark-field px-3.5 py-2.5 text-sm text-[#1E2838] dark:text-dark-text placeholder:text-gray-400 dark:placeholder:text-gray-500 outline-none shadow-sm transition focus:border-[#B12F26] dark:focus:border-[#D65A50] focus:ring-4 focus:ring-[#B12F26]/10 dark:focus:ring-[#D65A50]/10"
                autocomplete="email"
                placeholder="you@example.com"
              >

            </div>

          </div>



          <!-- SUBJECT -->

          <div class="flex flex-col gap-1.5">

            <label
              for="contactSubject"
              class="text-xs font-bold text-gray-700 dark:text-gray-300"
            >
              Subject
            </label>

            <select
              id="contactSubject"
              name="subject"
              required
              class="w-full min-h-[44px] rounded-xl border border-gray-200 dark:border-dark-border bg-white dark:bg-dark-field px-3.5 py-2.5 text-sm text-[#1E2838] dark:text-dark-text placeholder:text-gray-400 dark:placeholder:text-gray-500 outline-none shadow-sm transition focus:border-[#B12F26] dark:focus:border-[#D65A50] focus:ring-4 focus:ring-[#B12F26]/10 dark:focus:ring-[#D65A50]/10"
            >

              <option
                value=""
                selected
                disabled
              >
                Select a subject
              </option>

              <option value="General Inquiry">
                General Inquiry
              </option>

              <option value="Bug Report">
                Bug Report
              </option>

              <option value="Feature Request">
                Feature Request
              </option>

              <option value="Billing Question">
                Billing Question
              </option>

              <option value="Other">
                Other
              </option>

            </select>

          </div>



          <!-- MESSAGE -->

          <div class="flex flex-col gap-1.5">

            <label
              for="contactMessage"
              class="text-xs font-bold text-gray-700 dark:text-gray-300"
            >
              Message
            </label>

            <textarea
              id="contactMessage"
              name="message"
              rows="5"
              required
              class="w-full min-h-[44px] rounded-xl border border-gray-200 dark:border-dark-border bg-white dark:bg-dark-field px-3.5 py-2.5 text-sm text-[#1E2838] dark:text-dark-text placeholder:text-gray-400 dark:placeholder:text-gray-500 outline-none shadow-sm transition focus:border-[#B12F26] dark:focus:border-[#D65A50] focus:ring-4 focus:ring-[#B12F26]/10 dark:focus:ring-[#D65A50]/10"
              placeholder="Tell us how we can help..."
            ></textarea>

          </div>



          <!-- SUBMIT -->

          <div>

            <button
              type="submit"
              id="contactSubmitBtn"
              class="inline-flex min-h-[44px] items-center justify-center gap-2 rounded-xl bg-[#B12F26] hover:bg-[#8F241D] dark:bg-[#B12F26] dark:hover:bg-[#8F241D] px-5 py-2.5 text-sm font-bold text-white shadow-md shadow-[#B12F26]/15 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-lg disabled:cursor-not-allowed disabled:opacity-60"
            >

              <span>
                Send Message
              </span>

              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="16"
                height="16"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
                aria-hidden="true"
              >

                <line
                  x1="22"
                  y1="2"
                  x2="11"
                  y2="13"
                />

                <polygon
                  points="22 2 15 22 11 13 2 9 22 2"
                />

              </svg>

            </button>

          </div>


        </form>

      </div>

    </section>



    

    </div>


<!-- =====================================================
         QUICK LINKS
    ====================================================== -->

    <section class="w-full mt-12 sm:mt-16">


      <div class="mb-6">

        <div>

          <h2 class="text-xl sm:text-2xl font-extrabold tracking-tight text-[#182233] dark:text-dark-text leading-tight">
            Quick Links
          </h2>

          <p class="mt-1.5 text-sm text-gray-500 dark:text-dark-muted leading-6">
            Jump directly to the most useful InvoiceScheduler pages.
          </p>

        </div>

      </div>



      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">


        <!-- CREATE INVOICE -->

        <a
          href="/"
          class="group relative flex min-h-[72px] items-center gap-3 overflow-hidden rounded-xl border border-gray-200/80 dark:border-dark-border bg-white dark:bg-dark-card px-4 py-3.5 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-[#B12F26]/20 hover:shadow-md"
        >

          <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-[#B12F26]/10 bg-[#B12F26]/10 text-[#8F241D] dark:bg-[#D94A40]/10 dark:text-[#F17B72] transition-transform duration-300 group-hover:scale-105">

            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="19"
              height="19"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="1.8"
              stroke-linecap="round"
              stroke-linejoin="round"
              aria-hidden="true"
            >

              <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>

              <polyline points="14 2 14 8 20 8"/>

              <line x1="12" y1="18" x2="12" y2="12"/>

              <line x1="9" y1="15" x2="15" y2="15"/>

            </svg>

          </span>


          <span class="min-w-0">

            <span class="block text-sm font-bold text-[#253044] dark:text-dark-text transition-colors group-hover:text-[#8F241D] dark:group-hover:text-[#F17B72]">
              Create an Invoice
            </span>

            <span class="mt-0.5 block text-xs leading-5 text-gray-500 dark:text-dark-muted">
              Jump straight to invoicing
            </span>

          </span>


          <svg
            class="ml-auto shrink-0 text-gray-400 dark:text-gray-600 transition-all duration-300 group-hover:translate-x-1 group-hover:text-[#B12F26] dark:group-hover:text-[#D94A40]"
            xmlns="http://www.w3.org/2000/svg"
            width="17"
            height="17"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            aria-hidden="true"
          >

            <line
              x1="5"
              y1="12"
              x2="19"
              y2="12"
            />

            <polyline
              points="12 5 19 12 12 19"
            />

          </svg>

        </a>



        <!-- GUIDES -->

        <a
          href="/guides"
          class="group relative flex min-h-[72px] items-center gap-3 overflow-hidden rounded-xl border border-gray-200/80 dark:border-dark-border bg-white dark:bg-dark-card px-4 py-3.5 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-[#B12F26]/20 hover:shadow-md"
        >

          <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-[#B12F26]/10 bg-[#B12F26]/10 text-[#8F241D] dark:bg-[#D94A40]/10 dark:text-[#F17B72] transition-transform duration-300 group-hover:scale-105">

            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="19"
              height="19"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="1.8"
              stroke-linecap="round"
              stroke-linejoin="round"
              aria-hidden="true"
            >

              <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>

              <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>

            </svg>

          </span>


          <span class="min-w-0">

            <span class="block text-sm font-bold text-[#253044] dark:text-dark-text transition-colors group-hover:text-[#8F241D] dark:group-hover:text-[#F17B72]">
              Guides &amp; Tutorials
            </span>

            <span class="mt-0.5 block text-xs leading-5 text-gray-500 dark:text-dark-muted">
              Step-by-step instructions
            </span>

          </span>


          <svg
            class="ml-auto shrink-0 text-gray-400 dark:text-gray-600 transition-all duration-300 group-hover:translate-x-1 group-hover:text-[#B12F26] dark:group-hover:text-[#D94A40]"
            xmlns="http://www.w3.org/2000/svg"
            width="17"
            height="17"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            aria-hidden="true"
          >

            <line
              x1="5"
              y1="12"
              x2="19"
              y2="12"
            />

            <polyline
              points="12 5 19 12 12 19"
            />

          </svg>

        </a>



        <!-- SIGN UP -->

        <a
          href="/signup"
          class="group relative flex min-h-[72px] items-center gap-3 overflow-hidden rounded-xl border border-gray-200/80 dark:border-dark-border bg-white dark:bg-dark-card px-4 py-3.5 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-[#B12F26]/20 hover:shadow-md"
        >

          <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-[#B12F26]/10 bg-[#B12F26]/10 text-[#8F241D] dark:bg-[#D94A40]/10 dark:text-[#F17B72] transition-transform duration-300 group-hover:scale-105">

            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="19"
              height="19"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="1.8"
              stroke-linecap="round"
              stroke-linejoin="round"
              aria-hidden="true"
            >

              <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>

              <circle
                cx="9"
                cy="7"
                r="4"
              />

              <line
                x1="19"
                y1="8"
                x2="19"
                y2="14"
              />

              <line
                x1="16"
                y1="11"
                x2="22"
                y2="11"
              />

            </svg>

          </span>


          <span class="min-w-0">

            <span class="block text-sm font-bold text-[#253044] dark:text-dark-text transition-colors group-hover:text-[#8F241D] dark:group-hover:text-[#F17B72]">
              Sign Up for Cloud Mode
            </span>

            <span class="mt-0.5 block text-xs leading-5 text-gray-500 dark:text-dark-muted">
              Save invoices to the cloud
            </span>

          </span>


          <svg
            class="ml-auto shrink-0 text-gray-400 dark:text-gray-600 transition-all duration-300 group-hover:translate-x-1 group-hover:text-[#B12F26] dark:group-hover:text-[#D94A40]"
            xmlns="http://www.w3.org/2000/svg"
            width="17"
            height="17"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            aria-hidden="true"
          >

            <line
              x1="5"
              y1="12"
              x2="19"
              y2="12"
            />

            <polyline
              points="12 5 19 12 12 19"
            />

          </svg>

        </a>



        <!-- SIGN IN -->

        <a
          href="/signin"
          class="group relative flex min-h-[72px] items-center gap-3 overflow-hidden rounded-xl border border-gray-200/80 dark:border-dark-border bg-white dark:bg-dark-card px-4 py-3.5 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-[#B12F26]/20 hover:shadow-md"
        >

          <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-[#B12F26]/10 bg-[#B12F26]/10 text-[#8F241D] dark:bg-[#D94A40]/10 dark:text-[#F17B72] transition-transform duration-300 group-hover:scale-105">

            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="19"
              height="19"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="1.8"
              stroke-linecap="round"
              stroke-linejoin="round"
              aria-hidden="true"
            >

              <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>

              <polyline
                points="10 17 15 12 10 7"
              />

              <line
                x1="15"
                y1="12"
                x2="3"
                y2="12"
              />

            </svg>

          </span>


          <span class="min-w-0">

            <span class="block text-sm font-bold text-[#253044] dark:text-dark-text transition-colors group-hover:text-[#8F241D] dark:group-hover:text-[#F17B72]">
              Sign In
            </span>

            <span class="mt-0.5 block text-xs leading-5 text-gray-500 dark:text-dark-muted">
              Access your account
            </span>

          </span>


          <svg
            class="ml-auto shrink-0 text-gray-400 dark:text-gray-600 transition-all duration-300 group-hover:translate-x-1 group-hover:text-[#B12F26] dark:group-hover:text-[#D94A40]"
            xmlns="http://www.w3.org/2000/svg"
            width="17"
            height="17"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            aria-hidden="true"
          >

            <line
              x1="5"
              y1="12"
              x2="19"
              y2="12"
            />

            <polyline
              points="12 5 19 12 12 19"
            />

          </svg>

        </a>


      </div>

    </section>



    <!-- =====================================================
         BOTTOM
    ====================================================== -->

    <div class="text-center pt-1">

      <div class="inline-flex items-center gap-2 rounded-full border border-gray-200/80 dark:border-dark-border bg-white/70 dark:bg-dark-card/60 px-3.5 py-2 text-[11px] font-semibold text-gray-400 dark:text-gray-500 shadow-sm">

        <span class="h-1.5 w-1.5 rounded-full bg-[#B12F26] dark:bg-[#D94A40]"></span>

        <span>
          We're here to help. Simple invoicing, made easier.
        </span>

      </div>

    </div>


  </div>

</main>



<!-- =========================================================
     THEME + LANGUAGE
========================================================== -->

<script src="/assets/theme-lang.js"></script>


<script>

  /* =========================================================
     MOBILE MENU
  ========================================================= */

  const mobileMenuBtn =
    document.getElementById('mobileMenuBtn');

  const mobileMenu =
    document.getElementById('mobileMenu');


  function closeMobileMenu() {

    if (mobileMenu) {

      mobileMenu.classList.add('hidden');

    }

  }


  if (mobileMenuBtn && mobileMenu) {

    mobileMenuBtn.addEventListener(
      'click',
      (event) => {

        event.stopPropagation();

        mobileMenu.classList.toggle('hidden');

      }
    );


    mobileMenu.addEventListener(
      'click',
      (event) => {

        event.stopPropagation();

      }
    );


    document.addEventListener(
      'click',
      closeMobileMenu
    );

  }



  /* =========================================================
     MOBILE THEME
  ========================================================== */

  document
    .getElementById('mobileThemeToggle')
    ?.addEventListener(
      'click',
      () => {

        closeMobileMenu();

        document
          .getElementById('themeToggle')
          ?.click();

      }
    );



  /* =========================================================
     MOBILE LANGUAGE
  ========================================================== */

  document
    .getElementById('mobileChangeLanguage')
    ?.addEventListener(
      'click',
      () => {

        closeMobileMenu();

        document
          .getElementById('langBtn')
          ?.click();

      }
    );



  /* =========================================================
     FAQ ACCORDION
  ========================================================== */

  document.addEventListener('DOMContentLoaded', () => {

    const faqAccordion =
      document.getElementById('faqAccordion');

    if (!faqAccordion) {
      return;
    }


    const faqItems =
      faqAccordion.querySelectorAll('[data-faq-item]');


    function closeFaq(item) {

      const button =
        item.querySelector('.faq-toggle');

      const answer =
        item.querySelector('.faq-answer-wrapper');

      const icon =
        item.querySelector('.faq-icon');

      const plus =
        item.querySelector('.faq-plus');

      const minus =
        item.querySelector('.faq-minus');

      const number =
        item.querySelector('.faq-number');


      if (!button || !answer || !icon || !plus || !minus || !number) {
        return;
      }


      button.setAttribute(
        'aria-expanded',
        'false'
      );

      answer.setAttribute(
        'aria-hidden',
        'true'
      );

      answer.classList.remove(
        'grid-rows-[1fr]'
      );

      answer.classList.add(
        'grid-rows-[0fr]'
      );


      item.classList.remove(
        'border-[#B12F26]/30',
        'dark:border-[#D94A40]/35',
        'shadow-md',
        'is-open'
      );

      const accent = item.querySelector('.faq-accent');

      if (accent) {
        accent.classList.remove('scale-x-100');
      }


      icon.classList.remove(
        'bg-[#B12F26]/10',
        'dark:bg-[#D94A40]/10',
        'text-[#B12F26]',
        'dark:text-[#D94A40]'
      );

      icon.classList.add(
        'bg-gray-100',
        'dark:bg-dark-field',
        'text-gray-500',
        'dark:text-dark-muted'
      );


      plus.classList.remove('hidden');
      minus.classList.add('hidden');


      number.classList.remove(
        'bg-[#B12F26]',
        'dark:bg-[#D94A40]',
        'text-white',
        'border-transparent'
      );

      number.classList.add(
        'bg-[#B12F26]/10',
        'dark:bg-[#D94A40]/10',
        'text-[#8F241D]',
        'dark:text-[#F17B72]'
      );

    }


    function openFaq(item) {

      const button =
        item.querySelector('.faq-toggle');

      const answer =
        item.querySelector('.faq-answer-wrapper');

      const icon =
        item.querySelector('.faq-icon');

      const plus =
        item.querySelector('.faq-plus');

      const minus =
        item.querySelector('.faq-minus');

      const number =
        item.querySelector('.faq-number');


      if (!button || !answer || !icon || !plus || !minus || !number) {
        return;
      }


      button.setAttribute(
        'aria-expanded',
        'true'
      );

      answer.setAttribute(
        'aria-hidden',
        'false'
      );

      answer.classList.remove(
        'grid-rows-[0fr]'
      );

      answer.classList.add(
        'grid-rows-[1fr]'
      );


      item.classList.add(
        'border-[#B12F26]/30',
        'dark:border-[#D94A40]/35',
        'shadow-md',
        'is-open'
      );

      const accent = item.querySelector('.faq-accent');

      if (accent) {
        accent.classList.add('scale-x-100');
      }


      icon.classList.remove(
        'bg-gray-100',
        'dark:bg-dark-field',
        'text-gray-500',
        'dark:text-dark-muted'
      );

      icon.classList.add(
        'bg-[#B12F26]/10',
        'dark:bg-[#D94A40]/10',
        'text-[#B12F26]',
        'dark:text-[#D94A40]'
      );


      plus.classList.add('hidden');
      minus.classList.remove('hidden');


      number.classList.remove(
        'bg-[#B12F26]/10',
        'dark:bg-[#D94A40]/10',
        'text-[#8F241D]',
        'dark:text-[#F17B72]'
      );

      number.classList.add(
        'bg-[#B12F26]',
        'dark:bg-[#D94A40]',
        'text-white',
        'border-transparent'
      );

    }


    function closeAllFaqs(exceptItem = null) {

      faqItems.forEach((item) => {

        if (item !== exceptItem) {
          closeFaq(item);
        }

      });

    }


    faqItems.forEach((item) => {

      const button =
        item.querySelector('.faq-toggle');

      if (!button) {
        return;
      }


      button.addEventListener('click', () => {

        const isOpen =
          button.getAttribute('aria-expanded') === 'true';


        if (isOpen) {

          closeFaq(item);

        } else {

          closeAllFaqs(item);
          openFaq(item);

        }

      });

    });


    /* =========================================
       KEYBOARD NAVIGATION
    ========================================== */

    faqItems.forEach((item, index) => {

      const button =
        item.querySelector('.faq-toggle');

      if (!button) {
        return;
      }


      button.addEventListener('keydown', (event) => {

        let targetIndex = null;


        if (event.key === 'ArrowDown') {
          targetIndex =
            (index + 1) % faqItems.length;
        }


        if (event.key === 'ArrowUp') {
          targetIndex =
            (index - 1 + faqItems.length) % faqItems.length;
        }


        if (event.key === 'Home') {
          targetIndex = 0;
        }


        if (event.key === 'End') {
          targetIndex = faqItems.length - 1;
        }


        if (targetIndex !== null) {

          event.preventDefault();

          const targetButton =
            faqItems[targetIndex].querySelector('.faq-toggle');

          targetButton?.focus();

        }

      });

    });


    /* =========================================
       ESCAPE TO CLOSE OPEN FAQ
    ========================================== */

    document.addEventListener('keydown', (event) => {

      if (event.key !== 'Escape') {
        return;
      }

      faqItems.forEach((item) => {

        const button =
          item.querySelector('.faq-toggle');

        if (
          button &&
          button.getAttribute('aria-expanded') === 'true'
        ) {
          closeFaq(item);
        }

      });

    });

  });

const contactForm =
  document.getElementById('contactForm');

const contactSuccess =
  document.getElementById('contactSuccess');

const contactError =
  document.getElementById('contactError');

const contactSubmitBtn =
  document.getElementById('contactSubmitBtn');

function isValidEmail(value) {
  return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
}

if (contactForm) {

  contactForm.addEventListener(
    'submit',
    async (e) => {

      e.preventDefault();

      contactSuccess.classList.add('hidden');
      contactError.classList.add('hidden');

      const formData = new FormData(contactForm);

      const name =
        formData.get('name')?.toString().trim() || '';

      const email =
        formData.get('email')?.toString().trim() || '';

      const subject =
        formData.get('subject')?.toString().trim() || '';

      const message =
        formData.get('message')?.toString().trim() || '';

      if (
        !name ||
        !email ||
        !subject ||
        !message
      ) {
        contactError.textContent =
          'Please fill in all required fields.';

        contactError.classList.remove('hidden');

        return;
      }

      if (!isValidEmail(email)) {

        contactError.textContent =
          'Please enter a valid email address.';

        contactError.classList.remove('hidden');

        return;
      }

      contactSubmitBtn.disabled = true;

      contactSubmitBtn.innerHTML =
        '<span>Sending...</span>';

      try {

        const res = await fetch(
          contactForm.action,
          {
            method: 'POST',
            body: formData
          }
        );

        const responseText = await res.text();

        let data = null;

        try {
          data = responseText
            ? JSON.parse(responseText)
            : null;
        } catch (parseError) {

          console.error(
            'Invalid JSON response:',
            responseText
          );

          throw new Error(
            'The server returned an invalid response. Please try again.'
          );
        }

        if (
          !res.ok ||
          !data ||
          !data.success
        ) {
          throw new Error(
            data?.error ||
            'Something went wrong. Please try again.'
          );
        }

        contactSuccess.classList.remove('hidden');

        contactForm.reset();

      } catch (err) {

        contactError.textContent =
          err.message ||
          'Something went wrong. Please try again.';

        contactError.classList.remove('hidden');

      } finally {

        contactSubmitBtn.disabled = false;

        contactSubmitBtn.innerHTML = `
          <span>Send Message</span>

          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="16"
            height="16"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            aria-hidden="true"
          >
            <line
              x1="22"
              y1="2"
              x2="11"
              y2="13"
            />

            <polygon
              points="22 2 15 22 11 13 2 9 22 2"
            />
          </svg>
        `;
      }
    }
  );
}

</script>



<?php

require __DIR__ . '/includes/footer.php';

?>

