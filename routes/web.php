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
Route::get('/crud-metodos-pago','MotorpagosController@crudmetodospago');
Route::get('/bancos','MotorpagosController@bancos');
Route::get('/cambiar-status-transaccion','MotorpagosController@cambiarstatustransaccion');


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
Route::get('/cfdi-correccion/encabezado','CorreccioncfdiController@encabezado');
