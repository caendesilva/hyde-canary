<?php

namespace App\Http;

use Desilva\Microserve\Contracts\HttpKernelInterface;
use Desilva\Microserve\Request;
use Desilva\Microserve\Response;

class HttpKernel implements HttpKernelInterface
{
    public function handle(Request $request): Response
    {
        return (new Router($request))->handle();
    }

    public static function handleException(\Throwable $exception)
    {
        $whoops = new \Whoops\Run;
        $whoops->allowQuit(false);
        $whoops->writeToOutput(false);
        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
        $html = $whoops->handleException($exception);

        return Response::make(500, 'Internal Server Error', [
            'Content-Type' => 'text/html',
            'Content-Length' => strlen($html),
            'body' => $html,
        ]);
    }
}