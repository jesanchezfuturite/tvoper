<?php

use Illuminate\Database\Seeder;

class TramitesRegistradoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('portal.tramites_por_registrador')->insert([
	        [
                'registrador_id' 	=> 1,
                'tramite_id' 	=> 
                'region_id' 	=> ,
                'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'registrador_id' 	=> 2,
                'tramite_id' 	=>  ,
                'region_id' 	=> ,
                'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'registrador_id' 	=> 3,
                'tramite_id' 	=>  ,
                'region_id' 	=> ,
                'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'registrador_id' 	=> 4,
                'tramite_id' 	=>  ,
                'region_id' 	=> ,
                'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
            ],

            
            [
                'registrador_id' 	=> 5,
                'tramite_id' 	=>  ,
                'region_id' 	=> ,
                'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'registrador_id' 	=> 6,
                'tramite_id' 	=>,
                'region_id' 	=> ,
                'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'registrador_id' 	=> 7,
                'tramite_id' 	=> ,
                'region_id' 	=> ,
                'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
            ]      
	               
            [
                'registrador_id' 	=> 8,
                'tramite_id' 	=> ,
                'region_id' 	=> ,
                'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
            ]        
	              
	        
	    ]);
    }
}
