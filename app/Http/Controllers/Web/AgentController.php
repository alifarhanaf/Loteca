<?php

namespace App\Http\Controllers\Web;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AgentController extends Controller
{
    public function agentGrid(){
        $agents = User::where('roles','2')->get();
        // $users->images;
        // $users->contacts;
        foreach($agents as $agent){
            $agent->images;
            $agent->contacts;
            
        }
        // return $users;
        $data = array(
            'agents' => $agents,
        );
        return view('agentGrid')->with($data);
        
    }
    public function agentProfile($id){
        $agent = User::where('id',$id)->first();
        $agent->contacts;
        $agent->images;
        
        $data = array(
            "agent" => $agent,
            "rounds" => $agent->rounds,
        );

        return view('agentProfile')->with($data);
    }
}
