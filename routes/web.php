<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SalessController;
use App\Http\Controllers\DetailSalesController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;


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

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth:web'])->group(function () {

    Route::middleware([RoleMiddleware::class . ':admin'])->group(function () {
        Route::get('/users', [UserController::class,'index'])->name('users');
        Route::get('/add-employee', [UserController::class,'create'])->name('add-employee');
        Route::get('/edit-employee/{id}', [UserController::class,'edit'])->name('edit-employee');
        
        Route::post('/create-user', [UserController::class,'store'])->name('create-user');
        Route::put('/user/update/{id}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/user/delete/{id}', [UserController::class, 'destroy'])->name('user.delete');


        Route::get('/add-product', [ProductController::class,'create'])->name('add-product');
        Route::get('/edit-product/{id}', [ProductController::class,'edit'])->name('edit-product');
        
        Route::post('/create-product', [ProductController::class,'store'])->name('create-product');
        Route::put('/products/update/{id}', [ProductController::class, 'update'])->name('update-product');
        Route::delete('products/delete/{id}', [ProductController::class, 'destroy'])->name('product.delete');
        Route::put('/uppdate-stock/{id}', [ProductController::class, 'updateStock'])->name('uppdate-stock');
    
    });

    Route::middleware([RoleMiddleware::class . ':employee'])->group(function () {
        Route::prefix('/sales')->name('sales.')->group(function () {
            Route::get('/create',[SalessController::class, 'create'])->name('create');
            Route::post('/create/post',[SalessController::class, 'store'])->name('store');
            Route::post('/create/post/createsales',[SalessController::class, 'createsales'])->name('createsales');
            Route::get('/create/post',[SalessController::class, 'post'])->name('post');
            Route::get('/print/{id}',[DetailSalesController::class, 'show'])->name('print.show');
            Route::get('/create/member/{id}', [SalessController::class, 'createmember'])->name('create.member');
        });
    });

    Route::prefix('/sales')->name('sales.')->group(function () {
        Route::get('/list',[SalessController::class, 'index'])->name('list');
        Route::get('/exportexcel', [DetailSalesController::class, 'exportexcel'])->name('exportexcel');

    });

    Route::middleware(['role:employee'])->group(function () {

    });

   
    
    Route::get('/', [DashboardController::class,'index'])->name('index');
    Route::get('/index', [DashboardController::class,'index'])->name('index');



    Route::get('/product-list', [ProductController::class,'index'])->name('product-list');

    Route::get('/download/{id}', [DetailSalesController::class, 'downloadPDF'])->name('download');

    
    
    
    
    
    Route::get('/edit-product', function () {
        return view('edit-product');
    })->name('edit-product');
    
    Route::get('/customers', function () {                         
        return view('customers');
    })->name('customers');  
    
    
    Route::get('/signin-3', function () {
        return view('signin-3');
    })->name('signin-3');
    
    Route::get('/pos', function () {                         
        return view('pos');
    })->name('pos');  

});

