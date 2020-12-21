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


Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/* conciliacion app */
Route::get('/conciliacion-carga-archivo','ConciliacionController@index');
Route::get('/conciliacion-results','ConciliacionController@results');
Route::post('/conciliacion-uploadfile','ConciliacionController@uploadFile');
Route::post('/conciliacion-getinfo','ConciliacionController@getInfo');
Route::post('/conciliacion-detalle-anomalia','ConciliacionController@getAnomalia');

/******************* motor de pagos app **********************/
Route::get('/dias-feriados-inicio','MotorpagosController@diasferiados');
Route::post('/dias-feriados-insert','MotorpagosController@insertDiasFeriados');
Route::post('/dias-feriados-eliminar','MotorpagosController@deletediasferiados');
Route::get('/crud-metodos-pago','MotorpagosController@crudmetodospago');
Route::get('/bancos','MotorpagosController@bancos');
Route::get('/cambiar-status-transaccion','MotorpagosController@cambiarstatustransaccion');
Route::get('/pago-tramite','MotorpagosController@pagotramite');
/********************* Limite Referencia app **************/
Route::get('/limite-referencia','MotorpagosController@limitereferencia');
Route::post('/limite-referencia-deleted','MotorpagosController@deleteLimiteReferencia');
Route::post('/limite-referencia-insert','MotorpagosController@insertLimiteReferencia');
Route::post('/limite-referencia-find','MotorpagosController@FindLimiteReferencia');
Route::post('/limite-referencia-update','MotorpagosController@updateLimiteReferencia');
Route::get('/limite-referencia-fin-all','MotorpagosController@limitereferenciaFindAll');
/******************** Banco ******************/
Route::post('/banco-insert','MotorpagosController@insertBanco');
Route::post('/banco-find','MotorpagosController@findBanco');
Route::post('/cuentasbanco-find','MotorpagosController@findCuentasBanco');
Route::post('/cuentasbanco-find-where','MotorpagosController@findCuentasBancoWhere');
Route::post('/cuentasbanco-edit','MotorpagosController@findCuenta_edit');
Route::post('/cuentasbanco-insert','MotorpagosController@insertCuentasBanco');
Route::post('/cuentasbanco-update','MotorpagosController@updateCuentasBanco');
Route::post('/cuentasbanco-desactiva','MotorpagosController@DesactivaCuentaBanco');
Route::post('/banco-status-update','MotorpagosController@DesactivaBanco');
Route::post('/banco-concilia-update','MotorpagosController@updateConciliaBanco');
Route::post('/banco-update-imagen','MotorpagosController@updateBancoImagen');


/*********************** Metodo Pago ***************/
Route::get('/metodopago-find','MotorpagosController@findMetodopago');
Route::get('/banco-find-all','MotorpagosController@findBancoAll');
Route::get('/banco-find-allWhere','MotorpagosController@findBancoAllWhere');

/******************  Tipo Servicio  ***************/
Route::get('/tiposervicio-find-all-where','MotorpagosController@findTipoServicioAllWhere');
Route::get('/tiposervicio-find-all','MotorpagosController@findTipoServicioAll');
Route::post('/entidad-find-all','MotorpagosController@findEntidadAll');
Route::post('/entidad-familia','MotorpagosController@entidadfamilia');


/********************  metodo tipo PagoTramite  ***************/

Route::post('/pagotramite-find','MotorpagosController@findTipoServicio');
Route::post('/pagotramite-insert','MotorpagosController@insertPagoTramite');
Route::post('/pagotramite-find-where','MotorpagosController@findPagoTramiteWhere');
Route::post('/pagotramite-update','MotorpagosController@updatePagoTramite');
Route::post('/pagotramite-delete','MotorpagosController@deletePagoTramite');
Route::post('/pagotramite-update-status','MotorpagosController@updateStatusPagoTramite');

/****************** Metodo Entidad **********/
Route::get('/entidad','MotorpagosController@entidadView');
Route::get('/entidad-find','MotorpagosController@findentidad');
Route::post('/entidad-find-where','MotorpagosController@findentidadWhere');
Route::post('/entidad-insert','MotorpagosController@insertentidad');
Route::post('/entidad-update','MotorpagosController@updateentidad');
Route::post('/entidad-delete','MotorpagosController@deleteentidad');

