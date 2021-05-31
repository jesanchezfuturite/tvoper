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
    protected $o = "qa";

    public function testEmptyParamsCambiaEstatus()
    {   
        $response = $this->get('/transaccion-estatus');
        $this->assertEquals(404,$response->getStatusCode());       
    }

    public function testWrongTransactionCambiaEstatus()
    {
        $idtrans = 1;
        $response = $this->call('GET',"/transaccion-estatus/$idtrans/".$this->s."/".$this->k);
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
        $key = "BadKey";
        $response = $this->call('GET',"/transaccion-estatus/12345/0/$key");
        $v = json_decode($response->original);
        $this->assertEquals(400,$v->code);
        $this->assertEquals("La llave es incorrecta",$v->response);
    }

    public function testEmptyWrongParamsRegistroPublico()
    {
        $origen = $this->o;
        $response = $this->call('GET','/wsrp/'.$origen);
        $this->assertEquals(200,$response->getStatusCode());
        dd($response);
    }
}
