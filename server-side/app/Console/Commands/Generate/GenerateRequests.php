<?php

namespace App\Console\Commands\Generate;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class GenerateRequests extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:requests {name} {--type= : The type of structure (admin or user)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate request classes for a given name and type';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $name = $this->argument('name');
        $type = $this->option('type');

        // Validate the type
        if (!in_array($type, ['admin', 'user'])) {
            $this->error('Invalid structure type. Available types: admin, user');
            return;
        }

        // Set the parent folder
        $parentFolder = $type == 'admin' ? 'Admin' : 'User';

        $classNamespace = Str::beforeLast($name, '\\');
        $className = Str::afterLast($name, '\\');

        $directoryPath = app_path("Http/Requests/{$parentFolder}/{$classNamespace}");
        File::makeDirectory($directoryPath, 0755, true, true);

        $this->generateRequest('List', $className, 'ListRequest', $parentFolder, $classNamespace);
        $this->generateRequest('Create', $className, 'BaseRequest', $parentFolder, $classNamespace);
        $this->generateRequest('Read', $className, 'BaseRequest', $parentFolder, $classNamespace);
        $this->generateRequest('Update', $className, 'BaseRequest', $parentFolder, $classNamespace);
        $this->generateRequest('Delete', $className, 'BaseRequest', $parentFolder, $classNamespace);

        $this->info("Requests generated successfully.");
    }

    /**
     * Generate a request class based on the provided parameters.
     *
     * @param string $prefix
     * @param string $className
     * @param string $baseClass
     * @param string $parentFolder
     * @param string $classNamespace
     */
    private function generateRequest(string $prefix, string $className, string $baseClass, string $parentFolder, string $classNamespace): void
    {
        $stub = File::get(app_path('Console/Commands/Generate/Stubs/Request.stub'));
        $stub = str_replace('{{parentFolder}}', $parentFolder, $stub);
        $stub = str_replace('{{classNamespace}}', $classNamespace, $stub);
        $stub = str_replace('{{className}}', $prefix . $className, $stub);
        $stub = str_replace('{{baseClass}}', $baseClass, $stub);
        $path = app_path("Http/Requests/{$parentFolder}/{$classNamespace}/{$prefix}{$className}Request.php");
        File::put($path, $stub);
    }
}
