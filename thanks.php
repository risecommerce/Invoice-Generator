<?php

$invoiceNumber = trim($_GET['Invoice'] ?? '');

$pageTitle = 'Thank You - invoicescheduler.com';
$pageBodyAttributes = ' class="bg-gray-100 dark:bg-dark-bg min-h-screen flex flex-col transition-colors duration-200"';
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
                    green: '#1AA260',
                    greenDark: '#0E8A4E',
                    greenSoft: '#DFF6E7'
                },
                ink: '#1E2838',
                dark: {
                    bg: '#0B1220',
                    card: '#141d33',
                    field: '#1c2740',
                    border: '#2a3650',
                    text: '#e7ebf3',
                    muted: '#8492ac'
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

.thankyou-card {
    animation: cardIn 0.45s ease-out;
}

.success-icon {
    animation: iconIn 0.5s ease-out;
}

@keyframes cardIn {
    from {
        opacity: 0;
        transform: translateY(18px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes iconIn {
    from {
        opacity: 0;
        transform: scale(0.85);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}
</style>
HTML;

require __DIR__ . '/includes/meta.php';
require __DIR__ . '/includes/header.php';
?>
<script>
document.addEventListener('DOMContentLoaded', async function () {

    try {
        const res = await fetch('api/session_check.php');

        if (!res.ok) {
            return;
        }

        const currentUser = await res.json();

        if (!currentUser) {
            return;
        }
 const thankYouCancelBtn =
    document.getElementById('thankYouCancelBtn');

if (thankYouCancelBtn) {
    thankYouCancelBtn.href = 'dashboard';
}
        const firstName = currentUser.firstName || '';
        const lastName = currentUser.lastName || '';
        const initials = currentUser.initials || '';

        // User initials
        const userInitials = document.getElementById('userInitials');

        if (userInitials) {
            userInitials.textContent = initials;
        }

        // User name
        const userDisplayName =
            document.getElementById('userDisplayName');

        if (userDisplayName) {
            const displayName = lastName
                ? `${firstName}.${lastName.charAt(0).toLowerCase()}`
                : firstName;

            userDisplayName.textContent = displayName;
        }

        // Mobile account name
        const mobileSignIn =
            document.getElementById('mobileSignIn');

        const mobileSignUp =
            document.getElementById('mobileSignUp');

        if (mobileSignIn) {
            mobileSignIn.style.display = 'none';
        }

        if (mobileSignUp) {
            mobileSignUp.textContent = firstName || 'Account';
            mobileSignUp.href = 'dashboard';
        }

        // Desktop navigation
        const mainNav =
            document.getElementById('mainNav');

        if (mainNav) {
            mainNav.innerHTML = `
                <a href="dashboard"
                   class="hover:text-ink dark:hover:text-dark-text">
                    My Invoices
                </a>

                <a href="/scheduled-invoices"
                   class="hover:text-ink dark:hover:text-dark-text">
                    Scheduled Invoices
                </a>

                <a href="customers"
                   class="hover:text-ink dark:hover:text-dark-text">
                    Customers
                </a>
            `;
        }

        // Mobile navigation
        const mobileNavLinks =
            document.getElementById('mobileNavLinks');

        if (mobileNavLinks) {
            mobileNavLinks.innerHTML = `
                <a href="dashboard"
                   class="block px-3 py-2 rounded-md">
                    My Invoices
                </a>

                <a href="/scheduled-invoices"
                   class="block px-3 py-2 rounded-md">
                    Scheduled Invoices
                </a>

                <a href="customers"
                   class="block px-3 py-2 rounded-md">
                    Customers
                </a>
            `;
        }

    } catch (error) {
        console.error('Login status check failed:', error);
    }

});
</script>
<main class="flex-1 flex items-center justify-center px-5 py-10 sm:px-6">

    <div class="w-full max-w-2xl">

        <div class="thankyou-card relative overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-[0_12px_30px_rgba(0,0,0,0.08),0_4px_12px_rgba(0,0,0,0.04)] dark:border-dark-border dark:bg-dark-card dark:shadow-[0_15px_40px_rgba(0,0,0,0.28)]">

            <div class="absolute inset-x-0 top-0 h-[3px] bg-gradient-to-r from-green-500 via-emerald-400 to-green-500"></div>

            <div class="relative px-6 py-9 text-center sm:px-12 sm:py-11">

                <a     id="thankYouCancelBtn"
                    href="/"
                    aria-label="Cancel"
                    title="Cancel"
                    class="group absolute left-5 top-5 flex h-10 w-10 items-center justify-center rounded-full border border-gray-200 bg-white text-gray-500 shadow-[0_3px_10px_rgba(0,0,0,0.08),0_6px_18px_rgba(0,0,0,0.06)] transition-all duration-200 hover:-translate-y-0.5 hover:border-gray-300 hover:bg-gray-50 hover:text-gray-800 hover:shadow-[0_6px_14px_rgba(0,0,0,0.10),0_10px_24px_rgba(0,0,0,0.08)] dark:border-dark-border dark:bg-dark-field dark:text-dark-muted dark:shadow-[0_5px_18px_rgba(0,0,0,0.25)] dark:hover:bg-dark-card dark:hover:text-dark-text"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-[17px] w-[17px] transition-transform duration-200 group-hover:rotate-90"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6 6l12 12M18 6L6 18"
                        />
                    </svg>
                </a>

                <div class="success-icon mx-auto mb-5 flex h-[70px] w-[70px] items-center justify-center rounded-full border-[6px] border-green-50 bg-green-100 shadow-[0_6px_20px_rgba(34,197,94,0.12)] dark:border-green-950/30 dark:bg-green-900/30 dark:shadow-none">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-7 w-7 text-green-600 dark:text-green-400"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2.5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M5 13l4 4L19 7"
                        />
                    </svg>

                </div>

                <div class="mb-2 inline-flex items-center gap-2 rounded-full border border-green-100 bg-green-50 px-3 py-1 dark:border-green-900/30 dark:bg-green-950/20">

                    <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>

                    <span class="text-[10px] font-bold uppercase tracking-wider text-green-700 dark:text-green-400">
                        Invoice Created
                    </span>

                </div>

                <h1 class="mt-3 text-3xl font-bold tracking-tight text-ink dark:text-dark-text sm:text-[38px]">
                    Thank You!
                </h1>

                <?php if ($invoiceNumber !== ''): ?>

                    <div class="mx-auto mt-5 inline-flex items-center gap-2.5 rounded-lg border border-gray-200 bg-gray-50 px-4 py-2.5 shadow-[0_2px_8px_rgba(0,0,0,0.03)] dark:border-dark-border dark:bg-dark-field">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4 shrink-0 text-gray-600 dark:text-gray-300"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h6l5 5v11a2 2 0 01-2 2z"
                            />
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M13 3v5h5"
                            />
                        </svg>

                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                            Invoice Number:
                        </span>

                        <span class="text-sm font-bold tracking-wide text-gray-900 dark:text-white">
                            <?= htmlspecialchars($invoiceNumber, ENT_QUOTES, 'UTF-8') ?>
                        </span>

                    </div>

                <?php endif; ?>

                <div class="mx-auto mt-5 flex max-w-lg items-center justify-center gap-2 text-sm text-gray-500 dark:text-dark-muted">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4 shrink-0 text-green-600 dark:text-green-400"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622C17.176 19.29 21 14.591 21 9c0-1.048-.133-2.066-.382-3.016z"
                        />
                    </svg>

                    <span>
                        Your invoice PDF has been generated and saved to your device.
                    </span>

                </div>

            </div>

        </div>

    </div>

</main>

<?php require __DIR__ . '/includes/footer.php'; ?>