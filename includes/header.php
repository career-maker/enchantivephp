<?php
// Opens the page: <head>, preloader, skip link, icon sprite, site header, <main>.
// Expects $page = ['title','desc','nav','og'] from the including page.
require_once __DIR__ . '/config.php';

$is404 = ($page['status'] ?? 200) === 404;
$self = basename($_SERVER['SCRIPT_NAME'] ?? 'index.php', '.php');
$url = SITE_URL . ($self === 'index' || $is404 ? '' : $self);
$og = SITE_URL . ($page['og'] ?? 'assets/images/hero-koh-phangan-coast.webp');

if ($is404) {
    http_response_code(404);
    // The 404 page is served at any URL depth, so relative asset/link URLs must become absolute.
    $base = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/')), '/') . '/';
    ob_start(static fn(string $html): string => preg_replace(
        '/(href|src)="(?![a-z][a-z0-9+.-]*:|#|\/)([^"]*)"/',
        '$1="' . $base . '$2"',
        $html
    ));
}

// Header partial with the current page's nav link marked.
ob_start();
include __DIR__ . '/partials/header.php';
$headerHtml = preg_replace(
    '/(data-nav="' . preg_quote($page['nav'] ?? '', '/') . '")/',
    '$1 aria-current="page"',
    (string) ob_get_clean()
);
?>
<!doctype html>
<html lang="en-GB" class="no-js">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($page['title']) ?></title>
<meta name="description" content="<?= e($page['desc']) ?>">
<?php if (STAGING): ?>
<meta name="robots" content="noindex, nofollow">
<?php endif; ?>
<link rel="canonical" href="<?= e($url) ?>">
<meta property="og:type" content="website">
<meta property="og:title" content="<?= e($page['title']) ?>">
<meta property="og:description" content="<?= e($page['desc']) ?>">
<meta property="og:image" content="<?= e($og) ?>">
<meta property="og:url" content="<?= e($url) ?>">
<meta name="theme-color" content="#0658a7">
<link rel="icon" href="assets/icons/favicon.png" type="image/png" sizes="150x150">
<link rel="apple-touch-icon" href="assets/icons/favicon.png">
<link rel="preload" href="assets/fonts/Arcon-Regular.woff2" as="font" type="font/woff2" crossorigin>
<link rel="stylesheet" href="<?= asset('css/main.min.css') ?>">
<script>document.documentElement.classList.remove('no-js')</script>
</head>
<body>
<?php include __DIR__ . '/partials/preloader.php'; ?>
<a class="skip-link" href="#main">Skip to content</a>
<?php include __DIR__ . '/partials/sprite.php'; ?>
<?= $headerHtml ?>
<main id="main">
