<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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
    return redirect()->route('login');
});

Route::get('/dashboard',[DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::prefix('admin')->group(function(){
        Route::get('/users', [AdminController::class, 'indexUsers'])->name('admin.indexUsers');
        Route::put('/users/update', [AdminController::class, 'update'])->name('admin.users.update');
        Route::get('/permissions', [AdminController::class, 'createPermissions'])->name('admin.createPermissions');
        Route::post('/permissions', [AdminController::class, 'storePermissions'])->name('admin.storePermissions');
        Route::put('/permissions/user/{id}', [AdminController::class, 'updatePermissionUser'])->name('admin.updatePermissionUser');
        Route::delete('/permissions/{id}', [AdminController::class, 'deletePermissionUser'])->name('admin.deletePermissionUser');
    });

    Route::get('/produtos', [ProdutoController::class, 'index'])->name('produtos.index');
    Route::get('/marcas', [MarcaController::class, 'index'])->name('marcas.index');
    Route::get('/categorias', [CategoriaController::class, 'index'])->name('categorias.index');
});

require __DIR__.'/auth.php';
