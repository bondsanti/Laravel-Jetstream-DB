<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ServiceController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/user', function () {
        // $users=User::all(); //model users
        $users=DB::table('users')->get();
        return view('users',compact('users'));
    })->name('user');

    Route::get('/department',[DepartmentController::class,'index'])->name('department');
    Route::post('/department/insert',[DepartmentController::class,'insert'])->name('insertDepartment');
    Route::get('/department/edit/{id}',[DepartmentController::class,'edit']);
    Route::post('/department/update/{id}',[DepartmentController::class,'update']);
    Route::get('/department/softdel/{id}',[DepartmentController::class,'softdel']);
    Route::get('/department/restore/{id}',[DepartmentController::class,'restore']);
    Route::get('/department/del/{id}',[DepartmentController::class,'del']);


    Route::get('/service',[ServiceController::class,'index'])->name('service');
    Route::post('/service/insert',[ServiceController::class,'insert'])->name('insertService');
    Route::get('/service/edit/{id}',[ServiceController::class,'edit']);
    Route::post('/service/update/{id}',[ServiceController::class,'update']);
    Route::get('/service/del/{id}',[ServiceController::class,'del']);
});


