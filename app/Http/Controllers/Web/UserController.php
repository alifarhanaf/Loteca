<?php

namespace App\Http\Controllers\Web;

use App\User;
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
        dd('true');
        // return redirect()->back()->with('success','Agent Assigned Successfully');
    }
}
