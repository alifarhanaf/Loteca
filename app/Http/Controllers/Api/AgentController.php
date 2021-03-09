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
                    $package_id = $ressult->package_id;
                    $selected_package = Package::where('id',$package_id)->first();




                    } 
                    else
                    { 
                        $bid = false;
                        $selected_package = null;
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

    public function ValidateUser(Request $request){
        $user =  User::where('email',$request->email)->first();
        if ($user ){
            $now = Carbon::now();
            $now->toDateString();
            $round = Round::where('starting_date', '<=', $now)
            ->where('ending_date', '>=', $now)->where('tag', 'original')->where('status',1)
            ->first();
        // return $round;
        if ($round) {

            if (count($user->rounds) > 0) {
                $arr = [];
                foreach ($user->rounds as $rads) {
                    array_push($arr, $rads->id);
                }
                
                if (in_array($round->id, $arr)){ 
                    $data = array(
                        "status" => 209,
                        "response" => "false",
                        "message" => "User Already Made a Bet On This Round",
                        );
                        return response()->json($data,200);
                }else{ 
                        $user->contacts;
                        $user->images;
                        $data = array(
                            "status"=>200,
                            "response"=>"true",
                            "message" => "Success",
                            "user" => $user,
                        );
                        return response()->json($data,200);
                    
                } 
                
            }else{
                $user->contacts;
                $user->images;
                $data = array(
                    "status"=>200,
                    "response"=>"true",
                    "message" => "Success",
                    "user" => $user,
                );
                return response()->json($data,200);
            }



            

        }else {
            $data = array(
                "status" => 404,
                "response" => "false",
                "message" => "No Round is Live",
            );
            return response()->json($data, 404);
        }
            

        }else{
            $data = array(
            "status" => 404,
            "response" => "false",
            "message" => "User Not Found",
            );
            return response()->json($data,200);
        }
        
        
    }
}
