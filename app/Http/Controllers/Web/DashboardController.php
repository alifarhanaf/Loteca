<?php

namespace App\Http\Controllers\Web;

use App\Models\Game;
use App\Models\Point;
use App\Models\Round;
use App\Models\Winner;
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

    public function finalizeRound(Request $request){
        $round_id = $request->round_id;
        $round = Round::find($round_id); 
        $round->status = 2;
        $round->save();

        $round = Round::where('id',$round_id)->first();
        $packages = $round->packages;
        
        $arr = [];
        // dd(count($packages));
        for ($i = 0; $i < count($packages); $i++) {
            $multipleWinners = [];
            $multipleWinners2 = [];
            $multipleWinners3 = [];
            $points = Point::where('round_id',$round_id)->where('package_id',$packages[$i]->id)->orderBy('points', 'desc')->get();
           
            $totalGames = count($round->games);
            foreach($points as $pt){

                
                if($pt->points == $totalGames){    
                    array_push($multipleWinners,$pt->user->id); 
                }
                if(empty($multipleWinners) && $pt->points == ($totalGames-1)){

                    array_push($multipleWinners2,$pt->user->id); 
                }
                if(empty($multipleWinners2) && $pt->points == ($totalGames-2)){

                    array_push($multipleWinners3,$pt->user->id); 
                }
            }
            if(!empty($multipleWinners)){
                
                $arr[$i] =  $multipleWinners;
            }elseif(!empty($multipleWinners2)){
                $arr[$i] =  $multipleWinners2;
            }elseif(!empty($multipleWinners3)){
                $arr[$i] =  $multipleWinners3;
            }

            
          
        }
        // return $arr[2];
        for ($i = 0; $i < count($packages); $i++) {
            $totalCoinsApplied = $packages[$i]->accumulative_price;
            $winnersTotal = count($arr[$i]);
            $CoinPerHead = $totalCoinsApplied/$winnersTotal;
            foreach($arr[$i] as $a){
                 $points = Point::where('round_id',$round_id)->where('package_id',$packages[$i]->id)->where('user_id',$a)->first();
                 $points->winning_coins = $CoinPerHead;
                 $points->save();
                // return $a;
                $winner = new Winner();
                $winner->round_id = $round_id;
                $winner->user_id = $a;
                $winner->package_id = $packages[$i]->id;
                $winner->prize = $CoinPerHead;
                $winner->save();
            }
            

        }
        
        return $arr;
        if (!array_key_exists("0",$arr)){
            $arr[0] = null;
        }
        if (!array_key_exists("1",$arr)){
            $arr[1] = null;
        }
        if (!array_key_exists("2",$arr)){
            $arr[2] = null;
        }
        // $firstWinners =count($arr[0]);
        // return $arr;
        $data = array(
                "status" => 200,
                "response" => "true",
                "message" => "Result Received",
                "First Package Winners" => $arr[0],
                "Second Package Winners" => $arr[1],
                "Third Package Winners" => $arr[2],
    
    
            );
            return $data;

    }
}
