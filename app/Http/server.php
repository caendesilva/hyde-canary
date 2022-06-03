<?php

use Illuminate\Contracts\Console\Kernel;

define('LARAVEL_START', microtime(true));

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';


$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);


// If it is a media asset, proxy it directly without booting the entire RC
if (str_starts_with($uri, '/media/') || ($uri === '/favicon.ico')) {
    exit(404);
}
if ($uri === '/docs/search.json') {
    exit(404);
}

// If the uri is empty, serve the index file
if (empty($uri) || $uri == '/') {
    $uri = '/index';
}


// If uri ends in .html, strip it
if (str_ends_with($uri, '.html')) {
    $uri = substr($uri, 0, -5);
}


// If the uri is empty, serve the index file
if (empty($uri) || $uri == '/') {
    $uri = '/index';
}



// Bootstrap the application (providers)
$app->make(Kernel::class)->bootstrap();

$httpKernel = new \App\Http\HttpKernel($app, $uri);
$httpKernel->handle();