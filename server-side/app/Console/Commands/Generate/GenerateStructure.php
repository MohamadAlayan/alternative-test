<?php

namespace App\Console\Commands\Generate;

use Illuminate\Console\Command;

class GenerateStructure extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:structure {name} {--type= : The type of structure (admin or user)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the structure of the application for a given name';

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

        // Create Model
//        $this->call('make:model', [
//            'name' => $name . '/' . $name,
//        ]);

        // Create Controller
//        $this->call('make:controller', [
//            'name' => $parentFolder . '/' . $name . 'Controller'
//        ]);

        // Create Requests
        $this->call('generate:requests', [
            'name' => $name,
            '--type' => $type
        ]);

        // Create Repository
        $this->call('generate:repository', [
            'name' => $name,
        ]);

//        // Create Service
//        $this->call('make:service', [
//            'name' => $name . '/' . $name . 'Service',
//        ]);

        // Create Migration
        $this->call('make:migration', [
            'name' => 'create_' . $name . '_table',
        ]);

        // Create Seeder
        $this->call('make:seeder', [
            'name' => $name . 'Seeder',
        ]);

        // Create Factory
        $this->call('make:factory', [
            'name' => $name . 'Factory',
        ]);
//
//        // Create Test
//        $this->call('make:test', [
//            'name' => $name . '/' . $name . 'Test',
//        ]);
//
//        // Create Route
//        $this->call('make:route', [
//            'name' => $name . '/' . $name . 'Route',
//        ]);
    }
}
