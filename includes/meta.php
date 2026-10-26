<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pageTitle = $pageTitle ?? 'invoicescheduler.com';
$pageDescription = $pageDescription ?? 'Create, manage, download, and send invoices online.';
$pageBodyAttributes = $pageBodyAttributes ?? '';
$pageExtraHead = $pageExtraHead ?? '';
$pageKeywords = $pageKeywords ?? 'free invoice generator, invoice scheduler, online invoicing, create invoice online, recurring invoices, send invoice email, PDF invoice maker, freelancer invoice tool';
$pageCanonical = $pageCanonical ?? 'https://invoicescheduler.com/';
$pageOgType = $pageOgType ?? 'website';
$pageOgImage = $pageOgImage ?? 'https://invoicescheduler.com/assets/og-image.png';
$pageOgTitle = $pageOgTitle ?? $pageTitle;
$pageOgDescription = $pageOgDescription ?? $pageDescription;
$pageJsonLd = $pageJsonLd ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="<?= htmlspecialchars($pageDescription, ENT_QUOTES, 'UTF-8') ?>">
<meta name="robots" content="index, follow">
<meta name="keywords" content="<?= htmlspecialchars($pageKeywords, ENT_QUOTES, 'UTF-8') ?>">

<!-- Open Graph -->
<meta property="og:title" content="<?= htmlspecialchars($pageOgTitle, ENT_QUOTES, 'UTF-8') ?>">
<meta property="og:description" content="<?= htmlspecialchars($pageOgDescription, ENT_QUOTES, 'UTF-8') ?>">
<meta property="og:type" content="<?= htmlspecialchars($pageOgType, ENT_QUOTES, 'UTF-8') ?>">
<meta property="og:url" content="<?= htmlspecialchars($pageCanonical, ENT_QUOTES, 'UTF-8') ?>">
<meta property="og:image" content="<?= htmlspecialchars($pageOgImage, ENT_QUOTES, 'UTF-8') ?>">

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?= htmlspecialchars($pageOgTitle, ENT_QUOTES, 'UTF-8') ?>">
<meta name="twitter:description" content="<?= htmlspecialchars($pageOgDescription, ENT_QUOTES, 'UTF-8') ?>">

<!-- Canonical -->
<link rel="canonical" href="<?= htmlspecialchars($pageCanonical, ENT_QUOTES, 'UTF-8') ?>">

<!-- Favicon -->
<link rel="icon" type="image/svg+xml" href="/assets/invoices-fevicon.svg">

<meta name="google-adsense-account" content="ca-pub-6894980610374149">

<title><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?></title>
<?= $pageJsonLd ?>
<?= $pageExtraHead ?>
</head>
<body<?= $pageBodyAttributes ?>>