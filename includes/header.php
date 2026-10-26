<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pageHeader = $pageHeader ?? 'none';

/*
|--------------------------------------------------------------------------
| CURRENT PAGE / ACTIVE NAVIGATION
|--------------------------------------------------------------------------
*/
// Clean URLs: "/dashboard" and "/dashboard.php" both resolve to "dashboard"
$currentPage = preg_replace('/\.php$/', '', basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)));

$activeNavClass = 'text-ink dark:text-dark-text font-semibold border-b-2 border-[#B12F26] pb-4 -mb-4';

$inactiveNavClass = 'text-gray-500 dark:text-dark-muted hover:text-ink dark:hover:text-dark-text';

$isMyInvoicesPage = in_array($currentPage, [
    'dashboard',
    'invoice-view',
    'send-invoice'
], true);

$isScheduledPage = ($currentPage === 'scheduled-invoices');

$isCustomersPage = in_array($currentPage, [
    'customers',
    'customer-new',
    'customer-view'
], true);

$isLoggedIn = !empty($_SESSION['user_id']);

$headerFirstName = $_SESSION['first_name'] ?? '';
$headerLastName  = $_SESSION['last_name'] ?? '';
$headerEmail     = $_SESSION['email'] ?? '';

$headerName = trim($headerFirstName . ' ' . $headerLastName);

$headerInitials = '';

if ($headerFirstName !== '') {
    $headerInitials .= strtoupper(substr($headerFirstName, 0, 1));
}

if ($headerLastName !== '') {
    $headerInitials .= strtoupper(substr($headerLastName, 0, 1));
}

$headerInitials = $headerInitials ?: 'U';

?>

<?php if ($pageHeader === 'customers' || $pageHeader === 'customer-new'): ?>

<!-- =========================================================
     CUSTOMERS + CUSTOMER NEW HEADER
     ========================================================= -->
<header class="bg-white dark:bg-dark-card border-b border-gray-200 dark:border-dark-border transition-colors duration-200">

    <div class="max-w-[1200px] mx-auto flex items-center justify-between px-6 py-3">

        <!-- LEFT SIDE -->
        <div class="flex items-center gap-8">

            <!-- LOGO -->
            <a href="/" class="flex items-center gap-2">

                <span class="w-7 h-7 inline-block">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 117.59 100"
                        class="w-full h-full">

                        <g>
                            <rect x="37.62" y="45.29" fill="#B12F26" width="18.82" height="9.41"/>
                            <rect x="37.62" y="23.51" fill="#B12F26" width="28.22" height="9.41"/>
                            <rect x="37.62" y="67.07" fill="#B12F26" width="56.46" height="9.41"/>
                            <polygon fill="#B12F26" points="94.08,0 94.08,23.51 117.59,23.51"/>

                            <polygon
                                fill="#B12F26"
                                points="84.67,0 37.62,0 37.62,23.51 65.84,23.51 65.84,32.93 37.62,32.93 37.62,45.29 56.44,45.29 56.44,54.71 37.62,54.71 37.62,67.07 94.08,67.07 94.08,76.49 37.62,76.49 37.62,100 117.59,100 117.59,32.93 84.67,32.93"
                            />

                            <rect x="18.81" y="23.51" fill="#B12F26" width="18.81" height="9.41"/>
                            <rect y="45.29" fill="#B12F26" width="37.62" height="9.41"/>
                            <rect x="9.41" y="67.07" fill="#B12F26" width="28.21" height="9.41"/>
                        </g>

                    </svg>
                </span>

                <span class="text-lg text-ink dark:text-dark-text">
                    <span class="font-bold">invoicescheduler</span><span class="font-normal">.com</span>
                </span>

            </a>

            <!-- NAVIGATION -->
            <nav class="hidden md:flex items-center gap-6 text-sm">

                <a
                    href="dashboard"
                    class="<?= $isMyInvoicesPage ? $activeNavClass : $inactiveNavClass ?>"
                    data-i18n="nav.myInvoices">
                    My Invoices
                </a>

                <a
                    href="scheduled-invoices"
                    class="<?= $isScheduledPage ? $activeNavClass : $inactiveNavClass ?>">
                    Scheduled Invoices
                </a>

                <a
                    href="customers"
                    class="<?= $isCustomersPage ? $activeNavClass : $inactiveNavClass ?>"
                    data-i18n="nav.customers">
                    Customers
                </a>

            </nav>

        </div>

        <!-- RIGHT SIDE -->
        <div class="flex items-center gap-4">

            <!-- LANGUAGE -->
            <button
                id="langBtn"
                class="w-8 h-8 flex items-center justify-center rounded bg-gray-800 dark:bg-dark-field text-white text-[10px] font-bold hover:opacity-80 transition">
                文A
            </button>

            <!-- DARK MODE -->
            <button
                id="themeToggle"
                class="w-8 h-8 flex items-center justify-center text-gray-500 dark:text-dark-muted hover:text-ink dark:hover:text-dark-text transition">

                <svg
                    id="iconSun"
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 3v1.5M12 19.5V21M4.22 4.22l1.06 1.06M18.72 18.72l1.06 1.06M3 12h1.5M19.5 12H21M4.22 19.78l1.06-1.06M18.72 5.28l1.06-1.06M12 7.5a4.5 4.5 0 100 9 4.5 4.5 0 000-9z"
                    />

                </svg>

                <svg
                    id="iconMoon"
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5 hidden"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"
                    />

                </svg>

            </button>

            <!-- USER DROPDOWN -->
            <div class="dropdown relative">

                <button
                    type="button"
                    class="dropdown-toggle flex items-center gap-2 text-sm text-ink dark:text-dark-text">

                    <span
                        id="userInitials"
                        class="w-8 h-8 rounded-full bg-[#B12F26] text-white flex items-center justify-center font-semibold text-xs">
                        <?= htmlspecialchars($headerInitials) ?>
                    </span>

                    <span id="userName" class="hidden sm:inline">
                        <?= htmlspecialchars($headerName) ?>
                    </span>

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-4 h-4 text-gray-400"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M19 9l-7 7-7-7"
                        />

                    </svg>

                </button>

                <!-- DROPDOWN MENU -->
                <div
                    class="dropdown-menu absolute right-0 mt-2 w-56 bg-white dark:bg-dark-card border border-gray-200 dark:border-dark-border rounded-md shadow-lg z-50 py-2 text-sm">

                    <div class="px-4 py-2 border-b border-gray-100 dark:border-dark-border">

                        <p
                            id="userNameFull"
                            class="font-semibold text-ink dark:text-dark-text">
                            <?= htmlspecialchars($headerName) ?>
                        </p>

                        <p
                            id="userEmail"
                            class="text-gray-500 dark:text-dark-muted text-xs">
                            <?= htmlspecialchars($headerEmail) ?>
                        </p>

                    </div>

                    <a
                        href="/"
                        class="block px-4 py-2 text-ink dark:text-dark-text hover:bg-gray-50 dark:hover:bg-dark-border">
                        My Profile
                    </a>

                    <a
                        href="logout"
                        class="block px-4 py-2 text-red-600 hover:bg-gray-50 dark:hover:bg-dark-border"
                        data-i18n="account.signOut">
                        Sign Out
                    </a>

                </div>

            </div>

        </div>

    </div>

