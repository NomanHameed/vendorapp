<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Noman Hameed',
            'email' => 'nomanbutt8322@gmail.com',
            'password' => bcrypt('123456789')
        ]);
        $user = User::create([
            'name' => 'Vendor 1',
            'email' => 'vendor1@gmail.com',
            'password' => bcrypt('123456789')
        ]);
        $role = Role::create(['name' => 'Admin']);
        $permissions = Permission::pluck('id','id')->all();
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);
    }
}
