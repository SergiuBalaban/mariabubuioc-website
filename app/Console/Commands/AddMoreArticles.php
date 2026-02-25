<?php

namespace App\Console\Commands;

use App\Models\Blog;
use Illuminate\Console\Command;

class AddMoreArticles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-articles';

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
    }
}
