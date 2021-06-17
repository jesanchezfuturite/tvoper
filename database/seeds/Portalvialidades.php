<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class Portalvialidades extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('portal.vialidades')->insert([
	        [
	        'fixed_id' => 1,
	        'descripcion' => 'Ampliación' ,
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'fixed_id' => 2,
	        'descripcion' => 'Andador' ,
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'fixed_id' => 3,
	        'descripcion' => 'Avenida' ,
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'fixed_id' => 4,
	        'descripcion' => 'Boulevard' ,
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'fixed_id' => 5,
	        'descripcion' => 'Calle' ,
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'fixed_id' => 6,
	        'descripcion' => 'Circunvalación' ,
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'fixed_id' => 7,
	        'descripcion' =>'Circuito' ,
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'fixed_id' => 8,
	        'descripcion' =>'Cerrada' ,
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'fixed_id' => 9,
	        'descripcion' =>'Calzada' ,
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'fixed_id' => 10,
	        'descripcion' => 'Callejón' ,
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'fixed_id' => 11,
	        'descripcion' => 'Diagonal' ,
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'fixed_id' => 12,
	        'descripcion' => 'Corredor' ,
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'fixed_id' => 13,
	        'descripcion' => 'Continuación' ,
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'fixed_id' => 14,
	        'descripcion' => 'Eje Vial' ,
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'fixed_id' => 15,
	        'descripcion' => 'Viaducto' ,
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'fixed_id' => 16,
	        'descripcion' => 'Retorno' ,
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'fixed_id' => 17,
	        'descripcion' => 'Prolongación ' ,
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'fixed_id' => 18,
	        'descripcion' => 'Privada' ,
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'fixed_id' => 19,
	        'descripcion' => 'Periférico ' ,
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'fixed_id' => 20,
	        'descripcion' => 'Peatonal ' ,
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'fixed_id' => 21,
	        'descripcion' => 'Pasaje' ,
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'fixed_id' => 22,
	        'descripcion' => 'Carretera' ,
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'fixed_id' => 23,
	        'descripcion' => 'Camino' ,
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'fixed_id' => 24,
	        'descripcion' => 'Terracería' ,
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'fixed_id' => 25,
	        'descripcion' => 'Brecha' ,
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'fixed_id' => 26,
	        'descripcion' => 'Vereda' ,
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'fixed_id' => 27,
	        'descripcion' => 'Autopista' ,
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'fixed_id' => 28,
	        'descripcion' => 'Libramiento' ,
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	    ]);
    }
}
