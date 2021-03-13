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
                        $bid = true;
                        $ressult = DB::table('bid_results')
                            ->where('user_id', $user->id)
                            ->where('round_id', $round->id)->first();
                            $bet_date = $ressult->created_at;
                        $package_id = $ressult->package_id;
                        $selected_package = Package::where('id', $package_id)->first();
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


        $user = User::find($user_id);
        $agent = Auth::user();


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
                    $cc = $agent->coins;
                    if ($cc >= $pp) {
                        $new_cc = $cc - $pp;
                        $data = User::find($agent->id);
                        $data->coins = $new_cc;
                        $data->save();
                        $userz = User::find($user->id);
                        $userz->rounds()->attach($round_id);



                        for ($i = 0; $i < count($round->games); $i++) {
                            DB::table('bid_results')->insert([
                                'round_id' => $round_id,
                                'user_id' => $user_id,
                                'game_id' => $game_ids[$i],
                                'answer' => $selected_answers[$i],
                                'package_id' => $package_id,
                                'created_at' => DB::raw('now()'),

                            ]);
                        } //End For Loop
                        // $points = $this->answerCheck($round_id,$package_id);

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
                            'selected_package' => $pk,
                            'games' => $games,

                        );
                        $agent = User::find(Auth::user()->id);

                        $data = array(
                            "status" => 200,
                            "response" => "true",
                            "message" => "Record Inserted",
                            "bid" => true,
                            "user" => $user,
                            "agent" => $agent,
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
                $cc = $agent->coins;
                if ($cc >= $pp) {
                    $new_cc = $cc - $pp;
                    $data = User::find($agent->id);
                    $data->coins = $new_cc;
                    $data->save();

                    $userz = User::find($user->id);
                    $userz->rounds()->attach($round_id);


                    for ($i = 0; $i < count($round->games); $i++) {
                        DB::table('bid_results')->insert([
                            'round_id' => $round_id,
                            'user_id' => $user->id,
                            'game_id' => $game_ids[$i],
                            'answer' => $selected_answers[$i],
                            'package_id' => $package_id,
                            'created_at' => DB::raw('now()'),

                        ]);
                    }
                    // $points = $this->answerCheck($round_id,$package_id);

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
                        'selected_package' => $pk,
                        'games' => $games,
                    );
                    $agent = User::find(Auth::user()->id);
                    $data = array(
                        "status" => 200,
                        "response" => "true",
                        "message" => "Record Inserted",
                        "bid" => true,
                        "user" => $user,
                        "agent" => $agent,
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
        $cc = $agent->coins;
        if ($cc >= $pp) {
            $new_cc = $cc - $pp;
            $data = User::find($agent->id);
            $data->coins = $new_cc;
            $data->save();
            $userz = User::find($user->id);
            $userz->rounds()->attach($round_id);


            for ($i = 0; $i < count($round->games); $i++) {
                DB::table('bid_results')->insert([
                    'round_id' => $round_id,
                    'user_id' => $user->id,
                    'game_id' => $game_ids[$i],
                    'answer' => $selected_answers[$i],
                    'package_id' => $package_id,
                    'created_at' => DB::raw('now()'),

                ]);
            }
            // $points = $this->answerCheck($round_id,$package_id);
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
                'selected_package' => $pk,
                'games' => $games,
            );
            $agent = User::find(Auth::user()->id);
            $data = array(
                "status" => 200,
                "response" => "true",
                "message" => "Record Inserted",
                "bid" => true,
                "user" => $user,
                "agent" => $agent,
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