/****************  Entidad Tramite********/
Route::get('/entidad-tramite','MotorpagosController@entidadtramiteView');
Route::post('/entidad-tramite-find','MotorpagosController@findtramiteEntidad');
Route::post('/entidad-tramite-insert','MotorpagosController@insertentidadtramite');
Route::post('/entidad-tramite-update','MotorpagosController@updateentidadtramite');
Route::post('/entidad-tramite-delete','MotorpagosController@deleteentidadtramite');
Route::post('/entidad-tramite-find-where','MotorpagosController@findtramiteEntidadWhere');
Route::post('/entidad-tramite-find-id','MotorpagosController@findtramiteEntidadWhereID');
Route::post('/tipo-servicio-update-array','MotorpagosController@updateTipoServicioArray');

/*/************ Tipo Servicio**************/
Route::get('/tipo-servicio','MotorpagosController@tiposervicio');
Route::get('/tipo-referencia-Find','MotorpagosController@tiporeferenciaFindAll');
Route::post('/tipo-servicio-Find-where','MotorpagosController@findTipoServicio_whereId');
Route::post('/tipo-servicio-insert','MotorpagosController@insertTipoServicio');

Route::post('/tipo-servicio-update','MotorpagosController@updateTipoServicio');
Route::get('/tipo-servicio-find-all','MotorpagosController@findTipoServicioWhere');
Route::post('/tipo-servicio-delete','MotorpagosController@deleteTipoServicio');
Route::post('/tipo-servicio-find-where-id','MotorpagosController@serviciosFindWhereID');

/****************** Estatus Transaccion ****************/
Route::get('/status-find-all','MotorpagosController@statusFindAll');
Route::post('/transaccion-find-referencia','MotorpagosController@transaccionesFindWhere');
Route::post('/transaccion-find-status','MotorpagosController@transaccionesFindWhereStatus');
Route::post('/transaccion-update-status','MotorpagosController@updateTransaccionStatus');
Route::post('/transaccion-find-status-oper','MotorpagosController@transaccionesFindWhereStatus_oper');
//Route::post('/transaccion-find-referencia-oper','MotorpagosController@transaccionesFindWhereReferencia_oper');
Route::post('/transaccion-update-status-oper','MotorpagosController@updateTransaccionStatus_oper');

/****************** PARTIDAS *******************************/
Route::get('/partidas','MotorpagosController@partidas');
Route::get('/partidas-find-all','MotorpagosController@partidasFindAll');
Route::post('/partidas-insert','MotorpagosController@partidasInsert');
Route::post('/partidas-find-where','MotorpagosController@partidasFindWhere');
Route::post('/partidas-update','MotorpagosController@partidasUpdate');
Route::post('/partidas-deleted','MotorpagosController@partidasDeleted');
Route::post('/partidas-where','MotorpagosController@partidasWhere');



/*/***************************CLASIFICADOR*********************************/
Route::get('/clasificador','MotorpagosController@clasificador');
Route::get('/clasificador-find-all','MotorpagosController@clasificadorFindAll');
Route::post('/clasificador-insert','MotorpagosController@clasificadorInsert');
Route::post('/clasificador-find-where','MotorpagosController@clasificadorFindWhere');
Route::post('/clasificador-update','MotorpagosController@clasificadorUpdate');
Route::post('/clasificador-deleted','MotorpagosController@clasificadorDeleted');

/*****************************TIPO REFERENCIA***************************************/
Route::get('/tipo-referencia','MotorpagosController@tiporeferencia');
Route::get('/tipo-referencia-find-all','MotorpagosController@tiporeferenciaFindAll');
Route::post('/tipo-referencia-insert','MotorpagosController@tiporeferenciaInsert');
Route::post('/tipo-referencia-find-where','MotorpagosController@tiporeferenciaFindWhere');
Route::post('/tipo-referencia-update','MotorpagosController@tiporeferenciaUpdate');
Route::post('/tipo-referencia-deleted','MotorpagosController@tiporeferenciaDeleted');
/************detalle de pago tramite***********/

Route::get('/detalle-pago-tramite','MotorpagosController@detallepagotramite');
Route::post('/pagotramite-find-all','MotorpagosController@findCuentasBancoAll');

/*********************CONSULTA TRAMITES***************************/

