<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Models\Game;
use App\Models\Point;
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
        $user = Auth::user();
        $round = Round::where('id',$round_id)->first();
        if($round->status == 1){
            $userAnswers = DB::table('bid_results')
                        ->where('user_id', $user->id)
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
                $gameResults[$i]['id'] = $games[$i]->id;
                $gameResults[$i]['team_a'] = $games[$i]->team_a;
                $gameResults[$i]['team_b'] = $games[$i]->team_b;
                $gameResults[$i]['winner'] = $games[$i]->results->Answer;
            }
            $userAnswers = DB::table('bid_results')
                        ->where('user_id', $user->id)
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

    public function finalizeRound(Request $request,$id){
        $winner = Winner::where('round_id',$id)->first();
        if($winner){
            return redirect()->back()->with('error','Already Finalized This Round.');
        }
        // DB::beginTransaction();
        // try {
            
           
        $round_id = $id;
        $round = Round::find($round_id); 
        $round->status = 2;
        $round->save();
        $round = Round::where('id',$round_id)->first();
        $totalGames = count($round->games);
        $packages = $round->packages;
        // $roundUsers = RoundUser::where('round_id',$round_id)->get();
        $roundUsers = DB::table('round_user')->where('round_id',$round_id)->get();
        $roundUsersIds = [];
        $roundUserDates = [];
        $test = [];
        $test1 = [];
        foreach($roundUsers as $ru){
            array_push($roundUsersIds,$ru->user_id);
            array_push($roundUserDates,$ru->created_at);

        }
        
        // for($i=0;$i<count($roundUsersIds);$i++){
        //     $ruc = User::where('id',$roundUsersIds[$i])->first();
        //     $userAnswers = DB::table('bid_results')
        //     ->where('user_id', $ruc->id)
        //     ->where('round_id', $round_id)
        //     ->where('created_at',$roundUserDates[$i])->get();
            
        //     $i = 0;
        //     foreach($userAnswers as $UA){
         
        //     $gm = Game::where('id',$UA->game_id)->first();
        //     if($gm->results){
        //     $gameAnswer0 = $gm->results->Answer;
            
        //        $oAnswer =  str_replace(' ', '', $gameAnswer0);
        //        $uAnswer = str_replace(' ', '', $UA->answer);
               
        //     if(strtoupper($oAnswer) == strtoupper($uAnswer)){
                
        //         $i++;
                
        //     }
        // }else{
        //     DB::rollback();
        //     return redirect()->back()->with('error','You have Not Added Game Results Yet.     Kindly Add Answers First.');
        // }
        // }
        // $point = new Point();
        // $point->round_id = $round_id;
        // $point->user_id = $ruc->id;
        // $point->package_id = $userAnswers[0]->package_id;
        // $point->points = $i;
        // $point->total_points = $totalGames;
        // $point->created_at = $roundUserDates[$i];
        // $point->save();

        // }
        // $roundUsersC = User::findMany($roundUsersIds);
        $roundUsersC = [];
        for($i=0;$i<count($roundUsersIds);$i++){
            $user = User::where('id',$roundUsersIds[$i])->first();
            array_push($roundUsersC,$user);
        }
        $j = 0;
         
        foreach($roundUsersC as $ruc ){
            // dd($roundUserDates[$j],$ruc->id,$round_id,$roundUsersIds[0],$roundUserDates[0]);
        

        $userAnswers = DB::table('bid_results')
        ->where('user_id', $ruc->id)
        ->where('round_id', $round_id)
        ->where('created_at',$roundUserDates[$j])->get();
        // return $userAnswers;
        
        $i = 0;
        foreach($userAnswers as $UA){
         
            $gm = Game::where('id',$UA->game_id)->first();
            if($gm->results){
            $gameAnswer0 = $gm->results->Answer;
               $oAnswer =  str_replace(' ', '', $gameAnswer0);
               $uAnswer = str_replace(' ', '', $UA->answer);
              
            if(strtoupper($oAnswer) == strtoupper($uAnswer)){
                
                $i++;
                
            }
        }else{
            // DB::rollback();
            return redirect()->back()->with('error','You have Not Added Game Results Yet.     Kindly Add Answers First.');
        }
        }
        $vy = $userAnswers->toArray();
        // if(!array_key_exists(0,$vy) ){
        //     dd($ruc,$roundUserDates[$j]);
        // }


        $point = new Point();
        $point->round_id = $round_id;
        $point->user_id = $ruc->id;
        $point->package_id = $vy[0]->package_id;
        $point->points = $i;
        $point->total_points = $totalGames;
        $point->save();
        $j++;

        
        }

        //Old Commented
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
        $datz = [];
        for ($i = 0; $i < count($packages); $i++) {
            $multipleWinners = [];
            $multipleWinners2 = [];
            $multipleWinners3 = [];
            $multipleWinners4 = [];
            $multipleWinners5 = [];
            $multipleWinners6 = [];
            $multipleWinnersDates = [];
            $multipleWinnersDates2 = [];
            $multipleWinnersDates3 = [];
            $multipleWinnersDates4 = [];
            $multipleWinnersDates5 = [];
            $multipleWinnersDates6 = [];
            $points = Point::where('round_id',$round_id)->where('package_id',$packages[$i]->id)->orderBy('points', 'desc')->get();
           
            $totalGames = count($round->games);
            foreach($points as $pt){

                
                if($pt->points == $totalGames){    
                    array_push($multipleWinners,$pt->user->id); 
                    array_push($multipleWinnersDates,$pt->created_at); 
                }
                if(empty($multipleWinners) && $pt->points == ($totalGames-1)){

                    array_push($multipleWinners2,$pt->user->id); 
                    array_push($multipleWinnersDates2,$pt->created_at);
                }
                if(empty($multipleWinners2) && $pt->points == ($totalGames-2)){

                    array_push($multipleWinners3,$pt->user->id); 
                    array_push($multipleWinnersDates3,$pt->created_at);
                }
                if(empty($multipleWinners3) && $pt->points == ($totalGames-3)){

                    array_push($multipleWinners4,$pt->user->id);
                    array_push($multipleWinnersDates4,$pt->created_at); 
                }
                if(empty($multipleWinners4) && $pt->points == ($totalGames-4)){

                    array_push($multipleWinners5,$pt->user->id);
                    array_push($multipleWinnersDates5,$pt->created_at); 
                }
                if(empty($multipleWinners5) && $pt->points == ($totalGames-5)){

                    array_push($multipleWinners6,$pt->user->id); 
                    array_push($multipleWinnersDates6,$pt->created_at);
                }
            }
            if(!empty($multipleWinners)){
                
                $arr[$i] =  $multipleWinners;
                $datz[$i] =  $multipleWinnersDates;
            }elseif(!empty($multipleWinners2)){
                $arr[$i] =  $multipleWinners2;
                $datz[$i] =  $multipleWinnersDates2;
            }elseif(!empty($multipleWinners3)){
                $arr[$i] =  $multipleWinners3;
                $datz[$i] =  $multipleWinnersDates3;
            }elseif(!empty($multipleWinners4)){
                $arr[$i] =  $multipleWinners4;
                $datz[$i] =  $multipleWinnersDates4;
            }elseif(!empty($multipleWinners5)){
                $arr[$i] =  $multipleWinners5;
                $datz[$i] =  $multipleWinnersDates5;
            }elseif(!empty($multipleWinners6)){
                $arr[$i] =  $multipleWinners6;
                $datz[$i] =  $multipleWinnersDates6;
            }

            
          
        }
        // return $arr;
       //Start Winners
        for ($i = 0; $i < count($packages); $i++) {
            $totalCoinsApplied = $packages[$i]->accumulative_price;
            $winnersTotal = count($arr[$i]);
            $CoinPerHead = $totalCoinsApplied/$winnersTotal;
            for($j=0;$j<count($arr[$i]);$j++){
                $points = Point::where('round_id',$round_id)->where('package_id',$packages[$i]->id)->where('user_id',$arr[$i][$j])->where('created_at',$datz[$i][$j])->first();
                 $points->winning_coins = $CoinPerHead;
                 $points->save();
                $winner = new Winner();
                $winner->round_id = $round_id;
                $winner->user_id = $arr[$i][$j];
                $winner->package_id = $packages[$i]->id;
                $winner->prize = $CoinPerHead;
                $winner->save();

            }
            
            // foreach($arr[$i] as $a){
            //      $points = Point::where('round_id',$round_id)->where('package_id',$packages[$i]->id)->where('user_id',$a)->first();
            //      $points->winning_coins = $CoinPerHead;
            //      $points->save();
            //     $winner = new Winner();
            //     $winner->round_id = $round_id;
            //     $winner->user_id = $a;
            //     $winner->package_id = $packages[$i]->id;
            //     $winner->prize = $CoinPerHead;
            //     $winner->save();
            // }
            

        }
        //EndWinners

        
       
        

        // return true;
        // DB::commit();
        return redirect()->back()->with('success', 'Round Successfully Finalized',); 
        // } catch (\Exception $ex) {
        //     DB::rollback();
        //     return redirect()->back()->with('error',$ex->getMessage());
        // }
       
        

    }
    // public function submitGame(Request $request){
         // return $request->all();
    //     $game = New Game();
    //     $game->name = $request->name;
    //     $game->team_a = $request->team_a;
    //     $game->team_b = $request->team_b;
    //     $game->happening_date = $request->happening_date;
    //     $game->save();

    



    // }


    public function resultScreenDetails(Request $request){
       
        $round_id = $request->round_id;;
        $mainUser = Auth::user();
        $round = Round::where('id',$round_id)->first();
            $packages = $round->packages;
            $firstCategoryWinners = Winner::where('round_id',$round_id)->where('package_id',$packages[0]->id)->get();
            $firstCategoryFirstJackPotWinnerIds = [];
            $firstCategorySecondJackPotWinnerIds = [];
            $firstCategoryThirdJackPotWinnerIds = [];
            $firstCategoryFirstJackPotWinnerPrizes = [];
            $firstCategorySecondJackPotWinnerPrizes = [];
            $firstCategoryThirdJackPotWinnerPrizes = [];
            foreach($firstCategoryWinners as $ws1){
                if($ws1->jackpot_id == 0){
                    array_push($firstCategoryFirstJackPotWinnerIds,$ws1->user_id);
                    array_push($firstCategoryFirstJackPotWinnerPrizes,$ws1->prize);
                }elseif($ws1->jackpot_id == 1){
                    array_push($firstCategorySecondJackPotWinnerIds,$ws1->user_id);
                    array_push($firstCategorySecondJackPotWinnerPrizes,$ws1->prize);
                }elseif($ws1->jackpot_id == 2){
                    array_push($firstCategoryThirdJackPotWinnerIds,$ws1->user_id);
                    array_push($firstCategoryThirdJackPotWinnerPrizes,$ws1->prize);
                }
            }
            $secondCategoryWinners = Winner::where('round_id',$round_id)->where('package_id',$packages[1]->id)->get();
            $secondCategoryFirstJackPotWinnerIds = [];
            $secondCategorySecondJackPotWinnerIds = [];
            $secondCategoryThirdJackPotWinnerIds = [];
            $secondCategoryFirstJackPotWinnerPrizes = [];
            $secondCategorySecondJackPotWinnerPrizes = [];
            $secondCategoryThirdJackPotWinnerPrizes = [];
            foreach($secondCategoryWinners as $ws2){
                if($ws1->jackpot_id == 0){
                    array_push($secondCategoryFirstJackPotWinnerIds,$ws2->user_id);
                    array_push($secondCategoryFirstJackPotWinnerPrizes,$ws2->prize);
                }elseif($ws1->jackpot_id == 1){
                    array_push($secondCategorySecondJackPotWinnerIds,$ws2->user_id);
                    array_push($secondCategorySecondJackPotWinnerPrizes,$ws2->prize);
                }elseif($ws1->jackpot_id == 2){
                    array_push($secondCategoryThirdJackPotWinnerIds,$ws2->user_id);
                    array_push($secondCategoryThirdJackPotWinnerPrizes,$ws2->prize);
                }
            }
            $thirdCategoryWinners = Winner::where('round_id',$round_id)->where('package_id',$packages[2]->id)->get();
            $thirdCategoryFirstJackPotWinnerIds = [];
            $thirdCategorySecondJackPotWinnerIds = [];
            $thirdCategoryThirdJackPotWinnerIds = [];
            $thirdCategoryFirstJackPotWinnerPrizes = [];
            $thirdCategorySecondJackPotWinnerPrizes = [];
            $thirdCategoryThirdJackPotWinnerPrizes = [];
            foreach($thirdCategoryWinners as $ws3){
                if($ws1->jackpot_id == 0){
                    array_push($thirdCategoryFirstJackPotWinnerIds,$ws3->user_id);
                    array_push($thirdCategoryFirstJackPotWinnerPrizes,$ws3->prize);
                }elseif($ws1->jackpot_id == 1){
                    array_push($thirdCategorySecondJackPotWinnerIds,$ws3->user_id);
                    array_push($thirdCategorySecondJackPotWinnerPrizes,$ws3->prize);
                }elseif($ws1->jackpot_id == 2){
                    array_push($thirdCategoryThirdJackPotWinnerIds,$ws3->user_id);
                    array_push($thirdCategoryThirdJackPotWinnerPrizes,$ws3->prize);
                }
            }

            $finalWinners= [];
            $firstPackageWinners= [];
            $firstPackageFirstJackPotWinners = [];
            $firstPackageSecondJackPotWinners = [];
            $firstPackageThirdJackPotWinners = [];
            for($i=0;$i<count($firstCategoryFirstJackPotWinnerIds);$i++){
                $user = User::where('id',$firstCategoryFirstJackPotWinnerIds[$i])->first();
                $user['image'] = $user->images[0]->url;
                unset($user->images);
                $user['winningCoins'] = $firstCategoryFirstJackPotWinnerPrizes[$i];
                array_push($firstPackageFirstJackPotWinners,$user);
            }
            for($i=0;$i<count($firstCategorySecondJackPotWinnerIds);$i++){
                $user = User::where('id',$firstCategorySecondJackPotWinnerIds[$i])->first();
                $user['image'] = $user->images[0]->url;
                unset($user->images);
                $user['winningCoins'] = $firstCategorySecondJackPotWinnerPrizes[$i];
                array_push($firstPackageSecondJackPotWinners,$user);
            }
            for($i=0;$i<count($firstCategoryThirdJackPotWinnerIds);$i++){
                $user = User::where('id',$firstCategoryThirdJackPotWinnerIds[$i])->first();
                $user['image'] = $user->images[0]->url;
                unset($user->images);
                $user['winningCoins'] = $firstCategoryThirdJackPotWinnerPrizes[$i];
                array_push($firstPackageThirdJackPotWinners,$user);
            }
            $firstPackageWinners['firstJackPotWinners'] = $firstPackageFirstJackPotWinners;
            $firstPackageWinners['secondJackPotWinners'] = $firstPackageSecondJackPotWinners;
            $firstPackageWinners['thirdJackPotWinners'] = $firstPackageThirdJackPotWinners;


            
            

            $secondPackageWinners = [];
            $secondPackageFirstJackPotWinners = [];
            $secondPackageSecondJackPotWinners = [];
            $secondPackageThirdJackPotWinners = [];

            for($i=0;$i<count($secondCategoryFirstJackPotWinnerIds);$i++){
                $user = User::where('id',$secondCategoryFirstJackPotWinnerIds[$i])->first();
                $user['image'] = $user->images[0]->url;
                unset($user->images);
                $user['winningCoins'] = $secondCategoryFirstJackPotWinnerPrizes[$i];
                array_push($secondPackageFirstJackPotWinners,$user);
            }
            for($i=0;$i<count($secondCategorySecondJackPotWinnerIds);$i++){
                $user = User::where('id',$secondCategorySecondJackPotWinnerIds[$i])->first();
                $user['image'] = $user->images[0]->url;
                unset($user->images);
                $user['winningCoins'] = $secondCategorySecondJackPotWinnerPrizes[$i];
                array_push($secondPackageSecondJackPotWinners,$user);
            }
            for($i=0;$i<count($secondCategoryThirdJackPotWinnerIds);$i++){
                $user = User::where('id',$secondCategoryThirdJackPotWinnerIds[$i])->first();
                $user['image'] = $user->images[0]->url;
                unset($user->images);
                $user['winningCoins'] = $secondCategoryThirdJackPotWinnerPrizes[$i];
                array_push($secondPackageThirdJackPotWinners,$user);
            }
            $secondPackageWinners['firstJackPotWinners'] = $secondPackageFirstJackPotWinners;
            $secondPackageWinners['secondJackPotWinners'] = $secondPackageSecondJackPotWinners;
            $secondPackageWinners['thirdJackPotWinners'] = $secondPackageThirdJackPotWinners;


            $thirdPackageWinners = [];
            $thirdPackageFirstJackPotWinners = [];
            $thirdPackageSecondJackPotWinners = [];
            $thirdPackageThirdJackPotWinners = [];



            for($i=0;$i<count($thirdCategoryFirstJackPotWinnerIds);$i++){
                $user = User::where('id',$thirdCategoryFirstJackPotWinnerIds[$i])->first();
                $user['image'] = $user->images[0]->url;
                unset($user->images);
                $user['winningCoins'] = $thirdCategoryFirstJackPotWinnerPrizes[$i];
                array_push($thirdPackageFirstJackPotWinners,$user);
            }
            for($i=0;$i<count($thirdCategorySecondJackPotWinnerIds);$i++){
                $user = User::where('id',$thirdCategorySecondJackPotWinnerIds[$i])->first();
                $user['image'] = $user->images[0]->url;
                unset($user->images);
                $user['winningCoins'] = $thirdCategorySecondJackPotWinnerPrizes[$i];
                array_push($thirdPackageSecondJackPotWinners,$user);
            }
            for($i=0;$i<count($thirdCategoryThirdJackPotWinnerIds);$i++){
                $user = User::where('id',$thirdCategoryThirdJackPotWinnerIds[$i])->first();
                $user['image'] = $user->images[0]->url;
                unset($user->images);
                $user['winningCoins'] = $thirdCategoryThirdJackPotWinnerPrizes[$i];
                array_push($thirdPackageThirdJackPotWinners,$user);
            }
            $thirdPackageWinners['firstJackPotWinners'] = $thirdPackageFirstJackPotWinners;
            $thirdPackageWinners['secondJackPotWinners'] = $thirdPackageSecondJackPotWinners;
            $thirdPackageWinners['thirdJackPotWinners'] = $thirdPackageThirdJackPotWinners;


            $finalWinners['firstPackageWinners'] = $firstPackageWinners;
            $finalWinners['secondPackageWinners'] = $secondPackageWinners;
            $finalWinners['thirdPackageWinners'] = $thirdPackageWinners;

            $games = $round->games;
            $gameResults = [];
            for ($i = 0; $i < count($games); $i++) {
                $gameResults[$i]['id'] = $games[$i]->id;
                $gameResults[$i]['team_a'] = $games[$i]->team_a;
                $gameResults[$i]['team_b'] = $games[$i]->team_b;
                $gameResults[$i]['winner'] = $games[$i]->results->Answer;
            }
            $leaderBoardUsers = [];
            $points = DB::table('points')->where('round_id',$round_id)->pluck('user_id');
            $points = json_decode(json_encode($points), true);
            $points = array_values(array_unique($points)) ;
            for ($i = 0; $i < count($points); $i++) {        
                $cids = DB::table('points')->where('user_id',$points[$i])->where('round_id',$round_id)->max('points');
                $user = User::where('id',$points[$i])->with('images')->first();
                $user['image'] = $user->images[0]->url;
                unset($user->images);
                $user['points_scored'] = $cids;
            if(!in_array($user, $leaderBoardUsers, true)){
                    array_push($leaderBoardUsers,$user);
            }
        }
        $leaderBoardUsers = array_values(array_unique($leaderBoardUsers));
        $array = collect($leaderBoardUsers)->sortBy('points_scored')->reverse()->toArray();
        $arraySorted = array_values($array);

            $data = array(
                    "status" => 200,
                    "response" => "true",
                    "message" => "Result Received",
                    "winners" => $finalWinners,
                    "answers" => $gameResults,
                    "leaderBoard" => $arraySorted,
                    "round" => $round,
            );
            return response()->json($data, 200);
        
    }

        

    
}
