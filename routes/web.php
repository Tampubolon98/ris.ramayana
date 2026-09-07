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

// ===== START EMPLOYEE =====
// master employee
Route::get('/master-employee.index', 'Employees\MasterEmployeeController@indexEmployee')->name('master-employee.index');

Route::get('/master-employee.template', 'Employees\MasterEmployeeController@downloadTemplate')->name('/master-employee.template');

Route::get('/master-employee.get-employee', 'Employees\MasterEmployeeController@getEmployees')->name('/master-employee.get-employee');

Route::post('/master-employee.add-employee', 'Employees\MasterEmployeeController@newEmployee')->name('/master-employee.add-employee');

Route::post('/master-employee.upload', 'Employees\MasterEmployeeController@newUploadEmployee')->name('/master-employee.upload');

Route::get('/master-employee.get-supplier', 'Employees\MasterEmployeeController@getSupplier')->name('/master-employee.get-supplier');

Route::get('/master-employee.get-toko', 'Employees\MasterEmployeeController@getToko')->name('/master-employee.get-toko');

Route::get('/master-employee.history/{noKtp}', 'Employees\MasterEmployeeController@getHistoryData')->name('/master-employee.history');

Route::post('/master-employee.edit', 'Employees\MasterEmployeeController@editData')->name('/master-employee.edit');

Route::post('/master-employee.terminate', 'Employees\MasterEmployeeController@terminateData')->name('/master-employee.terminate');

Route::get('/master-employee.search', 'Employees\MasterEmployeeController@get_search_data')->name('/master-employee.search');


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
// ===== END EMPLOYEE =====

// ===== START TAX =====
// tax bahan
Route::get('/tax-bahan.index', 'Tax\PajakMasukanController@indexTaxBahan')->name('tax-bahan.index');

// tax non a/p
Route::get('/tax-nonap.index', 'Tax\PajakMasukanController@indexTaxNonap')->name('tax-nonap.index');

// tax out
Route::get('/tax-out.index', 'Tax\PajakKeluaranController@indexTaxOut')->name('tax-out.index');
// ===== END TAX =====

