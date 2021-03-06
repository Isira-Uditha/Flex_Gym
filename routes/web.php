<?php

use App\Http\Controllers\WorkoutExerciseController;
use App\Http\Controllers\WorkoutPlanController;
use App\Http\Controllers\DietPlanController;
use App\Models\Equipment;
use App\Models\WorkoutExercise;
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

Route::post('/equipment/delete/{id}',[EquipmentController::class, 'destroy'])->name('equipment_delete');

Route::get('/equipment/view/{id?}',[EquipmentController::class, 'show'])->name('equipment_view');

Route::get('/equipment/edit/{id?}',[EquipmentController::class, 'edit'])->name('equipment_edit_view');

Route::post('/equipment/update/{id?}',[EquipmentController::class, 'update'])->name('equipment_update');

Route::get('/equipment/report/view',[EquipmentController::class, 'viewReport'])->name('equipment_report_view');

Route::get('/equipment/report/print',[EquipmentController::class, 'printReport'])->name('equipment_report_print');

Route::get('/test',[test::class, 'index'])->name('test');

Route::get('/workout/workout_exercise', function () {
    $equipments = Equipment::where('status',"In Use")->get();
    return view('workoutplans.create_exercise')->with('equipments', $equipments);
})->name('createExercise_view');

Route::get('/workout/workout_plan/create', function () {
    $exercises=WorkoutExercise::all();
    return view('workoutplans.create_workoutplan')->with('exercises',  $exercises);;
})->name('create_workoutPlan_view');

Route::get('/diet_plan/create', function () {
    return view('dietplans.create_diet_plan');
})->name('create_dietPlan_view');


Route::post('/workout/workout_exercise/create',[WorkoutExerciseController::class, 'store'])->name('createExercise');

Route::post('/workout/workout_plan/create',[WorkoutPlanController::class, 'store'])->name('create_workout_plan');

Route::post('/workout/workout_plan/delete/{id}',[WorkoutPlanController::class, 'destroy'])->name('workout_plan_delete');

Route::get('/workout/workout_plan/view/{id?}',[WorkoutPlanController::class, 'show'])->name('workout_plan_view');

Route::post('/diet/diet_plan/create',[DietPlanController::class, 'store'])->name('create_diet_plan');

Route::get('/workout/workout_plan/index',[WorkoutPlanController::class, 'index'])->name('workout_plan_index');

Route::get('/workout/workout_plan/edit/{id?}',[WorkoutPlanController::class, 'edit'])->name('workout_plan_edit_view');

Route::post('/workout/workout_plan/update/{id?}',[WorkoutPlanController::class, 'update'])->name('workout_plan_update');

Route::get('/workout/workout_plan/report/view',[WorkoutPlanController::class, 'viewReport'])->name('workout_plan_report_view');

Route::get('/workout/workout_plan/report/print',[WorkoutPlanController::class, 'printReport'])->name('workout_plan_report_print');

Route::get('/diet_plan/index',[DietPlanController::class, 'index'])->name('diet_plan_index');

Route::get('/diet_plan/create/check',[DietPlanController::class, 'checkValid'])->name('check_valid_create_diet');

Route::post('/diet_plan/delete/{id}',[DietPlanController::class, 'destroy'])->name('diet_plan_delete');

Route::get('/diet_plan/view/{id?}',[DietPlanController::class, 'view'])->name('diet_plan_view');

Route::get('/diet_plan/edit/{id?}',[DietPlanController::class, 'edit'])->name('diet_plan_edit_view');

Route::post('/diet_plan/update/{id?}',[DietPlanController::class, 'update'])->name('diet_plan_update');

Route::get('/diet_plan/report/view',[DietPlanController::class, 'viewReport'])->name('diet_plan_report_view');

Route::get('/diet_plan/report/print',[DietPlanController::class, 'printReport'])->name('diet_plan_report_print');

Route::get('/main', function () {
    if(Auth::user()->role == 'Member'){
        return redirect('/dashboard');
    } else {
        return redirect('/package/index');
    }
});

//Package Routes
// Route::get('/package/index',[PackageController::class, 'index'])->name('package_index');
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

Route::get('/appointment/checkupdateAppointmentStatus',[AppointmentController::class, 'checkupdateAppointmentStatus'])->name('checkupdateAppointmentStatus');

Route::post('/appointment/create/{action}/{id?}',[AppointmentController::class, 'create'])->name('appointment_create');

Route::get('/appointment/checkPaymentStatus',[AppointmentController::class, 'checkPaymentStatus'])->name('checkPaymentStatus');

Route::get('/payment/index',[PaymentController::class, 'index'])->name('payment_index');

Route::get('/payment/view/{action}/{id?}',[PaymentController::class, 'view'])->name('payment_view');

Route::get('/payment/getPackagePrice',[PaymentController::class, 'getPackagePrice'])->name('getPackagePrice');

Route::post('/payment/create/{action}/{id?}',[PaymentController::class, 'create'])->name('payment_create');

Route::get('/dashboard',[DasboardController::class, 'index'])->name('dashboard');

Route::get('/dashboard/getBMIValues',[DasboardController::class, 'getBMIValues'])->name('getBMIValues');
