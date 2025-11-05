<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $superAdmin = User::create([
            'is_superAdmin' => true,
            'name' => 'Super Administrador',
            'nickname' => '@superAdmin',
            'username' => 'superadmin',
            'email' => 'superAdmin@mail.com',
            'password' => Hash::make('@superAdmin'),
            'role_id' => 4,
            'type_id' => 1,
        ]);

        // Asignar solo el rol
        $superAdmin->assignRole('AdministradorDireccion');
    }
}
