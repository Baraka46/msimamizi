<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
Route::middleware(['auth'])->group(function () {
    // Car routes
    Route::resource('cars', CarController::class)->except('show');
    Route::get('/cars/create', [CarController::class, 'create'])->name('cars.create');

    Route::get('cars/{id}', [CarController::class, 'show'])->name('cars.show'); // Show car details
});
// web.php

// web.php

Route::middleware(['auth', 'role:owner'])->group(function () {
    Route::get('/users/create-supervisor', [UserController::class, 'createSupervisorForm'])->name('users.create.supervisor');
    Route::post('/users/create-supervisor', [UserController::class, 'createSupervisor'])->name('users.store.supervisor');
});
