<?php

use App\Enums\UserStatus;
use App\Models\RoleAndPermission\Permission;
use App\Models\RoleAndPermission\Role;
use App\Models\User\User;
use Illuminate\Database\Migrations\Migration;


return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create permissions
        $permissions = [
            'users.list.admin',
            'users.create.admin',
            'users.read.admin',
            'users.update.admin',
            'users.delete.admin',
            'users.list.user',
            'users.create.user',
            'users.read.user',
            'users.update.user',
            'users.delete.user',
            'roles.list',
            'roles.create',
            'roles.read',
            'roles.update',
            'roles.delete',
            'permissions.list',
            'permissions.create',
            'permissions.read',
            'permissions.update',
            'permissions.delete',
        ];

        foreach ($permissions as $permission) {
           Permission::create(['name' => $permission]);
        }

        // Create roles
        $roles = [
            'super-admin',
            'admin',
        ];

        foreach ($roles as $role) {
           Role::create(['name' => $role]);
        }

        // Create first user
        $user = User::create([
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'email' => 'mohamadalayanlb@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('12345678'),
            'phone_dialing_number' => '961',
            'phone_number' => '03009290',
            'phone_verified_at' => now(),
            'status' => UserStatus::ACTIVE,
            'type' => \App\Enums\UserType::ADMIN->value,
        ]);

        $user->assignRole('super-admin');
    }
};
