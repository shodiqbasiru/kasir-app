<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransactionDetailsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    // Mengambil pengguna yang sudah login
    $user = Auth::user();

    // Mengambil roles pengguna
    $roles = $user->getRoleNames();

    // Mengambil permissions pengguna
    $permissions = $user->getAllPermissions()->pluck('name');

    return response()->json([
        'user' => $user,
        'roles' => $roles,
        'permissions' => $permissions,
    ]);
});
Route::middleware('auth:sanctum')->get('/authenticated', function () {
    return true;
});

// product
Route::get('/barang', [BarangController::class, 'index']);
Route::get('/barang/{id}', [BarangController::class, 'show']);
Route::post('/barang', [BarangController::class, 'store']);
Route::delete('/barang/{id}', [BarangController::class, 'destroy']);
Route::put('/barang/{id}', [BarangController::class, 'update']);

// category
Route::get('/kategori', [CategoryController::class, 'index']);
Route::get('/kategori/{id}', [CategoryController::class, 'show']);
Route::post('/kategori', [CategoryController::class, 'store']);
Route::delete('/kategori/{id}', [CategoryController::class, 'destroy']);
Route::put('/kategori/{id}', [CategoryController::class, 'update']);

//transaction
Route::get('/transaction', [TransactionController::class, 'index']);
Route::get('/transaction/{id}', [TransactionController::class, 'show']);
Route::post('/transaction', [TransactionController::class, 'createData']);
Route::put('/transaction/{id}', [TransactionController::class, 'update']);
Route::delete('/transaction/{id}', [TransactionController::class, 'destroy']);


//transaction detail
Route::get('/transaction-details', [TransactionDetailsController::class, 'index']);
Route::post('/transaction-details', [TransactionDetailsController::class, 'createData']);

//auth
Route::post('/register', [AuthController::class, 'registerUser']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logoutUser']);


Route::get('/users', [AuthController::class, 'index']);
Route::get('/users/{id}', [AuthController::class, 'show']);
Route::put('/users/{id}', [AuthController::class, 'editUser']);
Route::delete('/users/{id}', [AuthController::class, 'destroy']);
Route::get('/users/{id}/edit', [AuthController::class, 'getDataUser']);

Route::get('/users-permission', [AuthController::class, 'getDataPermission']);

// permission
Route::get('/roles', [PermissionController::class, 'getRoles']);
