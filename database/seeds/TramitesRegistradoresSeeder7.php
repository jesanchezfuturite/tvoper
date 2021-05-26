<?php

use Illuminate\Database\Seeder;

class TramitesRegistradoresSeeder7 extends Seeder
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
                'region_id' 	=>7,
                'tramite_id' 	=> 106,
                'region_id' 	=> 54,
                'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'region_id' 	=>7,
                'tramite_id' 	=> 458,
                'region_id' 	=> 54,
                'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'region_id' 	=>7,
                'tramite_id' 	=> 107,446
                'region_id' 	=> 54,
                'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'region_id' 	=>7,
                'tramite_id' 	=> 17, 
                'region_id' 	=>54,
                'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'region_id' 	=>7,
                'tramite_id' 	=>117,
                'region_id' 	=>54,
                'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
            ],
       
            [
                'region_id' 	=>7,
                'tramite_id' 	=> 118,
                'region_id' 	=>54,
                'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
            ],
    
         ]);
    }
}
