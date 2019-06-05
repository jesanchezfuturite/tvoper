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
        DB::table('oper_menu')->insert([
            'content' => '[{"info":{"title":"uno","route":"uno","id":1559342501898},"childs":[{"info":{"title":"tres","route":"tres","id":1559581699870,"id_father":"1559342501898"},"childs":[{"title":"ultimo","route":"u","id":1559582918202,"id_father":"1559581699870"},{"title":"prueba","route":"p","id":1559582926035,"id_father":"1559581699870"}]},{"info":{"title":"cuatro","route":"cuatro","id":1559581705549,"id_father":"1559342501898"},"childs":[{"title":"t","route":"tt","id":1559583628073,"id_father":"1559581705549"},{"title":"tttt","route":"t","id":1559583631151,"id_father":"1559581705549"}]},{"info":{"title":"cinco","route":"cinco","id":1559581716324,"id_father":"1559342501898"},"childs":[]}]},{"info":{"title":"dos","route":"dos","id":1559581298795},"childs":[{"info":{"title":"test","route":"test","id":1559581729442,"id_father":"1559581298795"},"childs":[]}]}]'
        ]);
    }
}
