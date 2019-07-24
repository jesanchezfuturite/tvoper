<?php

use Illuminate\Database\Seeder;

class OperMenuTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('oper_menu')->insert(
            [
            'content'    => '[]',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]
        );
    }
}
