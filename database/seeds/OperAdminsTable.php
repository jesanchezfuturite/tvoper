<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class OperAdminsTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('oper_administrators')->insert([
         	[
         		'name' => 'jesanchez.villanueva@gmail.com',
         		'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
         		'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
         	],
            [
            	'name' => 'cerdaduran@gmail.com',
         		'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
         		'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
         	],
        ]

    	);
    }
}
