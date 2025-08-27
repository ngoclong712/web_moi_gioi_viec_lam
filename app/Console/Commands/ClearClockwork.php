<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ClearClockwork extends Command
{
    protected $signature = 'clockwork:clear';
    protected $description = 'Clear Clockwork storage files';

    public function handle()
    {
        File::cleanDirectory(storage_path('clockwork'));
        $this->info('Clockwork storage cleared!');
    }
}
