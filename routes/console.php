<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Process\Process;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command(
    'tail {file=storage/logs/laravel.log : A path to the file being tailed. }
        {--only= : Only show lines containing this string. }
    ',
    function () {
        $command = 'tail -f "$FILE" | grep "$ONLY"';

        Process::fromShellCommandline($command)
            ->setTty(true)
            ->setTimeout(null)
            ->run(null, [
                'FILE' => $this->argument('file'),
                'ONLY' => $this->option('only'),
            ]);
    });
