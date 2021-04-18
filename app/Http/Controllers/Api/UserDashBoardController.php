<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserDashBoardController extends Controller
{
    public function userDashboard(){
        $user = Auth::user();
        $userDetail = [];
        $userDetail['id'] = $user->id;
        $userDetail['name'] = $user->name;
        $userDetail['email'] = $user->id;
        if($user->email_verified_at == null){
            $userDetail['verified'] = false;
        }else{
            $userDetail['verified'] = true;
        }
        if($user->roles == 2){
            $userDetail['role'] = "agent";
        }else if($user->roles == 1){
            $userDetail['role'] = "user";
        }else if($user->roles == 3){
            $userDetail['role'] = "agent";
        }
        $userDetail['coins_available'] = $user->coins;
        $userDetail['phone'] = $user->contacts[0]->phone;
        $userDetail['whatsapp'] = $user->contacts[0]->whatsapp;
        $userDetail['images'] = $user->images[0]->url;

        $data = array(
            "status"=>200,
            "response"=>"true",
            "message" => "Success",
            "data" => array(
                // "daily_data" => $daily_data,
                // "weekly_data" => $weekly_data,
                // "monthly_data" => $monthly_data,
                // "all_time_data" => $all_time_data,
                "user" => $userDetail,
                // "available_for_withdraw" => intval($afw),
    
            )
            );
            return response()->json($data,200);


        $userDetail['id'] = $user->id;
        $userDetail['id'] = $user->id;
        
    }
}
