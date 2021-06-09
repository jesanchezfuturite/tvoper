<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class InstitucionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('portal.instituciones')->insert([
	        [
                'descripcion' 	=> 'Infonavit',
                'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'descripcion' 	=> 'Fovissste',
                'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'descripcion' 	=> 'Isssteleon',
                'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
            ]       
	        
	    ]);
    }
}
