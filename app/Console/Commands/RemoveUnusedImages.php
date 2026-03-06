<?php

namespace App\Console\Commands;

use App\Models\Blog;
use App\Models\Project;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;

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

        $beforeCount = count(File::allFiles($pathStorage));
        $this->info("BEFORE CHECK - Storage Files: {$beforeCount}");

        $usedImages = $this->getUsedImages();
        $storageFiles = File::allFiles($pathStorage);

        $removedCount = 0;
        foreach ($storageFiles as $file) {
            $isUsed = collect($usedImages)->contains(
                fn ($image) => str_contains($image, $file->getFilename())
            );

            if (! $isUsed) {
                File::delete($file->getPathname());
                $removedCount++;
            }
        }

        $afterCount = count(File::allFiles($pathStorage));
        $this->info("AFTER CHECK - Storage Files: {$afterCount}");
        $this->info("Removed {$removedCount} unused images successfully.");
    }

    private function getUsedImages(): array
    {
        $projectCovers = Project::query()
            ->whereNotNull('cover')
            ->pluck('cover')
            ->toArray();

        $articleCovers = Blog::query()
            ->pluck('cover')
            ->toArray();

        $projectImages = [];
        Project::query()
            ->whereNotNull('images')
            ->chunk(100, function (Collection $projects) use (&$projectImages) {
                foreach ($projects as $project) {
                    array_push($projectImages, ...$project->images);
                }
            });

        return array_merge($projectCovers, $articleCovers, $projectImages);
    }
}
