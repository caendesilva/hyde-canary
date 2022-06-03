<?php

use Hyde\Framework\Actions\MarkdownConverter;
use Hyde\Framework\Models\DocumentationPage;

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(\LaravelZero\Framework\Kernel::class)->bootstrap();

$page = (new \Hyde\Framework\Models\Parsers\DocumentationPageParser('docs'));
$page->execute();
$page = $page->get();

view()->share('page', $page);
view()->share('currentPage', $page->getCurrentPagePath());


echo view('hyde::layouts/docs')->with([
	'title' => $page->title,
	'markdown' => MarkdownConverter::parse($page->body, DocumentationPage::class),
])->render();