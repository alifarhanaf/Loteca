<?php

namespace App\Http\Controllers\web;

use App\User;
use Carbon\Carbon;
use App\Models\Point;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class LeaderBoardController extends Controller
{
    public function leaderB(){
       
        
        $multipleWinners = [];
        $multipleWinnersMonthly = [];
     
   
            $points = DB::table('points')->pluck('user_id');
           
            for ($i = 0; $i < count($points); $i++) {
                $pts = DB::table('points')->where('user_id',$points[$i])->pluck('points');
                $cts = DB::table('points')->where('user_id',$points[$i])->where( 'created_at', '>', Carbon::now()->subDays(30))->pluck('points');
                
                $usera = User::where('id',$points[$i])->with('images')->with('contacts')->first();
                $userb = User::where('id',$points[$i])->with('images')->with('contacts')->first();
                
                $count = 0;
                foreach($pts as $a){
                    $count  = $count + $a;
                }
                $ccount = 0;
                foreach($cts as $b){
                    $ccount  = $ccount + $b;
                }
                // dd($count,$ccount);
                if($count > 0 ){
                    $usera['image'] = $usera->images[0]->url;
                $usera['winning_coins'] = $count*10;
                if(!in_array($usera, $multipleWinners, true)){
                    array_push($multipleWinners,$usera);
                }

                }

                
                if($ccount > 0 ){
                $userb['image'] = $userb->images[0]->url;
                $userb['winning_coins'] = $ccount*10;
                if(!in_array($userb, $multipleWinnersMonthly, true)){
                    array_push($multipleWinnersMonthly,$userb);
                }
                }


                    
              
            }
            
            $multipleWinnersMonthly = array_values(array_unique($multipleWinnersMonthly));
            $multipleWinners = array_values(array_unique($multipleWinners));
            
            $array = collect($multipleWinners)->sortBy('winning_coins')->reverse()->toArray();
            $arraySorted = array_values($array);

            $brray = collect($multipleWinnersMonthly)->sortBy('winning_coins')->reverse()->toArray();
            $brraySorted = array_values($brray);

            $newArray = [];
            if (array_key_exists("0",$arraySorted)){
                $newArray[0] = $arraySorted[0];
            }
            if (array_key_exists("1",$arraySorted)){
                $newArray[1] = $arraySorted[1];
            }
            if (array_key_exists("2",$arraySorted)){
                $newArray[2] = $arraySorted[2];
            }
            $newArray1 = [];
            if (array_key_exists("0",$brraySorted)){
                $newArray1[0] = $brraySorted[0];
            }
            if (array_key_exists("1",$brraySorted)){
                $newArray1[1] = $brraySorted[1];
            }
            if (array_key_exists("2",$brraySorted)){
                $newArray1[2] = $brraySorted[2];
            }
           

            $data = array(
                "leaderBoardMonthly" => $newArray1,
                "leaderBoardMonthlyAll" => $brraySorted,
                "leaderBoardAllTime" => $newArray,
                "leaderBoardAllTimeAll" => $arraySorted,
    
    
            );
            // return $data;
            return view ('monthlyLeaderBoard')->with($data);
    
            // return response()->json($data, 200);
            
        }
        public function leaderBAll(){
       
        
            $multipleWinners = [];
            $multipleWinnersMonthly = [];
         
       
                $points = DB::table('points')->pluck('user_id');
               
                for ($i = 0; $i < count($points); $i++) {
                    $pts = DB::table('points')->where('user_id',$points[$i])->pluck('points');
                    $cts = DB::table('points')->where('user_id',$points[$i])->where( 'created_at', '>', Carbon::now()->subDays(30))->pluck('points');
                    
                    $usera = User::where('id',$points[$i])->with('images')->with('contacts')->first();
                    $userb = User::where('id',$points[$i])->with('images')->with('contacts')->first();
                    
                    $count = 0;
                    foreach($pts as $a){
                        $count  = $count + $a;
                    }
                    $ccount = 0;
                    foreach($cts as $b){
                        $ccount  = $ccount + $b;
                    }
                    // dd($count,$ccount);
                    if($count > 0 ){
                        $usera['image'] = $usera->images[0]->url;
                    $usera['winning_coins'] = $count*10;
                    if(!in_array($usera, $multipleWinners, true)){
                        array_push($multipleWinners,$usera);
                    }
    
                    }
    
                    
                    if($ccount > 0 ){
                    $userb['image'] = $userb->images[0]->url;
                    $userb['winning_coins'] = $ccount*10;
                    if(!in_array($userb, $multipleWinnersMonthly, true)){
                        array_push($multipleWinnersMonthly,$userb);
                    }
                    }
    
    
                        
                  
                }
                
                $multipleWinnersMonthly = array_values(array_unique($multipleWinnersMonthly));
                $multipleWinners = array_values(array_unique($multipleWinners));
                
                $array = collect($multipleWinners)->sortBy('winning_coins')->reverse()->toArray();
                $arraySorted = array_values($array);
    
                $brray = collect($multipleWinnersMonthly)->sortBy('winning_coins')->reverse()->toArray();
                $brraySorted = array_values($brray);
    
                $newArray = [];
                if (array_key_exists("0",$arraySorted)){
                    $newArray[0] = $arraySorted[0];
                }
                if (array_key_exists("1",$arraySorted)){
                    $newArray[1] = $arraySorted[1];
                }
                if (array_key_exists("2",$arraySorted)){
                    $newArray[2] = $arraySorted[2];
                }
                $newArray1 = [];
                if (array_key_exists("0",$brraySorted)){
                    $newArray1[0] = $brraySorted[0];
                }
                if (array_key_exists("1",$brraySorted)){
                    $newArray1[1] = $brraySorted[1];
                }
                if (array_key_exists("2",$brraySorted)){
                    $newArray1[2] = $brraySorted[2];
                }
               
    
                $data = array(
                    "leaderBoardMonthly" => $newArray1,
                    "leaderBoardMonthlyAll" => $brraySorted,
                    "leaderBoardAllTime" => $newArray,
                    "leaderBoardAllTimeAll" => $arraySorted,
        
        
                );
                // return $data;
                return view ('allTimeLeaderBoard')->with($data);
        
                // return response()->json($data, 200);
                
            }
}
