<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Storage;

use Carbon\Carbon;

use App\Repositories\EgobiernoinpcRepositoryEloquent;
use App\Repositories\EgobiernoporcentajesRepositoryEloquent;
use App\Repositories\EgobiernodiasferiadosRepositoryEloquent;

class CalculoimpuestosController extends Controller
{
    //

    protected $inpc;
    protected $inpc_values;
    protected $porcentaje;
    protected $diasferiados;
    protected $a;
    protected $b;
    protected $c;
    protected $d;
    protected $e;
    protected $f;
    protected $g;
    protected $h;
    protected $fecha_escritura;
    protected $factor_actualizacion;
    protected $inpc_vencimiento;
    protected $inpc_reciente;


    public function __construct(
    	EgobiernoinpcRepositoryEloquent $inpc,
    	EgobiernoporcentajesRepositoryEloquent $porcentaje,
    	EgobiernodiasferiadosRepositoryEloquent $diasferiados
    )
    {

    	$this->inpc 		= $inpc;
    	$this->porcentaje 	= $porcentaje;
    	$this->diasferiados	= $diasferiados;

    	// obtener los dias inhabiles del año en curso
    	$this->inhabiles	= $this->getInhabiles(date('Y'));

    	$this->inpc_values			= $this->getInpcValues();
    	$this->porcentajes_values	= $this->getPorcentejesvalues();



    	$this->a 			= 0; //ganancia obtenida
    	$this->b 			= 0; //MONTO OBTENIDO CONFORME AL ARTICULO 127 LISR
    	$this->c 			= 0; //PAGO PROVISIONAL CONFORME AL ARTICULO 126 LISR
    	$this->d 			= 0; //IMPUESTO CORRESPONDIENTE A LA ENTIDAD FEDERATIVA
    	$this->e 			= 0; //PARTE ACTUALIZADA DEL IMPUESTO
    	$this->f 			= 0; //RECARGOS
    	$this->g 			= 0; //MULTA POR CORRECCION FISCAL
    	$this->h			= 0; //IMPORTE TOTAL



    }

    public function index()
    {

    	// mostrar la forma para ejemplo del calculo de declaracion normal
    	$fecha_escritura 			= '2020-11-1'; // sin ceros iniciales ej 2020-9-1 para primero de sept de 2020
    	$monto_operacion 			= 1500000;
    	$ganancia_obtenida 			= 850000; // puede ser mayor o igual al monto de operacion
    	$pago_provisional_lisr		= 40000;
    	$multa_correccion_fiscal	= 0;

    	$this->a 					= $ganancia_obtenida;
    	$this->c 					= $pago_provisional_lisr;
    	$this->g 					= $multa_correccion_fiscal;
    	$this->fecha_escritura		= $fecha_escritura;


 		$this->fecha_vencimiento	= $this->getVencimiento();
 		$this->inpc_periodo			= $this->getInpc($this->fecha_escritura); // getInpcperiodo en caso de que sea la fecha acumulada del año vigente
 		$this->fecha_actual			= date("Y-m-d");
 		$this->inpc_reciente		= $this->getInpc($this->fecha_actual);

 		$this->factor_actualizacion = $this->getFA();

 		$this->porcentaje_recargos	= $this->getPorcentajeregargos();



    	$this->calculo();

    	$results = array(
    		"Entradas" => array(
	    			"fecha_escritura" => $this->fecha_escritura,
	    			"monto_operacion" => $monto_operacion,
	    			"ganancia_obtenida" => $ganancia_obtenida,
	    			"pago provisional conforme al art 127 LISR" => $pago_provisional_lisr,
	    			"multa por correccion fiscal (g)" => $this->g,
	    		),
    		"Salidas" => array(
    			"Fecha Actual"				=> $this->fecha_actual,
    			"Fecha vencimiento" 		=> $this->fecha_vencimiento,
    			"Factor de Actualizacion" 	=> $this->factor_actualizacion,
    			"INPC Periodo reciente" 	=> $this->inpc_reciente,
    			"INPC Periodo" 				=> $this->inpc_periodo,
    			"Porcentaje de recargos"	=> $this->porcentaje_recargos,
	    		"A*(Ganancia Obtenida)" => $this->a,
	    		"B (Monto obtenido conforme al art 127 LISR)" => $this->b,
	    		"C*(Pago provisional conforme al art 126 LISR)" => $this->c,
	    		"D (Impuesto correspondiente a la entidad federativa)" => $this->d,
	    		"E (Parte actualizada del impuesto)" => $this->e,
	    		"F (Recargos)" => $this->f,
	    		"G*(Multa corrección fiscal)" => $this->g,
	    		"H (Importe total)" => $this->h,
    			),





    	);

    	dd($results);

    }

