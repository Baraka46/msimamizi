<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\DailyHesabuController;

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

    Route::get('cars/{id}', [CarController::class, 'show'])->name('cars.show'); // Show car details
    Route::get('cars/{id}/assign-supervisor', [CarController::class, 'assignSupervisorForm'])->name('cars.assign-supervisor');
Route::patch('cars/{id}/assign-supervisor', [CarController::class, 'assignSupervisor'])->name('cars.update-supervisor');

});
// web.php

// web.php

// web.php



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
});
