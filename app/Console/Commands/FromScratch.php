<?php

namespace App\Console\Commands;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Project;
use Illuminate\Console\Command;

class FromScratch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:from-scratch';

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
        Blog::factory(10)->create();
        Category::query()->count() ?: Category::factory(5)->create();
        Project::factory(10)->create();
    }
}
