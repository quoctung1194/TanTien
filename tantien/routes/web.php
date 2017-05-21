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

Route::get('/', 'DrugOrderController@index')->name('DO-index');

Route::group(['prefix' => 'DrugOrder'], function() {
    Route::get('/search', 'DrugOrderController@search')->name('DO-search');
    Route::get('/add', 'DrugOrderController@add')->name('DO-add');
    Route::post('/add', 'DrugOrderController@add')->name('DO-add');
    Route::get('/edit', 'DrugOrderController@add')->name('DO-edit');
    Route::get('/json/getDrugList', 'DrugOrderController@getDrugList')->name('DO-getDrugList');
    Route::get('/json/getUnitList/{drugId?}', 'DrugOrderController@getUnitList')->name('DO-getUnitList');
    Route::post('/json/getSum/{drugId?}', 'DrugOrderController@getSum')->name('DO-getSum');
});