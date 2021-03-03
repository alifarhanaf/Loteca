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
Route::get('/dashboard','Web\DashboardController@index')->name('dashboard');
Route::get('/create_round','Web\DashboardController@createRound')->name('create_round');
Route::get('/round_grid','Web\DashboardController@roundGrid')->name('round_grid');
Route::get('/create_game','Web\DashboardController@createGame')->name('create_game');
Route::get('/game_grid','Web\DashboardController@gameGrid')->name('game_grid');
Route::post('/gameSubmit','Web\DashboardController@submitGame')->name('submit.game');
    


Route::get('/', function () {
    return view('welcome');
});
