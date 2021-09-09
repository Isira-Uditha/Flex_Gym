<?php

use App\Http\Controllers\PackageController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DasboardController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\test;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\EquipmentController;

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

//Login
Route::get('/', function () {return redirect('/login');});
Auth::routes();

Route::get('/sample', function () {
    return view('sample');
});

Route::get('/equipment/create', function () {
    return view('equipment.create_equipment');
})->name('equipment_create_view');

Route::post('/equipment/create',[EquipmentController::class, 'store'])->name('createEquipment');

Route::get('/equipment/index',[EquipmentController::class, 'index'])->name('equipment_index');

Route::get('/test',[test::class, 'index'])->name('test');

//Package Routes
Route::get('/package/index',[PackageController::class, 'index'])->name('package_index');
Route::post('/package/create/{action}/{id?}', [PackageController::class, 'create'])->name('package_create');
Route::get('/package/view/{action}/{id?}', [PackageController::class, 'view'])->name('package_view');

//User Routes
Route::get('/user/index/{u_type}',[UserController::class, 'index'])->name('user_index');
Route::get('/user/view/{u_type}/{action}/{id?}', [UserController::class, 'view'])->name('user_view');
Route::post('/user/create/{u_type}/{action}/{id?}', [UserController::class, 'create'])->name('user_create');


Route::get('/appointment/index',[AppointmentController::class, 'index'])->name('appointment_index');

Route::get('/appointment/view/{action}/{id?}',[AppointmentController::class, 'view'])->name('appointment_view');

Route::get('/appointment/getSugestedSchedules',[AppointmentController::class, 'getSugestedSchedules'])->name('getSugestedSchedules');

Route::get('/appointment/checkAppointmentStatus',[AppointmentController::class, 'checkAppointmentStatus'])->name('checkAppointmentStatus');

Route::post('/appointment/create/{action}/{id?}',[AppointmentController::class, 'create'])->name('appointment_create');

Route::get('/appointment/checkPaymentStatus',[AppointmentController::class, 'checkPaymentStatus'])->name('checkPaymentStatus');

Route::get('/payment/index',[PaymentController::class, 'index'])->name('payment_index');

Route::get('/payment/view/{action}/{id?}',[PaymentController::class, 'view'])->name('payment_view');

Route::get('/payment/getPackagePrice',[PaymentController::class, 'getPackagePrice'])->name('getPackagePrice');

Route::post('/payment/create/{action}/{id?}',[PaymentController::class, 'create'])->name('payment_create');

Route::get('/dashboard',[DasboardController::class, 'index'])->name('dashboard');

Route::get('/dashboard/getBMIValues',[DasboardController::class, 'getBMIValues'])->name('getBMIValues');
