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
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home.index');

// Agenda
Route::get('agenda/{tipo}/{dia}/{mes}/{ano}', 'AgendaController@index')->where(['dia' => '[0-9]{2}', 'mes' => '[0-9]{2}', 'ano' => '[0-9]{4}'])->name('agenda.index');
Route::get('agenda/marcar', 'AgendaController@marcar')->name('agenda.marcar');

// Funcionário
Route::get('/funcionario', 'FuncionarioController@index')->name('funcionario.index');
Route::get('/funcionario/create', 'FuncionarioController@create')->name('funcionario.create');
Route::post('/funcionario/store', 'FuncionarioController@store')->name('funcionario.store');
//Route::post('/funcionario/store', function(){
    /*$employeeZeroFirstName = Request::input('employees.0.firstName');
    $allLastNames = Request::input('employees.*.lastName');
    $employeeOne = Request::input('employees.1');
    echo '<pre>';
    echo $employeeZeroFirstName; echo PHP_EOL;
    print_r($allLastNames);
    print_r($employeeOne);
    echo '</pre>';
    var_dump(Request::all());*/
//})->name('funcionario.store');
