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
Route::post('/conciliacion-uploadfile','ConciliacionController@uploadFile');

/* motor de pagos app */
Route::get('/dias-feriados-inicio','MotorpagosController@diasferiados');
Route::post('/dias-feriados-insert','MotorpagosController@insertDiasFeriados');
Route::post('/dias-feriados-eliminar','MotorpagosController@deletediasferiados');
Route::get('/crud-metodos-pago','MotorpagosController@crudmetodospago');
Route::get('/bancos','MotorpagosController@bancos');
Route::get('/cambiar-status-transaccion','MotorpagosController@cambiarstatustransaccion');
Route::get('/pago-tramite','MotorpagosController@pagotramite');
/* Limite Referencia app */
Route::get('/limite-referencia','MotorpagosController@limitereferencia');
Route::post('/limite-referencia-deleted','MotorpagosController@deleteLimiteReferencia');
Route::post('/limite-referencia-insert','MotorpagosController@insertLimiteReferencia');
Route::post('/limite-referencia-find','MotorpagosController@FindLimiteReferencia');
Route::post('/limite-referencia-update','MotorpagosController@updateLimiteReferencia');
Route::get('/limite-referencia-fin-all','MotorpagosController@limitereferenciaFindAll');
/* Banco app */
Route::post('/banco-insert','MotorpagosController@insertBanco');
Route::post('/banco-find','MotorpagosController@findBanco');
Route::post('/cuentasbanco-find','MotorpagosController@findCuentasBanco');
Route::post('/cuentasbanco-find-where','MotorpagosController@findCuentasBancoWhere');
Route::post('/cuentasbanco-edit','MotorpagosController@findCuenta_edit');
Route::post('/cuentasbanco-insert','MotorpagosController@insertCuentasBanco');
Route::post('/cuentasbanco-update','MotorpagosController@updateCuentasBanco');
Route::post('/cuentasbanco-desactiva','MotorpagosController@DesactivaCuentaBanco');
Route::post('/banco-status-update','MotorpagosController@DesactivaBanco');
/*Metodo Pago*/
Route::get('/metodopago-find','MotorpagosController@findMetodopago');
Route::get('/banco-find-all','MotorpagosController@findBancoAll');
Route::get('/banco-find-allWhere','MotorpagosController@findBancoAllWhere');
/*metodo tipo servicio*/
Route::get('/tiposervicio-find-all','MotorpagosController@findTipoServicioAll');
Route::post('/entidad-find-all','MotorpagosController@findEntidadAll');
/*metodo tipo PagoTramite*/

Route::post('/pagotramite-find','MotorpagosController@findTipoServicio');
Route::post('/pagotramite-insert','MotorpagosController@insertPagoTramite');
Route::post('/pagotramite-find-where','MotorpagosController@findPagoTramiteWhere');
Route::post('/pagotramite-update','MotorpagosController@updatePagoTramite');
Route::post('/pagotramite-delete','MotorpagosController@deletePagoTramite');
/* Metodo Entidad */
Route::get('/entidad','MotorpagosController@entidadView');
Route::get('/entidad-find','MotorpagosController@findentidad');
Route::post('/entidad-find-where','MotorpagosController@findentidadWhere');
Route::post('/entidad-insert','MotorpagosController@insertentidad');
Route::post('/entidad-update','MotorpagosController@updateentidad');
Route::post('/entidad-delete','MotorpagosController@deleteentidad');

/* Entidad Tramite*/
Route::get('/entidad-tramite','MotorpagosController@entidadtramiteView');
Route::post('/entidad-tramite-find','MotorpagosController@findtramiteEntidad');
Route::post('/entidad-tramite-insert','MotorpagosController@insertentidadtramite');
Route::post('/entidad-tramite-update','MotorpagosController@updateentidadtramite');
Route::post('/entidad-tramite-delete','MotorpagosController@deleteentidadtramite');
Route::post('/entidad-tramite-find-where','MotorpagosController@findtramiteEntidadWhere');
Route::post('/entidad-tramite-find-id','MotorpagosController@findtramiteEntidadWhereID');
/*/ Tipo Servicio/*/
Route::get('/tipo-servicio','MotorpagosController@tiposervicio');
Route::get('/tipo-referencia-Find','MotorpagosController@tiporeferenciaFindAll');
Route::post('/tipo-servicio-Find-where','MotorpagosController@findTipoServicio_whereId');
Route::post('/tipo-servicio-insert','MotorpagosController@insertTipoServicio');

Route::post('/tipo-servicio-update','MotorpagosController@updateTipoServicio');
Route::get('/tipo-servicio-find-all','MotorpagosController@findTipoServicioWhere');
Route::post('/tipo-servicio-delete','MotorpagosController@deleteTipoServicio');

/*----------Estatus Transaccion--------*/
Route::get('/status-find-all','MotorpagosController@statusFindAll');
Route::post('/transaccion-find-referencia','MotorpagosController@transaccionesFindWhere');
Route::post('/transaccion-find-status','MotorpagosController@transaccionesFindWhereStatus');
Route::post('/transaccion-update-status','MotorpagosController@updateTransaccionStatus');
Route::post('/transaccion-find-status-oper','MotorpagosController@transaccionesFindWhereStatus_oper');
//Route::post('/transaccion-find-referencia-oper','MotorpagosController@transaccionesFindWhereReferencia_oper');
Route::post('/transaccion-update-status-oper','MotorpagosController@updateTransaccionStatus_oper');


/************detalle de pago tramite***********/

Route::get('/detalle-pago-tramite','MotorpagosController@detallepagotramite');
Route::post('/pagotramite-find-all','MotorpagosController@findCuentasBancoAll');

/*************   envio correo    **************/

//Route::get('/envia-correo','ConciliacionController@enviacorreo');
Route::get('/genera-archivo','ConciliacionController@generaarchivo');

/* ws estado de cuenta icv */

Route::get('/icv-consulta-placa/{info}','IcvrestserviceController@icvconsultaplaca');

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
Route::get('/cfdi-correccion', 'CorreccioncfdiController@index')->name('cfdi-tool');
Route::post('/cfdi-correccion/busca-rfc','CorreccioncfdiController@searchrfc');
Route::post('/cfdi-correccion/busca-foliounico','CorreccioncfdiController@searchfoliounico');
Route::post('/cfdi-correccion/edit','CorreccioncfdiController@edit');
Route::get('/cfdi-correccion/encabezado','CorreccioncfdiController@encabezado');
Route::get('/cfdi-correccion/detalle','CorreccioncfdiController@detalle');
Route::get('/cfdi-manual','ManualcfdiController@index')->name('cfdi-captura');
Route::post('/cfdi-manual/busca-rfc','ManualcfdiController@searchrfc');
Route::post('/cfdi-manual/busca-datos','ManualcfdiController@datosfiscales');