Route::get('/consulta-transacciones','MotorpagosController@consultaTransacciones');
Route::post('/consulta-transacciones-egob','MotorpagosController@consultaTransaccionesEgob');
Route::post('/consulta-transacciones-oper','MotorpagosController@consultaTransaccionesOper');
Route::post('/consulta-transacciones-gpm','MotorpagosController@consultaTransaccionesGpm');

/************************ FAMILIA ***********************/
Route::get('/familia','MotorpagosController@familia');
Route::post('/familia-insert','MotorpagosController@familiaInsert');
Route::get('/familia-find-all','MotorpagosController@familiafindAll');
Route::post('/familiaentidad-find','MotorpagosController@familiaentidadFindwhere');
Route::post('/familiaentidad-insert','MotorpagosController@familientidadInsert');
Route::post('/familiaentidad-update','MotorpagosController@familientidadUpdate');
Route::post('/familiaentidad-deleted','MotorpagosController@familientidadDeleted');
Route::post('/familia-find-where','MotorpagosController@familiaFindWhere');
Route::post('/familia-update','MotorpagosController@familiaUpdate');

/*************************  INPC  ******************************/
Route::get('/inpc','MotorpagosController@inpc');
Route::get('/inpc-find-all','MotorpagosController@inpcFindAll');
Route::post('/inpc-find-where','MotorpagosController@inpcFindWhere');
Route::post('/inpc-insert','MotorpagosController@inpcInsert');
Route::post('/inpc-update','MotorpagosController@inpcUpdate');
Route::post('/inpc-deleted','MotorpagosController@inpcDeleted');

/*************************** RECARGOS SOBRE NOMINA ****************************/
Route::get('/recargos','MotorpagosController@recargosNomina');
Route::get('/recargos-find-all','MotorpagosController@recargosFindAll');
Route::post('/recargos-find-where','MotorpagosController@recargosFindWhere');
Route::post('/recargos-insert','MotorpagosController@recargosInsert');
Route::post('/recargos-update','MotorpagosController@recargosUpdate');
Route::post('/recargos-deleted','MotorpagosController@recargosDeleted');


/*******************************  UMA    ************************************/
Route::get('/uma','MotorpagosController@umaHistory');
Route::get('/uma-find-all','MotorpagosController@umaHistoryFindAll');
Route::post('/uma-insert','MotorpagosController@umaHistoryInsert');
Route::post('/uma-find-where','MotorpagosController@umaHistoryFindWhere');
Route::post('/uma-update','MotorpagosController@umaHistoryUpdate');
Route::post('/uma-deleted','MotorpagosController@umaHistoryDeleted');

/****************************  CURRENCIES  ***********************************/
Route::get('/currencies-find-all','MotorpagosController@currenciesFindAll');

/**************************************/

/**************************** SUBSIDIES  ******************************/
Route::post('/subsidio-find-where','MotorpagosController@subsidioFindWhere');
Route::post('/subsidio-insert','MotorpagosController@subsidioInsert');
Route::post('/subsidio-update','MotorpagosController@subsidioUpdate');

/******************************** APPLICABLE SUBJECT ***************************/
Route::get('/applicable-subject-find-all','MotorpagosController@applicablesubjectFindAll');

/******************************** CALCULATE CONCEPTS *************************/
Route::post('/calcula-find-where','MotorpagosController@calculoconceptoFindWhere');
Route::post('/calcula-insert','MotorpagosController@calculoconceptoInsert');
Route::post('/calcula-update','MotorpagosController@calculoconceptoUpdate');

//Route::get('/envia-correo','ConciliacionController@enviacorreo');
Route::get('/genera-archivo','CorteController@GeneraArchivo');

/********************* Command  ************************/
Route::get('/foo', function () {
    Artisan::queue('CorteSendEmail:SendEmail');
});
/* ws estado de cuenta icv */

Route::get('/icv-consulta-placa/{info}/{key}','IcvrestserviceController@icvconsultaplaca');

