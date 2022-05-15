<?php

namespace App\Commands;

use Illuminate\Foundation\Console\TestMakeCommand as BaseTestMakeCommand;
use Illuminate\Support\Str;

/**
 * @internal Generate a test in the framework directory
 * 
 * Based on LaravelZero\Framework\Commands\TestMakeCommand
 */
final class MakeTestCommand extends BaseTestMakeCommand
{
   /** {@inheritdoc} */
   protected function getNameInput(): string
   {
       return ucfirst(parent::getNameInput());
   }

   /** {@inheritdoc} */
   protected function getStub(): string
   {
       $suffix = $this->option('unit') ? '.unit.stub' : '.stub';

       $relativePath = $this->option('pest')
           ? '/stubs/pest'.$suffix
           : '/stubs/test'.$suffix;

       return file_exists($customPath = $this->laravel->basePath(trim($relativePath, '/')))
           ? $customPath
           : __DIR__.$relativePath;
   }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return base_path('vendor/hyde/framework/tests').str_replace('\\', '/', $name).'.php';
    }
}
