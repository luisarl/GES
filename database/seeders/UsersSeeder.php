<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class UsersSeeder extends Seeder
{

  public function run()
  {
    User::create([
      'name' => 'Administrador',
      'email' => '2050desarrollo@gmail.com',
      'email' => '2050gerenciati@gmail.com',
      'password' => Hash::make('aceros'),
      'username' => 'administrador',
      'id_departamento' => '1',
    ])->assignRole('administrador');

    User::create([
      'name' => 'Patricia Rojas',
      'email' => 'gtiprocesos1@gmail.com',
      'email2' => '2050gerenciati@gmail.com',
      'password' => Hash::make('projas'),
      'username' => 'projas',
      'id_departamento' => '1',
    ])->assignRole('catalogador');             
 }

}