</header>


<?php elseif ($pageHeader === 'customer-view'): ?>

<!-- =========================================================
     CUSTOMER VIEW HEADER
     ========================================================= -->
<header class="bg-white dark:bg-dark-card border-b border-gray-200 dark:border-dark-border transition-colors duration-200">

    <div class="max-w-[1200px] mx-auto flex items-center justify-between px-6 py-3">

        <div class="flex items-center gap-8">

            <a href="/dashboard" class="flex items-center gap-2">

                <span class="w-7 h-7 inline-block">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 117.59 100"
                        class="w-full h-full">

                        <g>
                            <rect x="37.62" y="45.29" fill="#B12F26" width="18.82" height="9.41"/>
                            <rect x="37.62" y="23.51" fill="#B12F26" width="28.22" height="9.41"/>
                            <rect x="37.62" y="67.07" fill="#B12F26" width="56.46" height="9.41"/>
                            <polygon fill="#B12F26" points="94.08,0 94.08,23.51 117.59,23.51"/>

                            <polygon
                                fill="#B12F26"
                                points="84.67,0 37.62,0 37.62,23.51 65.84,23.51 65.84,32.93 37.62,32.93 37.62,45.29 56.44,45.29 56.44,54.71 37.62,54.71 37.62,67.07 94.08,67.07 94.08,76.49 37.62,76.49 37.62,100 117.59,100 117.59,32.93 84.67,32.93"
                            />

                            <rect x="18.81" y="23.51" fill="#B12F26" width="18.81" height="9.41"/>
                            <rect y="45.29" fill="#B12F26" width="37.62" height="9.41"/>
                            <rect x="9.41" y="67.07" fill="#B12F26" width="28.21" height="9.41"/>
                        </g>

                    </svg>
                </span>

                <span class="text-lg text-ink dark:text-dark-text">
                    <span class="font-bold">invoicescheduler</span><span class="font-normal">.com</span>
                </span>

            </a>

            <nav class="hidden md:flex items-center gap-6 text-sm">

                <a
                    href="dashboard"
                    class="<?= $isMyInvoicesPage ? $activeNavClass : $inactiveNavClass ?>"
                    data-i18n="nav.myInvoices">
                    My Invoices
                </a>

                <a
                    href="scheduled-invoices"
                    class="<?= $isScheduledPage ? $activeNavClass : $inactiveNavClass ?>">
                    Scheduled Invoices
                </a>

                <a
                    href="customers"
                    class="<?= $isCustomersPage ? $activeNavClass : $inactiveNavClass ?>"
                    data-i18n="nav.customers">
                    Customers
                </a>

            </nav>

        </div>

        <div class="flex items-center gap-4">

            <!-- UPGRADE -->
            <button
                class="hidden sm:inline-flex items-center gap-2 bg-[#B12F26] hover:bg-[#9E2921] text-white text-sm font-semibold px-4 py-2 rounded-md">

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-4 h-4"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"
                    />

                </svg>

                <span data-i18n="nav.upgrade">Upgrade</span>

            </button>

            <!-- LANGUAGE -->
            <button
                id="langBtn"
                class="w-8 h-8 flex items-center justify-center rounded bg-gray-800 dark:bg-dark-field text-white text-[10px] font-bold hover:opacity-80 transition">
                文A
            </button>

            <!-- DARK MODE -->
            <button
                id="themeToggle"
                class="w-8 h-8 flex items-center justify-center text-gray-500 dark:text-dark-muted hover:text-ink dark:hover:text-dark-text transition">

                <svg
                    id="iconSun"
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 3v1.5M12 19.5V21M4.22 4.22l1.06 1.06M18.72 18.72l1.06 1.06M3 12h1.5M19.5 12H21M4.22 19.78l1.06-1.06M18.72 5.28l1.06-1.06M12 7.5a4.5 4.5 0 100 9 4.5 4.5 0 000-9z"
                    />

                </svg>

                <svg
                    id="iconMoon"
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5 hidden"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"
                    />

                </svg>

            </button>

            <!-- USER -->
            <div class="dropdown relative">

                <button
                    type="button"
                    class="dropdown-toggle flex items-center gap-2 text-sm text-ink dark:text-dark-text">

                    <span
                        id="userInitials"
                        class="w-8 h-8 rounded-full bg-[#B12F26] text-white flex items-center justify-center font-semibold text-xs">
                        <?= htmlspecialchars($headerInitials) ?>
                    </span>

                    <span id="userName" class="hidden sm:inline">
                        <?= htmlspecialchars($headerName) ?>
                    </span>

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-4 h-4 text-gray-400"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M19 9l-7 7-7-7"
                        />

                    </svg>

                </button>

                <div
                    class="dropdown-menu absolute right-0 mt-2 w-56 bg-white dark:bg-dark-card border border-gray-200 dark:border-dark-border rounded-md shadow-lg z-50 py-2 text-sm">

                    <div class="px-4 py-2 border-b border-gray-100 dark:border-dark-border">

                        <p
                            id="userNameFull"
                            class="font-semibold text-ink dark:text-dark-text">
                            <?= htmlspecialchars($headerName) ?>
                        </p>

                        <p
                            id="userEmail"
                            class="text-gray-500 dark:text-dark-muted text-xs">
                            <?= htmlspecialchars($headerEmail) ?>
                        </p>

                    </div>

                    <a
                        href="/"
                        class="block px-4 py-2 text-ink dark:text-dark-text hover:bg-gray-50 dark:hover:bg-dark-border">
                        My Profile
                    </a>

                    <a
                        href="logout"
                        class="block px-4 py-2 text-red-600 hover:bg-gray-50 dark:hover:bg-dark-border"
                        data-i18n="account.signOut">
                        Sign Out
                    </a>

                </div>

            </div>

        </div>

    </div>

