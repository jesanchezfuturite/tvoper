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
Route::get('/cfdi-correccion', 'CorreccioncfdiController@index')->name('cfdi-tool');
Route::post('/cfdi-correccion/busca-rfc','CorreccioncfdiController@searchrfc');


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
/* Banco app */
Route::post('/banco-insert','MotorpagosController@insertBanco');
Route::post('/banco-find','MotorpagosController@findBanco');
Route::post('/cuentasbanco-find','MotorpagosController@findCuentasBanco');
Route::post('/cuentasbanco-insert','MotorpagosController@insertCuentasBanco');
Route::post('/cuentasbanco-update','MotorpagosController@updateCuentasBanco');
Route::post('/cuentasbanco-desactiva','MotorpagosController@DesactivaCuentaBanco');
/*Metodo Pago*/
Route::get('/metodopago-find','MotorpagosController@findMetodopago');




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
