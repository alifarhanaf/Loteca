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
        $betting_date = $request->betting_date;
        $round = Round::where('id',$round_id)->first();
        $winnerCheck = Winner::where('round_id',$round_id)->get();
        if($winnerCheck){
            $packages = $round->packages;
            $firstCategoryWinners = Winner::where('round_id',$round_id)->where('package_id',$packages[0]->id)->get();
            $firstCategoryWinnerIds = [];
            $firstCategoryWinnerPrizes = [];
            foreach($firstCategoryWinners as $ws1){
                array_push($firstCategoryWinnerIds,$ws1->user_id);
                array_push($firstCategoryWinnerPrizes,$ws1->prize);
            }
            $secondCategoryWinners = Winner::where('round_id',$round_id)->where('package_id',$packages[1]->id)->get();
            $secondCategoryWinnerIds = [];
            $secondCategoryWinnerPrizes = [];
            foreach($secondCategoryWinners as $ws2){
                array_push($secondCategoryWinnerIds,$ws2->user_id);
                array_push($secondCategoryWinnerPrizes,$ws2->prize);
            }
            $thirdCategoryWinners = Winner::where('round_id',$round_id)->where('package_id',$packages[2]->id)->get();
            $thirdCategoryWinnerIds = [];
            $thirdCategoryWinnerPrizes = [];
            foreach($thirdCategoryWinners as $ws3){
                array_push($thirdCategoryWinnerIds,$ws3->user_id);
                array_push($thirdCategoryWinnerPrizes,$ws3->prize);
            }

            $finalWinners= [];
            $firstPackageWinners = [];
            for($i=0;$i<count($firstCategoryWinnerIds);$i++){
                $user = User::where('id',$firstCategoryWinnerIds[$i])->first();
                $user['image'] = $user->images[0]->url;
                $user['winning_coins'] = $firstCategoryWinnerPrizes[$i];
                array_push($firstPackageWinners,$user);
            }
            $secondPackageWinners = [];
            for($i=0;$i<count($secondCategoryWinnerIds);$i++){
                $user = User::where('id',$secondCategoryWinnerIds[$i])->first();
                $user['image'] = $user->images[0]->url;
                $user['winningCoins'] = $secondCategoryWinnerPrizes[$i];
                array_push($secondPackageWinners,$user);
            }
            $thirdPackageWinners = [];
            for($i=0;$i<count($thirdCategoryWinnerIds);$i++){
                $user = User::where('id',$thirdCategoryWinnerIds[$i])->first();
                $user['image'] = $user->images[0]->url;
                $user['winningCoins'] = $thirdCategoryWinnerPrizes[$i];
                array_push($thirdPackageWinners,$user);
            }
            $finalWinners[0] = $firstPackageWinners;
            $finalWinners[1] = $secondPackageWinners;
            $finalWinners[2] = $thirdPackageWinners;

            $games = $round->games;
            
            $gameResults = [];
            for ($i = 0; $i < count($games); $i++) {
                // return $games[$i]->results->Answer;
                $gameResults[$i]['id'] = $games[$i]->id;
                $gameResults[$i]['team_a'] = $games[$i]->team_a;
                $gameResults[$i]['team_b'] = $games[$i]->team_b;
                $gameResults[$i]['winner'] = $games[$i]->results->Answer;
            }
            if (!array_key_exists("0",$finalWinners)){
                $finalWinners[0] = null;
            }
            if (!array_key_exists("1",$finalWinners)){
                $finalWinners[1] = null;
            }
            if (!array_key_exists("2",$finalWinners)){
                $finalWinners[2] = null;
            }
            
    
            $data = array(
                    "status" => 200,
                    "response" => "true",
                    "message" => "Result Received",
                    "First Package Winners" => $finalWinners[0],
                    "Second Package Winners" => $finalWinners[1],
                    "Third Package Winners" => $finalWinners[2],
                    "answers" => $gameResults,
                    "round" => $round,
        
        
                );
        
        
                return response()->json($data, 200);
       

        }else{
            $data = array(
                "status" => 409,
                "response" => "true",
                "message" => "Results Awaited",
            );
            return response()->json($data, 409);
        }
        
    }
        

    
}