</header>


<?php elseif ($pageHeader === 'dashboard'): ?>

<!-- =========================================================
     DASHBOARD HEADER
     ========================================================= -->
<header class="bg-white dark:bg-dark-card border-b border-gray-200 dark:border-dark-border transition-colors duration-200">

    <div class="max-w-[1200px] mx-auto flex items-center justify-between px-6 py-3">

        <div class="flex items-center gap-8">

            <a href="/" class="flex items-center gap-2">

                <span class="w-7 h-7 inline-block">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 117.59 100"
                        class="w-full h-full">

                        <g>
                            <rect x="37.62" y="45.29" fill="#B12F26" width="18.82" height="9.41"/>
                            <rect x="37.62" y="23.51" fill="#B12F26" width="28.22" height="9.41"/>
                            <rect x="37.62" y="67.07" fill="#B12F26" width="56.46" height="9.41"/>
                            <polygon fill="#B12F26" points="94.08,0 94.08,23.51 117.59,23.51"/>

                            <polygon
                                fill="#B12F26"
                                points="84.67,0 37.62,0 37.62,23.51 65.84,23.51 65.84,32.93 37.62,32.93 37.62,45.29 56.44,45.29 56.44,54.71 37.62,54.71 37.62,67.07 94.08,67.07 94.08,76.49 37.62,76.49 37.62,100 117.59,100 117.59,32.93 84.67,32.93"
                            />

                            <rect x="18.81" y="23.51" fill="#B12F26" width="18.81" height="9.41"/>
                            <rect y="45.29" fill="#B12F26" width="37.62" height="9.41"/>
                            <rect x="9.41" y="67.07" fill="#B12F26" width="28.21" height="9.41"/>
                        </g>

                    </svg>
                </span>

                <span class="text-lg text-ink dark:text-dark-text">
                    <span class="font-bold">invoicescheduler</span><span class="font-normal">.com</span>
                </span>

            </a>

            <nav class="hidden md:flex items-center gap-6 text-sm">

                <a
                    href="dashboard"
                    class="<?= $isMyInvoicesPage ? $activeNavClass : $inactiveNavClass ?>"
                    data-i18n="nav.myInvoices">
                    My Invoices
                </a>

                <a
                    href="scheduled-invoices"
                    class="<?= $isScheduledPage ? $activeNavClass : $inactiveNavClass ?>">
                    Scheduled Invoices
                </a>

                <a
                    href="customers"
                    class="<?= $isCustomersPage ? $activeNavClass : $inactiveNavClass ?>"
                    data-i18n="nav.customers">
                    Customers
                </a>

            </nav>

        </div>

        <div class="flex items-center gap-4">

            <button
                id="langBtn"
                class="w-8 h-8 flex items-center justify-center rounded bg-gray-800 dark:bg-dark-field text-white text-[10px] font-bold hover:opacity-80 transition">
                文A
            </button>

            <button
                id="themeToggle"
                class="w-8 h-8 flex items-center justify-center text-gray-500 dark:text-dark-muted hover:text-ink dark:hover:text-dark-text transition">

                <svg
                    id="iconSun"
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 3v1.5M12 19.5V21M4.22 4.22l1.06 1.06M18.72 18.72l1.06 1.06M3 12h1.5M19.5 12H21M4.22 19.78l1.06-1.06M18.72 5.28l1.06-1.06M12 7.5a4.5 4.5 0 100 9 4.5 4.5 0 000-9z"
                    />

                </svg>

                <svg
                    id="iconMoon"
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5 hidden"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"
                    />

                </svg>

            </button>

            <div class="dropdown relative">

                <button
                    type="button"
                    class="dropdown-toggle flex items-center gap-2 text-sm text-ink dark:text-dark-text">

                    <span
                        id="userInitials"
                        class="w-8 h-8 rounded-full bg-[#B12F26] text-white flex items-center justify-center font-semibold text-xs">
                        <?= htmlspecialchars($headerInitials) ?>
                    </span>

                    <span id="userName" class="hidden sm:inline">
                        <?= htmlspecialchars($headerName) ?>
                    </span>

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-4 h-4 text-gray-400"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M19 9l-7 7-7-7"
                        />

                    </svg>

                </button>

                <div
                    class="dropdown-menu absolute right-0 mt-2 w-56 bg-white dark:bg-dark-card border border-gray-200 dark:border-dark-border rounded-md shadow-lg z-50 py-2 text-sm">

                    <div class="px-4 py-2 border-b border-gray-100 dark:border-dark-border">

                        <p
                            id="userNameFull"
                            class="font-semibold text-ink dark:text-dark-text">
                            <?= htmlspecialchars($headerName) ?>
                        </p>

                        <p
                            id="userEmail"
                            class="text-gray-500 dark:text-dark-muted text-xs">
                            <?= htmlspecialchars($headerEmail) ?>
                        </p>

                    </div>

                    <a
                        href="/"
                        class="block px-4 py-2 text-ink dark:text-dark-text hover:bg-gray-50 dark:hover:bg-dark-border">
                        My Profile
                    </a>

                    <a
                        href="logout"
                        class="block px-4 py-2 text-red-600 hover:bg-gray-50 dark:hover:bg-dark-border"
                        data-i18n="account.signOut">
                        Sign Out
                    </a>

                </div>

            </div>

        </div>

    </div>

