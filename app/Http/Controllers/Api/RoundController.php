<?php

namespace App\Http\Controllers\Api;

use App\User;
use Carbon\Carbon;
use App\Models\Round;
use App\Models\Package;
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
            ->where('ending_date', '>=', $now)->where('tag', 'original')
            ->first();

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
                } else {
                    $result = array_search("$round->id", $arr);
                    if ($result >= 0 || $result != '') {
                        $bid = true;
                    } else {
                        $bid = false;
                    }
                }
            } else {
                $bid = false;
            }
            $roundComplete = array(
                'id' => $round->id,
                'name' => $round->name,
                'starting_date' => $round->starting_date,
                'ending_date' => $round->ending_date,
                'created_at' => $round->created_at,
                'updated_at' => $round->updated_at,
                'packages' => $packages,
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

    public function sb(Request $request)
    {
        // return($request->all());
        $selected_answers = explode(",", $request->selected_answers);
        $game_ids = explode(",", $request->game_ids);
        $round_id = $request->round_id;
        $package_id = $request->package_id;

        // $ids = array("1","2","3");

        $user = Auth::user();

        if (count($user->rounds) > 0) {
            $arr = [];
            foreach ($user->rounds as $rads) {
                array_push($arr, $rads->id);
            }
            // return $arr;
            if (!empty($arr)) {
                // $arr = array('3','1','3');

                // $result = array_search("$round_id",$arr);
                // return $result;
                if (in_array("$round_id", $arr)) {
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

                        $user->rounds()->attach($round_id);

                        for ($i = 0; $i < count($round->games); $i++) {
                            DB::table('bid_results')->insert([
                                'round_id' => $round_id,
                                'user_id' => Auth::user()->id,
                                'game_id' => $game_ids[$i],
                                'answer' => $selected_answers[$i],
                                'package_id' => $package_id,

                            ]);
                        }

                        $userAnswers = DB::table('bid_results')
                            ->where('user_id', $user->id)
                            ->where('round_id', $round_id)->get();
                        $round = Round::where('id', $round_id)->first();
                        $games = $round->games;
                        $packages = $round->packages;

                        $roundComplete = array(
                            'id' => $round->id,
                            'name' => $round->name,
                            'starting_date' => $round->starting_date,
                            'ending_date' => $round->ending_date,
                            'created_at' => $round->created_at,
                            'updated_at' => $round->updated_at,
                            'packages' => $packages,
                            'games' => $games,

                        );

                        $data = array(
                            "status" => 200,
                            "response" => "true",
                            "message" => "Record Inserted",
                            "bid" => true,
                            "user" => Auth::user(),
                            "round" => $roundComplete,
                            "userAnswers" => $userAnswers,



                        );
                        return response()->json($data, 201);
                    } else {

                        $data = array(
                            "status" => 429,
                            "response" => "true",
                            "message" => "You Don't have enough Coins",

                        );
                        return response()->json($data, 429);
                    }
                }
            } else {

                $package = Package::where('id', $package_id)->first();
                    $pp = $package->participation_fee;
                    $cc = $user->coins;
                    if ($cc >= $pp) {
                        $new_cc = $cc - $pp;
                        $data = User::find($user->id);
                        $data->coins = $new_cc;
                        $data->save(); 
                $round = Round::where('id', $round_id)->first();
                $user->rounds()->attach($round_id);

                for($i = 0; $i < count($round->games); $i++) { 
                    DB::table('bid_results')->insert([
                        'round_id' => $round_id,
                        'user_id' => Auth::user()->id,
                        'game_id' => $game_ids[$i],
                        'answer' => $selected_answers[$i],
                        'package_id' => $package_id,

                    ]);
                    
                }

                $userAnswers = DB::table('bid_results')
                    ->where('user_id', $user->id)
                    ->where('round_id', $round_id)->get();
                $round = Round::where('id', $round_id)->first();
                $games = $round->games;
                $packages = $round->packages;

                $roundComplete = array(
                    'id' => $round->id,
                    'name' => $round->name,
                    'starting_date' => $round->starting_date,
                    'ending_date' => $round->ending_date,
                    'created_at' => $round->created_at,
                    'updated_at' => $round->updated_at,
                    'packages' => $packages,
                    'games' => $games,

                );

                $data = array(
                    "status" => 200,
                    "response" => "true",
                    "message" => "Record Inserted",
                    "bid" => true,
                    "user" => Auth::user(),
                    "round" => $roundComplete,
                    "userAnswers" => $userAnswers,



                );
                return response()->json($data, 201);
            }else{
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
        
        $user->rounds()->attach($round_id);

        for ($i = 0; $i < count($round->games); $i++) {
            DB::table('bid_results')->insert([
                'round_id' => $round_id,
                'user_id' => Auth::user()->id,
                'game_id' => $game_ids[$i],
                'answer' => $selected_answers[$i],
                'package_id' => $package_id,

            ]);
        }
        $userAnswers = DB::table('bid_results')
            ->where('user_id', $user->id)
            ->where('round_id', $round_id)->get();
        $round = Round::where('id', $round_id)->first();
        $games = $round->games;
        $packages = $round->packages;

        $roundComplete = array(
            'id' => $round->id,
            'name' => $round->name,
            'starting_date' => $round->starting_date,
            'ending_date' => $round->ending_date,
            'created_at' => $round->created_at,
            'updated_at' => $round->updated_at,
            'packages' => $packages,
            'games' => $games,

        );

        $data = array(
            "status" => 200,
            "response" => "true",
            "message" => "Record Inserted",
            "bid" => true,
            "user" => Auth::user(),
            "round" => $roundComplete,
            "userAnswers" => $userAnswers,



        );
        return response()->json($data, 201);
    }else{

        $data = array(
            "status" => 429,
            "response" => "true",
            "message" => "You Don't have enough Coins",

        );
        return response()->json($data, 429);
        
    }
    }

    public function llr()
    {
        $round = Round::where('status', 0)->orderBy('ending_date', 'DESC')->get();
        if (count($round) > 0) {
            $games = $round[0]->games;
            // return $games[0]->results;
            $arr = [];
            for ($i = 0; $i < count($games); $i++) {
                $arr[$i]['id'] = $games[$i]->id;
                $arr[$i]['team_a'] = $games[$i]->team_a;
                $arr[$i]['team_b'] = $games[$i]->team_b;
                $arr[$i]['winner'] = $games[$i]->results[0]->Answer;
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
    public function leagues()
    {
        $closedLeagues = Round::where('status', 2)->orderBy('ending_date', 'DESC')->get();
        $ActiveLeagues = Round::where('status', 1)->orderBy('ending_date', 'DESC')->get();;
        $ParticipatedLeagues = Round::all();
        $data = array(
            "status" => 200,
            "response" => "true",
            "message" => "Result Received",
            "activeLeagues" => $ActiveLeagues,
            "closedLeagues" => $closedLeagues,
            "participatedLeagues" => $ParticipatedLeagues,
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

    public function agents()
    {
        $users = User::all();
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
}
