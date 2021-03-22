<?php

namespace App\Http\Controllers\web;

use Carbon\Carbon;
use App\Models\Point;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LeaderBoardController extends Controller
{
    public function leaderB(){
       
        
        $multipleWinners = [];
     
   
        
            $points = Point::orderBy('points', 'desc')->get();
            
          
            for ($i = 0; $i < count($points); $i++) {
           
                $aa = Point::where('user_id',$points[$i]->user->id)->get();
                $count = 0;
                foreach($aa as $a){
                    $count  = $count + $a->points;
                }
                $points[$i]->user['image'] = $points[$i]->user->images[0]->url;
                $points[$i]->user['winning_coins'] = $count*10;
                if(!in_array($points[$i]->user, $multipleWinners, true)){
                    array_push($multipleWinners,$points[$i]->user);
                }

                    
              
            }
            // return $multipleWinners;
            $multipleWinnersMonthly = [];
     
   
        
            $points = Point::orderBy('points', 'desc')->where( 'created_at', '>', Carbon::now()->subDays(30))->get();
            
          
            for ($i = 0; $i < count($points); $i++) {
           
                $aa = Point::where('user_id',$points[$i]->user->id)->where( 'created_at', '>', Carbon::now()->subDays(30))->get();
                $count = 0;
                foreach($aa as $a){
                    $count  = $count + $a->points;
                }
                $points[$i]->user['image'] = $points[$i]->user->images[0]->url;
                $points[$i]->user['winning_coins'] = $count*10;
                if(!in_array($points[$i]->user, $multipleWinnersMonthly, true)){
                    array_push($multipleWinnersMonthly,$points[$i]->user);
                }

                    
              
            }
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
            return view ('leaderBoard')->with($data);
    
            // return response()->json($data, 200);
            
        }
}
