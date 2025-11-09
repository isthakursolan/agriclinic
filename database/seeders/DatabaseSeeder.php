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
        // Create users first, then profiles
        $user =  User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'test',
                'username' => 'farmer',
                'contact' => '1111111111',
                'password' => bcrypt('123456')
            ]
        );
        $admin = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'admin',
                'username' => 'admin',
                'contact' => '8888888888',
                'password' => bcrypt('123456')
            ]
        );
        $superadmin = User::firstOrCreate(
            ['email' => 'superadmin@admin.com'],
            [
                'name' => 'superadmin',
                'username' => 'superadmin',
                'contact' => '7777777777',
                'password' => bcrypt('123456')
            ]
        );
        $consultant = User::firstOrCreate(
            ['email' => 'consultant@agriclinic.in'],
            [
                'name' => 'Test Consultant',
                'username' => 'consultant',
                'contact' => '9876567856',
                'password' => bcrypt('123456')
            ]
        );
        $analyst = User::firstOrCreate(
            ['email' => 'analyst@agriclinic.in'],
            [
                'name' => 'Test Analyst',
                'username' => 'analyst',
                'contact' => '8765453456',
                'password' => bcrypt('123456')
            ]
        );
        $scientist = User::firstOrCreate(
            ['email' => 'scientist@agriclinic.in'],
            [
                'name' => 'Test Scientist',
                'username' => 'scientist',
                'contact' => '8976980757',
                'password' => bcrypt('123456')
            ]
        );
        $accountant = User::firstOrCreate(
            ['email' => 'accountant@agriclinic.in'],
            [
                'name' => 'Test Accountant',
                'username' => 'accountant',
                'contact' => '9765765456',
                'password' => bcrypt('123456')
            ]
        );
        $fieldAgent = User::firstOrCreate(
            ['email' => 'fieldagent@agriclinic.in'],
            [
                'name' => 'Test Field Agent',
                'username' => 'fieldagent',
                'contact' => '8795642468',
                'password' => bcrypt('123456')
            ]
        );
        $frontOffice = User::firstOrCreate(
            ['email' => 'frontoffice@agriclinic.in'],
            [
                'name' => 'Front Office Staff',
                'username' => 'frontoffice',
                'contact' => '7689765666',
                'password' => bcrypt('123456')
            ]
        );
        $collection = User::firstOrCreate(
            ['email' => 'collection@agriclinic.in'],
            [
                'name' => 'collection center',
                'username' => 'collection_center',
                'contact' => '7656798767',
                'password' => bcrypt('123456')
            ]
        );

        $admin_role = Role::firstOrCreate(['name' => 'admin']);
        $farmer_role = Role::firstOrCreate(['name' => 'farmer']);
        $superadmin_role = Role::firstOrCreate(['name' => 'superadmin']);
        $consultant_role = Role::firstOrCreate(['name' => 'consultant']);
        $analyst_role = Role::firstOrCreate(['name' => 'analyst']);
        $labscientist_role = Role::firstOrCreate(['name' => 'lab_scientist']);
        $accountant_role = Role::firstOrCreate(['name' => 'accountant']);
        $fieldagent_role = Role::firstOrCreate(['name' => 'field_agent']);
        $frontoffice_role = Role::firstOrCreate(['name' => 'front_office']);
        $collection_role = Role::firstOrCreate(['name' => 'collection_center']);

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

        // Create profiles for all users
        profileModel::firstOrCreate(
            ['user_id' => $user->id],
            [
                'fullname' => 'test',
                'email' => 'test@example.com',
                'username' => 'farmer',
                'contact' => '1111111111'
            ]
        );
        profileModel::firstOrCreate(
            ['user_id' => $admin->id],
            [
                'fullname' => 'admin',
                'email' => 'admin@admin.com',
                'username' => 'admin',
                'contact' => '8888888888',
            ]
        );
        profileModel::firstOrCreate(
            ['user_id' => $superadmin->id],
            [
                'fullname' => 'superadmin',
                'email' => 'superadmin@admin.com',
                'username' => 'superadmin',
                'contact' => '7777777777',
            ]
        );
        profileModel::firstOrCreate(
            ['user_id' => $consultant->id],
            [
                'email' => 'consultant@agriclinic.in',
                'fullname' => 'Test Consultant',
                'username' => 'consultant',
                'contact' => '9876567856'
            ]
        );
        profileModel::firstOrCreate(
            ['user_id' => $analyst->id],
            [
                'email' => 'analyst@agriclinic.in',
                'fullname' => 'Test Analyst',
                'username' => 'analyst',
                'contact' => '8765453456',
            ]
        );
        profileModel::firstOrCreate(
            ['user_id' => $scientist->id],
            [
                'email' => 'scientist@agriclinic.in',
                'fullname' => 'Test Scientist',
                'username' => 'scientist',
                'contact' => '8976980757',
            ]
        );
        profileModel::firstOrCreate(
            ['user_id' => $accountant->id],
            [
                'email' => 'accountant@agriclinic.in',
                'fullname' => 'Test Accountant',
                'username' => 'accountant',
                'contact' => '9765765456',
            ]
        );
        profileModel::firstOrCreate(
            ['user_id' => $fieldAgent->id],
            [
                'email' => 'fieldagent@agriclinic.in',
                'fullname' => 'Test Field Agent',
                'username' => 'fieldagent',
                'contact' => '8795642468'
            ]
        );
        profileModel::firstOrCreate(
            ['user_id' => $frontOffice->id],
            [
                'email' => 'frontoffice@agriclinic.in',
                'fullname' => 'Front Office Staff',
                'username' => 'frontoffice',
                'contact' => '7689765666',
            ]
        );
        profileModel::firstOrCreate(
            ['user_id' => $collection->id],
            [
                'fullname' => 'collection center',
                'email' => 'collection@agriclinic.in',
                'username' => 'collection',
                'contact' => '7656798767',
            ]
        );
    }
}