</header>


<?php elseif ($pageHeader === 'index'): ?>

<!-- =========================================================
     INDEX HEADER
     ========================================================= -->
<header class="bg-white dark:bg-dark-card border-b border-gray-200 dark:border-dark-border transition-colors duration-200">

    <div class="max-w-[1400px] mx-auto relative flex items-center justify-between px-6 py-3">

        <!-- LEFT -->
        <div class="flex items-center gap-8">

            <a href="/" class="flex items-center gap-2">

                <span class="w-7 h-7 inline-block">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 117.59 100"
                        class="w-full h-full">

                        <g>
                            <rect x="37.62" y="45.29" fill="#B12F26" width="18.82" height="9.41"/>
                            <rect x="37.62" y="23.51" fill="#B12F26" width="28.22" height="9.41"/>
                            <rect x="37.62" y="67.07" fill="#B12F26" width="56.46" height="9.41"/>
                            <polygon fill="#B12F26" points="94.08,0 94.08,23.51 117.59,23.51"/>

                            <polygon
                                fill="#B12F26"
                                points="84.67,0 37.62,0 37.62,23.51 65.84,23.51 65.84,32.93 37.62,32.93 37.62,45.29 56.44,45.29 56.44,54.71 37.62,54.71 37.62,67.07 94.08,67.07 94.08,76.49 37.62,76.49 37.62,100 117.59,100 117.59,32.93 84.67,32.93"
                            />

                            <rect x="18.81" y="23.51" fill="#B12F26" width="18.81" height="9.41"/>
                            <rect y="45.29" fill="#B12F26" width="37.62" height="9.41"/>
                            <rect x="9.41" y="67.07" fill="#B12F26" width="28.21" height="9.41"/>
                        </g>

                    </svg>

                </span>

                <span class="text-lg text-ink dark:text-dark-text">
                    <span class="font-bold">invoicescheduler</span><span class="font-normal">.com</span>
                </span>

            </a>

            <!-- DESKTOP NAV -->
            <nav
                id="mainNav"
                class="hidden md:flex items-center gap-6 text-gray-500 dark:text-dark-muted text-sm">

                <a
                    id="navHistory"
                    href="./#history"
                    class="hover:text-ink dark:hover:text-dark-text">
                    History
                </a>

                <a
                    id="navGuides"
                    href="guides"
                    class="hover:text-ink dark:hover:text-dark-text">
                    Guides
                </a>

                <a
                    id="navHelp"
                    href="help"
                    class="hover:text-ink dark:hover:text-dark-text">
                    Help
                </a>

            </nav>

        </div>

        <!-- RIGHT -->
        <div class="flex items-center gap-4">

            <!-- LANGUAGE -->
            <button
                id="langBtn"
                class="hidden md:inline-flex w-8 h-8 items-center justify-center rounded bg-gray-800 dark:bg-dark-field text-white text-[10px] font-bold hover:opacity-80 transition">
                文A
            </button>

            <!-- DARK MODE -->
            <button
                id="themeToggle"
                class="hidden md:inline-flex w-8 h-8 items-center justify-center text-gray-500 dark:text-dark-muted hover:text-ink dark:hover:text-dark-text transition">

                <svg
                    id="iconSun"
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 3v1.5M12 19.5V21M4.22 4.22l1.06 1.06M18.72 18.72l1.06 1.06M3 12h1.5M19.5 12H21M4.22 19.78l1.06-1.06M18.72 5.28l1.06-1.06M12 7.5a4.5 4.5 0 100 9 4.5 4.5 0 000-9z"
                    />

                </svg>

                <svg
                    id="iconMoon"
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5 hidden"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"
                    />

                </svg>

            </button>

            <?php if ($isLoggedIn): ?>

                <!-- LOGGED IN USER -->
                <div class="dropdown relative">

                    <button
                        type="button"
                        class="dropdown-toggle flex items-center gap-2 text-sm text-gray-700 dark:text-dark-text hover:text-ink dark:hover:text-white transition">

                        <span class="font-medium text-[#B12F26]">
                            <?= htmlspecialchars($headerInitials) ?>
                        </span>

                        <span>
                            <?= htmlspecialchars($headerName) ?>
                        </span>

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="w-4 h-4 text-gray-400"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M19 9l-7 7-7-7"
                            />

                        </svg>

                    </button>

                    <div
                        class="dropdown-menu hidden absolute right-0 mt-2 w-48 bg-white dark:bg-dark-card border border-gray-200 dark:border-dark-border rounded-md shadow-lg z-[9999] py-1 text-sm">

                        <a
                            href="dashboard"
                            class="block px-4 py-2 text-gray-700 dark:text-dark-text hover:bg-gray-50 dark:hover:bg-dark-border">
                            Dashboard
                        </a>

                        <a
                            href="logout"
                            class="block px-4 py-2 text-red-600 hover:bg-gray-50 dark:hover:bg-dark-border">
                            Sign Out
                        </a>

                    </div>

                </div>

            <?php else: ?>

                <!-- GUEST -->

                <a
                    id="signInLink"
                    href="signin"
                    class="hidden md:inline-block text-sm text-gray-600 dark:text-dark-muted hover:text-ink">
                    Sign In
                </a>

                <a
                    id="signUpLink"
                    href="signup"
                    class="hidden md:inline-block bg-[#B12F26] hover:bg-[#9E2921] text-white text-sm font-semibold px-5 py-2 rounded-md">
                    Sign Up
                </a>

            <?php endif; ?>

            <!-- MOBILE MENU BUTTON -->
            <button
                id="mobileMenuBtn"
                type="button"
                class="md:hidden w-10 h-10 flex items-center justify-center border border-gray-200 dark:border-dark-border rounded-md text-gray-700 dark:text-dark-text hover:bg-gray-100 dark:hover:bg-dark-border transition">

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M4 6h16M4 12h16M4 18h16"
                    />

                </svg>

            </button>

        </div>

        <!-- MOBILE MENU -->
        <div
            id="mobileMenu"
            class="hidden absolute right-6 top-full mt-2 w-64 bg-white dark:bg-dark-card border border-gray-200 dark:border-dark-border rounded-xl shadow-xl overflow-hidden z-50">

            <div class="flex flex-col px-4 py-3 gap-2 text-sm text-gray-700 dark:text-dark-text">

                <div
                    id="mobileNavLinks"
                    class="flex flex-col gap-2">

                    <a
                        href="./#history"
                        data-mobile-action="history"
                        class="px-3 py-2 rounded-md hover:bg-gray-100 dark:hover:bg-dark-border transition">
                        History
                    </a>

                    <a
                        href="guides"
                        data-mobile-action="guides"
                        class="px-3 py-2 rounded-md hover:bg-gray-100 dark:hover:bg-dark-border transition">
                        Guides
                    </a>

                    <a
                        href="help"
                        data-mobile-action="help"
                        class="px-3 py-2 rounded-md hover:bg-gray-100 dark:hover:bg-dark-border transition">
                        Help
                    </a>

                </div>

                <button
                    id="mobileChangeLanguage"
                    type="button"
                    class="text-left px-3 py-2 rounded-md hover:bg-gray-100 dark:hover:bg-dark-border transition">
                    Change Language
                </button>

                <button
                    id="mobileThemeToggle"
                    type="button"
                    class="text-left px-3 py-2 rounded-md hover:bg-gray-100 dark:hover:bg-dark-border transition">
                    Enable Dark Mode
                </button>

                <div class="border-t border-gray-200 dark:border-dark-border my-2"></div>

                <a
                    id="mobileSignIn"
                    href="signin"
                    class="px-3 py-2 rounded-md hover:bg-gray-100 dark:hover:bg-dark-border transition">
                    Sign In
                </a>

                <a
                    id="mobileSignUp"
                    href="signup"
                    class="px-3 py-2 rounded-md bg-[#B12F26] text-white hover:bg-[#9E2921] transition">
                    Sign Up
                </a>

            </div>

        </div>

    </div>

