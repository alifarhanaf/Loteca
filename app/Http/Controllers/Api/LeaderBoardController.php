<?php

namespace App\Http\Controllers\Api;

use App\User;
use Carbon\Carbon;
use App\Models\Game;
use App\Models\Point;
use App\Models\Round;
use App\Models\Winner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
        $multipleWinnersMonthly = [];
     
   
            $points = DB::table('points')->pluck('user_id');
           
            for ($i = 0; $i < count($points); $i++) {
                $pts = DB::table('points')->where('user_id',$points[$i])->pluck('points');
                $max_pts = max($pts);

                $cts = DB::table('points')->where('user_id',$points[$i])->where( 'created_at', '>', Carbon::now()->subDays(30))->pluck('points');
                $max_cts = max($cts);

                $usera = User::where('id',$points[$i])->with('images')->first();
                $userb = User::where('id',$points[$i])->with('images')->first();
                
                $count = 0;
                foreach($pts as $a){
                    $count  = $count + $a;
                }
                $ccount = 0;
                foreach($cts as $b){
                    $ccount  = $ccount + $b;
                }
                dd($count,$ccount);
                if($count > 0 ){
                    $usera['image'] = $usera->images[0]->url;
                $usera['Winning Coins'] = $count;
                if(!in_array($usera, $multipleWinners, true)){
                    array_push($multipleWinners,$usera);
                }

                }
                // if($max_pts > 0 ){
                //     $usera['image'] = $usera->images[0]->url;
                // $usera['Winning Coins'] = $max_pts*10;
                // if(!in_array($usera, $multipleWinners, true)){
                //     array_push($multipleWinners,$usera);
                // }

                // }

                
                if($ccount > 0 ){
                $userb['image'] = $userb->images[0]->url;
                $userb['Winning Coins'] = $ccount;
                if(!in_array($userb, $multipleWinnersMonthly, true)){
                    array_push($multipleWinnersMonthly,$userb);
                }
                }


                    
              
            }
            // return $multipleWinners;
            
          
            // for ($i = 0; $i < count($points); $i++) {
           
            //     $aa = Point::where('user_id',$points[$i]->user_id)->get();
            //     $count = 0;
            //     foreach($aa as $a){
            //         $count  = $count + $a->points;
            //     }
            //     $points[$i]->user['image'] = $points[$i]->user->images[0]->url;
            //     $points[$i]->user['Winning Coins'] = $count*10;
            //     if(!in_array($points[$i]->user, $multipleWinners, true)){
            //         array_push($multipleWinners,$points[$i]->user);
            //     }

                    
              
            // }
            // return $multipleWinners;
          
            
     
   
        
            // $points = Point::where( 'created_at', '>', Carbon::now()->subDays(30))->get();
            // $points = DB::table('points')->where( 'created_at', '>', Carbon::now()->subDays(30))->pluck('user_id');
            
          
            // for ($i = 0; $i < count($points); $i++) {
           
            //     $aa = Point::where('user_id',$points[$i]->user_id)->where( 'created_at', '>', Carbon::now()->subDays(30))->get();
            //     $count = 0;
            //     foreach($aa as $a){
            //         $count  = $count + $a->points;
            //     }
            //     $points[$i]->user['image'] = $points[$i]->user->images[0]->url;
            //     $points[$i]->user['Winning Coins'] = $count*10;
            //     if(!in_array($points[$i]->user, $multipleWinnersMonthly, true)){
            //         array_push($multipleWinnersMonthly,$points[$i]->user);
            //     }

            // }
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
        $betting_date = $request->betting_date;
        $round = Round::where('id',$round_id)->first();
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
public function leaderC(){
        
       
        
    $multipleWinners = [];
    $multipleWinnersMonthly = [];
 

        $points = DB::table('points')->pluck('user_id');
        $points = json_decode(json_encode($points), true);
        $points = array_values(array_unique($points)) ;
        // return $points;
        // return $points[2] ;
       
        for ($i = 0; $i < count($points); $i++) {
            $totalPoints = 0;
            
            $rids = DB::table('points')->where('user_id',$points[$i])->pluck('round_id');
            $rids = json_decode(json_encode($rids), true);
            $rids = array_values(array_unique($rids)) ;
            // return $rids;
            foreach($rids as $rd){
                // return $rd;
                $cids = DB::table('points')->where('user_id',$points[$i])->where('round_id',$rd)->max('points');
                $totalPoints = $totalPoints+$cids;
            }
            $usera = User::where('id',$points[$i])->with('images')->first();
            if($totalPoints > 0 ){
                $usera['image'] = $usera->images[0]->url;
            $usera['Winning Coins'] = $totalPoints;
            if(!in_array($usera, $multipleWinners, true)){
                array_push($multipleWinners,$usera);
            }

            }


            // $pts = DB::table('points')->where('user_id',$points[$i])->get();
            // if (($key = array_search('strawberry', $array)) !== false) {
            //     unset($array[$key]);
            // }
            // $max_pts = max($pts);

            // $cts = DB::table('points')->where('user_id',$points[$i])->where( 'created_at', '>', Carbon::now()->subDays(30))->pluck('points');
            // $max_cts = max($cts);

            // $usera = User::where('id',$points[$i])->with('images')->first();
            // $userb = User::where('id',$points[$i])->with('images')->first();
            
            // $count = 0;
            // foreach($pts as $a){
            //     $count  = $count + $a;
            // }
            // $ccount = 0;
            // foreach($cts as $b){
            //     $ccount  = $ccount + $b;
            // }
            // dd($count,$ccount);
            // if($count > 0 ){
            //     $usera['image'] = $usera->images[0]->url;
            // $usera['Winning Coins'] = $count*10;
            // if(!in_array($usera, $multipleWinners, true)){
            //     array_push($multipleWinners,$usera);
            // }

            // }
            // if($max_pts > 0 ){
            //     $usera['image'] = $usera->images[0]->url;
            // $usera['Winning Coins'] = $max_pts*10;
            // if(!in_array($usera, $multipleWinners, true)){
            //     array_push($multipleWinners,$usera);
            // }

            // }

            
            // if($ccount > 0 ){
            // $userb['image'] = $userb->images[0]->url;
            // $userb['Winning Coins'] = $ccount*10;
            // if(!in_array($userb, $multipleWinnersMonthly, true)){
            //     array_push($multipleWinnersMonthly,$userb);
            // }
            // }


                
          
        }
        $pointz = DB::table('points')->where( 'created_at', '>', Carbon::now()->subDays(30))->pluck('user_id');
        $pointz = json_decode(json_encode($pointz), true);
        $pointz = array_values(array_unique($pointz)) ;
        // return $pointz;
        // return $points[2] ;
       
        for ($i = 0; $i < count($pointz); $i++) {
            $totalPointz = 0;
            
            $ridz = DB::table('points')->where( 'created_at', '>', Carbon::now()->subDays(30))->where('user_id',$pointz[$i])->pluck('round_id');
            $ridz = json_decode(json_encode($ridz), true);
            $ridz = array_values(array_unique($ridz)) ;
            // return $rids;
            foreach($ridz as $rz){
                // return $rd;
                $cidz = DB::table('points')->where('user_id',$pointz[$i])->where('round_id',$rz)->where( 'created_at', '>', Carbon::now()->subDays(30))->max('points');
                $totalPointz = $totalPointz+$cidz;
            }
            $userz = User::where('id',$pointz[$i])->with('images')->first();
            if($totalPointz > 0 ){
                $userz['image'] = $userz->images[0]->url;
            $userz['Winning Coins'] = $totalPointz;
            if(!in_array($userz, $multipleWinnersMonthly, true)){
                array_push($multipleWinnersMonthly,$userz);
            }

            }


            // $pts = DB::table('points')->where('user_id',$points[$i])->get();
            // if (($key = array_search('strawberry', $array)) !== false) {
            //     unset($array[$key]);
            // }
            // $max_pts = max($pts);

            // $cts = DB::table('points')->where('user_id',$points[$i])->where( 'created_at', '>', Carbon::now()->subDays(30))->pluck('points');
            // $max_cts = max($cts);

            // $usera = User::where('id',$points[$i])->with('images')->first();
            // $userb = User::where('id',$points[$i])->with('images')->first();
            
            // $count = 0;
            // foreach($pts as $a){
            //     $count  = $count + $a;
            // }
            // $ccount = 0;
            // foreach($cts as $b){
            //     $ccount  = $ccount + $b;
            // }
            // dd($count,$ccount);
            // if($count > 0 ){
            //     $usera['image'] = $usera->images[0]->url;
            // $usera['Winning Coins'] = $count*10;
            // if(!in_array($usera, $multipleWinners, true)){
            //     array_push($multipleWinners,$usera);
            // }

            // }
            // if($max_pts > 0 ){
            //     $usera['image'] = $usera->images[0]->url;
            // $usera['Winning Coins'] = $max_pts*10;
            // if(!in_array($usera, $multipleWinners, true)){
            //     array_push($multipleWinners,$usera);
            // }

            // }

            
            // if($ccount > 0 ){
            // $userb['image'] = $userb->images[0]->url;
            // $userb['Winning Coins'] = $ccount*10;
            // if(!in_array($userb, $multipleWinnersMonthly, true)){
            //     array_push($multipleWinnersMonthly,$userb);
            // }
            // }


                
          
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
   

}
