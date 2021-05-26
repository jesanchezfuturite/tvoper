<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class TramitesRegistradoresSeeder8 extends Seeder
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
                'region_id' 	=>8,
                'tramite_id' 	=> 106,
                'region_id' 	=> 55,
                'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'region_id' 	=>8,
                'tramite_id' 	=> 458,
                'region_id' 	=> 55,
                'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'region_id' 	=>8,
                'tramite_id' 	=> 107,
                'region_id' 	=> 55,
                'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'region_id' 	=>8,
                'tramite_id' 	=> 446,
                'region_id' 	=> 55,
                'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'region_id' 	=>8,
                'tramite_id' 	=> 17, 
                'region_id' 	=>55,
                'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'region_id' 	=>8,
                'tramite_id' 	=>117,
                'region_id' 	=>55,
                'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
            ],
       
            [
                'region_id' 	=>8,
                'tramite_id' 	=> 118,
                'region_id' 	=>55,
                'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
            ],
    
         ]);
    }
}
