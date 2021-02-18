<?php

use App\Models\Round;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\RoundCollection as RoundResource;
use App\Http\Resources\Round as SingleRoundResource;

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
// Route::get('/mainRound','Api\RoundController@index');

Route::post('/login', 'Auth\ApiAuthController@login')->name('login.api');
Route::post('/register','Auth\ApiAuthController@register')->name('register.api');
Route::post('/logout', 'Auth\ApiAuthController@logout')->name('logout.api');


Route::middleware('auth:api')->group( function(){
    // Route::get('/user', 'Auth\ApiAuthController@user')->name('user.info');
    Route::get('/mainRound','Api\RoundController@index');
    Route::post('/submitResult','Api\RoundController@sb');
    Route::get('/lastRoundResult', 'Api\RoundController@llr');
    Route::get('/leagues', 'Api\RoundController@leagues');
    Route::get('/leaderBoard', 'Api\RoundController@leaderBoard');
    Route::get('/agents', 'Api\RoundController@agents');
    Route::post('/myleague', 'Api\MyLeagueController@index');
    Route::post('/updateProfile', 'Api\ProfileController@updateUser')->name('profileUpdate.api');
    Route::get('/agentDashBoard','Api\AdminDashboardController@index');
    
    


});

Route::group(['namespace'=>'Api'],function (){
Route::get('/roundx','RoundController@index');
Route::get('/rounds', function () {
    return new RoundResource(Round::all());
    
});
Route::get('/round', function () {
    return new SingleRoundResource(Round::find(1));
    
});
});