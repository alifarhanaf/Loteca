<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Point;
use App\Models\Round;
use App\Models\CoinTransfer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function index(){
        $user =  Auth::user();
        $user->contacts;
        $user->images;
        
        // return $user->roles;
        if($user->roles == '2'){
            $com_percentage = $user->comissions[0]->comission_percentage;
            $comissions = array(
            "id" => $user->comissions[0]->id,
            "comission_percentage"=> $user->comissions[0]->comission_percentage,
                    "user_id"=>  $user->comissions[0]->user_id,
                    "created_at"=>  $user->comissions[0]->created_at,
                    "updated_at"=>  $user->comissions[0]->updated_at
        );
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
        $history5 = CoinTransfer::where('sender_id', '=', $user->id)->get();
        $total_sales5 = 0; 
        $comission5 = 0;
        foreach($history5 as $h5){
            // $total_sales5 = $total_sales5 + $h5->sent_coins;
            $cc = $h5->sent_coins;
            $ac = ($cc * $com_percentage)/100;
            $comission5 = $comission5 + $ac;
            $comission5 = round($comission5, 1);


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
        unset($user->comissions);
        $user['comissions'] = $comissions;
        
        $data = array(
        "status"=>200,
        "response"=>"true",
        "message" => "Success",
        "data" => array(
            "daily_data" => $daily_data,
            "weekly_data" => $weekly_data,
            "monthly_data" => $monthly_data,
            "all_time_data" => $all_time_data,
            "user" => $user,
            "available_for_withdraw" => $comission5,

        )
        );
        return response()->json($data,200);
        }

    }
    
}