    /* este metodo realiza el calculo del impuesto a pagar */
    private function calculo()
    {
    	// obtener b monto obtenido conforme al articulo 127 LISR
    	$this->b = $this->a * .05;

    	// impuesto correspondiente a la entidad federativa
    	($this->b >= $this->c) ? $this->d = $this->c : $this->d = $this->b;

    	// parte actualizada del impuesto
    	$this->e = ($this->d * $this->factor_actualizacion) - $this->d;

    	// obtener los recargos
    	$this->f = ($this->d + $this->e) * $this->porcentaje_recargos;

    	// importe total
    	$this->h =  $this->d + $this->e + $this->f + $this->g ;


    }


    /* obtener el factor de actualizacion */
    private function getFA()
    {
    	// obtener el indice de la fecha de vencimiento
    	$factor = (round(($this->inpc_reciente/$this->inpc_periodo),4) < 1 ) ? 1 : round(($this->inpc_reciente/$this->inpc_periodo),4);

		return $factor;

    }

    /* obtener la fecha de vencimiento */

    /**
     *
     *
     * getVencimiento. utilizando la fecha de la escrituracion se obtiene la nueva
     * fecha, sumando 15 dias
     * en caso de ser festivo o sabado o domingo se determina el dia habil siguiente
     *
     *
    */

    private function getVencimiento()
    {
    	$vencimiento = date("Y-n-j", strtotime($this->fecha_escritura . "+ 15 days"));

    	$dia = date('w', strtotime($vencimiento));

    	$inhabil = 0;

    	if($dia == 0)
    	{
    		// es domingo
    		$vencimiento = date("Y-n-j", strtotime($vencimiento . "+ 1 days"));
    	}elseif($dia == 6){
    		// es sabado
    		$vencimiento = date("Y-m-j", strtotime($vencimiento . "+ 2 days"));
    	}

    	foreach($this->inhabiles as $fi)
    	{
    		if(strcmp($fi,$vencimiento))
    		{
    			$inhabil = 1;
    		}
    	}

    	// la fecha de vencimiento esta en un dia inhabil
    	if($inhabil == 1)
    	{
    		$vencimiento = date("Y-n-j", strtotime($vencimiento . "+ 1 days"));

    		$dia = date('w', strtotime($vencimiento));

    		if($dia == 0)
	    	{
	    		// es domingo
	    		$vencimiento = date("Y-n-j", strtotime($vencimiento . "+ 1 days"));
	    	}elseif($dia == 6){
	    		// es sabado
	    		$vencimiento = date("Y-m-j", strtotime($vencimiento . "+ 2 days"));
	    	}

	    	return $vencimiento;

    	}else{
    		return $vencimiento;
    	}



    }

    /**
     * getInhabiles. regresa los dias inhabiles del año
     *
     * @param year - entero que representa el año corriente
     *
     * @return array - con las fechas en la tabla
     *
     *
    */
    private function getInhabiles($year)
    {
    	try
    	{

    		$fechas = $this->diasferiados->findWhere( [ "Ano" => $year ] );
    		if($fechas->count() > 0)
    		{
    			$dates = array();
    			foreach($fechas as $f)
	    		{
	    			$dates []= $f->Ano."-".$f->Mes."-".$f->Dia;
	    		}

    		}else{
    			dd("CalculoimpuestosController::getInhabiles-No existen dias inhabiles en " . $year);
    		}


    		return $dates;

    	}catch( \Exception $e ){
    		dd("getInhabiles ERROR - " . $e->getMessage());
    	}
    }

    /**
     * getInpc. obtiene el inpc de una fecha
     *
     * @param fecha yyyy-m-d
     *
     * @return float
     *
     *
    */

    private function getInpc($fecha)
    {
    	$d = explode("-",$fecha);

    	$year 	= $d[0];
    	$month 	= $d[1];


    	// buscar en la tabla todos los factores que correspondan al año
    	try{

    		return $this->inpc_values[$year][$month];


    	}catch( \Exception $e ){
    		dd("CalculoimpuestosController::getInpc " . $e->getMessage());
    	}


    }

    /**
     * getInpcPeriodo. obtiene el inpc de una fecha
     *
     * @param fecha solo el año yyyy
     *
     * @return float
     *
     *
    */

