<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CleanStorage extends Command
{
    protected $signature = 'storage:clean {--force : Skip confirmation}';

    protected $description = 'Remove all files from client images, report images, and report PDFs';

    public function handle(): int
    {
        $disk = $this->choice('Which storage disk do you want to clean?', ['public', 'local (private)'], 0);

        $diskName = $disk === 'local (private)' ? 'local' : 'public';

        $directories = [
            'images/clients',
            'images/reports',
            'reports/pdfs',
        ];

        if (!$this->option('force') && !$this->confirm("This will permanently delete all files from the [{$diskName}] disk. Are you sure?")) {
            $this->info('Operation cancelled.');
            return self::SUCCESS;
        }

        foreach ($directories as $directory) {
            if (Storage::disk($diskName)->exists($directory)) {
                $files = Storage::disk($diskName)->allFiles($directory);
                $count = count($files);

                Storage::disk($diskName)->deleteDirectory($directory);
                Storage::disk($diskName)->makeDirectory($directory);

                $this->info("Deleted {$count} files from {$directory} ({$diskName} disk)");
            } else {
                $this->warn("Directory {$directory} does not exist on {$diskName} disk, skipping.");
            }
        }

        $this->info('Storage cleaned successfully.');

        return self::SUCCESS;
    }
}


