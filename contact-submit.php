<?php
// Enquiry form handler. POST only; returns JSON {ok, message}.
// MAIL_MODE 'log' (default, local dev) saves to storage/enquiries.log; 'mail' sends with mail(). See includes/config.php.
require __DIR__ . '/includes/config.php';

header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');

function respond(int $code, bool $ok, string $message): never
{
    http_response_code($code);
    echo json_encode(['ok' => $ok, 'message' => $message]);
    exit;
}

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    header('Allow: POST');
    respond(405, false, 'Method not allowed.');
}

// Same-origin only (CSRF defence for a public, unauthenticated form).
$origin = $_SERVER['HTTP_ORIGIN'] ?? '';
if ($origin !== '' && parse_url($origin, PHP_URL_HOST) !== parse_url('//' . ($_SERVER['HTTP_HOST'] ?? ''), PHP_URL_HOST)) {
    respond(403, false, 'Request blocked.');
}

// Honeypot: real visitors never fill this in. Pretend success so bots learn nothing.
if (trim((string) ($_POST['website'] ?? '')) !== '') {
    respond(200, true, 'Thank you. Your enquiry has been received.');
}

// Single-line fields: strip control characters/newlines (blocks mail header injection) and cap length.
function line(string $key, int $max): string
{
    $v = (string) ($_POST[$key] ?? '');
    $v = preg_replace('/[\x00-\x1F\x7F]+/', ' ', $v);
    return substr(trim($v), 0, $max);
}

$d = [
    'traveller_type' => line('traveller_type', 80),
    'name' => line('name', 120),
    'email' => line('email', 160),
    'company' => line('company', 160),
    'country' => line('country', 80),
    'phone' => line('phone', 40),
    'contact_method' => line('contact_method', 40),
    'service' => line('service', 80),
    'dates' => line('dates', 120),
    'guests' => line('guests', 10),
    'needs' => line('needs', 300),
    'source' => line('source', 80),
];
$message = substr(trim(str_replace("\0", '', (string) ($_POST['message'] ?? ''))), 0, 3000);

$errors = [];
if ($d['name'] === '') $errors[] = 'name';
if (!filter_var($d['email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'email';
if ($d['service'] === '') $errors[] = 'service';
if ($message === '') $errors[] = 'message';
if ($d['phone'] !== '' && !preg_match('/^[+\d][\d\s()-]{6,}$/', $d['phone'])) $errors[] = 'phone';
if ($d['guests'] !== '' && (!ctype_digit($d['guests']) || (int) $d['guests'] < 1)) $errors[] = 'guests';
if ($errors) {
    respond(422, false, 'Please check these fields: ' . implode(', ', $errors) . '.');
}

$body = "New website enquiry\n\n";
foreach ($d as $k => $v) {
    $body .= str_pad(ucfirst(str_replace('_', ' ', $k)), 18) . ': ' . $v . "\n";
}
$body .= "\nMessage:\n" . $message . "\n";

if (MAIL_MODE === 'mail') {
    $headers = 'From: ' . MAIL_FROM . "\r\nReply-To: " . $d['email'] . "\r\nContent-Type: text/plain; charset=UTF-8";
    $sent = mail(MAIL_TO, 'Website enquiry from ' . $d['name'], $body, $headers);
    if (!$sent) {
        respond(500, false, 'Sorry, we could not send your enquiry. Please email ' . MAIL_TO . ' or call +66 2028 2867.');
    }
    respond(200, true, 'Thank you. Your enquiry has been sent and our team will be in touch shortly.');
}

// Local/dev: save instead of sending.
$dir = __DIR__ . '/storage';
if (!is_dir($dir)) {
    mkdir($dir, 0755, true);
}
file_put_contents($dir . '/enquiries.log', '[' . date('c') . "]\n" . $body . str_repeat('-', 40) . "\n", FILE_APPEND | LOCK_EX);
respond(200, true, 'Thank you. This is a local test: your enquiry was saved to the server log and was not emailed.');
