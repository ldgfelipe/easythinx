<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Usuarios extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          DB::table('users')->insert([
            'name' => 'Administrador Easythinx',
            'email' => 'admin@easythinx.com',
            'password' => Hash::make('Easy1Thinx'),
            'tipo_usuario'=> 2, ///2 super admin cms, 1 administrador proyecto, 0 usuario normal invitado
        ]);
    }
}
