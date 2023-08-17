<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserDetailController;
use App\Http\Middleware\AdminAccess;
use App\Http\Middleware\AuthenticateJWT;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(AuthController::class)    
    ->prefix('auth')
    ->group(function() {
        Route::post('/login', 'login');        
        Route::post('/register', 'register');
        Route::middleware(AuthenticateJWT::class)->group(function() {
            Route::post('/logout', 'logout');
            Route::post('/refresh', 'refresh');
        });        
    }
);  

Route::middleware([AuthenticateJWT::class, AdminAccess::class])
    ->prefix('user')
    ->group(function() {        
        Route::controller(UserController::class)->group(function() {
            Route::get('/', 'index');            
            Route::get('/{id}', 'show')->where('id', '[0-9]+');
            Route::post('/create', 'store');
            Route::put('/update/{id}', 'update')->where('id', '[0-9]+');;
            Route::delete('/delete/{id}', 'destroy')->where('id', '[0-9]+');;
        });         
        
        Route::controller(UserDetailController::class)
        ->prefix('{userId}')
        ->group(function() {            
            Route::get('details', 'showByUserId');
            Route::post('details/create', 'store');    
            Route::put('details/update', 'update')->where('id', '[0-9]+');                
        });   

        Route::controller(AddressController::class)
        ->prefix('{userId}')
        ->group(function() {                
            Route::get('address', 'showByUserId');
            Route::get('address/{id}', 'showByUserAndAddressId')->where('id', '[0-9]+');
            Route::post('address/create', 'store');
            Route::put('address/update/{id}', 'update')->where('id', '[0-9]+');
            Route::delete('address/delete/{id}', 'destroy')->where('id', '[0-9]+');
        });       

        Route::controller(SaleController::class)
        ->prefix('{userId}')
        ->group(function() {
            Route::get('shopping/', 'showByUserId');
            Route::get('shopping/{id}', 'showByUserAndSaleId')->where('id', '[0-9]+');
            Route::delete('shopping/{id}', 'destroyByUserAndSaleId')->where('id', '[0-9]+');
        });                         
    });            

Route::middleware(AuthenticateJWT::class)
    ->controller(UserProfileController::class)
    ->prefix('my')
    ->group(function() {    

        Route::get('/', 'index');            
        Route::put('/update', 'update');
        Route::delete('/delete', 'destroy');
                            
        Route::prefix('details')->group(function() {
            Route::get('/', 'details');        
            Route::post('/create', 'detailStore');    
            Route::put('/update', 'detailsUpdate');                
        });
    
        Route::prefix('address')->group(function() {
            Route::get('/', 'address');        
            Route::get('/{id}', 'addressShow')->where('id', '[0-9]+');
            Route::post('/create', 'addressStore');    
            Route::put('/update/{id}', 'addressUpdate')->where('id', '[0-9]+');
            Route::delete('/delete/{id}', 'adderessDestroy')->where('id', '[0-9]+');
        });       
    
        Route::prefix('shopping')->group(function() {
            Route::get('/', 'shopping');                        
            Route::get('/{id}', 'shoppingShow')->where('id', '[0-9]+');                                
            Route::post('/create', 'shoppingStore');
            Route::delete('/delete/{id}', 'shoppingDestroy')->where('id', '[0-9]+');
        });                         
});

Route::controller(ProductController::class)    
    ->prefix('product')
    ->group(function() {
        Route::get('/', 'index');
        Route::get('/{id}', 'show')->where('id', '[0-9]+');
        Route::middleware([AuthenticateJWT::class, AdminAccess::class])->group(function() {            
            Route::post('/create', 'store');
            Route::put('/update/{id}', 'update')->where('id', '[0-9]+');
            Route::delete('/delete/{id}', 'destroy')->where('id', '[0-9]+');
        });        
    }
);

Route::controller(CategoryController::class)    
    ->prefix('category')
    ->group(function() {
        Route::get('/', 'index');
        Route::get('/{id}', 'show')->where('id', '[0-9]+');
        Route::middleware([AuthenticateJWT::class, AdminAccess::class])->group(function() {
            Route::post('/create', 'store');
            Route::put('/update/{id}', 'update')->where('id', '[0-9]+');
            Route::delete('/delete/{id}', 'destroy')->where('id', '[0-9]+');
        });
    }
);

Route::controller(SaleController::class)    
    ->middleware(AuthenticateJWT::class)
    ->prefix('sale')
    ->group(function(){        
        Route::post('/create', 'store');
        Route::middleware(AdminAccess::class)->group(function() {
            Route::get('/', 'index');
            Route::get('/{id}', 'showBySaleId')->where('id', '[0-9]+');                        
            Route::get('/user/{userId}', 'showByUserId')->where('userId', '[0-9]+');
            Route::delete('/delete/{id}', 'destroy')->where('id', '[0-9]+');
        });                            
    }
);    

Route::controller(PaymentController::class)
    ->middleware(AuthenticateJWT::class)
    ->prefix('payment')
    ->group(function() {        
        Route::middleware(AdminAccess::class)->group(function() {
            Route::get('/cash/{sale}', 'info')->where('sale', '[0-9]+');
            Route::put('/cash/{sale}', 'cash')->where('sale', '[0-9]+');
        });        
    }
);