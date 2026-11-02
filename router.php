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

// Pretty URLs: /about.html is served by about.php. Direct .php page URLs 301 to the .html form.
if (preg_match('#^/([A-Za-z0-9_-]+)\.html$#', $path, $m) && is_file(__DIR__ . "/{$m[1]}.php") && $m[1] !== '404') {
    $_SERVER['SCRIPT_NAME'] = "/{$m[1]}.php";
    require __DIR__ . "/{$m[1]}.php";
    return true;
}
if (preg_match('#^/([A-Za-z0-9_-]+)\.php$#', $path, $m) && !in_array($m[1], ['contact-submit', '404'], true)) {
    $q = ($_SERVER['QUERY_STRING'] ?? '') !== '' ? '?' . $_SERVER['QUERY_STRING'] : '';
    header('Location: /' . ($m[1] === 'index' ? '' : $m[1] . '.html') . $q, true, 301);
    return true;
}

$file = __DIR__ . $path;
if ($path !== '/' && is_file($file)) {
    return false; // let the built-in server send the static file (css, js, images, sitemap.xml...)
}

http_response_code(404);
$_SERVER['SCRIPT_NAME'] = '/404.php';
require __DIR__ . '/404.php';
return true;
