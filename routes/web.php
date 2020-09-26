<?php

use Illuminate\Support\Facades\Route;

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

/*Route::get('/', function () {
    //return view('welcome');

});*/
//Route::get('/', 'catalogoController@service');
Route::get('/{orden}/{token}/{nombre}/{pais}', 'CatalogoController@index')->where(['orden' => '[0-8]', 'token' => '[0-9]+' ,'pais' => 'pe|ec|PE|EC|co|CO|us|US|pa|PA|es|ES|ar|AR|bo|BO|cl|CL|gt|GT']);
Route::get('/setlog/{session_id}/{accion}/{producto}/{familia}', 'CatalogoController@setLog');
Route::get('/serviceresponse/{session_id}/{result}/{data}/{message}', 'CatalogoController@serviceResponse');
//Route::get('/api/serviceresponse', 'CatalogoController@serviceResponse');
//Route::post('/post', 'CatalogoController@post');
