<?php

namespace App\Http;

use Illuminate\Http\Response;
use LaravelZero\Framework\Application;

class HttpKernel
{
    public function __construct(Application $app, string $uri)
    {
        $this->app = $app;
        $this->uri = $uri;
    }

    public function handle(): void
    {
        $response = new Response();
        $response->setContent($this->render());
        $response->send();
    }

    protected function render(): string
    {
        return (new LiveCompiler($this->uri))->get();
    }
}