    private function getInpcPeriodo($fecha)
    {
    	$d = explode("-",$fecha);

    	$year 	= $d[0];
    	$month 	= 1;


    	// buscar en la tabla todos los factores que correspondan al año
    	try{

    		return $this->inpc_values[$year][$month];


    	}catch( \Exception $e ){
    		dd("CalculoimpuestosController::getInpc " . $e->getMessage());
    	}


    }
    /**
     * getInpcValues. esta funcion regresa un arreglo por año y dentro un asociativo por mes y valor
     *
     * @param fecha yyyy-m-d
     *
     * @return float
     *
     *
    */
    private function getInpcValues()
    {
    	// obtener todos los valores de la tabla en orden descendiente
    	try
    	{
    		$list = $this->inpc
    			->orderBy('anio','DESC')
    			->orderBy('mes','ASC')
    			->all();


    		$years 	= array();

    		$months = array( 1,2,3,4,5,6,7,8,9,10,11,12 );

    		$years[]= (integer)date("Y");

    		$final = array();

    		foreach($list as $l)
    		{

    			if(!in_array((integer)$l->anio,$years))
    			{
    				$years[]= (integer)$l->anio;
    			}
    		}

    		foreach($years as $y)
    		{

    			$valores = array();

    			foreach($months as $m)
    			{
    				// buscar el valor en list
    				foreach($list as $l)
    				{
    					if((integer)$l->anio == $y && (integer)$l->mes == $m)
    					{
    						$valores [$m]= $l->indice;
    						break;
    					}
    				}
    				if(!isset($valores[$m])){

    					$valores[$m] = (isset($valores[$m-1])) ? $valores[$m-1] : 0 ;

    				}

    			}
    			$final[$y]= $valores;
    		}

    		return($final);

    	}catch( \Exception $e ){
    		dd("CalculoimpuestosController::getInpcValues " . $e->getMessage());
    	}
    }
    /**
     * getPorcentejesvalues. esta funcion regresa un arreglo por año y dentro un asociativo por mes y valor
     *
     * @param null
     *
     * @return array
     *
     *
    */
    private function getPorcentejesvalues()
    {
    	// obtener todos los valores de la tabla en orden descendiente
    	try
    	{
    		$list = $this->porcentaje
    			->orderBy('anio','DESC')
    			->orderBy('mes','ASC')
    			->all();

    		$years 	= array();

    		$months = array( 1,2,3,4,5,6,7,8,9,10,11,12 );

    		$years[]= (integer)date("Y");

    		$final = array();

    		foreach($list as $l)
    		{

    			if(!in_array((integer)$l->anio,$years))
    			{
    				$years[]= (integer)$l->anio;
    			}
    		}

    		foreach($years as $y)
    		{

    			$valores = array();

    			foreach($months as $m)
    			{
    				// buscar el valor en list
    				foreach($list as $l)
    				{
    					if((integer)$l->anio == $y && (integer)$l->mes == $m)
    					{
    						/*$valores [$m]= array(
    							"vencido" 	=> $l->vencido,
    							"requerido"	=> $l->requerido
    						);*/

    						if(strlen((string)$m) == 1)
    						{
    							$index = $y."0".$m;
    						}else{
    							$index = $y.$m;
    						}

    						$final[(integer)$index]= array(
    							"year"		=> $y,
    							"month"		=> $m,
    							"vencido" 	=> $l->vencido,
    							"requerido"	=> $l->requerido
    						);
    						break;
    					}
    				}
    				/*
    				if(!isset($valores[$m])){

    					//$valores[$m] = (isset($valores[$m-1])) ? $valores[$m-1] : 0 ;
    					$final[]= (isset($valores[$m-1])) ? $valores[$m-1] : 0 ;

    				}*/

    			}
    			//$final[$y]= $valores;
    		}

    		return($final);

    	}catch( \Exception $e ){
    		dd("CalculoimpuestosController::getInpcValues " . $e->getMessage());
    	}
    }
    /**
     * getPorcentejesvalues. esta funcion regresa un arreglo por año y dentro un asociativo por mes y valor
     *
     * @param null
     *
     * @return array
     *
     *
    */
    private function getPorcentajeregargos()
    {
    	/*
    	$this->fecha_escritura
		$this->fecha_vencimiento
		$this->fecha_actual
		*/
		$total = 0;

		$fa = strtotime($this->fecha_actual . " 00:00:00");
		$fv = strtotime($this->fecha_vencimiento . " 00:00:00");

		if($fa <= $fv){
			return $total;
		}else{
			// esta vencido por lo tanto corre recargos
			$fa = explode("-",$this->fecha_actual);
			$yi = $fa[0];  // año de inicio
			$mi = $fa[1];  // mes de inicio
 			$fe = explode("-",$this->fecha_escritura);
 			$yf = $fe[0];  // año de inicio
			$mf = $fe[1];  // mes de inicio


			if(strlen((string)$mi) == 1){
				$i = $yi."0".$mi;
			}else{
				$i = $yi.$mi;
			}

			$i = (integer)$i;

			if(strlen((string)$mf) == 1){
				$f = $yf."0".$mf;
			}else{
				$f = $yf.$mf;
			}
			$f = (integer)$f;
			//$count = 0;
			foreach($this->porcentajes_values as $p => $data)
			{
				if($p >= $i && $p <= $f)
				{
					$total += $data["vencido"];
				}
/*
				else{
					echo "\n--------";
					echo "\nfecha_actual=>  ";
					var_dump($this->fecha_actual);
					echo "\nfecha escritura =>  ";
					var_dump($this->fecha_escritura);
					echo "\np =>  ";
					var_dump($p);
					echo "\ni =>  ";
					var_dump($i);
					echo "\nf =>  ";
					var_dump($f);


					$count ++;
					if($count == 12)
						exit();

				}*/
			}

			return $total / 100;
		}
    }


}
