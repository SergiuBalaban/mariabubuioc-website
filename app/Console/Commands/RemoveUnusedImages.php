<?php

namespace App\Console\Commands;

use App\Models\Blog;
use App\Models\Project;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class RemoveUnusedImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:remove-unused-images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $pathStorage = public_path('storage');

        if (! File::exists($pathStorage)) {
            $this->logInfo("Storage path does not exist: {$pathStorage}", 'error');

            return;
        }

        $beforeCount = count(File::allFiles($pathStorage));
        $this->logInfo("Starting image cleanup. Total files before: {$beforeCount}");

        $usedImagesLookup = $this->getUsedImagesLookup();
        $storageFiles = File::allFiles($pathStorage);

        $removedFilesCount = 0;
        foreach ($storageFiles as $file) {
            $relativePath = $file->getRelativePathname();

            // Check if file is used based on its relative path
            if (! isset($usedImagesLookup[$this->normalizePath($relativePath)])) {
                File::delete($file->getPathname());
                $removedFilesCount++;
            }
        }

        $removedDirsCount = $this->removeEmptyDirectories($pathStorage);

        $afterCount = count(File::allFiles($pathStorage));

        $this->logInfo('Cleanup finished.');
        $this->logInfo("Files before: {$beforeCount}");
        $this->logInfo("Files after: {$afterCount}");
        $this->logInfo("Removed images: {$removedFilesCount}");
        $this->logInfo("Removed empty directories: {$removedDirsCount}");
    }

    /**
     * Get a lookup array of all used images relative paths.
     */
    private function getUsedImagesLookup(): array
    {
        $lookup = [];

        // Project covers
        Project::query()
            ->whereNotNull('cover')
            ->select('id', 'cover')
            ->cursor()
            ->each(function (Project $project) use (&$lookup) {
                $path = $this->normalizePath($project->cover);
                if ($path) {
                    $lookup[$path] = true;
                }
            });

        // Blog covers
        Blog::query()
            ->whereNotNull('cover')
            ->select('id', 'cover')
            ->cursor()
            ->each(function (Blog $blog) use (&$lookup) {
                $path = $this->normalizePath($blog->cover);
                if ($path) {
                    $lookup[$path] = true;
                }
            });

        // Project gallery images
        Project::query()
            ->whereNotNull('images')
            ->select('id', 'images')
            ->cursor()
            ->each(function (Project $project) use (&$lookup) {
                foreach ($project->images ?? [] as $image) {
                    $path = $this->normalizePath($image);
                    if ($path) {
                        $lookup[$path] = true;
                    }
                }
            });

        return $lookup;
    }

    /**
     * Normalize image path to a relative path within storage.
     */
    private function normalizePath(?string $path): string
    {
        if (empty($path)) {
            return '';
        }

        // Remove base URL if present
        $baseUrl = config('app.url').'/storage/';
        if (str_starts_with($path, $baseUrl)) {
            $path = str_replace($baseUrl, '', $path);
        }

        // Remove /storage/ or storage/ prefix
        $path = preg_replace('/^(\/?storage\/)/', '', $path);

        return ltrim($path, '/');
    }

    /**
     * Recursively remove empty directories.
     */
    private function removeEmptyDirectories(string $path): int
    {
        $count = 0;
        $directories = File::directories($path);

        foreach ($directories as $directory) {
            $count += $this->removeEmptyDirectories($directory);

            if (empty(File::allFiles($directory)) && empty(File::directories($directory))) {
                File::deleteDirectory($directory);
                $count++;
            }
        }

        return $count;
    }

    /**
     * Log message to console and log file.
     */
    private function logInfo(string $message, string $level = 'info'): void
    {
        match ($level) {
            'error' => $this->error($message),
            'warn' => $this->warn($message),
            default => $this->info($message),
        };

        Log::channel('single')->log($level === 'warn' ? 'warning' : $level, "[RemoveUnusedImages] {$message}");
    }
}
