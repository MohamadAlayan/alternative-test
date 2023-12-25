<?php

namespace App\Console\Commands\Generate;

use Illuminate\Console\Command;

class GenerateModel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:model {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a model for a given name';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {

    }
}
