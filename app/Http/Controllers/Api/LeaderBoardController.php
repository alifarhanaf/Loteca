<?php

namespace App\Http\Controllers\Api;

use App\User;
use Carbon\Carbon;
use App\Models\Point;
use App\Models\Round;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LeaderBoardController extends Controller
{
    public function winner(Request $request){
        $round_id = 1;
        $round = Round::where('id',$round_id)->first();
        $packages = $round->packages;
        
        $arr = [];
        for ($i = 0; $i < count($packages); $i++) {
            $multipleWinners = [];
            $multipleWinners2 = [];
            $multipleWinners3 = [];
            $points = Point::where('round_id',$round_id)->where('package_id',$packages[$i]->id)->orderBy('points', 'desc')->get();
            $totalCoinsApplied = $packages[$i]->accumulative_price;
            $totalGames = count($round->games);
            foreach($points as $pt){

                $pt->user['image'] = $pt->user->images[0]->url;
                $pt->user['Winning Coins'] = $pt->winning_coins;
                if($pt->points == $totalGames){    
                    array_push($multipleWinners,$pt->user); 
                }
                if(empty($multipleWinners) && $pt->points == ($totalGames-1)){

                    array_push($multipleWinners2,$pt->user); 
                }
                if(empty($multipleWinners2) && $pt->points == ($totalGames-2)){

                    array_push($multipleWinners3,$pt->user); 
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
    
    
            return response()->json($data, 200);
        

    }

    public function leaderB(){
       
        
        $multipleWinners = [];
     
   
        
            $points = Point::orderBy('winning_coins', 'desc')->get();
            
          
            for ($i = 0; $i < count($points); $i++) {
           
                $aa = Point::where('user_id',$points[$i]->user->id)->get();
                $count = 0;
                foreach($aa as $a){
                    $count  = $count + $a->winning_coins;
                }
                $points[$i]->user['image'] = $points[$i]->user->images[0]->url;
                $points[$i]->user['Winning Coins'] = $count;
                if(!in_array($points[$i]->user, $multipleWinners, true)){
                    array_push($multipleWinners,$points[$i]->user);
                }

                    
              
            }
            // return $multipleWinners;
            $multipleWinnersMonthly = [];
     
   
        
            $points = Point::orderBy('winning_coins', 'desc')->where( 'created_at', '>', Carbon::now()->subDays(30))->get();
            
          
            for ($i = 0; $i < count($points); $i++) {
           
                $aa = Point::where('user_id',$points[$i]->user->id)->where( 'created_at', '>', Carbon::now()->subDays(30))->get();
                $count = 0;
                foreach($aa as $a){
                    $count  = $count + $a->winning_coins;
                }
                $points[$i]->user['image'] = $points[$i]->user->images[0]->url;
                $points[$i]->user['Winning Coins'] = $count;
                if(!in_array($points[$i]->user, $multipleWinnersMonthly, true)){
                    array_push($multipleWinnersMonthly,$points[$i]->user);
                }

                    
              
            }
            $multipleWinnersMonthly = array_unique($multipleWinnersMonthly);
            $multipleWinners = array_unique($multipleWinners);

            $data = array(
                "status" => 200,
                "response" => "true",
                "message" => "Result Received",
                "leaderBoardMonthly" => $multipleWinnersMonthly,
                "leaderBoardAllTime" => $multipleWinners,
    
    
            );
    
    
            return response()->json($data, 200);
            
        }
       
       
    public function leaderBoard()
    {
        $users = User::all();
        for ($i = 0; $i < count($users); $i++) {
            if (count($users[$i]->images) > 0) {
                $users[$i]['image'] = $users[$i]->images[0]->url;
                $users[$i]['Winning Coins'] = 500;
            } else {
                $users[$i]['image'] = null;
                $users[$i]['Winning Coins'] = 700;
            }
        }
        // $a = $users[0]->images[0]->url;
        $data = array(
            "status" => 200,
            "response" => "true",
            "message" => "Result Received",
            "leaderBoardMonthly" => $users,
            "leaderBoardAllTime" => $users,


        );


        return response()->json($data, 200);
    }
    public function closedLeague(Request $request){
        $round_id = $request->round_id;
        $round = Round::where('id',$round_id)->first();
        $packages = $round->packages;
        
        $arr = [];
        for ($i = 0; $i < count($packages); $i++) {
            $multipleWinners = [];
            $multipleWinners2 = [];
            $multipleWinners3 = [];
            $points = Point::where('round_id',$round_id)->where('package_id',$packages[$i]->id)->orderBy('points', 'desc')->get();
            $totalCoinsApplied = $packages[$i]->accumulative_price;
            $totalGames = count($round->games);
            foreach($points as $pt){

                $pt->user['image'] = $pt->user->images[0]->url;
                $pt->user['Winning Coins'] = $pt->winning_coins;
                if($pt->points == $totalGames){    
                    array_push($multipleWinners,$pt->user); 
                }
                if(empty($multipleWinners) && $pt->points == ($totalGames-1)){

                    array_push($multipleWinners2,$pt->user); 
                }
                if(empty($multipleWinners2) && $pt->points == ($totalGames-2)){

                    array_push($multipleWinners3,$pt->user); 
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

        // $round = Round::where('id', $round_id)->first();
            $games = $round->games;
            // return $games[0]->results;
            $arr1 = [];
            for ($i = 0; $i < count($games); $i++) {
                // return $games[$i]->results->Answer;
                $arr1[$i]['id'] = $games[$i]->id;
                $arr1[$i]['team_a'] = $games[$i]->team_a;
                $arr1[$i]['team_b'] = $games[$i]->team_b;
                $arr1[$i]['winner'] = $games[$i]->results->Answer;
            }


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
                "answers" => $arr1,
                "round" => $round,
    
    
            );
    
    
            return response()->json($data, 200);
        
    }
}
