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
Route::get('/round_detail/{id}','Web\RoundController@roundPage')->name('roundDetail');
Route::get('/dashboard','Web\DashboardController@index')->name('dashboard');
Route::get('/create_round','Web\DashboardController@createRound')->name('create_round');
Route::get('/round_grid','Web\DashboardController@roundGrid')->name('round_grid');
Route::get('/create_game','Web\DashboardController@createGame')->name('create_game');
Route::get('/game_grid','Web\DashboardController@gameGrid')->name('game_grid');
Route::post('/game_submit','Web\DashboardController@submitGame')->name('submit.game');
Route::post('/round_submit','Web\DashboardController@submitRound')->name('submit.round');
Route::post('/finalize_round/{id}','Web\DashboardController@finalizeRound')->name('finalize.round');
Route::delete('/delete_round/{id}','Web\DashboardController@destroyRound')->name('delete.round');
Route::get('/round_edit/{id}', 'Web\DashboardController@editRound')->name('edit.round');
Route::post('/submit_round_edit/{id}', 'Web\DashboardController@editRoundSubmit')->name('edit.round.submit');
Route::get('/game_answers','Web\DashboardController@gameAnswerGrid')->name('game_answer_grid');
Route::post('/submit_answers/{id}','Web\DashboardController@submitAnswer')->name('submit_game_answer');
Route::get('/', function () {
    return view('welcome');
});
