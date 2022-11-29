<?php
use Illuminate\Support\Facades\Route;

\L::Panel(app('admin')); ///SetLangredirecttoadmin
\L::LangNonymous(); //RunRouteLang'namespace'=>'Admin',

//Route::group(['prefix' => app('joined'), 'middleware' => 'Lang'], function () {
	Route::resource('users','Admin\Users'); 
	Route::post('users/multi_delete','Admin\Users@multi_delete');
//});


Route::group(['prefix' => app('admin'), 'middleware' => 'Lang'], function () {
	Route::get('lock/screen', 'Admin\AdminAuthenticated@lock_screen');
	Route::get('theme/{id}', 'Admin\Dashboard@theme');
	Route::group(['middleware' => 'admin_guest'], function () {

		Route::get('login', 'Admin\AdminAuthenticated@login_page');
		Route::post('login', 'Admin\AdminAuthenticated@login_post');
		Route::view('forgot/password', 'admin.forgot_password');

		Route::post('reset/password', 'Admin\AdminAuthenticated@reset_password');
		Route::get('password/reset/{token}', 'Admin\AdminAuthenticated@reset_password_final');
		Route::post('password/reset/{token}', 'Admin\AdminAuthenticated@reset_password_change');
	});

	Route::view('need/permission', 'admin.no_permission');
	
	Route::group(['middleware' => 'admin:admin'], function () {
		if (class_exists(\UniSharp\LaravelFilemanager\Lfm::class)) {
			Route::group(['prefix' => 'filemanager'], function () {
				\UniSharp\LaravelFilemanager\Lfm::routes();
			});
		}

		////////AdminRoutes/*Start*///////////////
		Route::get('/', 'Admin\Dashboard@home');
		Route::any('logout', 'Admin\AdminAuthenticated@logout');
		Route::get('account', 'Admin\AdminAuthenticated@account');
		Route::post('account', 'Admin\AdminAuthenticated@account_post');
		Route::resource('settings', 'Admin\Settings');
		Route::resource('admingroups', 'Admin\AdminGroups');
		Route::post('admingroups/multi_delete', 'Admin\AdminGroups@multi_delete');
		Route::resource('admins', 'Admin\Admins');
		Route::post('admins/multi_delete', 'Admin\Admins@multi_delete');
		Route::resource('test','Admin\tests'); 
		Route::post('test/multi_delete','Admin\tests@multi_delete'); 
		Route::resource('pages','Admin\Pages'); 
		Route::post('pages/multi_delete','Admin\Pages@multi_delete'); 
		Route::resource('slides','Admin\Slides'); 
		Route::post('slides/multi_delete','Admin\Slides@multi_delete'); 
		Route::resource('banners','Admin\Banners'); 
		Route::post('banners/multi_delete','Admin\Banners@multi_delete'); 
		Route::resource('infos','Admin\Infos'); 
		Route::post('infos/multi_delete','Admin\Infos@multi_delete'); 
		Route::resource('socials','Admin\Socials'); 
		Route::post('socials/multi_delete','Admin\Socials@multi_delete'); 
		Route::resource('voteplans','Admin\VotePlans'); 
		Route::post('voteplans/multi_delete','Admin\VotePlans@multi_delete'); 
		Route::resource('bfotplans','Admin\BFOTPlans'); 
		Route::post('bfotplans/multi_delete','Admin\BFOTPlans@multi_delete'); 
		Route::resource('blogs','Admin\Blogs'); 
		Route::post('blogs/multi_delete','Admin\Blogs@multi_delete'); 
		Route::resource('users','Admin\Users')->except(['create']); 
		Route::post('users/multi_delete','Admin\Users@multi_delete');
		Route::resource('comments','Admin\Comments')->except(['create']); 
		Route::post('comments/multi_delete','Admin\Comments@multi_delete'); 
		Route::resource('reactions','Admin\Reactions')->except(['create']); 
		Route::post('reactions/multi_delete','Admin\Reactions@multi_delete'); 
		Route::resource('icos','Admin\ICOs'); 
		Route::post('icos/multi_delete','Admin\ICOs@multi_delete'); 
		Route::post('icos/get/status','Admin\ICOs@get_status'); 
		Route::resource('icousers','Admin\IcoUsers'); 
		Route::post('icousers/multi_delete','Admin\IcoUsers@multi_delete'); 
		Route::post('icousers/get/status','Admin\IcoUsers@get_status'); 
		Route::post('icousers/get/purchase/method','Admin\IcoUsers@get_purchase_method'); 
		////////AdminRoutes/*End*///////////////
	});


});