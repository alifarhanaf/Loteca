<?php

namespace App\Http\Controllers\Web;

use App\User;
use App\Models\Point;
use App\Models\Round;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function userGrid(){
        $users = User::where('roles','1')->get();
        // $users->images;
        // $users->contacts;
        foreach($users as $user){
            $user->images;
            $user->contacts;
            
        }
        // return $users;
        $data = array(
            'users' => $users,
        );
        return view('userGrid')->with($data);
        
    }
    public function userProfile($id){
        $user = User::where('id',$id)->first();
        $user->contacts;
        $user->images;
        $usrs = DB::table('agent_users')
        ->where('user_id', $id)->first();
        if($usrs){
            $agent = User::where('id',$usrs->agent_id)->first();
        }else{
            $agent = null;
        }
        
        $data = array(
            "user" => $user,
            "agent" => $agent,
            "rounds" => $user->rounds,
        );

        return view('userProfile')->with($data);
    }
    public function assignAgent(Request $request, $id){
        $agent = User::where('email',$request->email)->first();
        DB::table('agent_users')->insert([
            'user_id' => $id,
            'agent_id' => $agent->id,

        ]);
        return redirect()->route('user.profile',$id)->with('success','Agent Assigned Successfully');
    }
    public function pointsUpdate(Request $request,$id){
        $points = $request->points;
        $round = Round::where('status',2)->first();
        $package_id = $round->packages[0]->id;
        // dd($package_id);
        $point = Point::where('user_id',$id)->where('package_id',$package_id)->where('round_id',$round->id)->max('points');
        if($point == null){
            $point = new Point();
            $point->user_id = $id;
            $point->round_id = $round->id;
            $point->package_id = $package_id;
            $point->points = $request->points;
            $point->total_points = 10;
            $point->winning_coins = 0;
            $point->save();
        }else{
            $point->points = $point->points + $points;
            $point->save();
        }
        return redirect()->route('user.profile',$id)->with('success','Points Added Successfully');
    }
}
