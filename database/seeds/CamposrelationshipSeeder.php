<?php

use Illuminate\Database\Seeder;

class CamposrelationshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('portal.campos_relationship')->insert([
	        [
	        'descripcion' 	=> 'Escritura',
	        'status'		=> 1,
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        
	        
	    ]);
    }
}
