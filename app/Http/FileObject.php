<?php

namespace App\Http;

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

        if (extension_loaded('fileinfo')) {
            return mime_content_type($this->internalPath);
        }

        return 'text/plain';
    }

    public function getContentLength(): int
    {
        return filesize($this->internalPath);
    }
}