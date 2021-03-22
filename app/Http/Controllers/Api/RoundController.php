<?php

namespace App\Http\Controllers\Api;

use App\User;
use Carbon\Carbon;
use App\Models\Game;
use App\Models\Point;
use App\Models\Round;
use App\Models\Package;
use App\Models\RoundUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\RoundCollection;
use App\Http\Resources\Round as SingleRound;

class RoundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $round = Round::where('id',1)->first();
        $now = Carbon::now();
        $now->toDateString();

        //  return $now;
        $round = Round::where('starting_date', '<=', $now)
            ->where('ending_date', '>=', $now)->where('tag', 'original')->where('status',1)
            ->first();
        // return $round;
        if ($round) {
            $games = $round->games;
            $user = Auth::user();
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
                    if (in_array($round->id, $arr)) 
                    { 
                        $bid = true;
                    $ressult = DB::table('bid_results')
                    ->where('user_id', $user->id)
                    ->where('round_id', $round->id)->first();
                    $bet_date = $ressult->created_at;
                    $package_id = $ressult->package_id;
                    $selected_package = Package::where('id',$package_id)->first();
                    foreach($games as $game){
                        // return $round->id;
                        $ressult1 = DB::table('bid_results')
                    ->where('user_id', $user->id)
                    ->where('round_id', $round->id)
                    ->where('game_id', $game->id)
                    ->get();
                    // return $ressult1;
                    $gta =  str_replace(' ', '', $game->team_a);
                    $gtb = str_replace(' ', '', $game->team_b);
                    $gtd = 'Draw';
                    $gto = str_replace(' ', '', $ressult1[0]->answer);
                    if(strtoupper($gta) == strtoupper($gto)){
                        $game['widegtSwitch0']= true ;
                        $game['widegtSwitch1']= false ;
                        $game['widegtSwitch2']= false ;
                    }else if(strtoupper($gtb) == strtoupper($gto)){
                        $game['widegtSwitch0']= false ;
                        $game['widegtSwitch1']= false ;
                        $game['widegtSwitch2']= true ;
                    }else if(strtoupper($gtd) == strtoupper($gto)){
                        $game['widegtSwitch0']= false ;
                        $game['widegtSwitch1']= true ;
                        $game['widegtSwitch2']= false ;
                    }
                    
                        // return $game;
                        
                    // return $ressult;
                        //  $game['id'] = 1;
                        //  return $game;

                    }
                    $widegtSwitch0 = 0;
                        $widegtSwitch1 = 0;
                        $widegtSwitch2 = 0;




                    } 
                    else
                    { 
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



    public function llr()
    {
        $round = Round::where('status', 2)->orderBy('ending_date', 'DESC')->get();
        if (count($round) > 0) {
            $games = $round[0]->games;
            // return $games[0]->results;
            $arr = [];
            for ($i = 0; $i < count($games); $i++) {
                $arr[$i]['id'] = $games[$i]->id;
                $arr[$i]['team_a'] = $games[$i]->team_a;
                $arr[$i]['team_b'] = $games[$i]->team_b;
                $arr[$i]['winner'] = $games[$i]->results->Answer;
            }
            $data = array(
                "status" => 200,
                "response" => "true",
                "message" => "Result Received",

                "answers" => $arr,
                "round" => $round[0],



            );


            return response()->json($data, 200);
        } else {
            $data = array(
                "status" => 404,
                "response" => "true",
                "message" => "No Round Played Yet",



            );

            return response()->json($data, 200);
        }
    }
    public function participatedleagues()
    {
        $userLeagues = DB::table('round_user')->where('user_id',Auth::user()->id)->get();
        $arr = [];
        foreach($userLeagues as $uL){
            array_push($arr, $uL->round_id);

        }
        if(count($arr)>0){
            array_values(array_unique($arr));
            $rounds = Round::where('status',2)->findMany($arr);
            // $closedLeagues = Round::where('status', 2)->orderBy('ending_date', 'DESC')->get();

       
        $data = array(
            "status" => 200,
            "response" => "true",
            "message" => "Result Received",
            "participatedLeagues" => $rounds,
        );


        return response()->json($data, 200);

        }else{
        
            $data = array(
                "status" => 404,
                "response" => "false",
                "message" => "No Result Found",
            );
    
    
            return response()->json($data, 200);
        }
        
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

    public function agents()
    {
        $users = User::where('roles', 2)->get();
        for ($i = 0; $i < count($users); $i++) {

            if (count($users[$i]->images) > 0) {
                $users[$i]->contacts;
                $users[$i]['image'] = $users[$i]->images[0]->url;
            } else {
                $users[$i]['image'] = null;
                $users[$i]->contacts;
            }
        }
        // $a = $users[0]->images[0]->url;
        $data = array(
            "status" => 200,
            "response" => "true",
            "message" => "Result Received",
            "agents" => $users,



        );


        return response()->json($data, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
        $pk = Package::where('id',$package_id)->first();
        $ck = Package::find($pk->id);
        $ck->accumulative_price = $pk->accumulative_price + $pk->participation_fee;
        $ck->save();
       
        $user = Auth::user();


        if (count($user->rounds) > 0) {
            $arr = [];
            foreach ($user->rounds as $rads) {
                array_push($arr, $rads->id);
            } //EndForeach
            if (!empty($arr)) {
                if (in_array("$round_id", $arr)) {
                    DB::rollback();
                    $data = array(
                        "status" => 409,
                        "response" => "true",
                        "message" => "Record Already Present",

                    );
                    return response()->json($data, 409);
                    // return $bid;
                } else {
                    $round = Round::where('id', $round_id)->first();
                    $package = Package::where('id', $package_id)->first();
                    $pp = $package->participation_fee;
                    $cc = $user->coins;
                    if ($cc >= $pp) {
                        $new_cc = $cc - $pp;
                        $data = User::find($user->id);
                        $data->coins = $new_cc;
                        $data->save();
                        $userz = User::find($user->id);
                        $userz->rounds()->attach($round_id);
                        
                        

                        for ($i = 0; $i < count($round->games); $i++) {
                            DB::table('bid_results')->insert([
                                'round_id' => $round_id,
                                'user_id' => Auth::user()->id,
                                'game_id' => $game_ids[$i],
                                'answer' => $selected_answers[$i],
                                'package_id' => $package_id,

                            ]);
                        } //End For Loop
                        // $points = $this->answerCheck($round_id,$package_id);

                        $userAnswers = DB::table('bid_results')
                            ->where('user_id', $user->id)
                            ->where('round_id', $round_id)->get();
                        $round = Round::where('id', $round_id)->first();
                        $bet_date = $userAnswers[0]->created_at;
                        $games = $round->games;
                        $packages = $round->packages;
                        foreach($games as $game){
                            // return $round->id;
                            $ressult1 = DB::table('bid_results')
                        ->where('user_id', $user->id)
                        ->where('round_id', $round->id)
                        ->where('game_id', $game->id)
                        ->get();
                        // return $ressult1;
                        $gta =  str_replace(' ', '', $game->team_a);
                        $gtb = str_replace(' ', '', $game->team_b);
                        $gtd = 'Draw';
                        $gto = str_replace(' ', '', $ressult1[0]->answer);
                        if(strtoupper($gta) == strtoupper($gto)){
                            $game['widegtSwitch0']= true ;
                            $game['widegtSwitch1']= false ;
                            $game['widegtSwitch2']= false ;
                        }else if(strtoupper($gtb) == strtoupper($gto)){
                            $game['widegtSwitch0']= false ;
                            $game['widegtSwitch1']= false ;
                            $game['widegtSwitch2']= true ;
                        }else if(strtoupper($gtd) == strtoupper($gto)){
                            $game['widegtSwitch0']= false ;
                            $game['widegtSwitch1']= true ;
                            $game['widegtSwitch2']= false ;
                        }
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
                        $user = User::find(Auth::user()->id);

                        $data = array(
                            "status" => 200,
                            "response" => "true",
                            "message" => "Record Inserted",
                            "bid" => true,
                            "bet_date" => $bet_date,
                            "user" => $user,
                            "round" => $roundComplete,
                            "userAnswers" => $userAnswers,



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
                } //EndRecordCheckCondition
            } else {
                $round = Round::where('id', $round_id)->first();
                $package = Package::where('id', $package_id)->first();
                $pp = $package->participation_fee;
                $cc = $user->coins;
                if ($cc >= $pp) {
                    $new_cc = $cc - $pp;
                    $data = User::find($user->id);
                    $data->coins = $new_cc;
                    $data->save();

                    $userz = User::find($user->id);
                    $userz->rounds()->attach($round_id);
                    

                    for ($i = 0; $i < count($round->games); $i++) {
                        DB::table('bid_results')->insert([
                            'round_id' => $round_id,
                            'user_id' => Auth::user()->id,
                            'game_id' => $game_ids[$i],
                            'answer' => $selected_answers[$i],
                            'package_id' => $package_id,

                        ]);
                    }
                    // $points = $this->answerCheck($round_id,$package_id);

                    $userAnswers = DB::table('bid_results')
                        ->where('user_id', $user->id)
                        ->where('round_id', $round_id)->get();
                    $round = Round::where('id', $round_id)->first();
                    $bet_date = $userAnswers[0]->created_at;
                    $games = $round->games;
                    $packages = $round->packages;
                    foreach($games as $game){
                        // return $round->id;
                        $ressult1 = DB::table('bid_results')
                    ->where('user_id', $user->id)
                    ->where('round_id', $round->id)
                    ->where('game_id', $game->id)
                    ->get();
                    // return $ressult1;
                    $gta =  str_replace(' ', '', $game->team_a);
                    $gtb = str_replace(' ', '', $game->team_b);
                    $gtd = 'Draw';
                    $gto = str_replace(' ', '', $ressult1[0]->answer);
                    if(strtoupper($gta) == strtoupper($gto)){
                        $game['widegtSwitch0']= true ;
                        $game['widegtSwitch1']= false ;
                        $game['widegtSwitch2']= false ;
                    }else if(strtoupper($gtb) == strtoupper($gto)){
                        $game['widegtSwitch0']= false ;
                        $game['widegtSwitch1']= false ;
                        $game['widegtSwitch2']= true ;
                    }else if(strtoupper($gtd) == strtoupper($gto)){
                        $game['widegtSwitch0']= false ;
                        $game['widegtSwitch1']= true ;
                        $game['widegtSwitch2']= false ;
                    }
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
                    $user = User::find(Auth::user()->id);
                    $data = array(
                        "status" => 200,
                        "response" => "true",
                        "message" => "Record Inserted",
                        "bid" => true,
                        "bet_date" => $bet_date,
                        "user" => $user,
                        "round" => $roundComplete,
                        "userAnswers" => $userAnswers,
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
        $cc = $user->coins;
        if ($cc >= $pp) {
            $new_cc = $cc - $pp;
            $data = User::find($user->id);
            $data->coins = $new_cc;
            $data->save();
            $userz = User::find($user->id);
            $userz->rounds()->attach($round_id);
           

            for ($i = 0; $i < count($round->games); $i++) {
                DB::table('bid_results')->insert([
                    'round_id' => $round_id,
                    'user_id' => Auth::user()->id,
                    'game_id' => $game_ids[$i],
                    'answer' => $selected_answers[$i],
                    'package_id' => $package_id,

                ]);
            }
            // $points = $this->answerCheck($round_id,$package_id);
            $userAnswers = DB::table('bid_results')
                ->where('user_id', $user->id)
                ->where('round_id', $round_id)->get();
            $round = Round::where('id', $round_id)->first();
            $bet_date = $userAnswers[0]->created_at;
            $games = $round->games;
            $packages = $round->packages;
            foreach($games as $game){
                // return $round->id;
                $ressult1 = DB::table('bid_results')
            ->where('user_id', $user->id)
            ->where('round_id', $round->id)
            ->where('game_id', $game->id)
            ->get();
            // return $ressult1;
            $gta =  str_replace(' ', '', $game->team_a);
            $gtb = str_replace(' ', '', $game->team_b);
            $gtd = 'Draw';
            $gto = str_replace(' ', '', $ressult1[0]->answer);
            if(strtoupper($gta) == strtoupper($gto)){
                $game['widegtSwitch0']= true ;
                $game['widegtSwitch1']= false ;
                $game['widegtSwitch2']= false ;
            }else if(strtoupper($gtb) == strtoupper($gto)){
                $game['widegtSwitch0']= false ;
                $game['widegtSwitch1']= false ;
                $game['widegtSwitch2']= true ;
            }else if(strtoupper($gtd) == strtoupper($gto)){
                $game['widegtSwitch0']= false ;
                $game['widegtSwitch1']= true ;
                $game['widegtSwitch2']= false ;
            }
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
            $user = User::find(Auth::user()->id);
            $data = array(
                "status" => 200,
                "response" => "true",
                "message" => "Record Inserted",
                "bid" => true,
                "bet_date" => $bet_date,
                "user" => $user,
                "round" => $roundComplete,
                "userAnswers" => $userAnswers,
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


        // DB::commit();
        // return redirect()->back()->with('message', 'success'); 
        // } catch (\Exception $ex) {
        //     DB::rollback();
        //     return redirect()->back()->with('message',$ex->getMessage());
        // }
    }
    

    public function answerCheck($round_id,$package_id){
        // dd($round_id);

        $user_id = Auth::user()->id;
       
        $userAnswers = DB::table('bid_results')
        ->where('user_id', $user_id)
        ->where('round_id', $round_id)->get();
        // dd($userAnswers);
        $round = Round::where('id',$round_id)->first();
        $totalGames = count($round->games);
        $i = 0;
        foreach($userAnswers as $UA){
         
            $gm = Game::where('id',$UA->game_id)->first();
            $gameAnswer0 = $gm->results->Answer;
            // dd($gameAnswer0 . $UA->answer);
            if($gameAnswer0 === $UA->answer){
                
                $i++;
                // dd($i);
            }
        }//EndForeach
        $point = new Point();
        $point->round_id = $round_id;
        $point->user_id = $user_id;
        $point->package_id = $package_id;
        $point->points = $i;
        $point->total_points = $totalGames;
        $point->save();

        return true;
       


    }
}
