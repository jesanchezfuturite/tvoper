<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function(){
    if(getenv('APP_PREFIX')){
        $path = request()->getPathInfo();
        if(!preg_match('/'.getenv('APP_PREFIX').'/', $path)){
            return redirect(getenv('APP_PREFIX').$path);
        }
    }
});

Route::group(["prefix" => getenv("APP_PREFIX") ?? "/"], function(){
    Route::get('/', function () {
        return view('auth.login');
    });

    Auth::routes();

    Route::get('/home', 'HomeController@index')->name('home');

    /* conciliacion app */
    Route::get('/conciliacion-carga-archivo','ConciliacionController@index')->name('conciliacion-carga-archivo');
    Route::get('/conciliacion-results','ConciliacionController@results')->name('conciliacion-results');
    Route::post('/conciliacion-uploadfile','ConciliacionController@uploadFile')->name('conciliacion-uploadfile');
    Route::post('/conciliacion-getinfo','ConciliacionController@getInfo')->name('conciliacion-getinfo');
    Route::post('/conciliacion-detalle-anomalia','ConciliacionController@getAnomalia')->name('conciliacion-detalle-anomalia');

    /******************* motor de pagos app **********************/
    Route::get('/dias-feriados-inicio','MotorpagosController@diasferiados')->name('dias-feriados-inicio');
    Route::post('/dias-feriados-insert','MotorpagosController@insertDiasFeriados')->name('dias-feriados-insert');
    Route::post('/dias-feriados-eliminar','MotorpagosController@deletediasferiados')->name('dias-feriados-eliminar');
    Route::post('/dias-feriados-find','MotorpagosController@findDiasFeriados')->name('dias-feriados-find');
    Route::get('/crud-metodos-pago','MotorpagosController@crudmetodospago')->name('crud-metodos-pago');
    Route::get('/bancos','MotorpagosController@bancos')->name('bancos');
    Route::get('/cambiar-status-transaccion','MotorpagosController@cambiarstatustransaccion')->name('cambiar-status-transaccion');
    Route::get('/pago-tramite','MotorpagosController@pagotramite')->name('pago-tramite');
    /********************* Limite Referencia app **************/
    Route::get('/limite-referencia','MotorpagosController@limitereferencia')->name('limite-referencia');
    Route::post('/limite-referencia-deleted','MotorpagosController@deleteLimiteReferencia')->name('limite-referencia-deleted');
    Route::post('/limite-referencia-insert','MotorpagosController@insertLimiteReferencia')->name('limite-referencia-insert');
    Route::post('/limite-referencia-find','MotorpagosController@FindLimiteReferencia')->name('limite-referencia-find');
    Route::post('/limite-referencia-update','MotorpagosController@updateLimiteReferencia')->name('limite-referencia-update');
    Route::get('/limite-referencia-fin-all','MotorpagosController@limitereferenciaFindAll')->name('limite-referencia-fin');
    /******************** Banco ******************/
    Route::post('/banco-insert','MotorpagosController@insertBanco')->name('banco-insert');
    Route::post('/banco-find','MotorpagosController@findBanco')->name('banco-find');
    Route::post('/cuentasbanco-find','MotorpagosController@findCuentasBanco')->name('cuentasbanco-find');
    Route::post('/cuentasbanco-find-where','MotorpagosController@findCuentasBancoWhere')->name('cuentasbanco-find-where');
    Route::post('/cuentasbanco-edit','MotorpagosController@findCuenta_edit')->name('cuentasbanco-edit');
    Route::post('/cuentasbanco-insert','MotorpagosController@insertCuentasBanco')->name('cuentasbanco-insert');
    Route::post('/cuentasbanco-update','MotorpagosController@updateCuentasBanco')->name('cuentasbanco-update');
    Route::post('/cuentasbanco-desactiva','MotorpagosController@DesactivaCuentaBanco')->name('cuentasbanco-desactiva');
    Route::post('/banco-status-update','MotorpagosController@DesactivaBanco')->name('banco-status-update');
    Route::post('/banco-concilia-update','MotorpagosController@updateConciliaBanco')->name('banco-concilia-update');
    Route::post('/banco-update-imagen','MotorpagosController@updateBancoImagen')->name('banco-update-imagen');


    /*********************** Metodo Pago ***************/
    Route::get('/metodopago-find','MotorpagosController@findMetodopago')->name('metodopago-find');
    Route::get('/banco-find-all','MotorpagosController@findBancoAll')->name('banco-find-all');
    Route::get('/banco-find-allWhere','MotorpagosController@findBancoAllWhere')->name('banco-find-allWhere');

    /******************  Tipo Servicio  ***************/
    Route::get('/tiposervicio-find-all-where','MotorpagosController@findTipoServicioAllWhere')->name('tiposervicio-find-all');
    Route::get('/tiposervicio-find-all','MotorpagosController@findTipoServicioAll')->name('tiposervicio-find-all');
    Route::post('/entidad-find-all','MotorpagosController@findEntidadAll')->name('entidad-find-all');
    Route::post('/entidad-familia','MotorpagosController@entidadfamilia')->name('entidad-familia');


    /********************  metodo tipo PagoTramite  ***************/

    Route::post('/pagotramite-find','MotorpagosController@findTipoServicio')->name('pagotramite-find');
    Route::post('/pagotramite-insert','MotorpagosController@insertPagoTramite')->name('pagotramite-insert');
    Route::post('/pagotramite-find-where','MotorpagosController@findPagoTramiteWhere')->name('pagotramite-find-where');
    Route::post('/pagotramite-update','MotorpagosController@updatePagoTramite')->name('pagotramite-update');
    Route::post('/pagotramite-delete','MotorpagosController@deletePagoTramite')->name('pagotramite-delete');
    Route::post('/pagotramite-update-status','MotorpagosController@updateStatusPagoTramite')->name('pagotramite-update-status');

    /****************** Metodo Entidad **********/
    Route::get('/entidad','MotorpagosController@entidadView')->name('entidad');
    Route::get('/entidad-find','MotorpagosController@findentidad')->name('entidad-find');
    Route::post('/entidad-find-where','MotorpagosController@findentidadWhere')->name('entidad-find-where');
    Route::post('/entidad-insert','MotorpagosController@insertentidad')->name('entidad-insert');
    Route::post('/entidad-update','MotorpagosController@updateentidad')->name('entidad-update');
    Route::post('/entidad-delete','MotorpagosController@deleteentidad')->name('entidad-delete');

    /****************  Entidad Tramite********/
    Route::get('/entidad-tramite','MotorpagosController@entidadtramiteView')->name('entidad-tramite');
    Route::post('/entidad-tramite-find','MotorpagosController@findtramiteEntidad')->name('entidad-tramite-find');
    Route::post('/entidad-tramite-insert','MotorpagosController@insertentidadtramite')->name('entidad-tramite-insert');
    Route::post('/entidad-tramite-update','MotorpagosController@updateentidadtramite')->name('entidad-tramite-update');
    Route::post('/entidad-tramite-delete','MotorpagosController@deleteentidadtramite')->name('entidad-tramite-delete');
    Route::post('/entidad-tramite-find-where','MotorpagosController@findtramiteEntidadWhere')->name('entidad-tramite-find-where');
    Route::post('/entidad-tramite-find-id','MotorpagosController@findtramiteEntidadWhereID')->name('entidad-tramite-find-id');
    Route::post('/tipo-servicio-update-array','MotorpagosController@updateTipoServicioArray')->name('tipo-servicio-update-array');

    /*/************ Tipo Servicio**************/
    Route::get('/tipo-servicio','MotorpagosController@tiposervicio')->name('tipo-servicio');
    Route::get('/tipo-referencia-Find','MotorpagosController@tiporeferenciaFindAll')->name('tipo-referencia-Find');
    Route::post('/tipo-servicio-Find-where','MotorpagosController@findTipoServicio_whereId')->name('tipo-servicio-Find-where');
    Route::post('/tipo-servicio-insert','MotorpagosController@insertTipoServicio')->name('tipo-servicio-insert');

    Route::post('/tipo-servicio-update','MotorpagosController@updateTipoServicio')->name('tipo-servicio-update');
    Route::get('/tipo-servicio-find-all','MotorpagosController@findTipoServicioWhere')->name('tipo-servicio-find-all');
    Route::post('/tipo-servicio-delete','MotorpagosController@deleteTipoServicio')->name('tipo-servicio-delete');
    Route::post('/tipo-servicio-find-where-id','MotorpagosController@serviciosFindWhereID')->name('tipo-servicio-find-where-id');

    /****************** Estatus Transaccion ****************/
    Route::get('/status-find-all','MotorpagosController@statusFindAll')->name('status-find-all');
    Route::post('/transaccion-find-referencia','MotorpagosController@transaccionesFindWhere')->name('transaccion-find-referencia');
    Route::post('/transaccion-find-status','MotorpagosController@transaccionesFindWhereStatus')->name('transaccion-find-status');
    Route::post('/transaccion-update-status','MotorpagosController@updateTransaccionStatus')->name('transaccion-update-status');
    Route::post('/transaccion-find-status-oper','MotorpagosController@transaccionesFindWhereStatus_oper')->name('transaccion-find-status-oper');
    //Route::post('/transaccion-find-referencia-oper','MotorpagosController@transaccionesFindWhereReferencia_oper')->name('transaccion-find-referencia-oper');
    Route::post('/transaccion-update-status-oper','MotorpagosController@updateTransaccionStatus_oper')->name('transaccion-update-status-oper');

    /****************** PARTIDAS *******************************/
    Route::get('/partidas','MotorpagosController@partidas')->name('partidas');
    Route::get('/partidas-find-all','MotorpagosController@partidasFindAll')->name('partidas-find-all');
    Route::post('/partidas-insert','MotorpagosController@partidasInsert')->name('partidas-insert');
    Route::post('/partidas-find-where','MotorpagosController@partidasFindWhere')->name('partidas-find-where');
    Route::post('/partidas-update','MotorpagosController@partidasUpdate')->name('partidas-update');
    Route::post('/partidas-deleted','MotorpagosController@partidasDeleted')->name('partidas-deleted');
    Route::post('/partidas-where','MotorpagosController@partidasWhere')->name('partidas-where');



    /*/***************************CLASIFICADOR*********************************/
    Route::get('/clasificador','MotorpagosController@clasificador')->name('clasificador');
    Route::get('/clasificador-find-all','MotorpagosController@clasificadorFindAll')->name('clasificador-find-all');
    Route::post('/clasificador-insert','MotorpagosController@clasificadorInsert')->name('clasificador-insert');
    Route::post('/clasificador-find-where','MotorpagosController@clasificadorFindWhere')->name('clasificador-find-where');
    Route::post('/clasificador-update','MotorpagosController@clasificadorUpdate')->name('clasificador-update');
    Route::post('/clasificador-deleted','MotorpagosController@clasificadorDeleted')->name('clasificador-deleted');

    /*****************************TIPO REFERENCIA***************************************/
    Route::get('/tipo-referencia','MotorpagosController@tiporeferencia')->name('tipo-referencia');
    Route::get('/tipo-referencia-find-all','MotorpagosController@tiporeferenciaFindAll')->name('tipo-referencia-find-all');
    Route::post('/tipo-referencia-insert','MotorpagosController@tiporeferenciaInsert')->name('tipo-referencia-insert');
    Route::post('/tipo-referencia-find-where','MotorpagosController@tiporeferenciaFindWhere')->name('tipo-referencia-find-where');
    Route::post('/tipo-referencia-update','MotorpagosController@tiporeferenciaUpdate')->name('tipo-referencia-update');
    Route::post('/tipo-referencia-deleted','MotorpagosController@tiporeferenciaDeleted')->name('tipo-referencia-deleted');
    /************detalle de pago tramite***********/

    Route::get('/detalle-pago-tramite','MotorpagosController@detallepagotramite')->name('detalle-pago-tramite');
    Route::post('/pagotramite-find-all','MotorpagosController@findCuentasBancoAll')->name('pagotramite-find-all');

    /*********************CONSULTA TRAMITES***************************/

    Route::get('/consulta-transacciones','MotorpagosController@consultaTransacciones')->name('consulta-transacciones');
    Route::post('/consulta-transacciones-egob','MotorpagosController@consultaTransaccionesEgob')->name('consulta-transacciones-egob');
    Route::post('/consulta-transacciones-oper','MotorpagosController@consultaTransaccionesOper')->name('consulta-transacciones-oper');
    Route::post('/consulta-transacciones-gpm','MotorpagosController@consultaTransaccionesGpm')->name('consulta-transacciones-gpm');
    Route::post('/consulta-transacciones-tramites','MotorpagosController@consultaTransaccionesTramites')->name('consulta-transacciones-tramites');

    Route::get('/reporte-actualizaciones','MasterlogController@index')->name('reporte-actualizaciones');
    Route::post('/report-paid-operation','MasterlogController@consultamasterlog')->name('report-paid-operation');
    Route::get('/reporte-bitacora','BitacorawsbController@index')->name('reporte-bitacora');
    Route::post('/report-bitacora-wsbancos','BitacorawsbController@consultabitacora')->name('report-bitacora-wsbancos');
    Route::post('/export-bitacorawsb','BitacorawsbController@excelBitacora')->name('export-bitacorawsb');

    /************************ FAMILIA ***********************/
    Route::get('/familia','MotorpagosController@familia')->name('familia');
    Route::post('/familia-insert','MotorpagosController@familiaInsert')->name('familia-insert');
    Route::get('/familia-find-all','MotorpagosController@familiafindAll')->name('familia-find-all');
    Route::post('/familiaentidad-find','MotorpagosController@familiaentidadFindwhere')->name('familiaentidad-find');
    Route::post('/familiaentidad-insert','MotorpagosController@familientidadInsert')->name('familiaentidad-insert');
    Route::post('/familiaentidad-update','MotorpagosController@familientidadUpdate')->name('familiaentidad-update');
    Route::post('/familiaentidad-deleted','MotorpagosController@familientidadDeleted')->name('familiaentidad-deleted');
    Route::post('/familia-find-where','MotorpagosController@familiaFindWhere')->name('familia-find-where');
    Route::post('/familia-update','MotorpagosController@familiaUpdate')->name('familia-update');

    /*************************  INPC  ******************************/
    Route::get('/inpc','MotorpagosController@inpc')->name('inpc');
    Route::get('/inpc-find-all','MotorpagosController@inpcFindAll')->name('inpc-find-all');
    Route::post('/inpc-find-where','MotorpagosController@inpcFindWhere')->name('inpc-find-where');
    Route::post('/inpc-insert','MotorpagosController@inpcInsert')->name('inpc-insert');
    Route::post('/inpc-update','MotorpagosController@inpcUpdate')->name('inpc-update');
    Route::post('/inpc-deleted','MotorpagosController@inpcDeleted')->name('inpc-deleted');

    /*************************** RECARGOS SOBRE NOMINA ****************************/
    Route::get('/recargos','MotorpagosController@recargosNomina')->name('recargos');
    Route::get('/recargos-find-all','MotorpagosController@recargosFindAll')->name('recargos-find-all');
    Route::post('/recargos-find-where','MotorpagosController@recargosFindWhere')->name('recargos-find-where');
    Route::post('/recargos-insert','MotorpagosController@recargosInsert')->name('recargos-insert');
    Route::post('/recargos-update','MotorpagosController@recargosUpdate')->name('recargos-update');
    Route::post('/recargos-deleted','MotorpagosController@recargosDeleted')->name('recargos-deleted');


    /*******************************  UMA    ************************************/
    Route::get('/uma','MotorpagosController@umaHistory')->name('uma');
    Route::get('/uma-find-all','MotorpagosController@umaHistoryFindAll')->name('uma-find-all');
    Route::post('/uma-insert','MotorpagosController@umaHistoryInsert')->name('uma-insert');
    Route::post('/uma-find-where','MotorpagosController@umaHistoryFindWhere')->name('uma-find-where');
    Route::post('/uma-update','MotorpagosController@umaHistoryUpdate')->name('uma-update');
    Route::post('/uma-deleted','MotorpagosController@umaHistoryDeleted')->name('uma-deleted');

    /****************************  CURRENCIES  ***********************************/
    Route::get('/currencies-find-all','MotorpagosController@currenciesFindAll')->name('currencies-find-all');

    /**************************************/

    /**************************** SUBSIDIES  ******************************/
    Route::post('/subsidio-find-where','MotorpagosController@subsidioFindWhere')->name('subsidio-find-where');
    Route::post('/subsidio-insert','MotorpagosController@subsidioInsert')->name('subsidio-insert');
    Route::post('/subsidio-update','MotorpagosController@subsidioUpdate')->name('subsidio-update');

    /******************************** APPLICABLE SUBJECT ***************************/
    Route::get('/applicable-subject-find-all','MotorpagosController@applicablesubjectFindAll')->name('applicable-subject-find-all');

    /******************************** CALCULATE CONCEPTS *************************/
    Route::post('/calcula-find-where','MotorpagosController@calculoconceptoFindWhere')->name('calcula-find-where');
    Route::post('/calcula-insert','MotorpagosController@calculoconceptoInsert')->name('calcula-insert');
    Route::post('/calcula-update','MotorpagosController@calculoconceptoUpdate')->name('calcula-update');

    //Route::get('/envia-correo','ConciliacionController@enviacorreo');
    Route::get('/genera-archivo','CorteController@GeneraArchivo')->name('genera-archivo');

    /********************* Command  ************************/
    Route::get('/foo', function () {
        Artisan::queue('CorteSendEmail:SendEmail');
    });
    /* ws estado de cuenta icv */

    Route::get('/icv-consulta-placa/{info}/{key}','IcvrestserviceController@icvconsultaplaca')->name('icv-consulta-placa');

    /******************SERVICIOS GENERALES ---RETENCIONES AL MILLAR---******************/
    Route::get('/retencionesalmillar','ServiciosgeneralesController@retencionesAlMillar')->name('retencionesalmillar');
    Route::post('/acceso-partidas','ServiciosgeneralesController@accesopartidasFind')->name('acceso-partidas');
    Route::post('/proyecto-programas','ServiciosgeneralesController@proyectoprogramasFind')->name('proyecto-programas');
    Route::get('/reporte-retencionesalmillar','ServiciosgeneralesController@reporteretencionesalmillar')->name('reporte-retencionesalmillar');
    Route::post('/detallleaportacion-find','ServiciosgeneralesController@detalleaportacionFind')->name('detallleaportacion-find');
    Route::post('/generate','ServiciosgeneralesController@wsReferencia')->name('generate');
    /***********************PAGO ARRENDAMIENTO **************************/
    Route::get('/pagoarrendamiento','ServiciosgeneralesController@pagoArrendamiento')->name('pagoarrendamiento');
    Route::post('/pagoarrendamiento-insert','ServiciosgeneralesController@wsArrendamientoR')->name('pagoarrendamiento-insert');

    /************************ PAGO SERVICIOS GENERALES *******************/
    Route::get('/pagoservicios','ServiciosgeneralesController@pagoserviciosgenerales')->name('pagoservicios');



    /**************************** ENVIO CORTE POR CORREO  ***************************/
    Route::get('/envio-corte/{fecha}','CorteController@enviacorreo')->name('envio-corte');

    /**************************** TRAMITES NO CONCILIADOS  ***************************/
    Route::get('/tramites-no-conciliados','ConciliacionController@tramitesNoConciliados')->name('tramites-no-conciliados');
    Route::post('/find-tramites-no-conciliados','ConciliacionController@findTramitesnoconcilados')->name('find-tramites-no-conciliados');

    /****************************    CONTROL ACCESO SERVICIOS GENERALES *************************/
    Route::group(['middleware' => 'permissions'], function () {
        Route::get('/acceso-servicios','ServiciosgeneralesController@accesoServicios')->name('acceso-servicios');
        Route::get('/user-find-all','ServiciosgeneralesController@findUserAcceso')->name('user-find-all');
        Route::post('/insert-user','ServiciosgeneralesController@insertUser')->name('insert-user');
        Route::post('/find-user','ServiciosgeneralesController@findUser')->name('find-user');
        Route::post('/update-user','ServiciosgeneralesController@updateUser')->name('update-user');
        Route::post('/deleted-user','ServiciosgeneralesController@deletedUser')->name('deleted-user');
        Route::post('/load-menu-user','ServiciosgeneralesController@loadUserMenu')->name('load-menu-user');
        Route::post('/update-menu-user','ServiciosgeneralesController@saveMenuUSer')->name('update-menu-user');
        Route::post('/deleted-menu-user','ServiciosgeneralesController@deleteElementMenuUser')->name('deleted-menu-user');
        Route::post('/find-partidas-where','ServiciosgeneralesController@findPartidasWhere')->name('find-partidas-where');
        Route::post('/find-partidas-user','ServiciosgeneralesController@findPartidasWhereUser')->name('find-partidas-user');
        Route::post('/insert-partidas-user','ServiciosgeneralesController@insertPartidasUser')->name('insert-partidas-user');
        Route::post('/delete-partidas-user','ServiciosgeneralesController@deletePartidasUser')->name('delete-partidas-user');
        Route::get('/alta-partidas-servicios','ServiciosgeneralesController@altapartidas')->name('alta-partidas-servicios');
        Route::get('/servicios-partidas-findall','ServiciosgeneralesController@partidasFindAllServicios')->name('servicios-partidas-findall');
        Route::post('/servicios-partidas-insert','ServiciosgeneralesController@insertPartidasServicios')->name('servicios-partidas-insert');
        Route::post('/servicios-partidas-find','ServiciosgeneralesController@serviciosPartidasFindWhere')->name('servicios-partidas-find');
        Route::post('/servicios-partidas-update','ServiciosgeneralesController@serviciosPartidasUpdate')->name('servicios-partidas-update');
        Route::post('/servicios-partidas-delete','ServiciosgeneralesController@serviciosPartidasDeleted')->name('servicios-partidas-delete');



    });
    /*/*******************************************************************************/

    Route::group(['middleware' => 'permissions'], function () {
        Route::get('/register', 'Auth\RegisterController@showRegistrationForm')->name('register')->name('register');
        Route::get('/adminmenu', 'AdminMenuController@index')->name('adminmenu');
        Route::post('/adminmenu/saveMenu', 'AdminMenuController@saveMenu')->name('adminmenu/saveMenu');
        /* set the user menu tools */
        Route::get('/asignaherramientas', 'AsignaHerramientasController@index')->name('asignaherramientas');
        Route::post('/asignaherramientas/saveuserprofile', 'AsignaHerramientasController@saveUserProfile')->name('asignaherramientas/saveuserprofile');
        Route::post('/asignaherramientas/loaduserprofile', 'AsignaHerramientasController@loadUserProfile')->name('asignaherramientas/loaduserprofile');
        Route::post('/asignaherramientas/deleteelementuserprofile', 'AsignaHerramientasController@deleteElementUserProfile')->name('asignaherramientas/deleteelementuserprofile');


    });

    /* herramienta de cfdi */
    Route::group(['middleware' => ['verifyassignment']],function(){
    	Route::get('/cfdi-correccion', 'CorreccioncfdiController@index')->name('cfdi-tool');
    	Route::get('/cfdi-manual','ManualcfdiController@index')->name('cfdi-captura');
        Route::get('/cfdi-cancel','CorreccioncfdiController@cancel')->name('cfdi-cancel');
    });
    Route::post('/cfdi-correccion/busca-rfc','CorreccioncfdiController@searchrfc')->name('cfdi-correccion/busca-rfc');
    Route::post('/cfdi-correccion/busca-foliounico','CorreccioncfdiController@searchfoliounico')->name('cfdi-correccion/busca-foliounico');
    Route::post('/cfdi-correccion/edit','CorreccioncfdiController@edit')->name('cfdi-correccion/edit');
    Route::get('/cfdi-correccion/encabezado','CorreccioncfdiController@encabezado')->name('cfdi-correccion/encabezado');
    Route::get('/cfdi-correccion/detalle','CorreccioncfdiController@detalle')->name('cfdi-correccion/detalle');
    Route::post('/cfdi-manual/busca-datos','ManualcfdiController@datosfiscales')->name('cfdi-manual/busca-datos');
    Route::post('/cfdi-manual/busca-rfc','ManualcfdiController@searchrfc')->name('cfdi-manual/busca-rfc');
    Route::post('/cfdi-manual/savecfdi','ManualcfdiController@savecfdi')->name('cfdi-manual/savecfdi');


    /*************************    PORTAL    ******************************************/
    Route::get('/tramites-list-fields','PortaltramitesController@listFields')->name('tramites-list-fields');
    Route::post('/tramites-add-field','PortaltramitesController@newField')->name('tramites-add-field');
    Route::post('/tramites-edit-field','PortaltramitesController@editField')->name('tramites-edit-field');
    Route::post('/tramites-estatus', 'PortaltramitesController@fieldStatus')->name('tramites-estatus');

    Route::get('/traux-campos','PortaltramitesauxController@index')->name('traux-campos');
    Route::get('/traux-get-serv','PortaltramitesauxController@listarTramites')->name('traux-get-serv');
    Route::get('/traux-get-camp','PortaltramitesauxController@listarCampos')->name('traux-get-camp');
    Route::get('/traux-get-tcamp','PortaltramitesauxController@listarTipoCampos')->name('traux-get-tcamp');
    Route::post('/traux-get-relcamp','PortaltramitesauxController@listarRelacion')->name('traux-get-relcamp');
    Route::post('/traux-add-serv','PortaltramitesauxController@guardaTramite')->name('traux-add-serv');
    Route::post('/traux-edit-relcamp','PortaltramitesauxController@editarTramite')->name('traux-edit-relcamp');
    Route::post('/traux-del-relcamp','PortaltramitesauxController@eliminarTramite')->name('traux-del-relcamp');
    Route::get('/traux-get-partida', 'PortaltramitesauxController@listarPartidas')->name('traux-get-partida');
    Route::post('/traux-prelacion', 'PortaltramitesauxController@editPrelacion')->name('traux-prelacion');
    Route::post('/traux-divisa', 'PortaltramitesauxController@saveDivisa')->name('traux-divisa');



    Route::get('/solicitudes', 'PortalSolicitudesController@index')->name('solicitudes');
    Route::post('/solicitud-add', 'PortalSolicitudesController@crearSolicitud')->name('solicitud-add');
    Route::get('/solicitud-tramites', 'PortalSolicitudesController@getTramites')->name('solicitud-tramites');
    Route::get('/solicitud-all', 'PortalSolicitudesController@getSolicitudes')->name('solicitud-all');
    Route::get('/solicitud-getUsers', 'PortalSolicitudesController@getUsers')->name('solicitud-getUsers');
    Route::post('/solicitud-editar', 'PortalSolicitudesController@editarSolicitud')->name('solicitud-editar');
    Route::post('/solicitud-delete', 'PortalSolicitudesController@delete')->name('solicitud-delete');
    Route::get('/solicitud-documentos','PortalSolicitudesController@viewpermisosdocumentos')->name('solicitud-documentos');
    Route::post('/solicitud-find-folio','PortalSolicitudesController@findTicketidFolio')->name('solicitud-find-folio');
    Route::post('/solicitud-update-permisos','PortalSolicitudesController@updatePermisoSolicitud')->name('solicitud-update-permisos');
    Route::get('/solicitud-find-detalle/{idticket?}','PortalSolicitudesController@findDetalleSolicitud')->name('solicitud-find-detalle');

    Route::post('/solicitud-save-documento','PortalSolicitudesController@saveFile')->name('solicitud-save-documento');
    /*estas son para crear los tickets de solicitud*/
    Route::post('/solicitudes-registro', 'PortalSolicitudesController@registrarSolicitudes')->name('solicitudes-registro'); // este sirve para crear los tickets configurados y guardar los vakores iniciale de una solicitud


    Route::get('/traux-pago-costos','PortaltramitesauxController@Viewtipopagocosto')->name('traux-pago-costos');
    Route::get('/traux-get-tramites','PortaltramitesauxController@findTramites')->name('traux-get-tramites');
    Route::get('/traux-get-costos','PortaltramitesauxController@findCostos')->name('traux-get-costos');
    Route::get('/traux-get-cuota','PortaltramitesauxController@findValorcuota')->name('traux-get-cuota');
    Route::post('/traux-post-tramites','PortaltramitesauxController@insertCostos')->name('traux-post-tramites');
    Route::post('/traux-edit-tramites','PortaltramitesauxController@updateCostos')->name('traux-edit-tramites');
    Route::post('/traux-del-tramites','PortaltramitesauxController@updateStatusCostos')->name('traux-del-tramites');
    Route::post('/traux-post-subsidios','PortaltramitesauxController@updateSubsidio')->name('traux-post-subsidios');
    Route::post('/traux-add-caract', 'PortaltramitesauxController@addCaracteristics')->name('traux-add-caract');
    Route::get('/traux-get-reglas', 'PortaltramitesauxController@getReglas')->name('traux-get-reglas');
    Route::post('/traux-agrupacion', 'PortaltramitesauxController@listarAgrupacion')->name('traux-agrupacion');
    Route::get('/configuracion-tramites', 'PortaltramitesauxController@viewConfiguracion')->name('configuracion-tramites');
    Route::post('/guardar-agrupacion', 'PortaltramitesauxController@guardarAgrupacion')->name('guardar-agrupacion');
    Route::post('/guardar-orden', 'PortaltramitesauxController@guardarOrden')->name('guardar-orden');
    Route::get('/listarCategorias', 'PortaltramitesauxController@listCategory')->name('listarCategorias');
    Route::post('/addFile', 'PortaltramitesauxController@addFile')->name('addFile');
    Route::post('/guardar-orden-agrupacion', 'PortaltramitesauxController@saveOrdenAgrupacion')->name('guardar-orden-agrupacion');
    Route::post('/edit-agrupacion', 'PortaltramitesauxController@editAgrupacion')->name('edit-agrupacion');
    Route::post('/traux-edit-porcentaje','PortaltramitesauxController@savePorcentaje')->name('traux-edit-porcentaje');

    Route::post('/notary-offices', 'PortalNotaryOfficesController@createNotary')->name('notary-offices');
    Route::get('/notary-offices-get-users/{id}', 'PortalNotaryOfficesController@getUsers')->name('notary-offices-get-users');
    Route::get('/notary','PortalNotaryOfficesController@index')->name('notary');
    Route::post('/notary-offices-edit-user', 'PortalNotaryOfficesController@editUsersNotary')->name('notary-offices-edit-user');
    Route::post('/notary-offices-user-status', 'PortalNotaryOfficesController@status')->name('notary-offices-user-status');
    Route::post('/notary-offices-create-users', 'PortalNotaryOfficesController@createUsersNotary')->name('notary-offices-create-users');
    Route::get('/notary-offices-roles', 'PortalNotaryOfficesController@getRolesPermission')->name('notary-offices-roles');
    Route::get('/notary-offices-community/{id}', 'PortalNotaryOfficesController@listNotaryCommunity')->name('notary-offices-community');
    Route::get('/config-users', 'PortalNotaryOfficesController@viewUsers')->name('config-users');
    Route::post('/config-create-users', 'PortalNotaryOfficesController@createUsers')->name('config-create-users');
    Route::post('/notary-offices-update', 'PortalNotaryOfficesController@updateNotary')->name('notary-offices-update');
    Route::get('/get-notary-offices/{id}', 'PortalNotaryOfficesController@getNotary')->name('get-notary-offices');
    Route::post('/notary-offices-username', 'PortalNotaryOfficesController@searchUsername')->name('notary-offices-username');





    Route::get('/comunidades', 'OperacionRolesController@index')->name('comunidades');
    Route::get('/operacion-roles-create', 'OperacionRolesController@createRol')->name('operacion-roles-create');
    Route::post('/operacion-roles-add-tramite', 'OperacionRolesController@addTramite')->name('operacion-roles-add-tramite');
    Route::post('/operacion-roles-get-tramite/{id}', 'OperacionRolesController@getTramites')->name('operacion-roles-get-tramite');
    Route::post('/operacion-roles-edit-rol', 'OperacionRolesController@editRol')->name('operacion-roles-edit-rol');
    Route::post('/operacion-roles-eliminar-rol', 'OperacionRolesController@eliminarRol')->name('operacion-roles-eliminar-rol');
    Route::get('/operacion-roles-get-rol', 'OperacionRolesController@getRoles')->name('operacion-roles-get-rol');
    Route::get('/operacion-roles-get-tramites', 'OperacionRolesController@listTramites')->name('operacion-roles-get-tramites');

    Route::post('/filtrar-solicitudes', 'PortalSolicitudesController@filtrar')->name('filtrar-solicitudes');
    Route::get('/listado-solicitudes', 'PortalSolicitudesController@listSolicitudes')->name('listado-solicitudes');
    Route::get('/atender-solicitudes/{id}', 'PortalSolicitudesController@atenderSolicitud')->name('atender-solicitudes');
    Route::post('/guardar-solicitudes', 'PortalSolicitudesController@guardarSolicitud')->name('guardar-solicitudes');
    Route::post('/cerrar-ticket', 'PortalSolicitudesController@cerrarTicket')->name('cerrar-ticket');
    Route::get('/listado-mensajes/{id}', 'PortalSolicitudesController@getMensajes')->name('listado-mensajes');
    Route::get('/listado-download/{file}' , 'PortalSolicitudesController@downloadFile')->name('listado-download');
    Route::get('/get-route/{id}/{type}' , 'PortalSolicitudesController@getFileRoute')->name('get-route');
    Route::post('/solicitudes-update-status' , 'PortalSolicitudesController@updateStatus')->name('solicitudes-update-status');
    Route::get('/find-solicitudes' , 'PortalSolicitudesController@findSol')->name('find-solicitudes');
    Route::get('/get-motivos' , 'PortalSolicitudesController@getmotivos')->name('get-motivos');
    Route::post('/create-solicitud-motivo' , 'PortalSolicitudesController@createsolicitudMotivos')->name('create-solicitud-motivo');
    Route::get('/get-solicitudes-motivos/{solicitud_catalogo_id?}' , 'PortalSolicitudesController@getSolicitudesMotivos')->name('get-solicitudes-motivos');
    Route::post('/delete-solicitudes-motivos' , 'PortalSolicitudesController@deleteSolicitudMotivo')->name('delete-solicitudes-motivos');

    Route::get('/get-firma-find/{tramite_id?}', 'PortalSolicitudesController@findFirmaTramite')->name('get-firma-find');
    Route::post('/update-firma', 'PortalSolicitudesController@updateFirmaTramite')->name('update-firma');


    Route::post('/solicitudes-register', 'PortalSolicitudesTicketController@registrarSolicitud')->name("RegistrarSolicitud");
    Route::put('/solicitudes-discard/{id}', 'PortalSolicitudesTicketController@eliminarSolicitud')->name('solicitudes-discard');
    Route::get('/solicitudes-info/{id}/{type?}', 'PortalSolicitudesTicketController@getInfo')->name('solicitudes-info');
    Route::get('/solicitudes-detalle-tramite/{id}', 'PortalSolicitudesTicketController@detalleTramite')->name('solicitudes-detalle-tramite');
    Route::post('/solicitudes-update', 'PortalSolicitudesTicketController@updateTramite')->name('solicitudes-update');
    Route::post('/solicitudes-filtrar/{max?}', 'PortalSolicitudesTicketController@filtrarSolicitudes')->name('solicitudes-filtrar');
    Route::post('/save-transaccion', 'PortalSolicitudesTicketController@saveTransaccion')->name('save-transaccion');
    Route::post('/save-transaccion-motor', 'PortalSolicitudesTicketController@saveTransaccionMotor')->name('save-transaccion-motor');
    Route::post('/solicitudes-update-status-tramite', 'PortalSolicitudesTicketController@updateStatusTramite')->name('solicitudes-update-status-tramite');
    Route::post('/solicitudes-get-status', 'PortalSolicitudesTicketController@getStatus')->name('solicitudes-get-status');
    Route::post('/solicitudes-register-temporal', 'PortalSolicitudesTicketController@registrarSolicitud')->name("RegistrarSolicitudTemporal");
    Route::get('/solicitudes-get-tramite/{clave}', 'PortalSolicitudesTicketController@getRegistroTramite')->name('solicitudes-get-tramite');
    Route::post('/solicitudes-update-tramite', 'PortalSolicitudesTicketController@updateSolTramites')->name('solicitudes-update-tramite');
    Route::get('/solicitudes-get-tramite-pdf/{id}', 'PortalSolicitudesTicketController@getDataTramite')->name('solicitudes-get-tramite-pdf');
    Route::get('/download/{file?}' , 'PortalSolicitudesTicketController@downloadFile')->name('download');
    Route::post('/solicitudes-guardar-carrito' , 'PortalSolicitudesTicketController@enCarrito')->name('solicitudes-guardar-carrito');
    Route::get('/getInfoNormales/{folio}', 'PortalSolicitudesTicketController@getNormales')->name('getInfoNormales');

    Route::post('/solicitudes-filtrar/count', 'PortalSolicitudesTicketController@countFiltrado')->name('solicitudes-filtrar/count');
    Route::post('/save-files', 'PortalSolicitudesTicketController@saveFiles')->name('save-files');
    Route::post('/edit-solicitudes-info', 'PortalSolicitudesTicketController@editInfo')->name('edit-solicitudes-info');


    Route::get('/reglas-operativas', 'PortalReglaOperativaController@index')->name('reglas-operativas');
    Route::get('/reglas-tmt', 'PortalReglaOperativaController@getTramites')->name('reglas-tmt');
    Route::post('/reglas-tmt-relationship', 'PortalReglaOperativaController@getCampos')->name('reglas-tmt-relationship');
    Route::post('/reglas-cmp', 'PortalReglaOperativaController@getReglasCampos')->name('reglas-cmp');
    Route::post('/reglas-info', 'PortalReglaOperativaController@getReglas')->name('reglas-info');
    Route::post('/reglas-save', 'PortalReglaOperativaController@saveRegla')->name('reglas-save');


    Route::get('/avisos-internos', 'PortalAvisosInternosController@index')->name('avisos-internos');
    Route::get('/find-avisos', 'PortalAvisosInternosController@findNotifications')->name('find-avisos');
    Route::post('/create-avisos', 'PortalAvisosInternosController@createNotifications')->name('create-avisos');
    Route::post('/update-avisos', 'PortalAvisosInternosController@updateNotifications')->name('update-avisos');
    Route::post('/delete-avisos', 'PortalAvisosInternosController@deletedNotifications')->name('delete-avisos');


    Route::get('/obtener-divisas', 'DivisasController@getDivisas')->name('obtener-divisas');
    Route::post('/save-divisas', 'DivisasController@saveDivisas')->name('save-divisas');
    Route::post('/delete-divisas', 'DivisasController@deleteDivisas')->name('delete-divisas');
    Route::get('/get-divisas-save', 'DivisasController@getDivisasSave')->name('get-divisas-save');
    Route::get('/divisas', 'DivisasController@index')->name('divisas');
    Route::post('/obt-divisas-cambio', 'DivisasController@getCambioDivisa')->name('obt-divisas-cambio');

    /***************************apis webservice*************************************/
    Route::get('/insumos-catastro-consulta/{expediente}', 'ApiController@catastro_consulta')->name('insumos-catastro-consulta');
    Route::get('/transaccion-estatus/{transaccion}/{estatus}/{key}', 'ApiController@cambiaEstatusTransaccion')->name('transaccion-estatus');
    Route::get('/wsrp/{origen}', 'ApiController@registro_publico')->name('wsrp');
    Route::get('/wsent/{origen}', 'ApiController@entidades')->name('wsent');
    Route::get('/wsmun/{origen}/{clave_entidad}', 'ApiController@municipios')->name('wsmun');
    Route::get('/wsdis/{origen}/{clave_municipio}', 'ApiController@distritos')->name('wsdis');
    Route::get('/consultar-curp/{curp}', 'ApiController@curp')->name('consultar-curp');
    Route::get('/valor-catastral-notaria/{id}', 'ApiController@getValorCatastral')->name('valor-catastral-notaria');

    Route::get('/insumos-montos', 'ApiController@getMontoOperacion')->name('insumos-montos');

    Route::get('/aviso/{expediente}/{userid}/{tramite}', 'ApiController@getTicketsAviso')->name('aviso');



    Route::get('/obtener-estados', 'CatalogosController@getEntidad')->name('obtener-estados');
    Route::get('/obtener-municipios/{clave_estado}', 'CatalogosController@getMunicipios')->name('obtener-municipios');

    Route::get('/porcentaje-recargos', 'PortaltramitesauxController@viewPorcentajes')->name('porcentaje-recargos');
    Route::get('/porcentaje-find-all', 'PortaltramitesauxController@findPorcentajes')->name('porcentaje-find-all');
    Route::post('/porcentaje-insert', 'PortaltramitesauxController@insertPorcentajes')->name('porcentaje-insert');
    Route::post('/porcentaje-update', 'PortaltramitesauxController@updatePorcentajes')->name('porcentaje-update');
    Route::post('/porcentaje-deleted', 'PortaltramitesauxController@deletePorcentajes')->name('porcentaje-deleted');


    Route::get('/campo-alias-update','PortalSolicitudesTicketController@updateAlias')->name('campo-alias-update');
    Route::get('/reporte-usuarios', 'ReportesController@listadoUsuariosPortal')->name('reporte-usuarios');
    Route::post('/find-usuarios', 'ReportesController@findUsuarios')->name('find-usuarios');
    Route::post('/descargar-excel', 'ReportesController@excelUsuarios')->name("export");
    Route::post('/descargar-excel-notaria', 'ReportesController@excelNotaria')->name("export-notaria");
    Route::get('/file/{file?}' , 'ReportesController@downloadFile')->name('file');
    
    Route::get('/get-all-tramites/{user}', "Portal\ListController@getTramites");
});