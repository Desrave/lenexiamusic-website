<?php
// Deploy trigger — called by GitHub Actions after every push
$token = getenv('DEPLOY_TOKEN');
$provided = $_SERVER['HTTP_X_DEPLOY_TOKEN'] ?? '';

if (empty($token) || empty($provided) || !hash_equals($token, $provided)) {
    http_response_code(401);
    exit('Unauthorized');
}

$dir = escapeshellarg(__DIR__);
$output = shell_exec("git -C {$dir} pull origin master 2>&1");

header('Content-Type: text/plain');
http_response_code(200);
echo $output ?: 'Done (no output)';
