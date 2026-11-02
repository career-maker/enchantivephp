<?php
// Site-wide settings. No secrets here: put SMTP/API credentials in includes/config.local.php (git-ignored).
const SITE_URL = 'https://www.enchantiveasia.com/'; // canonical base; confirm production domain
const STAGING = true;                               // true => noindex meta on every page (see README)
const MAIL_TO = 'info@enchantiveasia.com';
const MAIL_FROM = 'no-reply@enchantiveasia.com';
const MAIL_MODE = 'log';                            // 'log' = save enquiries to storage/enquiries.log (local dev); 'mail' = send with mail()

if (is_file(__DIR__ . '/config.local.php')) {
    require __DIR__ . '/config.local.php';
}

function e(string $s): string
{
    return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8', false);
}

// Cache-buster: changes whenever the asset file changes.
function asset(string $path): string
{
    $f = dirname(__DIR__) . '/' . $path;
    return $path . '?v=' . (is_file($f) ? base_convert((string) filemtime($f), 10, 36) : '0');
}
