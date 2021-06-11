<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;

class ApiTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    protected $i = 12345;
    protected $s = 0;
    protected $k = "X8x7+QUsij2zTquc5ZsrDnBcZU7A4guF8uK8iPmj2w=";
    protected $badKey = "BADKEY";
    protected $o = "qa";
    protected $ex = "";
    protected $ce = 19;
    protected $cm = 70;
    protected $curp = "XEXX010101MNEXXXA8";
    protected $vc = "";

    public function testEmptyParamsCambiaEstatus()
    {   
        $response = $this->get('/transaccion-estatus');
        $this->assertEquals(404,$response->getStatusCode());       
    }

    public function testWrongTransactionCambiaEstatus()
    {
        $idtrans = 1;
        $response = $this->call('GET',"/transaccion-estatus/". $idtrans . "/" . $this->s . "/" . $this->k);
        $v = json_decode($response->original);
        $this->assertEquals(401,$v->code);
        $this->assertEquals("Existen el mismo numero de transaccion en mas de un registro",$v->response);   
    }

    public function testNotConnectionCambiaEstatus()
    {
        $host = config('database.connections.mysql6.host');

        config(['database.connections.mysql6.host' => '127.0.0.1']);
        $response = $this->call('GET',"transaccion-estatus/".$this->i."/".$this->s."/".$this->k);
        $v = json_decode($response->original);
        Log::info(json_encode($response));
        config(['database.connections.mysql6.host' => $host]);
    }

    public function testWrongKeyCambiaEstatus()
    {
        $key = $this->badKey;
        $id = $this->i;
        $st = $this->s;
        $response = $this->call('GET',"/transaccion-estatus/". $id . "/" . $st . "/" . $key);
        $v = json_decode($response->original);
        $this->assertEquals(400,$v->code);
        $this->assertEquals("La llave es incorrecta",$v->response);
    }

    public function testParamsRegistroPublico()
    {
        $origen = $this->o;
        $response = $this->call('GET','/wsrp/' . $origen);
        $this->assertEquals(200,$response->getStatusCode());
    }

    public function testParamsCatastroConsulta()
    {
        $expediente = $this->ex;
        $response = $this->call('GET',"/insumos-catastro-consulta/" . $expediente);
        $this->assertEquals(200,$response->getStatusCode());
    }

    // public function testEntidades()
    // {
    //     $origen = $this->o;
    //     $response = $this->call('GET','/wsent/' . $origen);
    //     $this->assertEquals(200,$response->getStatusCode());
    // }

    // public function testMunicipios()
    // {
    //     $origen = $this->o;
    //     $clave_entidad = $this->ce;
    //     $response = $this->call('GET','/wsmun/'.$origen.'/'.$clave_entidad);
    //     $this->assertEquals(200,$response->getStatusCode());
    // }

    // public function testDistritos()
    // {
    //     $origen = $this->o;
    //     $mun = $this->cm;
    //     $response = $this->call('GET','/wsdis/' . $origen . '/' . $mun);
    //     $this->assertEquals(200,$response->getStatusCode());
    // }

    public function testCurp()
    {
        $curp_id = $this->curp;
        $response = $this->call('GET','/consultar-curp/' . $curp_id);
        $this->assertEquals(200,$response->getStatusCode());
    }

    public function testValorCatastral()
    {
        $id = $this->vc;
        $response = $this->call('GET','/valor-catastral-notaria/' . $id);
        $this->assertEquals(200,$response->getStatusCode());
    }

    public function testInsumosMontos()
    {
        
    }
}