/******************SERVICIOS GENERALES ---RETENCIONES AL MILLAR---******************/
Route::get('/retencionesalmillar','ServiciosgeneralesController@retencionesAlMillar');
Route::post('/acceso-partidas','ServiciosgeneralesController@accesopartidasFind');
Route::post('/proyecto-programas','ServiciosgeneralesController@proyectoprogramasFind');
Route::get('/reporte-retencionesalmillar','ServiciosgeneralesController@reporteretencionesalmillar');
Route::post('/detallleaportacion-find','ServiciosgeneralesController@detalleaportacionFind');
Route::post('/generate','ServiciosgeneralesController@wsReferencia');
/***********************PAGO ARRENDAMIENTO **************************/
Route::get('/pagoarrendamiento','ServiciosgeneralesController@pagoArrendamiento');
Route::post('/pagoarrendamiento-insert','ServiciosgeneralesController@wsArrendamientoR');

/************************ PAGO SERVICIOS GENERALES *******************/
Route::get('/pagoservicios','ServiciosgeneralesController@pagoserviciosgenerales');



/**************************** ENVIO CORTE POR CORREO  ***************************/
Route::get('/envio-corte/{fecha}','CorteController@enviacorreo');

/**************************** TRAMITES NO CONCILIADOS  ***************************/
Route::get('/tramites-no-conciliados','ConciliacionController@tramitesNoConciliados');
Route::post('/find-tramites-no-conciliados','ConciliacionController@findTramitesnoconcilados');

/****************************    CONTROL ACCESO SERVICIOS GENERALES *************************/
Route::group(['middleware' => 'permissions'], function () {
    Route::get('/acceso-servicios','ServiciosgeneralesController@accesoServicios');
    Route::get('/user-find-all','ServiciosgeneralesController@findUserAcceso');
    Route::post('/insert-user','ServiciosgeneralesController@insertUser');
    Route::post('/find-user','ServiciosgeneralesController@findUser');
    Route::post('/update-user','ServiciosgeneralesController@updateUser');
    Route::post('/deleted-user','ServiciosgeneralesController@deletedUser');
    Route::post('/load-menu-user','ServiciosgeneralesController@loadUserMenu');
    Route::post('/update-menu-user','ServiciosgeneralesController@saveMenuUSer');
    Route::post('/deleted-menu-user','ServiciosgeneralesController@deleteElementMenuUser');
    Route::post('/find-partidas-where','ServiciosgeneralesController@findPartidasWhere');
    Route::post('/find-partidas-user','ServiciosgeneralesController@findPartidasWhereUser');
    Route::post('/insert-partidas-user','ServiciosgeneralesController@insertPartidasUser');
    Route::post('/delete-partidas-user','ServiciosgeneralesController@deletePartidasUser');
    Route::get('/alta-partidas-servicios','ServiciosgeneralesController@altapartidas');
    Route::get('/servicios-partidas-findall','ServiciosgeneralesController@partidasFindAllServicios');
    Route::post('/servicios-partidas-insert','ServiciosgeneralesController@insertPartidasServicios');
    Route::post('/servicios-partidas-find','ServiciosgeneralesController@serviciosPartidasFindWhere');
    Route::post('/servicios-partidas-update','ServiciosgeneralesController@serviciosPartidasUpdate');
    Route::post('/servicios-partidas-delete','ServiciosgeneralesController@serviciosPartidasDeleted');



});
/*/*******************************************************************************/

