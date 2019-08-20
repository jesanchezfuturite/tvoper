<?php

return array (
	"conciliacion_conf" => array (
		"afirmeGobMx" 			=>	
			array(
				"extension"		=> "txt",
				"lineExample"	=> "27/06/201900000000005100010000000000121412560624146225",
				"positions"		=> array
					(
					"month"			=> [3,2],
					"day" 			=> [0,2],
					"year"			=> [6,4],
					"amount"		=> [10,14],
					"id"			=> [36,8],
					"referencia"	=> [24,30],
					"origen"		=> [24,2],
					),
				"startFrom"		=> 0,
				"method"		=> 1,
			), 
		"afirmeVentanilla" 		=>
			array(
				"extension"	=> "txt",
				"lineExample"	=> "D0000391137808110010000000000121393260624181257                                                                                          2019062800000000016280001V0000000101121305MXP201906281507080000000000000000000000000000000000000000",
				"positions"		=> array
					(
					"month"			=> [141,2],
					"day" 			=> [143,2],
					"year"			=> [137,4],
					"amount"		=> [145,15],
					"id"			=> [29,8],
					"referencia"	=> [17,30],
					"origen"		=> [17,2],
					),
				"startFrom"		=> 'D',
				"method"		=> 1
			),
			/*
			para american express se separa todo en un arreglo con explode
			el valor del arreglo positions esta en relacion a los datos en lineExample
			*/
		"american"				=> //pendiente
			array(
				"extension"	=> "csv",
				"lineExample"	=> "AMEXGWS,12141757,27/06/2019 11:01,American Express,Captura,338.00,Aprobadas,376689xxxxx2009,MANUEL GARCIA GARZA,207799,0,660,Internet,No evaluado,No se requiere,Coincidencia parcial,Coincidencia,19062768696",
				"positions"		=> array
					(
					"month"		=> 2,
					"day" 		=> 2,
					"year"		=> 2,
					"amount"	=> 5,
					"id"		=> 1
					),
				"startFrom"		=> 1
			),
		"banamex"				=> // pendiente
			array(
				"extension"		=> "txt",
				"lineExample"	=> "1|28/06/19|A|15|00|519|1214381327|A|64,793.00|00092946",
				"positions"		=> array
					(
					"month"		=> 1,
					"day" 		=> 1,
					"year"		=> 1,
					"amount"	=> 8,
					"id"		=> 6 /* se descartan los ultimos dos digitos del id */ 
					),
				"startFrom"		=> 7 /* los movimientos comienzan con 1 en todos los archivos */
			),
		"banamexVentanilla"		=>
			array(
				"extension"	=> "txt",
				"lineExample"	=> "11906280000000000726000024144552010519712321128010000000000121442650624141203                                24         ",
				"positions"		=> array
					(
					"month"			=> [3,2],
					"day" 			=> [5,2],
					"year"			=> [1,2],
					"amount"		=> [7,15], /* se divide entre 100 para que nos regrese el numero en pesos y esta acumulado con el CostoMensajeria */
					"id"			=> [49,18], /* se descartan los ultimos dos digitos del id */ 
					"referencia"	=> [47,30],
					"origen"		=> [47,2],
					),
				"startFrom"		=> 1, /* los movimientos 1 al inicio de la linea se refiere a ingresos */
				"method"		=> 1
			),
		"bancomer"				=> // pendiente
			array(
				"extension"		=> "txt",
				"lineExample"	=> "00000000000012141368000000000STU34562019  1               3390.0000923934530000000000005052392019-06-27 07:29:01.770000 1         ************66292019-06-28 07:50:08.529901                            0.00 0",
				"positions"		=> array
					(
					"month"			=> [98,2],
					"day" 			=> [101,2],
					"year"			=> [93,4],
					"amount"		=> [43,22],
					"id"			=> [0,20], /* 20 posiciones a partir de 0 */ 
					),
				"startFrom"		=> 0, /*el archivo no tiene encabezados*/
				"method"		=> 1,
			),
		"bancomerVentanilla"	=>
			array(
				"extension"		=> "txt",
				"lineExample"	=> "1480138000000000000000000001800000000000002526107241682760000000000000.000000000000000.000000000000707.000003678562019-06-28SANTA CATA0204EFE",
				"positions"		=> array
					(
					"month"			=> [119,2],
					"day" 			=> [122,2],
					"year"			=> [114,4],
					"amount"		=> [89,16],
					"id"			=> [39,8], /* 20 posiciones a partir de 0 */ 
					"referencia"	=> [27,30],
					"origen"		=> [27,2],
					),
				"startFrom"		=> 0, /*el archivo no tiene encabezados y los registros comienzan con numero, sino se descartan*/
				"method"		=> 1
			),
		"banorteCheque"			=> array // pendiente
			(
				/* aqui se hace un explode a la linea por | */
				"extension"		=> "txt",
				"lineExample"	=> "0524310375|28/06/2019|0000000000|COM CHQ ELECCHE050534427Jun19|537|8502|$0.00|$52.50|$667,004.30|246915|COMISIONES POR ECHECK",
				"positions"		=> array
					(
					"month"		=> 1,
					"day" 		=> 1,
					"year"		=> 1,
					"amount"	=> 6, /* si la posicion 6 del arreglo es 0 entonces es otro tipo de movimiento diferente al ingreso*/
					"id"		=> 2 /* 20 posiciones a partir de 0, si este valor es igual a cero se descarta el registro */ 
					),
				"startFrom"		=> 0 /* todos los movimientos que comiencen con 0*/
			),
		"banorteNominas"		=>
			array(
				"extension"		=> "txt",
				"lineExample"	=> "2088469179574555003508I10400000000012559000000000000N00000000012559000000000000010000000000120648880624148284                                                                                                                        000101018846130316A00020190628**31620720000000                                                       003508",
				"positions"		=> array
					(
					"month"			=> [11,2],
					"day" 			=> [13,2],
					"year"			=> [7,4],
					"amount"		=> [53,16], /* se divide entre 100 para considerar los centavos*/
					"id"			=> [91,8], /* 8 posiciones a partir de 91 */ 
					"referencia"	=> [79,30],
					"origen"		=> [79,2],
					),
				"startFrom"		=> 2, /* todos los movimientos que comiencen con 2*/
				"method"		=> 1,
			),
		"banregioVentanilla"	=>
			array(
				"extension"		=> "txt",
				"lineExample"	=> "06/27/20190000000010800010000000000121198780624341207",
				"positions"		=> array
					(
					"month"			=> [0,2],
					"day" 			=> [3,2],
					"year"			=> [6,4],
					"amount"		=> [10,13], /* se divide entre 100 para considerar los centavos*/
					"id"			=> [35,8], /* 8 posiciones a partir de 91 */ 
					"referencia"	=> [23,30],
					"origen"		=> [23,2],
					),
				"startFrom"		=> 0, /* el archivo no tiene condiciones especiales o delimitadores */
				"method"		=> 1
			),
		"bazteca"				=> // pendiente
			array(
				"extension"		=> "txt",
				"lineExample"	=> "",
				"positions"		=> array
					(
					"month"		=> [56,2],
					"day" 		=> [58,2],
					"year"		=> [52,4],
					"amount"	=> [40,12], /* incluye un punto decimal en la formula original se elimina el punto y se divide entre 100*/
					"id"		=> [13,8] /* 8 posiciones a partir de 91 */ 
					),
				"startFrom"		=> 'D' /* considerar los movimientos que inicien con la letra D (depositos) */
			),
		"hsbc"					=> 
			array(
				"extension"		=> "txt",
				"lineExample"	=> "405756518620190627101115003980000000295700CR05503000000000000000000000010000000000121396370624141264          0000182408665CR",
				"positions"		=> array
					(
					"month"			=> [14,2],
					"day" 			=> [16,2],
					"year"			=> [10,4],
					"amount"		=> [29,13], /* se divide entre 100*/
					"id"			=> [82,8], /* 8 posiciones a partir de 91 */
					"referencia"	=> [70,30],
					"origen"		=> [70,2],
					),
				"startFrom"		=> 0, /* el archivo no tiene condiciones especiales o delimitadores */
				"method"		=> 1
			),
		"santanderVentanilla"	=> 
			array(
				"extension"		=> "txt",
				"lineExample"	=> "65506402461     06282019101201710000DEP EN EFECTIV                          +000000001297000000004773497701713619180000000000000222210324167274          ",
				"positions"		=> array
					(
					"month"			=> [16,2],
					"day" 			=> [18,2],
					"year"			=> [20,4],
					"amount"		=> [79,12], /* se divide entre 100*/
					"id"			=> [125,8], /* 8 posiciones a partir de 91 */ 
					"referencia"	=> [113,30],
					"origen"		=> [113,2],
					),
				"startFrom"		=> 0, /* el archivo no tiene condiciones especiales o delimitadores */
				"method"		=> 1
			),
		"scotiabankVentanilla"	=>
			array(
				"extension"		=> "txt",
				"lineExample"	=> "DMONTERREY, N.L001037000000000295700|010000000000121204020624141235|20190628||                                                                                                                                                                                                 20190628201906282019062820190628+00000000029570000100000000000   000000000295700112551063120351112035110000000000000001",
				"positions"		=> array
					(
					"month"			=> [283,2],
					"day" 			=> [285,2],
					"year"			=> [279,4],
					"amount"		=> [304,15], /* se divide entre 100*/
					"id"			=> [49,8],  /* 8 posiciones a partir de 91 */ 
					"referencia"	=> [37,30],
					"origen"		=> [37,2],
					),
				"startFrom"		=> 'D', /* considerar los movimientos que inicien con la letra D (depositos) */
				"method"		=> 1,
			),
		"telecomm"				=>
			array(
				"extension"	=> "txt",
				"lineExample"	=> "65506402461     06282019101201710000DEP EN EFECTIV                          +000000001297000000004773497701713619180000000000000222210324167274          ",
				"positions"		=> array
					(
					"month"			=> [2,2],
					"day" 			=> [0,2],
					"year"			=> [4,4],
					"amount"		=> [46,10], /* se divide entre 100*/
					"id"			=> [20,8], /* 8 posiciones a partir de 91 */ 
					"referencia"	=> [8,30],
					"origen"		=> [8,2],
					),
				"startFrom"		=> 0, /* el archivo no tiene condiciones especiales o delimitadores */
				"method"		=> 1,
			),
	)
);	
