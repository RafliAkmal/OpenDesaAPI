<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'role_name' => 'Super Admin',
            'role_desc' => 'Super Admin'
        ]);

        Role::create([
            'role_name' => 'Admin Desa',
            'role_desc' => 'Admin Desa'
        ]);

        Role::create([
            'role_name' => 'Admin Kecamatan',
            'role_desc' => 'Admin Kecamatan'
        ]);

        Role::create([
            'role_name' => 'Admin Puskesmas',
            'role_desc' => 'Admin Puskesmas'
        ]);

        Role::create([
            'role_name' => 'Admin Pendidikan',
            'role_desc' => 'Admin Pendidikan'
        ]);

        Role::create([
            'role_name' => 'Admin Komplain',
            'role_desc' => 'Admin Komplain'
        ]);

        Role::create([
            'role_name' => 'Administrator Web',
            'role_desc' => 'Administrator Web'
        ]);
    }
}
