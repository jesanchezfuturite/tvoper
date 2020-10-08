<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class CamposcatalogueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('portal.campos_catalogue')->insert([
	        [
	        'descripcion' 	=> 'Escritura',
	        'status'		=> 1,
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'descripcion' 	=> 'Acta',
	        'status'		=> 1,
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'descripcion' 	=> 'Oficio',
	        'status'		=> 1,
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'descripcion' 	=> 'Municipio',
	        'status'		=> 1,
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'descripcion' 	=> 'Nombre',
	        'status'		=> 1,
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'descripcion' 	=> 'Apellido paterno',
	        'status'		=> 1,
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'descripcion' 	=> 'Apellido materno',
	        'status'		=> 1,
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'descripcion' 	=> 'Razón Social',
	        'status'		=> 1,
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'descripcion' 	=> 'Infonavit',
	        'status'		=> 1,
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'descripcion' 	=> 'Ingresado por',
	        'status'		=> 1,
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'descripcion' 	=> 'Valor ISAI',
	        'status'		=> 1,
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'descripcion' 	=> 'Recibo ISAI',
	        'status'		=> 1,
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'descripcion' 	=> 'Valor catastral',
	        'status'		=> 1,
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'descripcion' 	=> 'Valor de operacion',
	        'status'		=> 1,
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'descripcion' 	=> 'Subsidio',
	        'status'		=> 1,
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        
	    ]);
    }
}

