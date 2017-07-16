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

Route::post('/', 'UserController@login')->name('LG');
Route::get('/', 'UserController@index')->name('LG');

//Admin
Route::group(['middleware' => 'auth'], function()
{
    Route::group(['prefix' => 'DrugOrder'], function() {
        Route::get('/', 'DrugOrderController@index')->name('DO-index');
        Route::get('/search', 'DrugOrderController@search')->name('DO-search');
        Route::get('/add', 'DrugOrderController@add')->name('DO-add');
        Route::post('/add', 'DrugOrderController@add')->name('DO-add');
        Route::get('/edit/{id?}', 'DrugOrderController@edit')->name('DO-edit');
        Route::post('/edit', 'DrugOrderController@edit')->name('DO-edit');
        Route::post('/delete', 'DrugOrderController@delete')->name('DO-delete');
        Route::get('/json/getDrugList', 'DrugOrderController@getDrugList')->name('DO-getDrugList');
        Route::get('/json/getUnitList/{drugId?}', 'DrugOrderController@getUnitList')->name('DO-getUnitList');
        Route::post('/json/getSum/{drugId?}', 'DrugOrderController@getSum')->name('DO-getSum');
    });

    Route::group(['prefix' => 'Drug'], function() {
        Route::get('/', 'DrugController@index')->name('D-index');
        Route::get('/search', 'DrugController@search')->name('D-search');
        Route::get('/add', 'DrugController@add')->name('D-add');
        Route::post('/add', 'DrugController@add')->name('D-add');
        Route::get('/edit/{id?}', 'DrugController@edit')->name('D-edit');
        Route::post('/edit', 'DrugController@edit')->name('D-edit');
        Route::post('/delete', 'DrugController@delete')->name('D-delete');
    });

});