<?php
// Local dev router for `php -S localhost:8000 router.php` (mirrors the .htaccess rules used on Apache).
$path = rawurldecode(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/');

// Never serve source, includes, tooling or docs.
if (preg_match('#^/(\.git|\.deploy|\.freebuff|includes|storage|node_modules|scripts|src|scss|docs|qa-report|design-mockups)(/|$)#', $path)
    || preg_match('#/(package(-lock)?\.json|README\.md|PRODUCT\.md|Design\.pdf|router\.php|image[^/]*\.png)$#', $path)) {
    http_response_code(404);
    require __DIR__ . '/404.php';
    return true;
}

if ($path === '/') {
    require __DIR__ . '/index.php';
    return true;
}

// Clean URLs: /about is served by about.php. Old /about.html and /about.php 301 to /about (index -> /).
$q = ($_SERVER['QUERY_STRING'] ?? '') !== '' ? '?' . $_SERVER['QUERY_STRING'] : '';
if (preg_match('#^/([A-Za-z0-9_-]+)\.(html|php)$#', $path, $m) && !in_array($m[1], ['contact-submit', '404', 'router'], true) && is_file(__DIR__ . "/{$m[1]}.php")) {
    header('Location: /' . ($m[1] === 'index' ? '' : $m[1]) . $q, true, 301);
    return true;
}
if (preg_match('#^/([A-Za-z0-9_-]+)$#', $path, $m) && !in_array($m[1], ['contact-submit', '404', 'router'], true) && is_file(__DIR__ . "/{$m[1]}.php")) {
    $_SERVER['SCRIPT_NAME'] = "/{$m[1]}.php";
    require __DIR__ . "/{$m[1]}.php";
    return true;
}
if ($path === '/contact-submit.php') {
    return false; // handler is requested directly by the form
}

$file = __DIR__ . $path;
if ($path !== '/' && is_file($file)) {
    return false; // let the built-in server send the static file (css, js, images, sitemap.xml...)
}

http_response_code(404);
$_SERVER['SCRIPT_NAME'] = '/404.php';
require __DIR__ . '/404.php';
return true;
