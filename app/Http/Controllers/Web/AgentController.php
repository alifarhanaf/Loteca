<?php

namespace App\Http\Controllers\Web;

use App\User;
use Carbon\Carbon;
use App\Models\Comission;
use App\Models\CoinTransfer;
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
        
        $user =  User::where('id',$id)->first();
        $user->contacts;
        $user->images;
        // return $user->roles;
        if($user->roles == '2'){
            $com_percentage = $user->comissions->comission_percentage;
        // return $user->comissions->comission_percentage;
        
        $history1 = CoinTransfer::where('sender_id', '=', $user->id)->where( 'created_at', '>', Carbon::today())->get();
        $total_sales1 = 0; 
        $comission1 = 0;
        foreach($history1 as $h1){
            $total_sales1 = $total_sales1 + $h1->sent_coins;
            $cc = $h1->sent_coins;
            $ac = ($cc * $com_percentage)/100;
            $comission1 = $comission1 + $ac;
            $comission1 = round($comission1, 1);

        }
       
        


        $history2 = CoinTransfer::where('sender_id', '=', $user->id)->where( 'created_at', '>', Carbon::now()->subDays(7))->get();
        $total_sales2 = 0; 
        $comission2 = 0;
        foreach($history2 as $h2){
            $total_sales2 = $total_sales2 + $h2->sent_coins;
            $cc = $h2->sent_coins;
            $ac = ($cc * $com_percentage)/100;
            $comission2 = $comission2 + $ac;
            $comission2 = round($comission2, 1);


        }


        $history3 = CoinTransfer::where('sender_id', '=', $user->id)->where( 'created_at', '>', Carbon::now()->subDays(30))->get();
        $total_sales3 = 0; 
        $comission3 = 0;
        foreach($history3 as $h3){
            $total_sales3 = $total_sales3 + $h3->sent_coins;
            $cc = $h3->sent_coins;
            $ac = ($cc * $com_percentage)/100;
            $comission3 = $comission3 + $ac;
            $comission3 = round($comission3, 1);

        }

        $history4 = CoinTransfer::where('sender_id', '=', $user->id)->get();
        $total_sales4 = 0; 
        $comission4 = 0;
        foreach($history4 as $h4){
            $total_sales4 = $total_sales4 + $h4->sent_coins;
            $cc = $h4->sent_coins;
            $ac = ($cc * $com_percentage)/100;
            $comission4 = $comission4 + $ac;
            $comission4 = round($comission4, 1);

        }
    

     
        $daily_data = array (
            "sales" => $total_sales1,
            "comission" => $comission1,

            
        );
        $weekly_data = array (
            "sales" => $total_sales2,
            "comission" => $comission2,
            
        );
        $monthly_data = array (
            "sales" => $total_sales3,
            "comission" => $comission3,
        );
        $all_time_data = array (
            "sales" => $total_sales4,
            "comission" => $comission4,
            
        );
        
        // $data = array(
        // "status"=>200,
        // "response"=>"true",
        // "message" => "Success",
        // "data" => array(
        //     "daily_data" => $daily_data,
        //     "weekly_data" => $weekly_data,
        //     "monthly_data" => $monthly_data,
        //     "all_time_data" => $all_time_data,
        //     "user" => $user,

        // )
        // );
        // return response()->json($data,200);
        }
        
        $data = array(
            "agent" => $user,
            "daily_data" => $daily_data,
            "weekly_data" => $weekly_data,
            "monthly_data" => $monthly_data,
            "all_time_data" => $all_time_data,
            "comission" => $com_percentage,
        );

        return view('agentProfile')->with($data);
    }
    public function updateComission(Request $request,$id){
        $user = User::find($id);
        $cid = $user->comissions->id;
        $comission = Comission::find($cid);
        $comission->comission_percentage = $request->percent;
        $comission->save();
        return redirect()->route('agent_grid')->with('success','Comission Updated Successfully');

    }
}
