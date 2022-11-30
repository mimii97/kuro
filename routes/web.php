<?php

use Illuminate\Support\Facades\Route;
use Spatie\Honeypot\ProtectAgainstSpam;

// L::LangNonymous();
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
Route::group(['prefix' => 'user', 'middleware' => 'auth','middleware' => 'Lang'],
	
	function () {
		Route::any('logout', 'Auth\LoginController@logout')->name('web.logout');

		
		Route::get('/eth/signature', [App\Http\Controllers\Web3\Web3AuthController::class, 'signature'])->name('metamask.signature');
		Route::post('/eth/authenticate', [App\Http\Controllers\Web3\Web3AuthController::class, 'authenticate'])->name('metamask.authenticate');

		Route::get('/eth/getKuroBalance', [App\Http\Controllers\Web3\Web3AuthController::class, 'getKuroBalance'])->name('metamask.getKuroBalance');

		
		Route::group(['middleware' => 'admin:web'], function () {

		Route::resource('/voteplans','User\UserVotePlans'); 
		Route::resource('/bfotplans','User\UserBFOTPlans'); 
		Route::resource('/icousers','User\UserICOsUsers'); 

		Route::get('/dashboard', 'User\Dashboard@home');
		});
	}
	
);
Route::get('/metamask-login', function () {
	/*if (Auth::check()) {
		return redirect('login');
	}*/
	return view('auth.metamask-login');
});
Route::resource('/voteplans','User\UserVotePlans'); 
Route::resource('/bfotplans','User\UserBFOTPlans'); 
Route::resource('/icos','User\ICOs', ['only' => ['index','show', 'store']]); 

Route::view('need/permission', 'user.no_permission');
Route::get('/', function () {
	return view('welcome');
});


Route::get('/home', [App\Http\Controllers\User\HomeController::class, 'index'])->name('home');
Route::get('/blog', [App\Http\Controllers\User\HomeController::class, 'blog'])->name('blog');
Route::get('/ICO', [App\Http\Controllers\User\HomeController::class, 'ICO'])->name('ICO');
Route::get('/vote', [App\Http\Controllers\User\HomeController::class, 'vote'])->name('vote');
Route::get('/about', [App\Http\Controllers\User\HomeController::class, 'about'])->name('about');
Route::get('/Beteam', [App\Http\Controllers\User\HomeController::class, 'Beteam'])->name('Beteam');

Auth::routes();



