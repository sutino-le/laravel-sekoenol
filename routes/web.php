<?php

use App\Http\Controllers\Admin\User;
use App\Http\Controllers\DataTableAjaxCRUDController;
use Illuminate\Support\Facades\Route;

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


Route::get('/main', function () {
    return view('admin.main.layout');
});


Route::get('/auth', function () {
    return view('admin.user.login');
});


Route::get('/register', [User::class, 'register']);



Route::get('ajax-crud-datatable', [DataTableAjaxCRUDController::class, 'index']);
Route::post('store-company', [DataTableAjaxCRUDController::class, 'store']);
Route::post('edit-company', [DataTableAjaxCRUDController::class, 'edit']);
Route::post('delete-company', [DataTableAjaxCRUDController::class, 'destroy']);

Route::get('user', [User::class, 'index']);
Route::post('store-user', [User::class, 'store']);
Route::post('edit-user', [User::class, 'edit']);
Route::post('delete-user', [User::class, 'destroy']);
