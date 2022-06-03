<?php

define('LARAVEL_START', microtime(true));
define('BASE_PATH', realpath('.'));

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

// $uri = urldecode(
//     parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
// );


// // If it is a media asset, proxy it directly without booting the entire RC
// if (str_starts_with($uri, '/media/') || isset(pathinfo($uri)['extension']) && in_array(pathinfo($uri)['extension'], ['css', 'js', 'png', 'jpg', 'jpeg', 'gif', 'svg', 'ico', 'json'])) {
//     return require_once 'ProxyServer.php';
// }

// // If the uri is empty, rewrite to serve the index file
// if (empty($uri) || $uri == '/') {
//     $uri = '/index';
// }


// // If uri ends in .html, strip it
// if (str_ends_with($uri, '.html')) {
//     $uri = substr($uri, 0, -5);
// }


// // If the uri is empty, serve the index file
// if (empty($uri) || $uri == '/') {
//     $uri = '/index';
// }

// Bootstrap the application (providers)
// $app->make(Kernel::class)->bootstrap();

//$httpKernel = new \App\Http\HttpKernel($app, $uri);
//$httpKernel->handle();

$app = \Desilva\Microserve\Microserve::boot(\App\Http\HttpKernel::class);

exit($app->handle());