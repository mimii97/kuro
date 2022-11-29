<?php
use Illuminate\Support\Facades\Route;

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
// your api is integerated but if you want reintegrate no problem
// to configure jwt-auth visit this link https://jwt-auth.readthedocs.io/en/docs/

Route::group(['middleware' => ['ApiLang', 'cors'], 'prefix' => 'v1', 'namespace' => 'Api\V1'], function () {

	Route::get('/', function () {

	});
	// Insert your Api Here Start //
	Route::group(['middleware' => 'guest'], function () {
		Route::post('login', 'Auth\AuthAndLogin@login')->name('api.login');
		Route::post('register', 'Auth\Register@register')->name('api.register');
	});

	Route::group(['middleware' => 'auth:api'], function () {
		Route::get('account', 'Auth\AuthAndLogin@account')->name('api.account');
		Route::post('logout', 'Auth\AuthAndLogin@logout')->name('api.logout');
		Route::post('refresh', 'Auth\AuthAndLogin@refresh')->name('api.refresh');
		Route::post('me', 'Auth\AuthAndLogin@me')->name('api.me');
		Route::post('change/password', 'Auth\AuthAndLogin@change_password')->name('api.change_password');
		//Auth-Api-Start//
		Route::apiResource("page","PageControllerApi", ["as" => "api.page"]); 
			Route::post("page/multi_delete","PageControllerApi@multi_delete"); 
			Route::apiResource("test","testApi", ["as" => "api.test"]); 
			Route::post("test/multi_delete","testApi@multi_delete"); 
			Route::apiResource("pages","PagesApi", ["as" => "api.pages"]); 
			Route::post("pages/multi_delete","PagesApi@multi_delete"); 
			Route::apiResource("slides","SlidesApi", ["as" => "api.slides"]); 
			Route::post("slides/multi_delete","SlidesApi@multi_delete"); 
			Route::apiResource("banners","BannersApi", ["as" => "api.banners"]); 
			Route::post("banners/multi_delete","BannersApi@multi_delete"); 
			Route::apiResource("infos","InfosApi", ["as" => "api.infos"]); 
			Route::post("infos/multi_delete","InfosApi@multi_delete"); 
			Route::apiResource("socials","SocialsApi", ["as" => "api.socials"]); 
			Route::post("socials/multi_delete","SocialsApi@multi_delete"); 
			Route::apiResource("voteplans","VotePlansApi", ["as" => "api.voteplans"]); 
			Route::post("voteplans/multi_delete","VotePlansApi@multi_delete"); 
			Route::apiResource("bfotplans","BFOTPlansApi", ["as" => "api.bfotplans"]); 
			Route::post("bfotplans/multi_delete","BFOTPlansApi@multi_delete"); 
			Route::apiResource("blogs","BlogsApi", ["as" => "api.blogs"]); 
			Route::apiResource("blogcomments","BlogsApi", ["as" => "api.blog_comments"])->only('blog_comments');
			Route::post("blogs/multi_delete","BlogsApi@multi_delete"); 
			Route::apiResource("joinedusers","JoinedUsersApi", ["as" => "api.joinedusers"]); 
			Route::post("joinedusers/multi_delete","JoinedUsersApi@multi_delete"); 
			Route::apiResource("comments","CommentsApi", ["as" => "api.comments"]); 
			Route::post("comments/multi_delete","CommentsApi@multi_delete"); 
			Route::apiResource("reactions","ReactionsApi", ["as" => "api.reactions"]); 
			Route::post("reactions/multi_delete","ReactionsApi@multi_delete"); 
			Route::apiResource("icos","ICOsApi", ["as" => "api.icos"]); 
			Route::post("icos/multi_delete","ICOsApi@multi_delete"); 
			Route::apiResource("icousers","IcoUsersApi", ["as" => "api.icousers"]); 
			Route::post("icousers/multi_delete","IcoUsersApi@multi_delete"); 
			//Auth-Api-End//
	});
	// Insert your Api Here End //
});