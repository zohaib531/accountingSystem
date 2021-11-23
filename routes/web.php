<?php

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

Route::get('/clear-all', function () {
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:cache');
    Artisan::call('view:clear');
    $homeURL = url('/');
    return 'Views Cleared, Routes Cleared, Cache Cleared, and Config Cleared Successfully ! <a href="' . $homeURL . '">Go Back To Home</a>';
});


Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('uploadFile','ProductController@uploadAllFiles')->name('uploadFile');

Route::middleware(['auth'])->group(function(){
    Route::view('/dashboard','admin.index')->name('dashboard');
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('accounts', AccountsController::class);
    Route::resource('sub-accounts', SubAccountController::class);
    Route::resource('products', ProductController::class);
    Route::resource('salePurchase', SalePurchaseVoucherController::class);
    Route::resource('journal', JournalVoucherController::class);
    Route::get('trialBalance', 'TrialBalance@index')->name('trial_balance');
});
