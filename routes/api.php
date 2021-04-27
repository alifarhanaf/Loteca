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
// Route::get('/winner','Api\LeaderBoardController@winner');
// Route::get('/leaderBoard', 'Api\RoundController@leaderBoard');
// Route::post('/closedLeague', 'Api\LeaderBoardController@closedLeague');
// Route::post('/activeLeague', 'Api\MyLeagueController@activeLeague');

Route::post('/login', 'Auth\ApiAuthController@login')->name('login.api');
Route::post('/register','Auth\ApiAuthController@register')->name('register.api');
Route::post('/logout', 'Auth\ApiAuthController@logout')->name('logout.api');
Route::post('/resetPasswordCode','Auth\ApiAuthController@changePasswordCode');
Route::post('/updatePassword','Auth\ApiAuthController@updatePassword');


Route::get('/test','Api\AdminDashboardController@testz');
Route::post('/arrayCheck','Api\RoundController@arrayCheck');




Route::middleware('auth:api')->group( function(){
    Route::post('/submitBet','Api\BetController@betSubmit');
    Route::get('/lastResultsList','Api\ResultController@resultsList');
    // Route::get('/user', 'Auth\ApiAuthController@user')->name('user.info');
    Route::get('/mainRound','Api\RoundController@index');
    Route::post('/submitResult','Api\RoundController@betSubmit');
    Route::get('/lastRoundResult', 'Api\RoundController@llr');
    
    // Route::get('/leaderBoard', 'Api\LeaderBoardController@leaderB');
    Route::post('/updateProfile', 'Api\ProfileController@updateUser')->name('profileUpdate.api');
    Route::get('/leaderBoard', 'Api\LeaderBoardController@leaderC');
    Route::get('/agents', 'Api\RoundController@agents');
    Route::post('/myleague', 'Api\MyLeagueController@index');

    Route::get('/agentDashBoard','Api\AdminDashboardController@index');
    Route::get('/userDashBoard','Api\UserDashBoardController@userDashboard');
    Route::post('/userRecord','Api\CoinController@index');
    Route::post('/sendCoins','Api\CoinController@sendCoins');
    Route::get('/coins_record','Api\CoinController@coinsRecord');
    Route::get('/user_bets_record','Api\CoinController@userBetsRecord');
    Route::post('/bet_ticket_detail','Api\CoinController@ticketData');
    Route::get('/user_coins_record','Api\CoinController@userCoinsRecord');
    Route::post('/winner','Api\LeaderBoardController@winner');
    
    Route::post('/activeLeague', 'Api\MyLeagueController@activeLeague');
    Route::post('/mainRoundForAgent','Api\AgentController@index');
    Route::post('/ValidateUser','Api\AgentController@ValidateUser');
    Route::post('/submitResultByAgent','Api\AgentController@betSubmit');
    Route::post('/feedback','Api\FeedBackController@index');
    // Route::post('/resendCode','Auth\ApiAuthController@resendCode');
    Route::get('/resendCode','Auth\ApiAuthController@resendCode');
    Route::post('/confirmEmail','Auth\ApiAuthController@confirmEmail');
    //League APIs
    Route::get('/participatedleagues', 'Api\MyLeaguesController@participatedleagues');
    Route::post('/leagueDetails', 'Api\MyLeaguesController@leagueDetails');
    Route::post('/resultScreenDetails','Api\ResultController@resultScreenDetails');
    

    

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