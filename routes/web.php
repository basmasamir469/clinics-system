<?php

use App\Models\PaymentTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AreaController;

use App\Http\Controllers\DrugController;

use App\Http\Controllers\VisitController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AdditionController;
use App\Http\Controllers\InsuranceController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\LaboratoryController;
use App\Http\Controllers\AppointmentsController;
use App\Http\Controllers\LaboratoryRequestController;
use App\Http\Controllers\PaymentTransactionController;

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

$controller_path = 'App\Http\Controllers\\';
// Main Page Rou
Route::post('do-login', [LoginController::class, 'doLogin'])->name('do-login');



route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'App\Http\Controllers\dashboard\Analytics@index')->name('home');
    Route::get('/appointmentsreports', [ReportController::class, 'create']);
    Route::get('/medicinesreports', [ReportController::class, 'createMedicinesReport']);
    Route::get('/expensesreports', [ReportController::class, 'createExpensesReport']);
    Route::get('/paymentsreports', [ReportController::class, 'createPaymentsReport']);
    Route::get('/patientsreports', [ReportController::class, 'createPatientsReport']);
    Route::get('/getexpensesresults', [ReportController::class, 'searchexpenses'])->name('expense_search');
    Route::get('/getappointmentsresults', [ReportController::class, 'reportsearch'])->name('report_search');
    Route::get('/getmedicinesresults', [ReportController::class, 'searchMedicines'])->name('medicine_search');
    Route::get('/getpaymentsresults', [ReportController::class, 'searchPayments'])->name('payment_search');
    Route::get('/getpatientsresults', [ReportController::class, 'searchPatients'])->name('patient_search');
    Route::resource('roles', 'App\Http\Controllers\RoleController'::class);
    Route::resource('/user', 'App\Http\Controllers\UserController'::class);
    Route::resource('/expenses', 'App\Http\Controllers\ExpenseController'::class);
    Route::resource('/expenseItems', 'App\Http\Controllers\ExpenseItemsController'::class);
    Route::resource('/appointments', AppointmentsController::class);
    Route::resource('/addition', AdditionController::class);
    Route::resource('/insurances', InsuranceController::class);
    Route::resource('/areas', AreaController::class);
    Route::resource('/patients', PatientController::class);
    Route::resource('/laps', LaboratoryController::class);
    Route::resource('/services', ServiceController::class);
    Route::resource('/drugs', DrugController::class);
    Route::resource('/payments', PaymentTransactionController::class);

    // visits
    Route::resource('/visits', VisitController::class);
    Route::get('/todayvisits', [App\Http\Controllers\VisitController::class, 'todayvisits']);
    Route::post('/visitresults/{id}', [App\Http\Controllers\VisitController::class, 'updateVisit']);
    Route::post('/entry/{id}', [App\Http\Controllers\VisitController::class, 'entry'])->name('entry');
    Route::get('/patiententry/{id}', [App\Http\Controllers\VisitController::class, 'patiententry'])->name('patient entry');
    Route::get('/search', [App\Http\Controllers\VisitController::class, 'todayvisits'])->name('search');
    // laprequests
    Route::resource('/labrequests', LaboratoryRequestController::class);
    Route::post('/labrequest/{id}', [App\Http\Controllers\LaboratoryRequestController::class, 'store']);
    Route::post('/addpayment', [App\Http\Controllers\LaboratoryRequestController::class, 'addpayment']);
    Route::get('/showpayment/{id}', [App\Http\Controllers\LaboratoryRequestController::class, 'showpayment']);
    Route::get('/labresults/{id}', [App\Http\Controllers\LaboratoryRequestController::class, 'editLabResult']);
    Route::post('/labresults/{id}', [App\Http\Controllers\LaboratoryRequestController::class, 'updateLabResult']);
});
Auth::routes();
