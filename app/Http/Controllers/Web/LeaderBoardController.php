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
            
            $array = collect($multipleWinners)->sortBy('winning_coins')->reverse()->toArray();
            $arraySorted = array_values($array);

            $brray = collect($multipleWinnersMonthly)->sortBy('winning_coins')->reverse()->toArray();
            $brraySorted = array_values($brray);

            $data = array(
                "leaderBoardMonthly" => $brraySorted,
                "leaderBoardAllTime" => $arraySorted,
    
    
            );
            // return $data;
            return view ('leaderBoard')->with($data);
    
            // return response()->json($data, 200);
            
        }
}
