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
Route::get('/test','Api\AdminDashboardController@tt');
Route::get('/leaderBoard', 'Api\LeaderBoardController@leaderC');


Route::middleware('admin:web')->group( function(){
Route::get('/dashboard','Web\DashboardController@dashboard')->name('dashboard');
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
Route::get('/leader_board_monthly','Web\LeaderBoardController@leaderB')->name('leaderBoardMonthly');
Route::get('/leader_board','Web\LeaderBoardController@leaderBAll')->name('leaderBoard');
Route::get('/sendMail','Web\DashboardController@sendMail');
Route::get('/create_game','Web\DashboardController@createGame')->name('create_game');
Route::get('/user_grid','Web\UserController@userGrid')->name('user_grid');
Route::get('/user_profile/{id}','Web\UserController@userProfile')->name('user.profile');
Route::get('/agent_profile/{id}','Web\AgentController@agentProfile')->name('agent.profile');
Route::get('/agent_grid','Web\AgentController@agentGrid')->name('agent_grid');
Route::post('/update_comission/{id}','Web\AgentController@updateComission')->name('update.comission');
Route::get('/register_form','Auth\ApiAuthController@registerForm')->name('form.register');
Route::post('/register_process','Auth\ApiAuthController@register')->name('submit.register');
Route::get('/comments','Web\FeedbackController@comment')->name('comments');
Route::get('/bugs','Web\FeedbackController@bug')->name('bugs');
Route::get('/questions','Web\FeedbackController@question')->name('questions');
Route::get('/send_coins','Web\DashboardController@coins')->name('coin.screen');
Route::post('/transfer_coins','Web\DashboardController@transferCoins')->name('coin.transfer');
Route::post('/assign_agent/{id}','Web\UserController@assignAgent')->name('assign.agent');
Route::post('/points_update/{id}','Web\UserController@pointsUpdate')->name('points.update');
});

Route::get('/', function () {
    return view('welcome');
});