Route::group(['middleware' => 'permissions'], function () {
    Route::get('/register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::get('/adminmenu', 'AdminMenuController@index');
    Route::post('/adminmenu/saveMenu', 'AdminMenuController@saveMenu');
    /* set the user menu tools */
    Route::get('/asignaherramientas', 'AsignaHerramientasController@index');
    Route::post('/asignaherramientas/saveuserprofile', 'AsignaHerramientasController@saveUserProfile');
    Route::post('/asignaherramientas/loaduserprofile', 'AsignaHerramientasController@loadUserProfile');
    Route::post('/asignaherramientas/deleteelementuserprofile', 'AsignaHerramientasController@deleteElementUserProfile');


});

/* herramienta de cfdi */
Route::group(['middleware' => ['verifyassignment']],function(){
	Route::get('/cfdi-correccion', 'CorreccioncfdiController@index')->name('cfdi-tool');
	Route::get('/cfdi-manual','ManualcfdiController@index')->name('cfdi-captura');
    Route::get('/cfdi-cancel','CorreccioncfdiController@cancel')->name('cfdi-cancel');
});
Route::post('/cfdi-correccion/busca-rfc','CorreccioncfdiController@searchrfc');
Route::post('/cfdi-correccion/busca-foliounico','CorreccioncfdiController@searchfoliounico');
Route::post('/cfdi-correccion/edit','CorreccioncfdiController@edit');
Route::get('/cfdi-correccion/encabezado','CorreccioncfdiController@encabezado');
Route::get('/cfdi-correccion/detalle','CorreccioncfdiController@detalle');
Route::post('/cfdi-manual/busca-datos','ManualcfdiController@datosfiscales');
Route::post('/cfdi-manual/busca-rfc','ManualcfdiController@searchrfc');
Route::post('/cfdi-manual/savecfdi','ManualcfdiController@savecfdi');


/*************************    PORTAL    ******************************************/
Route::get('/tramites-list-fields','PortaltramitesController@listFields');
Route::post('/tramites-add-field','PortaltramitesController@newField');
Route::post('/tramites-edit-field','PortaltramitesController@editField');
Route::post('/tramites-estatus', 'PortaltramitesController@fieldStatus');

Route::get('/traux-campos','PortaltramitesauxController@index');
Route::get('/traux-get-serv','PortaltramitesauxController@listarTramites');
Route::get('/traux-get-camp','PortaltramitesauxController@listarCampos');
Route::get('/traux-get-tcamp','PortaltramitesauxController@listarTipoCampos');
Route::post('/traux-get-relcamp','PortaltramitesauxController@listarRelacion');
Route::post('/traux-add-serv','PortaltramitesauxController@guardaTramite');
Route::post('/traux-edit-relcamp','PortaltramitesauxController@editarTramite');
Route::post('/traux-del-relcamp','PortaltramitesauxController@eliminarTramite');
Route::get('/traux-get-partida', 'PortaltramitesauxController@listarPartidas');


Route::get('/solicitudes', 'PortalSolicitudesController@index');
Route::post('/solicitud-add', 'PortalSolicitudesController@crearSolicitud');
Route::get('/solicitud-tramites', 'PortalSolicitudesController@getTramites');
Route::get('/solicitud-all', 'PortalSolicitudesController@getSolicitudes');
Route::get('/solicitud-getUsers', 'PortalSolicitudesController@getUsers');
Route::post('/solicitud-editar', 'PortalSolicitudesController@editarSolicitud');
Route::post('/solicitud-delete', 'PortalSolicitudesController@delete');


/*estas son para crear los tickets de solicitud*/
Route::post('/solicitudes-registro', 'PortalSolicitudesController@registrarSolicitudes'); // este sirve para crear los tickets configurados y guardar los vakores iniciale de una solicitud


Route::get('/traux-pago-costos','PortaltramitesauxController@Viewtipopagocosto');
Route::get('/traux-get-tramites','PortaltramitesauxController@findTramites');
Route::get('/traux-get-costos','PortaltramitesauxController@findCostos');
Route::get('/traux-get-cuota','PortaltramitesauxController@findValorcuota');
Route::post('/traux-post-tramites','PortaltramitesauxController@insertCostos');
Route::post('/traux-edit-tramites','PortaltramitesauxController@updateCostos');
Route::post('/traux-del-tramites','PortaltramitesauxController@updateStatusCostos');
Route::post('/traux-post-subsidios','PortaltramitesauxController@updateSubsidio');
Route::post('/traux-add-caract', 'PortaltramitesauxController@addCaracteristics');
Route::get('/traux-get-reglas', 'PortaltramitesauxController@getReglas');
Route::post('/traux-agrupacion', 'PortaltramitesauxController@listarAgrupacion');
Route::get('/configuracion-tramites', 'PortaltramitesauxController@viewConfiguracion');
Route::post('/guardar-agrupacion', 'PortaltramitesauxController@guardarAgrupacion');
Route::post('/guardar-orden', 'PortaltramitesauxController@guardarOrden');
Route::get('/listarCategorias', 'PortaltramitesauxController@listCategory');
Route::post('/addFile', 'PortaltramitesauxController@addFile');

Route::post('/notary-offices', 'PortalNotaryOfficesController@createNotary');
Route::get('/notary-offices-get-users/{id}', 'PortalNotaryOfficesController@getUsers');
Route::get('/notary','PortalNotaryOfficesController@index');
Route::post('/notary-offices-edit-user', 'PortalNotaryOfficesController@editUsersNotary');
Route::post('/notary-offices-user-status', 'PortalNotaryOfficesController@status');
Route::post('/notary-offices-create-users', 'PortalNotaryOfficesController@createUsersNotary');
Route::get('/notary-offices-roles', 'PortalNotaryOfficesController@getRolesPermission');
Route::get('/notary-offices-community/{id}', 'PortalNotaryOfficesController@listNotaryCommunity');


Route::get('/comunidades', 'OperacionRolesController@index');
Route::get('/operacion-roles-create', 'OperacionRolesController@createRol');
Route::post('/operacion-roles-add-tramite', 'OperacionRolesController@addTramite');
Route::post('/operacion-roles-get-tramite/{id}', 'OperacionRolesController@getTramites');
Route::post('/operacion-roles-edit-rol', 'OperacionRolesController@editRol');
Route::post('/operacion-roles-eliminar-rol', 'OperacionRolesController@eliminarRol');
Route::get('/operacion-roles-get-rol', 'OperacionRolesController@getRoles');
Route::get('/operacion-roles-get-tramites', 'OperacionRolesController@listTramites');

Route::post('/filtrar-solicitudes', 'PortalSolicitudesController@filtrar');
Route::get('/listado-solicitudes', 'PortalSolicitudesController@listSolicitudes');
Route::get('/atender-solicitudes/{id}', 'PortalSolicitudesController@atenderSolicitud');
Route::post('/guardar-solicitudes', 'PortalSolicitudesController@guardarSolicitud');
Route::post('/cerrar-ticket', 'PortalSolicitudesController@cerrarTicket');
Route::get('/listado-mensajes/{id}', 'PortalSolicitudesController@getMensajes');
Route::get('/listado-download/{file}' , 'PortalSolicitudesController@downloadFile');
Route::get('/get-route/{id}/{type}' , 'PortalSolicitudesController@getFileRoute');


Route::post('/solicitudes-register', 'PortalSolicitudesTicketController@registrarSolicitud')->name("RegistrarSolicitud");
Route::put('/solicitudes-discard/{id}', 'PortalSolicitudesTicketController@eliminarSolicitud');
Route::get('/solicitudes-info/{id}', 'PortalSolicitudesTicketController@getInfo');
Route::get('/solicitudes-detalle-tramite/{id}', 'PortalSolicitudesTicketController@detalleTramite');
Route::post('/solicitudes-update', 'PortalSolicitudesTicketController@updateTramite');
Route::post('/solicitudes-filtrar', 'PortalSolicitudesTicketController@filtrarSolicitudes');
Route::post('/save-transaccion', 'PortalSolicitudesTicketController@saveTransaccion');
Route::post('/save-transaccion-motor', 'PortalSolicitudesTicketController@saveTransaccionMotor');
Route::post('/solicitudes-update-status-tramite', 'PortalSolicitudesTicketController@updateStatusTramite');
Route::post('/solicitudes-register-temporal', 'PortalSolicitudesTicketController@registrarSolicitud')->name("RegistrarSolicitudTemporal");


Route::get('/reglas-operativas', 'PortalReglaOperativaController@index');
Route::get('/reglas-tmt', 'PortalReglaOperativaController@getTramites');
Route::post('/reglas-tmt-relationship', 'PortalReglaOperativaController@getCampos');
Route::post('/reglas-cmp', 'PortalReglaOperativaController@getReglasCampos');
Route::post('/reglas-info', 'PortalReglaOperativaController@getReglas');
Route::post('/reglas-save', 'PortalReglaOperativaController@saveRegla');


Route::get('/avisos-internos', 'PortalAvisosInternosController@index');
Route::get('/find-avisos', 'PortalAvisosInternosController@findNotifications');
Route::post('/create-avisos', 'PortalAvisosInternosController@createNotifications');
Route::post('/update-avisos', 'PortalAvisosInternosController@updateNotifications');
Route::post('/delete-avisos', 'PortalAvisosInternosController@deletedNotifications');


Route::get('/obtener-divisas', 'DivisasController@getDivisas');
Route::post('/save-divisas', 'DivisasController@saveDivisas');
Route::post('/delete-divisas', 'DivisasController@deleteDivisas');
Route::get('/get-divisas-save', 'DivisasController@getDivisasSave');
Route::get('/divisas', 'DivisasController@index');
