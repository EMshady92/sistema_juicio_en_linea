<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('empleados')->insert([
    		'name' => 'RAUL', 
    		'apellido_p'  =>  'MASCULINO',
    		'apellido_m' => '', 
            'sexo' => 'MASCULINO',
    		'email' => 'raul.delhoyo@trijazac.gob.mx', 
    		'password' => '$2y$10$OexcQi0QQKDgAP6atkT5fOmFzWmIM5eIp7QbkZTOTCOsqyn.WE2de',
    		'passfirma' => 'omarcd780416@gmail.com', 
            'remember_token'=>'',
            'estado'  => 'HOMBRE',
            'funcion' => 'NORMAL',
            'tipo_usuario'=>'Activo',
            'captura'=>'Activo',
            'tipo_usuario'=>'Activo',
            'created_at'=>'Activo',
            'updated_at'=>'Activo',
            ]);
        //
    }
}
