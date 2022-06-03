<?php

namespace App\Http;

use Desilva\Microserve\Request;
use Desilva\Microserve\Response;
use Hyde\Framework\Hyde;

/**
 * Determine the request type and route the request to the appropriate handler.
 */
class Router
{
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function handle(): Response
    {
        // Determine what kind of request we're dealing with

        // If it is a media asset, proxy it directly without booting the entire RC
        if ($this->shouldProxy($this->request)) {
            return $this->proxyStatic($this->request);
        }

        return new Response(200, 'OK', [
            'body' => 'Hello World!',
        ]);
    }


    /**
     * Since the compiler only handles static pages,
     * we simply proxy everything else.
     */
    protected function shouldProxy(Request $request): bool
    {
        $extension = pathinfo($request->path)['extension'] ?? null;

        if ($extension === null || $extension === 'html') {
            return false;
        }

        return true;
    }

    /**
     * Proxy a static file or return a 404.
     */
    protected function proxyStatic(): Response
    {
        $path = $this->findStaticPath();

        if (! ($path)) {
            return new Response(404, 'Not Found');
        }

        $file = new FileObject($path);

        return (new Response(200, 'OK', [
            'body' => $file->getStream(),
        ]))->withHeaders([
            'Content-Type' => $file->getMimeType(),
            'Content-Length' => $file->getContentLength(),
        ]);
    }

    protected function findStaticPath(): null|string
    {
        $path = Hyde::path(). '/_site'. $this->request->path;

        if (file_exists($path)) {
            return $path;
        }

        $path = Hyde::path(). '/_media'. $this->request->path;

        if (file_exists($path)) {
            return $path;
        }

        $path = Hyde::path().'/'. basename($this->request->path);

        if (file_exists($path)) {
            return $path;
        }

        $path = Hyde::path(). '/_media/'. basename($this->request->path);

        if (file_exists($path)) {
            return $path;
        }

        return null;
    }
}