<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class Portalpaises extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        DB::table('portal.paises')->insert([
	        [
	        'catalog_key' => '00',
	        'entidad_federativa' => 'NO ESPECIFICADO' ,
	        'abreviatura' => 'NE',
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'catalog_key' => '01',
	        'entidad_federativa' => 'AGUASCALIENTES' ,
	        'abreviatura' => 'AS',
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'catalog_key' => '02',
	        'entidad_federativa' => 'BAJA CALIFORNIA' ,
	        'abreviatura' => 'BC',
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'catalog_key' => '03',
	        'entidad_federativa' => 'BAJA CALIFORNIA SUR' ,
	        'abreviatura' => 'BS',
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'catalog_key' => '04',
	        'entidad_federativa' => 'CAMPECHE' ,
	        'abreviatura' => 'CC',
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'catalog_key' => '05',
	        'entidad_federativa' => 'COAHUILA DE ZARAGOZA' ,
	        'abreviatura' => 'CL',
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'catalog_key' => '06',
	        'entidad_federativa' => 'COLIMA' ,
	        'abreviatura' => 'CM',
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'catalog_key' => '07',
	        'entidad_federativa' => 'CHIAPAS' ,
	        'abreviatura' => 'CS',
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'catalog_key' => '08',
	        'entidad_federativa' => 'CHIHUAHUA' ,
	        'abreviatura' => 'CH',
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'catalog_key' => '09',
	        'entidad_federativa' => 'CIUDAD DE MÉXICO' ,
	        'abreviatura' => 'DF',
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'catalog_key' => '10',
	        'entidad_federativa' => 'DURANGO' ,
	        'abreviatura' => 'DG',
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'catalog_key' => '11',
	        'entidad_federativa' => 'GUANAJUATO' ,
	        'abreviatura' => 'GT',
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'catalog_key' => '12',
	        'entidad_federativa' => 'GUERRERO' ,
	        'abreviatura' => 'GR',
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'catalog_key' => '13',
	        'entidad_federativa' => 'HIDALGO' ,
	        'abreviatura' => 'HG',
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'catalog_key' => '14',
	        'entidad_federativa' => 'JALISCO' ,
	        'abreviatura' => 'JC',
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'catalog_key' => '15',
	        'entidad_federativa' => 'MÉXICO' ,
	        'abreviatura' => 'MC',
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'catalog_key' => '16',
	        'entidad_federativa' => 'MICHOACÁN DE OCAMPO' ,
	        'abreviatura' => 'MN',
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'catalog_key' => '17',
	        'entidad_federativa' => 'MORELOS' ,
	        'abreviatura' => 'MS',
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'catalog_key' => '18',
	        'entidad_federativa' => 'NAYARIT' ,
	        'abreviatura' => 'NT',
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'catalog_key' => '19',
	        'entidad_federativa' => 'NUEVO LEÓN' ,
	        'abreviatura' => 'NL',
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'catalog_key' => '20',
	        'entidad_federativa' => 'OAXACA' ,
	        'abreviatura' => 'OC',
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'catalog_key' => '21',
	        'entidad_federativa' => 'PUEBLA' ,
	        'abreviatura' => 'PL',
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'catalog_key' => '22',
	        'entidad_federativa' => 'QUERÉTARO' ,
	        'abreviatura' => 'QT',
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'catalog_key' => '23',
	        'entidad_federativa' => 'QUINTANA ROO' ,
	        'abreviatura' => 'QR',
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'catalog_key' => '24',
	        'entidad_federativa' => 'SAN LUIS POTOSÍ' ,
	        'abreviatura' => 'SP',
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'catalog_key' => '25',
	        'entidad_federativa' => 'SINALOA' ,
	        'abreviatura' => 'SL',
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'catalog_key' => '26',
	        'entidad_federativa' => 'SONORA' ,
	        'abreviatura' => 'SR',
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'catalog_key' => '27',
	        'entidad_federativa' => 'TABASCO' ,
	        'abreviatura' => 'TC',
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'catalog_key' => '28',
	        'entidad_federativa' => 'TAMAULIPAS' ,
	        'abreviatura' => 'TS',
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'catalog_key' => '29',
	        'entidad_federativa' => 'TLAXCALA' ,
	        'abreviatura' => 'TL',
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'catalog_key' => '30',
	        'entidad_federativa' => 'VERACRUZ DE IGNACIO DE LA LLAVE' ,
	        'abreviatura' => 'VZ',
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'catalog_key' => '31',
	        'entidad_federativa' => 'YUCATÁN' ,
	        'abreviatura' => 'YN',
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'catalog_key' => '32',
	        'entidad_federativa' => 'ZACATECAS' ,
	        'abreviatura' => 'ZS',
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'catalog_key' => '88',
	        'entidad_federativa' => 'NO APLICA' ,
	        'abreviatura' => 'NA',
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	        [
	        'catalog_key' => '99',
	        'entidad_federativa' => 'SE IGNORA' ,
	        'abreviatura' => 'SI',
	        'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
	        ],
	    ]);
    }
}
