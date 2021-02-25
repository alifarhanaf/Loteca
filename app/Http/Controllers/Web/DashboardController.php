<?php

namespace App\Http\Controllers\Web;

use App\User;
use App\Models\Game;
use App\Models\Point;
use App\Models\Round;
use App\Models\Winner;
use App\Models\RoundUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $totalGames = count($round->games);
        $packages = $round->packages;
        // $roundUsers = RoundUser::where('round_id',$round_id)->get();
        $roundUsers = DB::table('round_user')->where('round_id',$round_id)->get();
        $roundUsersIds = [];
        foreach($roundUsers as $ru){
            array_push($roundUsersIds,$ru->user_id);

        }
        $roundUsersC = User::findMany($roundUsersIds);
        foreach($roundUsersC as $ruc ){

        $userAnswers = DB::table('bid_results')
        ->where('user_id', $ruc->id)
        ->where('round_id', $round_id)->get();
        $i = 0;
        foreach($userAnswers as $UA){
         
            $gm = Game::where('id',$UA->game_id)->first();
            $gameAnswer0 = $gm->results->Answer;
            if($gameAnswer0 === $UA->answer){
                
                $i++;
            }
        }//EndForeach

        $point = new Point();
        $point->round_id = $round_id;
        $point->user_id = $ruc->id;
        $point->package_id = $userAnswers[0]->package_id;
        $point->points = $i;
        $point->total_points = $totalGames;
        $point->save();

        
        }
        // $userAnswers = DB::table('bid_results')
        // ->where('user_id', $user_id)
        // ->where('round_id', $round_id)->get();
        // dd($userAnswers);
        // $round = Round::where('id',$round_id)->first();
        // $totalGames = count($round->games);
        // $i = 0;
        // foreach($userAnswers as $UA){
         
        //     $gm = Game::where('id',$UA->game_id)->first();
        //     $gameAnswer0 = $gm->results->Answer;
        //     dd($gameAnswer0 . $UA->answer);
        //     if($gameAnswer0 === $UA->answer){
                
        //         $i++;
        //         dd($i);
        //     }
        // }//EndForeach
        // $point = new Point();
        // $point->round_id = $round_id;
        // $point->user_id = $user_id;
        // $point->package_id = $package_id;
        // $point->points = $i;
        // $point->total_points = $totalGames;
        // $point->save();


        // $round = Round::where('id',$round_id)->first();
        
        
        $arr = [];
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

        
       
        

        return true;
       
        

    }
}
