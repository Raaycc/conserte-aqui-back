<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', 'Auth\LoginController@login');
Route::post('criar/usuario', 'Controller@criarUsuario');
Route::post('criar/fornecedor', 'Controller@criarFornecedor');


Route::get('listaFornecedor', 'Controller@listaFornecedor');

Route::post('chat/usuario/enviar', 'Controller@mandaMensagem');
Route::get('chat/usuario/lista', 'Controller@receberChatsUsuario');
Route::post('chat/fornecedor/enviar', 'Controller@mandaMensagemFornecedor');
Route::get('chat/fornecedor/lista', 'Controller@receberChatsUsuario');




