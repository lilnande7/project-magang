<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Resolve the Laravel application root.
// Supports the standard layout (public/ with app root at ../)
// and common shared-hosting layouts where the app root is outside public_html.
$appRootCandidates = [
    __DIR__ . '/..',
    __DIR__ . '/../../laravel_app',
];

$appRoot = null;
foreach ($appRootCandidates as $candidate) {
    if (is_file($candidate . '/vendor/autoload.php') && is_file($candidate . '/bootstrap/app.php')) {
        $appRoot = $candidate;
        break;
    }
}

if ($appRoot === null) {
    http_response_code(500);
    echo 'Application root not found. Check deployment paths.';
    exit(1);
}

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = $appRoot . '/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require $appRoot . '/vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once $appRoot . '/bootstrap/app.php';

$app->handleRequest(Request::capture());
