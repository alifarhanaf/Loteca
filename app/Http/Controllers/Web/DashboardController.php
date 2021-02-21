<?php

namespace App\Http\Controllers\Web;

use App\Models\Game;
use App\Models\Round;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(){
        return view ('home');
    }
    public function createRound(){
        return view ('createRound');
    }
    public function createGame(){
        return view ('createGame');
    }
    public function gameGrid(){
        $games = Game::all();
        $data = array(
            "games"=> $games,
        );
        return view ('gameGrid')->with($data);

    }
    public function roundGrid(){
        $rounds = Round::all();
        $data = array(
            "rounds"=> $rounds,
        );
        return view ('roundGrid')->with($data);
    }
}
