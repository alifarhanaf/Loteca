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
Route::get('/login','Web\AuthController@index')->name('login');
Route::post('/processing','Auth\ApiAuthController@login')->name('submit.login');

Route::middleware('admin:web')->group( function(){
Route::get('/dashboard','Web\DashboardController@index')->name('dashboard');
Route::get('/round_detail/{id}','Web\RoundController@roundPage')->name('roundDetail');
Route::get('/create_round','Web\DashboardController@createRound')->name('create_round');
Route::get('/round_grid','Web\DashboardController@roundGrid')->name('round_grid');
Route::get('/create_game','Web\DashboardController@createGame')->name('create_game');
Route::get('/game_grid','Web\DashboardController@gameGrid')->name('game_grid');
Route::post('/game_submit','Web\DashboardController@submitGame')->name('submit.game');
Route::post('/round_submit','Web\DashboardController@submitRound')->name('submit.round');
Route::post('/finalize_round/{id}','Web\DashboardController@finalizeRound')->name('finalize.round');
Route::post('/close_round/{id}','Web\DashboardController@closeRound')->name('close.round');
Route::delete('/delete_round/{id}','Web\DashboardController@destroyRound')->name('delete.round');
Route::get('/round_edit/{id}', 'Web\DashboardController@editRound')->name('edit.round');
Route::post('/submit_round_edit/{id}', 'Web\DashboardController@editRoundSubmit')->name('edit.round.submit');
Route::get('/game_answers','Web\DashboardController@gameAnswerGrid')->name('game_answer_grid');
Route::post('/submit_answers/{id}','Web\DashboardController@submitAnswer')->name('submit_game_answer');
Route::get('/leaderBoard','Web\LeaderBoardController@leaderB')->name('leaderB');
Route::get('/sendMail','Web\DashboardController@sendMail');
Route::get('/create_game','Web\DashboardController@createGame')->name('create_game');
Route::get('/user_grid','Web\UserController@userGrid')->name('user_grid');
Route::post('/user_profile/{id}','Web\UserController@userProfile')->name('user.profile');
Route::post('/agent_profile/{id}','Web\AgentController@agentProfile')->name('agent.profile');
Route::get('/agent_grid','Web\AgentController@agentGrid')->name('agent_grid');
Route::post('/update_comission/{id}','Web\AgentController@updateComission')->name('update.comission');
});

Route::get('/', function () {
    return view('welcome');
});
