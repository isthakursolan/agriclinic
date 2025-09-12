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
            'username' => 'farmer',
            'contact' => '1111111111'
        ]);
        profileModel::create([
            'fullname' => 'admin',
            'email' => 'admin@admin.com',
            'username' => 'admin',
            'contact' => '8888888888',
        ]);
        profileModel::create([
            'fullname' => 'superadmin',
            'email' => 'superadmin@admin.com',
            'username' => 'superadmin',
            'contact' => '7777777777',
        ]);
        profileModel::firstOrCreate([
            'email' => 'consultant@agriclinic.in',
            'fullname' => 'Test Consultant',
            'username' => 'consultant',
            'contact' => '9876567856'
        ]);
        profileModel::firstOrCreate([
            'email' => 'analyst@agriclinic.in',
            'fullname' => 'Test Analyst',
            'username' => 'analyst',
            'contact' => '8765453456',
        ]);
        profileModel::firstOrCreate([
            'email' => 'scientist@agriclinic.in',
            'fullname' => 'Test Scientist',
            'username' => 'scientist',
            'contact' => '8976980757',
        ]);
        profileModel::firstOrCreate([
            'email' => 'accountant@agriclinic.in',
            'fullname' => 'Test Accountant',
            'username' => 'accountant',
            'contact' => '9765765456',
        ]);
        profileModel::firstOrCreate([
            'email' => 'fieldagent@agriclinic.in',
            'fullname' => 'Test Field Agent',
            'username' => 'fieldagent',
            'contact' => '8795642468'
        ]);
        profileModel::firstOrCreate([
            'email' => 'frontoffice@agriclinic.in',
            'fullname' => 'Front Office Staff',
            'username' => 'frontoffice',
            'contact' => '7689765666',
        ]);
        profileModel::create([
            'fullname' => 'collection center',
            'email' => 'collection@agriclinic.in',
            'username' => 'collection',
            'contact' => '7656798767',
        ]);

        $user =  User::factory()->create([
            'name' => 'test',
            'email' => 'test@example.com',
            'username' => 'farmer',
            'contact' => '1111111111'
        ]);
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'username' => 'admin',
            'contact' => '8888888888',
            'password' => bcrypt('password')
        ]);
        $superadmin = User::create([
            'name' => 'superadmin',
            'email' => 'superadmin@admin.com',
            'username' => 'superadmin',
            'contact' => '7777777777',
            'password' => bcrypt('password')
        ]);
        $consultant = User::firstOrCreate([
            'email' => 'consultant@agriclinic.in',
            'name' => 'Test Consultant',
            'username' => 'consultant',
            'contact' => '9876567856',
            'password' => bcrypt('password')
        ]);
        $analyst = User::firstOrCreate([
            'email' => 'analyst@agriclinic.in',
            'name' => 'Test Analyst',
            'username' => 'analyst',
            'contact' => '8765453456',
            'password' => bcrypt('password')
        ]);
        $scientist = User::firstOrCreate([
            'email' => 'scientist@agriclinic.in',
            'name' => 'Test Scientist',
            'username' => 'scientist',
            'contact' => '8976980757',
            'password' => bcrypt('password')
        ]);
        $accountant = User::firstOrCreate([
            'email' => 'accountant@agriclinic.in',
            'name' => 'Test Accountant',
            'username' => 'accountant',
            'contact' => '9765765456',
            'password' => bcrypt('password')
        ]);
        $fieldAgent = User::firstOrCreate([
            'email' => 'fieldagent@agriclinic.in',
            'name' => 'Test Field Agent',
            'username' => 'fieldagent',
            'contact' => '8795642468',
            'password' => bcrypt('password')
        ]);
        $frontOffice = User::firstOrCreate([
            'email' => 'frontoffice@agriclinic.in',
            'name' => 'Front Office Staff',
            'username' => 'frontoffice',
            'contact' => '7689765666',
            'password' => bcrypt('password')
        ]);
        $collection = User::firstOrCreate([
            'name' => 'collection center',
            'email' => 'collection@agriclinic.in',
            'username' => 'collection_center',
            'contact' => '7656798767',
            'password' => bcrypt('password'),
        ]);

        $admin_role = Role::create(['name' => 'admin']);
        $farmer_role = Role::create(['name' => 'farmer']);
        $superadmin_role = Role::create(['name' => 'superadmin']);
        $consultant_role = Role::create(['name' => 'consultant']);
        $analyst_role = Role::create(['name' => 'analyst']);
        $labscientist_role = Role::create(['name' => 'lab_scientist']);
        $accountant_role = Role::create(['name' => 'accountant']);
        $fieldagent_role = Role::create(['name' => 'field_agent']);
        $frontoffice_role = Role::create(['name' => 'front_office']);
        $collection_role = Role::create(['name' => 'collection_center']);

        $user->assignRole($farmer_role);
        $admin->assignRole($admin_role);
        $superadmin->assignRole($superadmin_role);
        $consultant->assignRole($consultant_role);
        $analyst->assignRole($analyst_role);
        $frontOffice->assignRole($frontoffice_role);
        $fieldAgent->assignRole($fieldagent_role);
        $accountant->assignRole($accountant_role);
        $scientist->assignRole($labscientist_role);
        $collection->assignRole($collection_role);
    }
}
