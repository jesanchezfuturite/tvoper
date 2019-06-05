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
        DB::table('oper_menu')->insert('[]');
    }
}
