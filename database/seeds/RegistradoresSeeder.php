<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class RegistradoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('portal.registradores')->insert([
	        [
                'descripcion' 	=> 'Registrador 1',
                'instituciones_id' 	=>"null",
                'municipios_id' 	=> json_encode(["70"]),
                'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'descripcion' 	=> 'Registrador 2',
                'instituciones_id' 	=>"null",
                'municipios_id' 	=>json_encode(["17", "31", "58"]),
                'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'descripcion' 	=> 'Registrador 3',
                'instituciones_id' 	=>"null",
                'municipios_id' 	=>json_encode(["28", "33" ,"53"]),
                'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'descripcion' 	=> 'Registrador 4',
                'instituciones_id' 	=>json_encode(["1", "2", "3"]),
                'municipios_id' 	=>json_encode(["15", "28", "30", "31", "36", "39", "47", "51", "58", "70"]),
                'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
            ],

            
            [
                'descripcion' 	=> 'Registrador 5',
                'instituciones_id' 	=>"null",
                'municipios_id' =>json_encode(["15", "20", "22", "30", "36", "39", "47", "51", "54", "55", "57"]),
                'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'descripcion' 	=> 'Registrador 7',
                'instituciones_id' 	=> json_encode(["1", "2", "3"]),
                'municipios_id' 	=> json_encode(["17", "20", "22", "33", "55", "57"]),
                'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'descripcion' 	=> 'Registrador 8',
                'instituciones_id' 	=>"null",
                'municipios_id' 	=>json_encode(["15","20","22","28","30","33","39","47","51", "55","56","57","58","70"]),
                'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
            ],     
	               
            [
                'descripcion' 	=> 'Registrador 9',
                'instituciones_id' 	=>json_encode(["1","2","3"]),
                'municipios_id' 	=>"null",
                'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
            ]        
	              
	        
	    ]);
    }
}