</header>


<?php elseif ($pageHeader === 'invoice-view'): ?>

<!-- =========================================================
     INVOICE VIEW HEADER
     ========================================================= -->
<header class="bg-white dark:bg-dark-card border-b border-gray-200 dark:border-dark-border transition-colors duration-200">

    <div class="max-w-[1200px] mx-auto flex items-center justify-between px-6 py-3">

        <div class="flex items-center gap-8">

            <a href="dashboard" class="flex items-center gap-2">

                <span class="w-7 h-7 inline-block">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 117.59 100"
                        class="w-full h-full">

                        <g>
                            <rect x="37.62" y="45.29" fill="#B12F26" width="18.82" height="9.41"/>
                            <rect x="37.62" y="23.51" fill="#B12F26" width="28.22" height="9.41"/>
                            <rect x="37.62" y="67.07" fill="#B12F26" width="56.46" height="9.41"/>
                            <polygon fill="#B12F26" points="94.08,0 94.08,23.51 117.59,23.51"/>

                            <polygon
                                fill="#B12F26"
                                points="84.67,0 37.62,0 37.62,23.51 65.84,23.51 65.84,32.93 37.62,32.93 37.62,45.29 56.44,45.29 56.44,54.71 37.62,54.71 37.62,67.07 94.08,67.07 94.08,76.49 37.62,76.49 37.62,100 117.59,100 117.59,32.93 84.67,32.93"
                            />

                            <rect x="18.81" y="23.51" fill="#B12F26" width="18.81" height="9.41"/>
                            <rect y="45.29" fill="#B12F26" width="37.62" height="9.41"/>
                            <rect x="9.41" y="67.07" fill="#B12F26" width="28.21" height="9.41"/>
                        </g>

                    </svg>
                </span>

                <span class="text-lg text-ink dark:text-dark-text">
                    <span class="font-bold">invoicescheduler</span><span class="font-normal">.com</span>
                </span>

            </a>

            <nav class="hidden md:flex items-center gap-6 text-sm">

                <a
                    href="dashboard"
                    class="text-ink dark:text-dark-text font-semibold pb-4 -mb-4"
                    data-i18n="nav.myInvoices">
                    My Invoices
                </a>

                <a
                    href="scheduled-invoices"
                    class="hover:text-ink dark:hover:text-dark-text">
                    Scheduled Invoices
                </a>

                <a
                    href="customers"
                    class="text-gray-500 dark:text-dark-muted hover:text-ink dark:hover:text-dark-text"
                    data-i18n="nav.customers">
                    Customers
                </a>

            </nav>

        </div>

        <div class="flex items-center gap-4">

            <button
                id="langBtn"
                class="w-8 h-8 flex items-center justify-center rounded bg-gray-800 dark:bg-dark-field text-white text-[10px] font-bold hover:opacity-80 transition">
                文A
            </button>

            <button
                id="themeToggle"
                class="w-8 h-8 flex items-center justify-center text-gray-500 dark:text-dark-muted hover:text-ink dark:hover:text-dark-text transition">

                <svg
                    id="iconSun"
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 3v1.5M12 19.5V21M4.22 4.22l1.06 1.06M18.72 18.72l1.06 1.06M3 12h1.5M19.5 12H21M4.22 19.78l1.06-1.06M18.72 5.28l1.06-1.06M12 7.5a4.5 4.5 0 100 9 4.5 4.5 0 000-9z"
                    />

                </svg>

                <svg
                    id="iconMoon"
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5 hidden"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"
                    />

                </svg>

            </button>

            <div class="dropdown relative">

                <button
                    type="button"
                    class="dropdown-toggle flex items-center gap-2 text-sm text-ink dark:text-dark-text">

                    <span
                        id="userInitials"
                        class="w-8 h-8 rounded-full bg-[#B12F26] text-white flex items-center justify-center font-semibold text-xs">
                        <?= htmlspecialchars($headerInitials) ?>
                    </span>

                    <span id="userName" class="hidden sm:inline">
                        <?= htmlspecialchars($headerName) ?>
                    </span>

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-4 h-4 text-gray-400"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M19 9l-7 7-7-7"
                        />

                    </svg>

                </button>

                <div
                    class="dropdown-menu absolute right-0 mt-2 w-56 bg-white dark:bg-dark-card border border-gray-200 dark:border-dark-border rounded-md shadow-lg z-50 py-2 text-sm">

                    <div class="px-4 py-2 border-b border-gray-100 dark:border-dark-border">

                        <p
                            id="userNameFull"
                            class="font-semibold text-ink dark:text-dark-text">
                            <?= htmlspecialchars($headerName) ?>
                        </p>

                        <p
                            id="userEmail"
                            class="text-gray-500 dark:text-dark-muted text-xs">
                            <?= htmlspecialchars($headerEmail) ?>
                        </p>

                    </div>

                    <a
                        href="/"
                        class="block px-4 py-2 text-ink dark:text-dark-text hover:bg-gray-50 dark:hover:bg-dark-border">
                        My Profile
                    </a>

                    <a
                        href="logout"
                        class="block px-4 py-2 text-red-600 hover:bg-gray-50"
                        data-i18n="account.signOut">
                        Sign Out
                    </a>

                </div>

            </div>

        </div>

    </div>

