<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\DailyHesabuController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\GroupExpenseController;
use App\Http\Controllers\ContributionController;
use App\Http\Controllers\InHouseMaintenanceController;

Route::get('/', function () {
    return view('welcome');
});



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware(['auth'])->group(function () {

    
    // Car routes
    Route::resource('cars', CarController::class)->except('show');
    Route::get('/cars/create', [CarController::class, 'create'])->name('cars.create');
    Route::get('/cars/scrape/refresh', [CarController::class, 'fetchOffenceData'])->name('cars.scrape');
        Route::get('/cars/scrape', [CarController::class, 'ShowOffense'])->name('offense.index');
    Route::get('/ticket/{reference}', [CarController::class, 'showTicket'])->name('view.ticket');

    Route::get('cars/{id}', [CarController::class, 'show'])->name('cars.show'); // Show car details
    Route::get('cars/{id}/assign-supervisor', [CarController::class, 'assignSupervisorForm'])->name('cars.assign-supervisor');
Route::patch('cars/{id}/assign-supervisor', [CarController::class, 'assignSupervisor'])->name('cars.update-supervisor');
Route::get('cars/group/create',[CarController::class, 'GroupCreate'])->name('GroupCreate.create');
Route::post('cars/group',[CarController::class, 'GroupStore'])->name('GroupStore.store');
Route::get('cars/group/index',[CarController::class, 'GroupIndex'])->name('GroupIndex.index');

Route::resource('cars/group/expenses', GroupExpenseController::class)->shallow();
Route::get('/cars/group/expenses/create/{group}', [GroupExpenseController::class, 'create'])->name('expenses.create');
Route::get('/cars/group/expenses/index/{group}', [GroupExpenseController::class, 'index'])->name('expenses.index');
Route::resource('expenses.contributions', ContributionController::class);



});
// web.php

// web.php

// web.php

Route::get('/foo', function () {
    return 'FOO WORKS';
});



Route::middleware(['auth'])->group(function () {
    Route::get('/supervisors', [UserController::class, 'index'])->name('supervisors.index'); // List supervisors
    Route::get('/supervisors/create', [UserController::class, 'create'])->name('supervisors.create'); // Create form
    Route::post('/supervisors', [UserController::class, 'store'])->name('supervisors.store'); // Store supervisor
    Route::patch('/supervisors/{id}/disable', [UserController::class, 'disableSupervisor'])->name('supervisors.disable');
    Route::patch('/supervisors/{id}/enable', [UserController::class, 'enableSupervisor'])->name('supervisors.enable');
    Route::get('supervisors/{id}', [UserController::class, 'show'])->name('supervisors.show');
    Route::patch('supervisors/{id}/assign-cars', [UserController::class, 'assignCars'])->name('supervisors.assign-cars');
    Route::delete('/supervisors/{supervisor}/unassign-car/{car}', [UserController::class, 'unassignCar'])
    ->name('supervisors.unassign-car');



});


Route::middleware(['web'])->group(function () {
    Route::get('/company/register', [RegistrationController::class, 'showForm'])->name('register.form');
    Route::post('/company/register', [RegistrationController::class, 'handleStep'])->name('register.handleStep');
});



Route::middleware('auth')->group(function () {
    Route::get('/daily-hesabu', [DailyHesabuController::class, 'index'])->name('daily-hesabu.index');
    Route::post('/daily-hesabu', [DailyHesabuController::class, 'store'])->name('daily-hesabu.store');
    Route::put('daily-hesabu/{dailyHesabu}', [DailyHesabuController::class, 'update'])->name('daily-hesabu.update');

});



Route::resource('maintenances', MaintenanceController::class);
Route::post('/maintenances/store-multiple', [MaintenanceController::class, 'storeMultiple'])->name('maintenances.storeMultiple');

Route::resource('in-house-maintenance', InHouseMaintenanceController::class);
Route::post('/in-house-maintenance/store-multiple', [ InHouseMaintenanceController::class, 'storeMultiple'])->name('in-house-maintenances.storeMultiple');
Route::post('/in-house-maintenance/payment', [ InHouseMaintenanceController::class,'makePayment'])->name('makePayment');
Route::get('/cars/group/expenses/create/{group}', [GroupExpenseController::class, 'create'])->name('expenses.create');
Route::get('/cars/group/expenses/index/{group}', [GroupExpenseController::class, 'index'])->name('expenses.index');




Route::resource('services', ServiceController::class);


Route::resource('maintenances', MaintenanceController::class);
Route::post('maintenances/{maintenance}/add-payment', [MaintenanceController::class, 'addPayment'])->name('maintenances.addPayment');
Route::get('maintenances/{maintenance}/payments', [MaintenanceController::class, 'viewPayments'])->name('maintenances.viewPayments');
