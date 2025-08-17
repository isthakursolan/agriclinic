<?php

namespace Database\Seeders;

use App\Models\profileModel;
use App\Models\User;
use Spatie\Permission\Models\Permission;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        profileModel::create([
            'fullname' => 'test',
            'email' => 'test@example.com',
            'contact' => '1111111111'
        ]);
        profileModel::create([
            'fullname' => 'admin',
            'email' => 'admin@admin.com',
            'contact' => '8888888888',
        ]);
        profileModel::create([
            'fullname' => 'superadmin',
            'email' => 'superadmin@admin.com',
            'contact' => '7777777777',
        ]);

        $user = User::factory()->create([
            'name' => 'test',
            'email' => 'test@example.com',
            'contact' => '1111111111'

        ]);
        $admin = User::create([
            'name' => 'admin',
            'contact' => '8888888888',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password')
        ]);
        $superadmin = User::create([
            'name' => 'superadmin',
            'contact' => '7777777777',
            'email' => 'superadmin@admin.com',
            'password' => bcrypt('password')
        ]);
        $admin_role = Role::create(['name' => 'admin']);
        $farmer_role = Role::create(['name' => 'farmer']);
        $superadmin_role = Role::create(['name' => 'superadmin']);

        $user->assignRole($farmer_role);
        $admin->assignRole($admin_role);
        $superadmin->assignRole($superadmin_role);
    }
}
