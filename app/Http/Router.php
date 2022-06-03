<?php

namespace App\Http;

use Desilva\Microserve\Request;
use Desilva\Microserve\Response;
use Hyde\Framework\Hyde;
use Hyde\Framework\Models\MarkdownPost;

use Hyde\Framework\Contracts\AbstractPage;
use Hyde\Framework\Models\BladePage;
use Hyde\Framework\Models\DocumentationPage;
use Hyde\Framework\Models\MarkdownPage;

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
            return $this->proxyStatic();
        }

		// Boot the application (providers)
		$this->bootApplication();

        return $this->handlePageRequest();
    }


    /**
     * Since the compiler only handles static pages,
     * we simply proxy everything else.
     */
    protected function shouldProxy(Request $request): bool
    {
        if (str_starts_with($request->path, '/media/')) {
            return true;
        }

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

    protected function handlePageRequest(): Response
    {
        $requestPath = $this->normalizePath($this->request->path);
		$sourceFilePath = $this->decodeSourceFilePath($requestPath);
		$sourceFileModel = $this->decodeSourceFileModel($sourceFilePath);

		$html = $this->getHtml($sourceFileModel, $sourceFilePath);

        return new Response(200, 'OK', [
            'body' => $html,
        ]);
    }

    protected function normalizePath(string $path): string
    {
        // If uri ends in .html, strip it
        if (str_ends_with($path, '.html')) {
            $path = substr($path, 0, -5);
        }

        // If the path is empty, serve the index file
        if (empty($path) || $path == '/') {
            $path = '/index';
        }

        return $path;
    }

	protected function decodeSourceFilePath(string $path): string
	{
        // Todo get paths from model class instead of hardcoded
		if (str_starts_with($path, '/posts/')) {
            return '_posts/'. basename($path);
        }

        if (str_starts_with($path, '/docs/')) {
            return '_docs/'. basename($path);
        }

        return '_pages/'. basename($path);
	}

	protected function decodeSourceFileModel(string $path): string
	{
        if (str_starts_with($path, '_posts/')) {
            return MarkdownPost::class;
        }

        if (str_starts_with($path, '_docs/')) {
            return DocumentationPage::class;
        }

        if (file_exists(Hyde::path($path . '.md'))) {
            return MarkdownPage::class;
        }

        return BladePage::class;
	}

	protected function getHtml(string $model, string $path): string
	{
		// todo add caching as we don't need to recompile pages that have not changed
		return (new LiveCompiler($model, $path))->get();
	}

	protected function bootApplication()
	{
		global $laravel;
		$laravel->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();
	}
}