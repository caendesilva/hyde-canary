<?php

namespace App\Commands;

use Hyde\Framework\Hyde;
use LaravelZero\Framework\Commands\Command;

class HydeStartLiveServerCommand extends Command
{
    protected $signature = 'up';
    protected $description = 'Start the experimental live server.';

    public function handle()
    {
        $this->line('<info>Starting the server...</info> Press Ctrl+C to stop');
        $this->warn('This feature is experimental. Please report any issues on GitHub.');

        $command = "php -S localhost:3000 ". Hyde::path('app/Http/server.php');
        passthru($command);

        return 0;
    }
}
