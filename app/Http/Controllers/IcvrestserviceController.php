<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Storage;

use App\Repositories\IcvremotoreferenciaRepositoryEloquent;
use App\Repositories\IcvremotodetalleRepositoryEloquent;
use App\Repositories\TransaccionesRepositoryEloquent;
use App\Repositories\TramitesRepositoryEloquent;
use App\Repositories\DetalletramiteRepositoryEloquent;

class IcvrestserviceController extends Controller
{
    //
    protected $icv;
    protected $transacciones;
    protected $tramites;
    protected $detalleIcv;
    protected $detalleTramite;

    public function __construct(
        IcvremotoreferenciaRepositoryEloquent $icv,
        TransaccionesRepositoryEloquent $transacciones,
        TramitesRepositoryEloquent $tramites,
        IcvremotodetalleRepositoryEloquent $detalleIcv,
        DetalletramiteRepositoryEloquent $detalleTramite        
    )
    {

        $this->icv              = $icv;
        $this->transacciones    = $transacciones;
        $this->tramites         = $tramites;
        $this->detalleIcv       = $detalleIcv;
        $this->detalleTramite   = $detalleTramite;
    }

    /**
     * Este metodo recibe una cadena y valida si contiene numeros y letras y si la longitud esta entre 7 y 8 caracteres
     *
	 *
	 *
	 */

    public function icvconsultaplaca(Request $request)
    {

    	if(
    		preg_match('/^[a-zA-Z]+[a-zA-Z0-9._]+$/', $request->info)
    		&& ( strlen($request->info) == 7 || strlen($request->info) == 8 )
    	)
		{
			// buscar en ICV la placa solicitada
			try {
				
    			$placa = $request->info;

    			$data = $this->icv->findWhere( ['PLACA' => $placa . " "] );

    			if($data->count() > 1)
    			{
    				$message = "Existe más de un registro en ICV";
    				$response ["E01"]= $message ;
    				Log::info('[WS-icvconsultaplaca] - Más de una placa en Oracle ICV - ' . $placa);
  	
    			}elseif($data->count() == 1){
    				$message = array();
    				Log::info('[WS-icvconsultaplaca] - Placa - ' . $placa);
    				// insertar referencia en 
                    $answer = $this->insertarReferencia($data);
                    if( is_array($answer) )
                    {
                        // aqui recibo la referencia, monto
                        $response = $answer;
                    }else{
                        // aqui genero el mensaje de error 
                        $response ["E04"]= "Error al insertar referencia en el repositorio";
                    }
    			}else{
    				$message = "No existe información de la placa";
    				$response ["E02"]= $message;
    				Log::info('[WS-icvconsultaplaca] - E02 - ' . $placa);
    			}
			} catch ( \Exception $e) {
				$response ["FE-R"]= "Error al intentar obtener información de ICV";
				return response()->json($response,200,['Content-Type' => "json", 'charset' => 'utf-8'],JSON_UNESCAPED_UNICODE);			
			}			

            return response()->json($response);

		}else{
			$response ["E03"]= "No es una placa valida";
  			return response()->json($response);
		}

    }

    /**
     * Guardo la informacion de la referencia en el repositorio
     *
     * @param $data = objeto que tiene la información ICV y guarda en oper_transacciones
     *
     *
     * @return true / false si sucede algún error
     *
     */
    private function insertarReferencia($data)
    {
        $insert = array();

        foreach($data as $info)
        {
            $insert = array (
                "id_transaccion"            => 0,
                "fecha_limite_referencia"   => date("Y-m-t"),
                "fecha_transaccion"         => date("Y-m-d H:i:s"),
                "entidad"                   => 0,
                "estatus"                   => 60,
                "tipo_pago"                 => 12,
                "referencia"                => $info->linea_referencia,
                "importe_transaccion"       => $info->total
            );
        }

        try{
            $i = $this->transacciones->create(
                $insert
            );

            $first_level = $this->insertTramite($info,$i->id);

        }catch( \Exception $e ){
            dd($e->getMessage());
            return false;
        }

        return array( "referencia" => $info->linea_referencia , "monto" => $info->total );

    }

    /**
     * Insertar el registro en oper_tramites
     *
     * @param $info info from oracle / $id inserted in motor
     *
     *
     * @return true / false si sucede algún error
     *
     */
    private function insertTramite($info, $id)
    {
        $d = array(
            "id_transaccion"            => $id,
            // "id_tipo_servicio"          => $info->,
            "nombre"                    => $info->nombre,
            "apellido_paterno"          => $info->apellido_paterno,
            "apellido_materno"          => $info->apellido_materno,
            //"razon_social"      => $info->, /* no hay datos */
            "rfc"                       => $info->rfc,
            "curp"                      => $info->curp,
            "email"                     => $info->email,
            "calle"                     => $info->calle,
            "colonia"                   => $info->colonia,
            "numexterior"               => $info->numero_ext,
            "numinterior"               => $info->numero_int,
            "colonia"                   => $info->colonia,
            "codigopostal"              => $info->codigo_postal,
            "municipio"                 => $info->municipio,
            //"razon_social"      => $info->, /* no hay datos */
            "nombre_factura"            => $info->nombre,
            "apellido_paterno_factura"  => $info->apellido_paterno,
            "apellido_materno_factura"  => $info->apellido_materno,
            "rfc_factura"               => $info->rfc,
            "curp_factura"              => $info->curp,
            "email_factura"             => $info->email,
            "calle_factura"             => $info->calle,
            "colonia_factura"           => $info->colonia,
            "numexteior_factura"       => $info->numero_ext,
            "numinterior_factura"       => $info->numero_int,
            "colonia_factura"           => $info->colonia,
            "codigopostal_factura"      => $info->codigo_postal,
            "municipio_factura"         => $info->municipio,
        );

        try {
            $i = $this->tramites->create ( $d );

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
        return true;
    }

    /**
     * Insertar el registro en oper_detalle_tramite
     *
     * @param $info info from oracle / $id inserted in motor
     *
     *
     * @return true / false si sucede algún error
     *
     */
    private function insertDetalles($info,$id)
    {

        try {
            
            $detalle = $this->detalleIcv->findWhere( [ "guid" => $info->guid ] );

            foreach($detalle as $d)
            {
                $insert = array(
                    "id_tramite_motor"  => $id,
                    "concepto"          => $detalle->concepto,
                    "importe_concepto"  => $detalle->importe,
                    "partida"           => $detalle->partida 
                );

                $i = $this->detalleTramite->create( $insert );

            }

        } catch (Exception $e) {
            dd($e->getMessage());
        }

        return true;
    }

}
