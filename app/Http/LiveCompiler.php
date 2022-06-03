<?php

namespace App\Http;

use Hyde\Framework\Services\DiscoveryService;
use Hyde\Framework\StaticPageBuilder;

class LiveCompiler extends StaticPageBuilder
{
    public function __construct(string $model, string $path)
    {
        parent::__construct($this->parseSourceFile($model, $path));
    }

    protected function parseSourceFile(string $model, string $path)
    {
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
        // @todo investigate overhead of this (compiling to to disk vs in memory)
        return file_get_contents($this->__invoke());
    }
}