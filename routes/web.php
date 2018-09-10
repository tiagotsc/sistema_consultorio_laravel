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
    if(auth()->check()){
        return view('home');
    }else{
        return view('auth.login');
    }
});

Route::group(['middleware' => 'auth'], function(){
    Route::get('/home', 'HomeController@index')->name('home.index');

    // Agenda
    Route::get('agenda/{tipo}/{dia}/{mes}/{ano}', 'AgendaController@index')->where(['dia' => '[0-9]{2}', 'mes' => '[0-9]{2}', 'ano' => '[0-9]{4}'])->name('agenda.index');
    Route::get('agenda/marcar', 'AgendaController@marcar')->name('agenda.marcar');
    
    // Usuário
    Route::resource('usuario', 'UserController');
    Route::post('/usuario/getpesq', 'UserController@getpesq')->name('usuario.getpesq');

    Route::resource('paciente', 'PacienteController');
    Route::post('/paciente/getpesq', 'PacienteController@getpesq')->name('paciente.getpesq');

    // Roles
    Route::resource('roles','RoleController');
    Route::post('/rolesgetpesq', 'RoleController@getpesq')->name('roles.getpesq');

});


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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
