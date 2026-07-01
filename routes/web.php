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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// master employee
Route::get('/master-employee.index', 'Employees\MasterEmployeeController@indexEmployee')->name('master-employee.index');

// rehire employee
Route::get('/rehire-employee.index', 'Employees\MasterEmployeeController@indexRehire')->name('rehire-employee.index');

// terminate employee
Route::get('/terminate-employee.index', 'Employees\MasterEmployeeController@indexTerminate')->name('terminate-employee.index');

// Report SPG
Route::get('/report-spg.index', 'Employees\MasterEmployeeController@indexReportSPG')->name('report-spg.index');

// master brand
Route::get('/master-brand.index', 'Employees\MasterEmployeeController@indexBrand')->name('master-brand.index');

// Report CV
Route::get('/report-cv.index', 'Employees\MasterEmployeeController@indexReportCV')->name('report-cv.index');

// mutasi employee
Route::get('/mutasi-employee.index', 'Employees\MasterEmployeeController@indexMutasi')->name('mutasi-employee.index');

