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

class MyLeaguesController extends Controller
{
    public function participatedleagues()
    {
        $user = Auth::user();
        $userLeagues = DB::table('round_user')->where('user_id',$user->id)->orderBy('created_at', 'desc')->get();
        if($userLeagues){
        $userLeagueIds = [];
        $userLeagueDates = [];
        foreach($userLeagues as $userLeague){
            array_push($userLeagueIds, $userLeague->round_id);
            array_push($userLeagueDates, $userLeague->created_at);
        }
        $userRounds = [];
        for($i=0;$i<count($userLeagueIds);$i++){
            $round = Round::where('id',$userLeagueIds[$i])->first();
            $round['betting_date'] = $userLeagueDates[$i];
            array_push($userRounds,$round);
        }
        $data = array(
            "status" => 200,
            "response" => "true",
            "message" => "Result Received",
            "participatedLeagues" => $userRounds,
        );
        return response()->json($data, 200);
        }else{
            $data = array(
                "status" => 200,
                "response" => "true",
                "message" => "Result Received",
                "participatedLeagues" => [],
            );
            return response()->json($data, 200);
        }
        
    }

    public function leagueDetails(Request $request){
       
        $round_id = $request->round_id;
        $betting_date = $request->betting_date;
        $mainUser = Auth::user();
        $round = Round::where('id',$round_id)->first();
        if($round->status == 1){
            $userAnswers = DB::table('bid_results')
                        ->where('user_id', $mainUser->id)
                        ->where('round_id', $round_id)
                        ->where('created_at',$betting_date)->get();
            $userSelectedAnswers = [];
            for($k=0;$k<count($userAnswers);$k++){
                $game = Game::where('id',$userAnswers[$k]->game_id)->first();
                $userSelectedAnswers[$k]['id'] = $userAnswers[$k]->id;
                $userSelectedAnswers[$k]['team_a'] = $game->team_a;
                $userSelectedAnswers[$k]['team_b'] = $game->team_b;
                $userSelectedAnswers[$k]['winner'] = $userAnswers[$k]->answer;
            }
            $data = array(
                "status" => 200,
                "response" => "true",
                "message" => "Result Received",
                "First Package Winners" => null,
                "Second Package Winners" => null,
                "Third Package Winners" => null,
                "answers" => null,
                "userAnswers" => $userSelectedAnswers,
                "round" => $round,
            );
            return response()->json($data, 200);

        }else{

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
                $user['winningCoins'] = $firstCategoryWinnerPrizes[$i];
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
                $gameResults[$i]['id'] = $games[$i]->id;
                $gameResults[$i]['team_a'] = $games[$i]->team_a;
                $gameResults[$i]['team_b'] = $games[$i]->team_b;
                $gameResults[$i]['winner'] = $games[$i]->results->Answer;
            }
            
            $userAnswers = DB::table('bid_results')
                        ->where('user_id', $mainUser->id)
                        ->where('round_id', $round_id)
                        ->where('created_at',$betting_date)->get();
            $userSelectedAnswers = [];
            for($k=0;$k<count($userAnswers);$k++){
                $game = Game::where('id',$userAnswers[$k]->game_id)->first();
                $userSelectedAnswers[$k]['id'] = $userAnswers[$k]->id;
                $userSelectedAnswers[$k]['team_a'] = $game->team_a;
                $userSelectedAnswers[$k]['team_b'] = $game->team_b;
                $userSelectedAnswers[$k]['winner'] = $userAnswers[$k]->answer;
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
                    "userAnswers" => $userSelectedAnswers,
                    "round" => $round,
            );
            return response()->json($data, 200);
        }
    }

    public function leaderBoardForSingleRound($id){
        $round_id = $id;
        $leaderBoardUsers = [];
        $points = DB::table('points')->where('round_id',$round_id)->pluck('user_id');
        $points = json_decode(json_encode($points), true);
        $points = array_values(array_unique($points)) ;
        for ($i = 0; $i < count($points); $i++) {        
            $cids = DB::table('points')->where('user_id',$points[$i])->where('round_id',$round_id)->max('points');
            $user = User::where('id',$points[$i])->with('images')->first();
            $user['image'] = $user->images[0]->url;
            $user['points_scored'] = $cids;
            if(!in_array($user, $leaderBoardUsers, true)){
                    array_push($leaderBoardUsers,$user);
            }
        }
        $leaderBoardUsers = array_values(array_unique($leaderBoardUsers));
        $array = collect($leaderBoardUsers)->sortBy('points_scored')->reverse()->toArray();
        $arraySorted = array_values($array);
        return $arraySorted;
        }
       
    
}
