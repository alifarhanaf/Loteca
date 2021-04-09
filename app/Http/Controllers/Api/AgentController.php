<?php

namespace App\Http\Controllers\Api;

use App\User;
use Carbon\Carbon;
use App\Models\Game;
use App\Models\Round;
use App\Models\Package;
use App\Models\WithDraw;
use App\Models\CoinTransfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class AgentController extends Controller
{
    public function index(Request $request)
    {
        // return $request->all();
        // $round = Round::where('id',1)->first();
        $now = Carbon::now();
        $now->toDateString();

        //  return $now;
        $round = Round::where('starting_date', '<=', $now)
            ->where('ending_date', '>=', $now)->where('tag', 'original')->where('status', 1)
            ->first();
        // return $round;
        if ($round) {
            $games = $round->games;
            $agent = Auth::user();
            $user = User::where('id', $request->user_id)->first();
            $packages = $round->packages;
            if (count($user->rounds) > 0) {
                $arr = [];
                foreach ($user->rounds as $rads) {
                    array_push($arr, $rads->id);
                }
                if (empty($arr)) {
                    $bid = false;
                    $selected_package = null;
                    $bet_date = null;
                } else {
                    // $result = array_search("$round->id", $arr);
                    // dd($result);
                    // if ($result >= 0 || $result != '') {
                    //     $bid = true;
                    // } else {
                    //     $bid = false;
                    // }
                    if (in_array($round->id, $arr)) {
                        $bid = false;
                        $selected_package = null;
                        $bet_date = null;
                        
                        // $bid = true;

                        // $ressult = DB::table('bid_results')
                        //     ->where('user_id', $user->id)
                        //     ->where('round_id', $round->id)->first();
                           
                        //     $bet_date = $ressult->created_at;
                        // $package_id = $ressult->package_id;
                        // $selected_package = Package::where('id', $package_id)->first();
                        foreach($games as $game){
                            $game['widegtSwitch0']= null ;
                            $game['widegtSwitch1']= null ;
                            $game['widegtSwitch2']= null ;
                           
                        //     $ressult1 = DB::table('bid_results')
                        // ->where('user_id', $user->id)
                        // ->where('round_id', $round->id)
                        // ->where('game_id', $game->id)
                        // ->get();
                        
                        // $gta =  str_replace(' ', '', $game->team_a);
                        // $gtb = str_replace(' ', '', $game->team_b);
                        // $gtd = 'Draw';
                        // $gto = str_replace(' ', '', $ressult1[0]->answer);
                        // if(strtoupper($gta) == strtoupper($gto)){
                        //     $game['widegtSwitch0']= true ;
                        //     $game['widegtSwitch1']= false ;
                        //     $game['widegtSwitch2']= false ;
                        // }else if(strtoupper($gtb) == strtoupper($gto)){
                        //     $game['widegtSwitch0']= false ;
                        //     $game['widegtSwitch1']= false ;
                        //     $game['widegtSwitch2']= true ;
                        // }else if(strtoupper($gtd) == strtoupper($gto)){
                        //     $game['widegtSwitch0']= false ;
                        //     $game['widegtSwitch1']= true ;
                        //     $game['widegtSwitch2']= false ;
                        // }
                        
    
                        }
                       
                        
                    } else {
                        $bid = false;
                        $selected_package = null;
                        $bet_date = null;
                    }
                }
            } else {
                $bid = false;
                $selected_package = null;
                $bet_date = null;
            }
            $roundComplete = array(
                'id' => $round->id,
                'name' => $round->name,
                'starting_date' => $round->starting_date,
                'ending_date' => $round->ending_date,
                'created_at' => $round->created_at,
                'updated_at' => $round->updated_at,
                'packages' => $packages,
                'selected_package' => $selected_package,
                'games' => $games,

            );
            if ($bid == true) {
                $userAnswers = DB::table('bid_results')
                    ->where('user_id', $user->id)
                    ->where('round_id', $round->id)->get();
            } else {
                $userAnswers = "No Bet Yet";
            }
            $data = array(
                "status" => 200,
                "response" => "true",
                "message" => "Success",
                "bid" => $bid,
                "bet_date" => $bet_date,
                "user" => $user,
                "agent" => $agent,
                "round" => $roundComplete,
                "userAnswers" => $userAnswers,
            );
            return response()->json($data, 200);
        } else {
            $data = array(
                "status" => 404,
                "response" => "false",
                "message" => "No Round is Live",
            );
            return response()->json($data, 404);
        }
    }

    public function ValidateUser(Request $request)
    {
        $user =  User::where('email', $request->email)->first();
        if ($user) {
            $now = Carbon::now();
            $now->toDateString();
            $round = Round::where('starting_date', '<=', $now)
                ->where('ending_date', '>=', $now)->where('tag', 'original')->where('status', 1)
                ->first();
            // return $round;
            if ($round) {

                if (count($user->rounds) > 0) {
                    $arr = [];
                    foreach ($user->rounds as $rads) {
                        array_push($arr, $rads->id);
                    }

                    if (in_array($round->id, $arr)) {
                        $data = array(
                            "status" => 209,
                            "response" => "false",
                            "message" => "User Already Made a Bet On This Round",
                        );
                        return response()->json($data, 209);
                    } else {
                        $user->contacts;
                        $user->images;
                        $data = array(
                            "status" => 200,
                            "response" => "true",
                            "message" => "Success",
                            "user" => $user,
                        );
                        return response()->json($data, 200);
                    }
                } else {
                    $user->contacts;
                    $user->images;
                    $data = array(
                        "status" => 200,
                        "response" => "true",
                        "message" => "Success",
                        "user" => $user,
                    );
                    return response()->json($data, 200);
                }
            } else {
                $data = array(
                    "status" => 404,
                    "response" => "false",
                    "message" => "No Round is Live",
                );
                return response()->json($data, 404);
            }
        } else {
            $data = array(
                "status" => 404,
                "response" => "false",
                "message" => "User Not Found",
            );
            return response()->json($data, 404);
        }
    }

    public function betSubmit(Request $request)
    {
        DB::beginTransaction();
        // try {
        $selected_answerz = trim($request->selected_answers, '[]');
        $selected_answers = explode(",", $selected_answerz);
        $game_idz = trim($request->game_ids, '[]');
        $game_ids = explode(",", $game_idz);
        // dd($game_idz);
        $round_id = $request->round_id;
        $package_id = $request->package_id;
        $user_id = $request->user_id;
        $pk = Package::where('id', $package_id)->first();
        $ck = Package::find($pk->id);
        $ck->accumulative_price = $pk->accumulative_price + $pk->participation_fee;
        $ck->save();


        $user = User::find($user_id);
        $agent = Auth::user();
        $submitDate = Carbon::now();


        if (count($user->rounds) > 0) {
            $arr = [];
            foreach ($user->rounds as $rads) {
                array_push($arr, $rads->id);
            } //EndForeach
            if (!empty($arr)) {
                // if (in_array("$round_id", $arr)) {
                //     DB::rollback();
                //     $data = array(
                //         "status" => 409,
                //         "response" => "true",
                //         "message" => "Record Already Present",

                //     );
                //     return response()->json($data, 409);
                    
                // } else {
                    $round = Round::where('id', $round_id)->first();
                    $package = Package::where('id', $package_id)->first();
                    $pp = $package->participation_fee;
                    $cc = $agent->coins;
                    if ($cc >= $pp) {

                        // Start Here
                        $dd = $cc - $pp;
                        $sender = User::find($agent->id);
                        $sender->coins = $dd ;
                        $sender->save();
                        $receiver = User::find($user_id);
                        $receiver->coins = $receiver->coins + $pp;
                        $receiver->save();
                        $ct = new CoinTransfer(); 
                        $ct->sender_id = $sender->id;
                        $ct->receiver_id = $receiver->id;
                        $ct->sent_coins = $pp;
                        $ct->withdraw = 1;
                        $ct->save();
                        $user = User::find($user_id);
                       
                        $ff = $user->coins;
                        $ee = $ff - $pp;
                        $userz = User::find($user->id);
                        $userz->coins = $ee;
                        $userz->save();
                        DB::table('round_user')->insert([
                            'round_id' => $round_id,
                            'user_id' => $user->id,
                            'created_at' => $submitDate,
                            'updated_at' => $submitDate,
                            

                        ]);



                        for ($i = 0; $i < count($round->games); $i++) {
                            DB::table('bid_results')->insert([
                                'round_id' => $round_id,
                                'user_id' => $user_id,
                                'game_id' => $game_ids[$i],
                                'answer' => $selected_answers[$i],
                                'package_id' => $package_id,
                                'created_at' => $submitDate,
                                'updated_at' => $submitDate

                            ]);
                        } //End For Loop
                        // $points = $this->answerCheck($round_id,$package_id);

                        $userAnswers = DB::table('bid_results')
                            ->where('user_id', $user->id)
                            ->where('round_id', $round_id)
                            ->where('created_at',$submitDate)->get();
                            $ansArray = [];
                            for($k=0;$k<count($userAnswers);$k++){
                                $game = Game::where('id',$userAnswers[$k]->game_id)->first();
                                
                                $ansArray[$k]['id'] = $userAnswers[$k]->id;
                                $ansArray[$k]['team_a'] = $game->team_a;
                                $ansArray[$k]['team_b'] = $game->team_b;
                                $ansArray[$k]['winner'] = $userAnswers[$k]->answer;
                
                            }
                        $round = Round::where('id', $round_id)->first();
                        // $bet_date = $userAnswers[0]->created_at;
                        $now = Carbon::now();
                        $now->toDateString();
                        $bet_date = $now;
                        $games = $round->games;
                        $packages = $round->packages;
                        foreach($games as $game){
                            $game['widegtSwitch0']= null ;
                            $game['widegtSwitch1']= null ;
                            $game['widegtSwitch2']= null ;

                        //     // return $round->id;
                        //     $ressult1 = DB::table('bid_results')
                        // ->where('user_id', $user->id)
                        // ->where('round_id', $round->id)
                        // ->where('game_id', $game->id)
                        // ->get();
                        // // return $ressult1;
                        // $gta =  str_replace(' ', '', $game->team_a);
                        // $gtb = str_replace(' ', '', $game->team_b);
                        // $gtd = 'Draw';
                        // $gto = str_replace(' ', '', $ressult1[0]->answer);
                        // if(strtoupper($gta) == strtoupper($gto)){
                        //     $game['widegtSwitch0']= true ;
                        //     $game['widegtSwitch1']= false ;
                        //     $game['widegtSwitch2']= false ;
                        // }else if(strtoupper($gtb) == strtoupper($gto)){
                        //     $game['widegtSwitch0']= false ;
                        //     $game['widegtSwitch1']= false ;
                        //     $game['widegtSwitch2']= true ;
                        // }else if(strtoupper($gtd) == strtoupper($gto)){
                        //     $game['widegtSwitch0']= false ;
                        //     $game['widegtSwitch1']= true ;
                        //     $game['widegtSwitch2']= false ;
                        // }
                    }

                        $roundComplete = array(
                            'id' => $round->id,
                            'name' => $round->name,
                            'starting_date' => $round->starting_date,
                            'ending_date' => $round->ending_date,
                            'created_at' => $round->created_at,
                            'updated_at' => $round->updated_at,
                            'packages' => $packages,
                            'selected_package' => $pk,
                            'games' => $games,

                        );
                        $agent = User::find(Auth::user()->id);

                        $data = array(
                            "status" => 200,
                            "response" => "true",
                            "message" => "Record Inserted",
                            "bid" => true,
                            "bet_date" => $bet_date,
                            "user" => $user,
                            "agent" => $agent,
                            "round" => $roundComplete,
                            "userAnswers" => $ansArray,



                        );
                        DB::commit();
                        return response()->json($data, 201);
                    } else {
                        DB::rollback();
                        $data = array(
                            "status" => 429,
                            "response" => "true",
                            "message" => "You Don't have enough Coins",

                        );

                        return response()->json($data, 429);
                    } //EndCoinsCheckCondition
                    //Insert Bracket Here
                 //EndRecordCheckCondition
            } else {
                $round = Round::where('id', $round_id)->first();
                $package = Package::where('id', $package_id)->first();
                $pp = $package->participation_fee;
                $cc = $agent->coins;
                if ($cc >= $pp) {
                    // $new_cc = $cc - $pp;
                    // $data = User::find($agent->id);
                    // $data->coins = $new_cc;
                    // $data->save();

                    // $userz = User::find($user->id);
                    // $userz->rounds()->attach($round_id);
                    $dd = $cc - $pp;
                        $sender = User::find($agent->id);
                        $sender->coins = $dd ;
                        $sender->save();
                        $receiver = User::find($user_id);
                        $receiver->coins = $receiver->coins + $pp;
                        $receiver->save();
                        $ct = new CoinTransfer(); 
                        $ct->sender_id = $sender->id;
                        $ct->receiver_id = $receiver->id;
                        $ct->sent_coins = $pp;
                        $ct->withdraw = 1;
                        $ct->save();
                        // Start Here

                        $comissions = $sender->comissions;
                        $newArray = [] ;
                        $comissionArray = json_decode(json_encode($comissions), true);
                        $lastIndex = array_key_last($comissionArray);
                        for($i=0;$i<count($comissions);$i++){
                           
                            // return $comissions[$i];
                            if($i != $lastIndex ){
                                $dateOne = $comissions[$i]->created_at;
                                $dateTwo = $comissions[$i+1]->created_at;
                                $newArray[$i]['dateOne'] = $dateOne;
                                $newArray[$i]['dateTwo'] = $dateTwo;
                                $newArray[$i]['percentage'] = $comissions[$i]->comission_percentage;
                            }else{
                                $dateOne = $comissions[$i]->created_at;
                                $dateTwo = null;
                                $newArray[$i]['dateOne'] = $dateOne;
                                $newArray[$i]['dateTwo'] = $dateTwo;
                                $newArray[$i]['percentage'] = $comissions[$i]->comission_percentage;
                            }
                
                            
                            
                           
                           
                        }


        $totalComission4 = 0;
        $total_sales4 = 0; 
        foreach ($newArray as $na){
            if($na['dateTwo'] == null){
                
            $history4 = CoinTransfer::where('sender_id', $user->id)->where('withdraw',1)->whereBetween('created_at', [$na['dateOne'], Carbon::now()])->get();
            
        
        $comission4 = 0;
        foreach($history4 as $h4){
            $total_sales4 = $total_sales4 + $h4->sent_coins;
            $cc = $h4->sent_coins;
            $ac = ($cc * $na['percentage'])/100;
            $comission4 = $comission4 + $ac;
            $comission4 = round($comission4, 1);

        }
        $totalComission4 = $totalComission4+$comission4;


            }else{
               
            $history4 = CoinTransfer::where('sender_id', $user->id)->where('withdraw',1)->whereBetween('created_at', [$na['dateOne'], $na['dateTwo']])->get();
           
        
        $comission4 = 0;
        foreach($history4 as $h4){
            $total_sales4 = $total_sales4 + $h4->sent_coins;
            $cc = $h4->sent_coins;
            $ac = ($cc * $na['percentage'])/100;
            $comission4 = $comission4 + $ac;
            $comission4 = round($comission4, 1);

        }
        $totalComission4 = $totalComission4+$comission4;


            }
            
        }
        $comm = WithDraw::where('user_id',$sender->id)->get();
        if(count($comm)>0){
            $withD = WithDraw::find($comm[0]->id);
            $withD->total_comission = $totalComission4;
            $withD->save();

        }else{
            $withD = new WithDraw();
            $withD->total_comission = $totalComission4;
            $withD->save();
        }

                        // End Here
                        $user = User::find($user_id);
                       
                        $ff = $user->coins;
                        $ee = $ff - $pp;
                        $userz = User::find($user->id);
                        $userz->coins = $ee;
                        $userz->save();
                        DB::table('round_user')->insert([
                            'round_id' => $round_id,
                            'user_id' => $user->id,
                            'created_at' => $submitDate,
                            'updated_at' => $submitDate,
                            
    
                        ]);


                    for ($i = 0; $i < count($round->games); $i++) {
                        DB::table('bid_results')->insert([
                            'round_id' => $round_id,
                            'user_id' => $user->id,
                            'game_id' => $game_ids[$i],
                            'answer' => $selected_answers[$i],
                            'package_id' => $package_id,
                            'created_at' => $submitDate,
                            'updated_at' => $submitDate,

                        ]);
                    }
                    // $points = $this->answerCheck($round_id,$package_id);

                    $userAnswers = DB::table('bid_results')
                        ->where('user_id', $user->id)
                        ->where('round_id', $round_id)
                        ->where('created_at', $submitDate)->get();
                        $ansArray = [];
                            for($k=0;$k<count($userAnswers);$k++){
                                $game = Game::where('id',$userAnswers[$k]->game_id)->first();
                                
                                $ansArray[$k]['id'] = $userAnswers[$k]->id;
                                $ansArray[$k]['team_a'] = $game->team_a;
                                $ansArray[$k]['team_b'] = $game->team_b;
                                $ansArray[$k]['winner'] = $userAnswers[$k]->answer;
                
                            }
                    $round = Round::where('id', $round_id)->first();
                    // $bet_date = $userAnswers[0]->created_at;
                    $now = Carbon::now();
                        $now->toDateString();
                        $bet_date = $now;
                    $games = $round->games;
                    $packages = $round->packages;
                    foreach($games as $game){
                        $game['widegtSwitch0']= null ;
                        $game['widegtSwitch1']= null ;
                        $game['widegtSwitch2']= null ;
                    //     // return $round->id;
                    //     $ressult1 = DB::table('bid_results')
                    // ->where('user_id', $user->id)
                    // ->where('round_id', $round->id)
                    // ->where('game_id', $game->id)
                    // ->get();
                    // // return $ressult1;
                    // $gta =  str_replace(' ', '', $game->team_a);
                    // $gtb = str_replace(' ', '', $game->team_b);
                    // $gtd = 'Draw';
                    // $gto = str_replace(' ', '', $ressult1[0]->answer);
                    // if(strtoupper($gta) == strtoupper($gto)){
                    //     $game['widegtSwitch0']= true ;
                    //     $game['widegtSwitch1']= false ;
                    //     $game['widegtSwitch2']= false ;
                    // }else if(strtoupper($gtb) == strtoupper($gto)){
                    //     $game['widegtSwitch0']= false ;
                    //     $game['widegtSwitch1']= false ;
                    //     $game['widegtSwitch2']= true ;
                    // }else if(strtoupper($gtd) == strtoupper($gto)){
                    //     $game['widegtSwitch0']= false ;
                    //     $game['widegtSwitch1']= true ;
                    //     $game['widegtSwitch2']= false ;
                    // }
                }

                    $roundComplete = array(
                        'id' => $round->id,
                        'name' => $round->name,
                        'starting_date' => $round->starting_date,
                        'ending_date' => $round->ending_date,
                        'created_at' => $round->created_at,
                        'updated_at' => $round->updated_at,
                        'packages' => $packages,
                        'selected_package' => $pk,
                        'games' => $games,
                    );
                    $agent = User::find(Auth::user()->id);
                    $data = array(
                        "status" => 200,
                        "response" => "true",
                        "message" => "Record Inserted",
                        "bid" => true,
                        "bet_date" => $bet_date,
                        "user" => $user,
                        "agent" => $agent,
                        "round" => $roundComplete,
                        "userAnswers" => $ansArray,
                    );
                    DB::commit();
                    return response()->json($data, 201);
                } else {
                    DB::rollback();
                    $data = array(
                        "status" => 429,
                        "response" => "true",
                        "message" => "You Don't have enough Coins",
                    );

                    return response()->json($data, 429);
                }
            }
        }
        $round = Round::where('id', $round_id)->first();
        $package = Package::where('id', $package_id)->first();
        $pp = $package->participation_fee;
        $cc = $agent->coins;
        if ($cc >= $pp) {
            $dd = $cc - $pp;
            $sender = User::find($agent->id);
            $sender->coins = $dd ;
            $sender->save();
            $receiver = User::find($user_id);
            $receiver->coins = $receiver->coins + $pp;
            $receiver->save();
            $ct = new CoinTransfer(); 
            $ct->sender_id = $sender->id;
            $ct->receiver_id = $receiver->id;
            $ct->sent_coins = $pp;
            $ct->withdraw = 1;
            $ct->save();
            $user = User::find($user_id);
           
            $ff = $user->coins;
            $ee = $ff - $pp;
            $userz = User::find($user->id);
            $userz->coins = $ee;
            $userz->save();
            DB::table('round_user')->insert([
                'round_id' => $round_id,
                'user_id' => $user->id,
                'created_at' => $submitDate,
                'updated_at' => $submitDate,
                

            ]);
            // $new_cc = $cc - $pp;
            // $data = User::find($agent->id);
            // $data->coins = $new_cc;
            // $data->save();
            // $userz = User::find($user->id);
            // $userz->rounds()->attach($round_id);


            for ($i = 0; $i < count($round->games); $i++) {
                DB::table('bid_results')->insert([
                    'round_id' => $round_id,
                    'user_id' => $user->id,
                    'game_id' => $game_ids[$i],
                    'answer' => $selected_answers[$i],
                    'package_id' => $package_id,
                    'created_at' => $submitDate,
                    'updated_at' => $submitDate,

                ]);
            }
            // $points = $this->answerCheck($round_id,$package_id);
            $userAnswers = DB::table('bid_results')
                ->where('user_id', $user->id)
                ->where('round_id', $round_id)
                ->where('created_at', $submitDate)->get();
                $ansArray = [];
                            for($k=0;$k<count($userAnswers);$k++){
                                $game = Game::where('id',$userAnswers[$k]->game_id)->first();
                                
                                $ansArray[$k]['id'] = $userAnswers[$k]->id;
                                $ansArray[$k]['team_a'] = $game->team_a;
                                $ansArray[$k]['team_b'] = $game->team_b;
                                $ansArray[$k]['winner'] = $userAnswers[$k]->answer;
                
                            }
            $round = Round::where('id', $round_id)->first();
           
            $now = Carbon::now();
                        $now->toDateString();
                        $bet_date = $now;
            $games = $round->games;
            $packages = $round->packages;
            foreach($games as $game){
                $game['widegtSwitch0']= null ;
                $game['widegtSwitch1']= null ;
                $game['widegtSwitch2']= null ;

            //     $ressult1 = DB::table('bid_results')
            // ->where('user_id', $user->id)
            // ->where('round_id', $round->id)
            // ->where('game_id', $game->id)
            // ->get();
           
            // $gta =  str_replace(' ', '', $game->team_a);
            // $gtb = str_replace(' ', '', $game->team_b);
            // $gtd = 'Draw';
            // $gto = str_replace(' ', '', $ressult1[0]->answer);
            // if(strtoupper($gta) == strtoupper($gto)){
            //     $game['widegtSwitch0']= true ;
            //     $game['widegtSwitch1']= false ;
            //     $game['widegtSwitch2']= false ;
            // }else if(strtoupper($gtb) == strtoupper($gto)){
            //     $game['widegtSwitch0']= false ;
            //     $game['widegtSwitch1']= false ;
            //     $game['widegtSwitch2']= true ;
            // }else if(strtoupper($gtd) == strtoupper($gto)){
            //     $game['widegtSwitch0']= false ;
            //     $game['widegtSwitch1']= true ;
            //     $game['widegtSwitch2']= false ;
            // }
        }

            $roundComplete = array(
                'id' => $round->id,
                'name' => $round->name,
                'starting_date' => $round->starting_date,
                'ending_date' => $round->ending_date,
                'created_at' => $round->created_at,
                'updated_at' => $round->updated_at,
                'packages' => $packages,
                'selected_package' => $pk,
                'games' => $games,
            );
            $agent = User::find(Auth::user()->id);
            $data = array(
                "status" => 200,
                "response" => "true",
                "message" => "Record Inserted",
                "bid" => true,
                "bet_date" => $bet_date,
                "user" => $user,
                "agent" => $agent,
                "round" => $roundComplete,
                "userAnswers" => $ansArray,
            );
            DB::commit();
            return response()->json($data, 201);
        } else {
            DB::rollback();
            $data = array(
                "status" => 429,
                "response" => "true",
                "message" => "You Don't have enough Coins",
            );

            return response()->json($data, 429);
        }
    
    }
}
