<?php

namespace App\Http;

use Hyde\Framework\Contracts\AbstractPage;
use Hyde\Framework\Hyde;
use Hyde\Framework\Models\BladePage;
use Hyde\Framework\Models\DocumentationPage;
use Hyde\Framework\Models\MarkdownPage;
use Hyde\Framework\Models\MarkdownPost;
use Hyde\Framework\Modules\LiveServer\Actions\SourceFileFinder;
use Hyde\Framework\Services\DiscoveryService;
use Hyde\Framework\StaticPageBuilder;

class LiveCompiler extends StaticPageBuilder
{
    protected string $uri;
    private string $model;

    public function __construct(string $uri)
    {
        $this->uri = $uri;

        parent::__construct($this->parseSourceFile());
    }

    protected function parseSourceFile()
    {
        $path =  $this->getPath();
        $model = $this->model;

        return DiscoveryService::getParserInstanceForModel(
            $model,
            basename(
                str_replace(
                    DiscoveryService::getFilePathForModelClassFiles($model).'/',
                    '',
                    $path
                ),
                DiscoveryService::getFileExtensionForModelFiles($model)
            )
        )->get();
    }

    public function get(): string
    {
        return file_get_contents($this->__invoke());
    }

    private function getType(): string
    {
        if (str_starts_with($this->uri, '/posts/')) {
            $this->model = MarkdownPost::class;
            return '_posts';
        }

        if (str_starts_with($this->uri, '/docs/')) {
            $this->model = DocumentationPage::class;
            return '_docs';
        }

        // todo support markdown
        $this->model = BladePage::class;
        return '_pages';
    }

    private function getPath()
    {
        $path =Hyde::path($this->getType().'/'.basename($this->uri, '.html'));

        return  $path;
    }
}