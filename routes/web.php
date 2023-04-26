<?php

use App\Http\Controllers\EmployeeController;
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


Route::get('/', [EmployeeController::class,'index']);
Route::get('/employees/add', [EmployeeController::class, 'add']);
Route::post('/employees/store', [EmployeeController::class, 'save']);
Route::post('/employees/delete', [EmployeeController::class, 'delete']);
Route::get('/employees/edit/{id}', [EmployeeController::class, 'edit']);
Route::post('/employees/update', [EmployeeController::class, 'update']);
