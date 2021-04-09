<?php

namespace App\Http\Controllers\Web;

use App\User;
use App\Models\Round;
use App\Models\Winner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoundController extends Controller
{
    public function roundPage($id){
        $round =  Round::find($id);
        $check = 1;
        
        $packages = $round->packages;
        $round->games;
        foreach($round->games as $ga){
            $ga->results;
        }
        $winnerCheck = Winner::where('round_id',$round->id)->get();
        
        if(count($winnerCheck) == 0){
            $check = 0;
        }
        if($round->status == 2 && $winnerCheck != null){
            $winnerCat1 = Winner::where('round_id',$round->id)->where('package_id',$packages[0]->id)->get();
        $array1 = [];
        $wc1 = [];
        foreach($winnerCat1 as $ws1){
            array_push($array1,$ws1->user_id);
            array_push($wc1,$ws1->prize);

        }
        $winnerCat2 = Winner::where('round_id',$round->id)->where('package_id',$packages[1]->id)->get();
        $array2 = [];
        $wc2 = [];
        foreach($winnerCat2 as $ws2){
            array_push($array2,$ws2->user_id);
            array_push($wc2,$ws2->prize);

        }
        $winnerCat3 = Winner::where('round_id',$round->id)->where('package_id',$packages[2]->id)->get();
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
       


        
        
        
           

        if (!array_key_exists("0",$arr)){
            $arr[0] = null;
        }
        if (!array_key_exists("1",$arr)){
            $arr[1] = null;
        }
        if (!array_key_exists("2",$arr)){
            $arr[2] = null;
        }
        
        }else{
            $arr[0] = null;
            $arr[1] = null;
            $arr[2] = null;
        }
        // return $round;
        // $games = Game::OrderBy('created_at', 'desc')->get();
        // return $games;
        // $sorted = $games->orderBy('created_at', 'desc');
        // $games = Game::sortBy('created_at', 'ASC')->get();
        // dd($check);
        $data = array(
            "round"=> $round,
            "firstRoundWinners" => $arr[0],
            "secondRoundWinners" => $arr[1],
            "thirdRoundWinners" => $arr[2],
            "check" => $check,
        );
        // return $data;
        return view ('roundDetailScreen')->with($data);
        // ->with($data);

    }
}
