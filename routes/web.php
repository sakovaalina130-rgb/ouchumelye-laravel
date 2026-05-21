<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CabinetController;
use App\Http\Controllers\CraftController;
use App\Http\Controllers\MasterClassController;
use App\Http\Controllers\RegistrationController;
use App\Models\CraftType;
use Illuminate\Support\Facades\Route;

// Главная страница
Route::get('/', function () {
    $craftTypes = CraftType::all();
    $myRegistrations = auth()->check() ? auth()->user()->registrations()->with('masterClass.craftType')->get() : collect();
    return view('index', compact('craftTypes', 'myRegistrations'));
})->name('home');

// Аутентификация
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout.get');

// Виды творчества
Route::get('/craft/{id}', [CraftController::class, 'show'])->name('craft.show');

// Запись на мастер-класс
Route::get('/confirm/{id}', [RegistrationController::class, 'confirm'])->name('confirm');
Route::post('/register-master-class', [RegistrationController::class, 'store'])->name('register.store');

// Личный кабинет
Route::get('/cabinet', [CabinetController::class, 'index'])->middleware('auth')->name('cabinet');

// Управление мастер-классами
Route::middleware(['auth'])->group(function () {
    Route::get('/master-class/create', [MasterClassController::class, 'create'])->name('master-class.create');
    Route::post('/master-class', [MasterClassController::class, 'store'])->name('master-class.store');
    Route::get('/master-class/{id}/edit', [MasterClassController::class, 'edit'])->name('master-class.edit');
    Route::put('/master-class/{id}', [MasterClassController::class, 'update'])->name('master-class.update');
    Route::get('/check-slots', [MasterClassController::class, 'checkSlots'])->name('check-slots');
});

// Тестовый маршрут
Route::get('/test', function () {
    return response()->json(['message' => 'Test works']);
});
