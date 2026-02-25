<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Project;
use Illuminate\Console\Command;

class AddMoreProjects extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-projects';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Category::query()->count() ?: Category::factory(5)->create();
        Project::factory(10)->create();
    }
}
