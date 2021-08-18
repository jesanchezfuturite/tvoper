<?php

	
namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use App\Entities\PortalCatalogoescuelas;
use App\Repositories\PortalCatalogoescuelasRepositoryEloquent;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Guzzle\Http\Exception\ClientErrorResponseException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\BadResponseException;




class CatalogoEscuelas extends Command {

	/**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'CatalogoEscuelas:updateTable';
    protected $description = 'Actualiza o inserta los registros correspondientes al catalogo de escuelas';

    protected $catalogo;
    protected $escuela;

    public function __construct(PortalCatalogoescuelasRepositoryEloquent $catalogo)
    {
    	parent::__construct();

    	$this->catalogo = $catalogo;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // 
        Log::info('[CatalogoEscuela:updateTable] - Inicia el proceso');
        Log::info('[CatalogoEscuela:updateTable] - Realiza Request para obtener el catalogo completo');
        $this->actualizaCatalogo();
        Log::info('[CatalogoEscuela:updateTable] - Proceso Finalizado');
    
    }
	

	public function actualizaCatalogo()
    {

        try {

            $client = new \GuzzleHttp\Client();

            $response = $client->get(
                'https://sa.nl.gob.mx/Educacion/api/values//',
                [
                    'headers' => [
                        'Accept' => 'application/json',  
                    ]
                ]
            );

            $results = $response->getBody();
            $data = json_decode($results);
            // {"CCT":"04PES0006L","NombreEscuela":" JUVENTINO ROSAS","ClaveMunicipio":74,"NombreMunicipio":"CAMPECHE","ClaveColonia":1,"NombreColonia":"BENITO JUAREZ","Calle":"","NumExterior":0,"ClaveTurno":1,"NombreTurno":"MATUTINO","Mensaje":"","ClaveNivel":13,"NombreNivel":"Secundaria","ClaveEstatusCCT":3,"NombreEstatusCCT":"CLAUSURA"}
            Log::info("Datos totales obtenidos para actualizar o insertar => ". count($data->results));
            foreach ($data->results as $value) {
                
                $this->escuela = [
                    'cct' => !is_null($value->CCT) ? $value->CCT : 'N/A',
                    'nombre_escuela' => !is_null($value->NombreEscuela) ? $value->NombreEscuela : '',
                    'clave_municipio' => !is_null($value->ClaveMunicipio) ? $value->ClaveMunicipio : 0,
                    'nombre_municipio' => !is_null($value->NombreMunicipio) ? $value->NombreMunicipio : '',
                    'clave_colonia' => !is_null($value->ClaveColonia) ? $value->ClaveColonia : 0,
                    'nombre_colonia' => !is_null($value->NombreColonia) ? $value->NombreColonia : '',
                    'calle' => !is_null($value->Calle) ? $value->Calle : '',
                    'num_exterior' => !is_null($value->NumExterior) ? $value->NumExterior : 0,
                    'clave_turno' => !is_null($value->ClaveTurno) ? $value->ClaveTurno : 0,
                    'nombre_turno' => !is_null($value->NombreTurno) ? $value->NombreTurno : '',
                    'mensaje' => !is_null($value->Mensaje) ? $value->Mensaje : '',
                    'clave_nivel' => !is_null($value->ClaveNivel) ? $value->ClaveNivel : 0,
                    'nombre_nivel' => !is_null($value->NombreNivel) ? $value->NombreNivel : '',
                    'clave_estatus_cct' => !is_null($value->ClaveEstatusCCT) ? $value->ClaveEstatusCCT : 0,
                    'nombre_estatus_cct' => !is_null($value->NombreEstatusCCT) ? $value->NombreEstatusCCT : ''
                ];

                $this->catalogo->updateOrCreate($this->escuela,$this->escuela);
                
            }
            
        } catch (\Exception $e) {
            Log::info('Error al conseguir el catalgo');
            Log::info($e->getMessage());
        }
        
    }

}










