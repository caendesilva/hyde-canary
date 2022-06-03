<?php

namespace App\Http;

use Desilva\Microserve\Contracts\HttpKernelInterface;
use Desilva\Microserve\Request;
use Desilva\Microserve\Response;

class HttpKernel implements HttpKernelInterface
{
    public function handle(Request $request): Response
    {
        return new Response(200, 'OK', [
            'body' => 'Hello World!',
        ]);
    }
}