</header>


<?php elseif ($pageHeader === 'send-invoice'): ?>

<!-- =========================================================
     SEND INVOICE HEADER
     ========================================================= -->
<header class="bg-white dark:bg-dark-card border-b border-gray-200 dark:border-dark-border transition-colors duration-200">

    <div class="max-w-[1200px] mx-auto flex items-center justify-between px-6 py-3">

        <a href="dashboard" class="flex items-center gap-2">

            <span class="w-7 h-7 inline-block">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 117.59 100"
                    class="w-full h-full">

                    <g>
                        <rect x="37.62" y="45.29" fill="#B12F26" width="18.82" height="9.41"/>
                        <rect x="37.62" y="23.51" fill="#B12F26" width="28.22" height="9.41"/>
                        <rect x="37.62" y="67.07" fill="#B12F26" width="56.46" height="9.41"/>
                        <polygon fill="#B12F26" points="94.08,0 94.08,23.51 117.59,23.51"/>

                        <polygon
                            fill="#B12F26"
                            points="84.67,0 37.62,0 37.62,23.51 65.84,23.51 65.84,32.93 37.62,32.93 37.62,45.29 56.44,45.29 56.44,54.71 37.62,54.71 37.62,67.07 94.08,67.07 94.08,76.49 37.62,76.49 37.62,100 117.59,100 117.59,32.93 84.67,32.93"
                        />

                        <rect x="18.81" y="23.51" fill="#B12F26" width="18.81" height="9.41"/>
                        <rect y="45.29" fill="#B12F26" width="37.62" height="9.41"/>
                        <rect x="9.41" y="67.07" fill="#B12F26" width="28.21" height="9.41"/>
                    </g>

                </svg>
            </span>

            <span class="text-lg text-ink dark:text-dark-text">
                <span class="font-bold">invoicescheduler</span><span class="font-normal">.com</span>
            </span>

        </a>

        <nav class="hidden md:flex items-center gap-6 text-sm">

            <a
                href="dashboard"
                class="text-ink dark:text-dark-text font-semibold"
                data-i18n="nav.myInvoices">
                My Invoices
            </a>

            <a
                href="scheduled-invoices"
                class="text-gray-500 dark:text-dark-muted hover:text-ink dark:hover:text-dark-text">
                Scheduled Invoices
            </a>

            <a
                href="customers"
                class="text-gray-500 dark:text-dark-muted hover:text-ink dark:hover:text-dark-text"
                data-i18n="nav.customers">
                Customers
            </a>

        </nav>

        <div class="flex items-center gap-4">

            <button
                id="langBtn"
                class="w-8 h-8 flex items-center justify-center rounded bg-gray-800 dark:bg-dark-field text-white text-[10px] font-bold hover:opacity-80 transition">
                文A
            </button>

            <button
                id="themeToggle"
                class="w-8 h-8 flex items-center justify-center text-gray-500 dark:text-dark-muted hover:text-ink dark:hover:text-dark-text transition">

                <svg
                    id="iconSun"
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 3v1.5M12 19.5V21M4.22 4.22l1.06 1.06M18.72 18.72l1.06 1.06M3 12h1.5M19.5 12H21M4.22 19.78l1.06-1.06M18.72 5.28l1.06-1.06M12 7.5a4.5 4.5 0 100 9 4.5 4.5 0 000-9z"
                    />

                </svg>

                <svg
                    id="iconMoon"
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5 hidden"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"
                    />

                </svg>

            </button>

            <div class="dropdown relative">

                <button
                    type="button"
                    class="dropdown-toggle flex items-center gap-2 text-sm text-ink dark:text-dark-text">

                    <span
                        id="userInitials"
                        class="w-8 h-8 rounded-full bg-[#B12F26] text-white flex items-center justify-center font-semibold text-xs">
                        <?= htmlspecialchars($headerInitials) ?>
                    </span>

                    <span id="userName" class="hidden sm:inline">
                        <?= htmlspecialchars($headerName) ?>
                    </span>

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-4 h-4 text-gray-400"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M19 9l-7 7-7-7"
                        />

                    </svg>

                </button>

                <div
                    class="dropdown-menu absolute right-0 mt-2 w-56 bg-white dark:bg-dark-card border border-gray-200 dark:border-dark-border rounded-md shadow-lg z-50 py-2 text-sm">

                    <div class="px-4 py-2 border-b border-gray-100 dark:border-dark-border">

                        <p
                            id="userNameFull"
                            class="font-semibold text-ink dark:text-dark-text">
                            <?= htmlspecialchars($headerName) ?>
                        </p>

                        <p
                            id="userEmail"
                            class="text-gray-500 dark:text-dark-muted text-xs">
                            <?= htmlspecialchars($headerEmail) ?>
                        </p>

                    </div>

                    <a
                        href="/"
                        class="block px-4 py-2 text-ink dark:text-dark-text hover:bg-gray-50 dark:hover:bg-dark-border">
                        My Profile
                    </a>

                    <a
                        href="logout"
                        class="block px-4 py-2 text-red-600 hover:bg-gray-50 dark:hover:bg-dark-border"
                        data-i18n="account.signOut">
                        Sign Out
                    </a>

                </div>

            </div>

        </div>

    </div>

</header>

<?php endif; ?>