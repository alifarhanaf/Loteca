<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Models\Game;
use App\Models\Round;
use App\Models\Winner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ResultController extends Controller
{
    public function resultsList(){
        $lastThreeClosedRounds = Round::select('id','name','starting_date','ending_date')->latest()->where('status',2)->take(3)->get();
            $data = array(
                "status" => 200,
                "response" => "true",
                "message" => "Result Received",
                "lastClosedRounds" => $lastThreeClosedRounds,
            );
        return response()->json($data, 200);
    }

    public function resultDetails(Request $request){
       
        $round_id = $request->round_id;
        $betting_date = 1;
        $round = Round::where('id',$round_id)->first();
        $winnerCheck = Winner::where('round_id',$round_id)->get();
        if($winnerCheck){
            $packages = $round->packages;
            $winnerCat1 = Winner::where('round_id',$round_id)->where('package_id',$packages[0]->id)->get();
            $array1 = [];
            $wc1 = [];
            foreach($winnerCat1 as $ws1){
                array_push($array1,$ws1->user_id);
                array_push($wc1,$ws1->prize);
            }
        $winnerCat2 = Winner::where('round_id',$round_id)->where('package_id',$packages[1]->id)->get();
        $array2 = [];
        $wc2 = [];
        foreach($winnerCat2 as $ws2){
            array_push($array2,$ws2->user_id);
            array_push($wc2,$ws2->prize);

        }
        $winnerCat3 = Winner::where('round_id',$round_id)->where('package_id',$packages[2]->id)->get();
        $array3 = [];
        $wc3 = [];
        foreach($winnerCat3 as $ws3){
            array_push($array3,$ws3->user_id);
            array_push($wc3,$ws3->prize);

        }

        }else{
            $data = array(
                "status" => 409,
                "response" => "true",
                "message" => "Results Awaited",
            );
            return response()->json($data, 200);
        }
        $packages = $round->packages;
        if($round->status == 1){

            $userAnswers = DB::table('bid_results')
                        ->where('user_id', Auth::user()->id)
                        ->where('round_id', $round_id)
                        ->where('created_at',$betting_date)->get();
            $arr2 = [];
            for($k=0;$k<count($userAnswers);$k++){
                $game = Game::where('id',$userAnswers[$k]->game_id)->first();
                
                $arr2[$k]['id'] = $userAnswers[$k]->id;
                $arr2[$k]['team_a'] = $game->team_a;
                $arr2[$k]['team_b'] = $game->team_b;
                $arr2[$k]['winner'] = $userAnswers[$k]->answer;

            }
            
            




            $data = array(
                "status" => 200,
                "response" => "true",
                "message" => "Result Received",
                "First Package Winners" => null,
                "Second Package Winners" => null,
                "Third Package Winners" => null,
                "answers" => null,
                "userAnswers" => $arr2,
                "round" => $round,
    
    
            );
    
    
            return response()->json($data, 200);

        }else{

        $winnerCat1 = Winner::where('round_id',$round_id)->where('package_id',$packages[0]->id)->get();
        $array1 = [];
        $wc1 = [];
        foreach($winnerCat1 as $ws1){
            array_push($array1,$ws1->user_id);
            array_push($wc1,$ws1->prize);

        }
        $winnerCat2 = Winner::where('round_id',$round_id)->where('package_id',$packages[1]->id)->get();
        $array2 = [];
        $wc2 = [];
        foreach($winnerCat2 as $ws2){
            array_push($array2,$ws2->user_id);
            array_push($wc2,$ws2->prize);

        }
        $winnerCat3 = Winner::where('round_id',$round_id)->where('package_id',$packages[2]->id)->get();
        $array3 = [];
        $wc3 = [];
        foreach($winnerCat3 as $ws3){
            array_push($array3,$ws3->user_id);
            array_push($wc3,$ws3->prize);

        }
        $arr= [];
        $roundUsers1 = [];
        for($i=0;$i<count($array1);$i++){
            $user = User::where('id',$array1[$i])->first();
            $user['image'] = $user->images[0]->url;
            $user['winningCoins'] = $wc1[$i];
            array_push($roundUsers1,$user);
        }
        $roundUsers2 = [];
        for($i=0;$i<count($array2);$i++){
            $user = User::where('id',$array2[$i])->first();
            $user['image'] = $user->images[0]->url;
            $user['winningCoins'] = $wc2[$i];
            array_push($roundUsers2,$user);
        }
        $roundUsers3 = [];
        for($i=0;$i<count($array3);$i++){
            $user = User::where('id',$array3[$i])->first();
            $user['image'] = $user->images[0]->url;
            $user['winningCoins'] = $wc3[$i];
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
            $userAnswers = DB::table('bid_results')
                        ->where('user_id', Auth::user()->id)
                        ->where('round_id', $round_id)
                        ->where('created_at',$betting_date)->get();
            $arr2 = [];
            for($k=0;$k<count($userAnswers);$k++){
                $game = Game::where('id',$userAnswers[$k]->game_id)->first();
                
                $arr2[$k]['id'] = $userAnswers[$k]->id;
                $arr2[$k]['team_a'] = $game->team_a;
                $arr2[$k]['team_b'] = $game->team_b;
                $arr2[$k]['winner'] = $userAnswers[$k]->answer;

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
                "userAnswers" => $arr2,
                "round" => $round,
    
    
            );
    
    
            return response()->json($data, 200);
        
    }
} 
}
