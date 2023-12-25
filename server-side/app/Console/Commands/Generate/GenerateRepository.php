<?php

namespace App\Console\Commands\Generate;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class GenerateRepository extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:repository {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new repository class for a given name';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $name = $this->argument('name');
        $classNamespace = Str::beforeLast($name, '\\');
        $className = Str::afterLast($name, '\\');

        $stub = File::get(app_path('Console/Commands/Generate/Stubs/Repository.stub'));
        $stub = str_replace('{{classNamespace}}', $classNamespace, $stub);
        $stub = str_replace('{{class}}', $className, $stub);

        $directoryPath = app_path("Repositories/{$classNamespace}");
        File::makeDirectory($directoryPath, 0755, true, true);

        $path = app_path("Repositories/{$classNamespace}/{$className}Repository.php");

        File::put($path, $stub);

        $this->info("Repository created successfully at {$path}");
    }
}
