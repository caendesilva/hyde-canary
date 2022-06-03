<?php /** @noinspection ALL */

// Include the Piko class
//require_once 'vendor/caendesilva/pikoserve/Piko.php';
require_once 'packages/server/Piko.php';

/**
 * Proxy static Hyde assets
 */
class Main extends App
{
    public function handle(): Response
    {
        $this->request = Request::get();

        try {
             $file = $this->getFile();
        } catch (\Exception $e) {
            return new Response(404, 'Not Found');
        }

        header('Cache-Control: no-cache');
        header('Content-Type: ' . $file->getMimeType());
        header('Content-Length: ' . $file->getContentLength());

        return new Response(200, 'Hello World!', [
            'body' => $file->getStream(),
        ]);
    }

    protected function getFile(): FileObject
    {
        $path = BASE_PATH. '/_site'. $this->request->path;

        if (file_exists($path)) {
            return new FileObject($path) ;
        }

        $path = BASE_PATH. '/_media'. $this->request->path;

        if (file_exists($path)) {
            return new FileObject($path) ;
        }

        $path = BASE_PATH.'/'. basename($this->request->path);

        if (file_exists($path)) {
            return new FileObject($path) ;
        }

        $path = BASE_PATH. '/_media/'. basename($this->request->path);

        if (file_exists($path)) {
            return new FileObject($path) ;
        }

        throw new \Exception('File not found', 404);
    }
}

class FileObject
{
    protected $internalPath;
    protected $mimeType;
    protected $contentLength;

    public function __construct(string $internalPath)
    {
        $this->internalPath = $internalPath;
    }

    public function getStream(): string
    {
        return file_get_contents($this->internalPath);
    }

    public function getMimeType(): string
    {
        $extension = pathinfo($this->internalPath, PATHINFO_EXTENSION);

        if ($extension === 'css') {
            return 'text/css';
        } elseif ($extension === 'js') {
            return 'application/javascript';
        } elseif ($extension === 'html') {
            return 'text/html';
        } elseif ($extension === 'md') {
            return 'text/markdown';
        } elseif ($extension === 'json') {
            return 'application/json';
        }

        return mime_content_type($this->internalPath);
    }

    public function getContentLength(): int
    {
        return filesize($this->internalPath);
    }
}

// Boot the Piko application with the Main class
Piko::boot(new Main());