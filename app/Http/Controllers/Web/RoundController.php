<?php

namespace App\Http\Controllers\Web;

use App\Models\Round;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoundController extends Controller
{
    public function roundPage($id){
        $round =  Round::find($id);
        
        $round->packages;
        $round->games;
        // return $round;
        // $games = Game::OrderBy('created_at', 'desc')->get();
        // return $games;
        // $sorted = $games->orderBy('created_at', 'desc');
        // $games = Game::sortBy('created_at', 'ASC')->get();
        $data = array(
            "round"=> $round,
        );
        return view ('roundDetailScreen')->with($data);
        // ->with($data);

    }
}
