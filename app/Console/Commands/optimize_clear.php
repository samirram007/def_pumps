<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class optimize_clear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'optimize_clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear views, cache, config, route, and compiled files';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return $this->call('optimize:clear');
       // return Command::PhpArtisan('optimize:clear');
    }
}
