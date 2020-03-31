<?php

/**
 * Antonio J.Sánchez 
 * curso 2019/20
 */

/**
 * Antonio J.Sánchez 
 * curso 2019/20
 */

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/',    'TableroController@index')->name('tablero.ver');
Route::match(['get','post'], '/ver', 'NotaController@ver')->name('nota.ver') ;

Route::match(['get','post'], '/editar', 'TableroController@edit')->name('tablero.editar') ;

Route::get('/borrar', 'TableroController@delete')->name('tablero.borrar') ;










