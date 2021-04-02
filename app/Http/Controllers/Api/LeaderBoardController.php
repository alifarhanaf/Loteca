<?php

namespace App\Http\Controllers\Api;

use App\User;
use Carbon\Carbon;
use App\Models\Point;
use App\Models\Round;
use App\Models\Winner;
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
        // return 'Hello';
       
        
        $multipleWinners = [];
     
   
        
            $points = Point::all();
            // return $points;
            
          
            for ($i = 0; $i < count($points); $i++) {
           
                $aa = Point::where('user_id',$points[$i]->user->id)->get();
                $count = 0;
                foreach($aa as $a){
                    $count  = $count + $a->points;
                }
                $points[$i]->user['image'] = $points[$i]->user->images[0]->url;
                $points[$i]->user['Winning Coins'] = $count*10;
                if(!in_array($points[$i]->user, $multipleWinners, true)){
                    array_push($multipleWinners,$points[$i]->user);
                }

                    
              
            }
            // return $multipleWinners;
          
            $multipleWinnersMonthly = [];
     
   
        
            $points = Point::where( 'created_at', '>', Carbon::now()->subDays(30))->get();
            
          
            for ($i = 0; $i < count($points); $i++) {
           
                $aa = Point::where('user_id',$points[$i]->user->id)->where( 'created_at', '>', Carbon::now()->subDays(30))->get();
                $count = 0;
                foreach($aa as $a){
                    $count  = $count + $a->points;
                }
                $points[$i]->user['image'] = $points[$i]->user->images[0]->url;
                $points[$i]->user['Winning Coins'] = $count*10;
                if(!in_array($points[$i]->user, $multipleWinnersMonthly, true)){
                    array_push($multipleWinnersMonthly,$points[$i]->user);
                }

            }
            $multipleWinnersMonthly = array_values(array_unique($multipleWinnersMonthly));
            $multipleWinners = array_values(array_unique($multipleWinners));
            
            $array = collect($multipleWinners)->sortBy('Winning Coins')->reverse()->toArray();
            $arraySorted = array_values($array);

            $brray = collect($multipleWinnersMonthly)->sortBy('Winning Coins')->reverse()->toArray();
            $brraySorted = array_values($brray);

            $data = array(
                "status" => 200,
                "response" => "true",
                "message" => "Result Received",
                "leaderBoardMonthly" => $brraySorted,
                "leaderBoardAllTime" => $arraySorted,
    
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
    // public function test(Request $request){
    //     return $request;
    // }
    public function closedLeague(Request $request){
       
        $round_id = $request->round_id;
        $round = Round::where('id',$round_id)->first();
        $packages = $round->packages;
        $winnerCat1 = Winner::where('round_id',$round_id)->where('package_id',$packages[0]->id)->get();
        $array1 = [];
        foreach($winnerCat1 as $ws1){
            array_push($array1,$ws1->user_id);

        }
        $winnerCat2 = Winner::where('round_id',$round_id)->where('package_id',$packages[1]->id)->get();
        $array2 = [];
        foreach($winnerCat2 as $ws2){
            array_push($array2,$ws2->user_id);

        }
        $winnerCat3 = Winner::where('round_id',$round_id)->where('package_id',$packages[2]->id)->get();
        $array3 = [];
        foreach($winnerCat3 as $ws3){
            array_push($array3,$ws3->user_id);

        }
        $arr= [];
        $roundUsers1 = [];
        for($i=0;$i<count($array1);$i++){
            $user = User::where('id',$array1[$i])->first();
            array_push($roundUsers1,$user);
        }
        $roundUsers2 = [];
        for($i=0;$i<count($array2);$i++){
            $user = User::where('id',$array2[$i])->first();
            array_push($roundUsers2,$user);
        }
        $roundUsers3 = [];
        for($i=0;$i<count($array3);$i++){
            $user = User::where('id',$array3[$i])->first();
            array_push($roundUsers3,$user);
        }
        $arr[0] = $roundUsers1;
        $arr[1] = $roundUsers2;
        $arr[2] = $roundUsers3;
       


        
        
        
            $games = $round->games;
            
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
