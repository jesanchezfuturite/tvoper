<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class CampostypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */


    public function run()
    {
        
        DB::table('portal.campos_type')->insert([
	        [
	        'descripcion' 	=> 'input',
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'descripcion' 	=> 'textbox',
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'descripcion' 	=> 'select',
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'descripcion' 	=> 'multiple',
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'descripcion' 	=> 'option',
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'descripcion' 	=> 'checkbox',
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	    ]);

    }
}
