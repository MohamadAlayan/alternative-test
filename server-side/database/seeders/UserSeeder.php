<?php

namespace Database\Seeders;

use App\Enums\UserType;
use App\Models\RoleAndPermission\Role;
use App\Models\User\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 50 unverified users
        User::factory(20)->unverified()->create();

        // Create 50 verified users
        User::factory(50)->verified()->create();

        // Create 10 admin users
        $adminRole = Role::where('name', 'admin')->first();
        User::factory()
            ->count(10)
            ->verified()
            ->type(UserType::ADMIN->value)
            ->create()
            ->each(function ($user) use ($adminRole) {
                $user->roles()->attach($adminRole);
            });
    }
}
