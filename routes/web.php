<?php

use App\Http\Controllers\Admin\ChecklistController as AdminChecklistController;
use App\Http\Controllers\Admin\ChecklistGroupController as AdminChecklistGroupController;
use App\Http\Controllers\Admin\PagesController as AdminPagesController;
use App\Http\Controllers\Admin\TaskController as AdminTaskController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth'])->group(function () {

    Route::prefix('admin')->as('admin.')->middleware('is_admin')->group(function () {
        Route::resource('pages', AdminPagesController::class);
        Route::resource('checklist_group', AdminChecklistGroupController::class);
        Route::resource('checklist_group.checklist', AdminChecklistController::class);
        Route::resource('checklist.task', AdminTaskController::class);
    });
});
require __DIR__ . '/auth.php';
