<?php

namespace App\Http\Controllers\Api;

use App\User;
use Carbon\Carbon;
use App\Models\Point;
use App\Models\Round;
use App\Models\WithDraw;
use App\Models\AppComission;
use App\Models\CoinTransfer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminDashboardController extends Controller
{
    // public function index(){
    //     $user =  Auth::user();
    //     $user->contacts;
    //     $user->images;
        
    //     // return $user->roles;
    //     if($user->roles == '2'){
    //         $com_percentage = $user->comissions[0]->comission_percentage;
    //         $comissions = array(
    //         "id" => $user->comissions[0]->id,
    //         "comission_percentage"=> $user->comissions[0]->comission_percentage,
    //                 "user_id"=>  $user->comissions[0]->user_id,
    //                 "created_at"=>  $user->comissions[0]->created_at,
    //                 "updated_at"=>  $user->comissions[0]->updated_at
    //     );
    //     // return $user->comissions->comission_percentage;
        
    //     $history1 = CoinTransfer::where('sender_id', '=', $user->id)->where( 'created_at', '>', Carbon::today())->get();
    //     $total_sales1 = 0; 
    //     $comission1 = 0;
    //     foreach($history1 as $h1){
    //         $total_sales1 = $total_sales1 + $h1->sent_coins;
    //         $cc = $h1->sent_coins;
    //         $ac = ($cc * $com_percentage)/100;
    //         $comission1 = $comission1 + $ac;
    //         $comission1 = round($comission1, 1);

    //     }
        
       
        


    //     $history2 = CoinTransfer::where('sender_id', '=', $user->id)->where( 'created_at', '>', Carbon::now()->subDays(7))->get();
    //     $total_sales2 = 0; 
    //     $comission2 = 0;
    //     foreach($history2 as $h2){
    //         $total_sales2 = $total_sales2 + $h2->sent_coins;
    //         $cc = $h2->sent_coins;
    //         $ac = ($cc * $com_percentage)/100;
    //         $comission2 = $comission2 + $ac;
    //         $comission2 = round($comission2, 1);


    //     }


    //     $history3 = CoinTransfer::where('sender_id', '=', $user->id)->where( 'created_at', '>', Carbon::now()->subDays(30))->get();
    //     $total_sales3 = 0; 
    //     $comission3 = 0;
    //     foreach($history3 as $h3){
    //         $total_sales3 = $total_sales3 + $h3->sent_coins;
    //         $cc = $h3->sent_coins;
    //         $ac = ($cc * $com_percentage)/100;
    //         $comission3 = $comission3 + $ac;
    //         $comission3 = round($comission3, 1);

    //     }

    //     $history4 = CoinTransfer::where('sender_id', '=', $user->id)->get();
    //     $total_sales4 = 0; 
    //     $comission4 = 0;
    //     foreach($history4 as $h4){
    //         $total_sales4 = $total_sales4 + $h4->sent_coins;
    //         $cc = $h4->sent_coins;
    //         $ac = ($cc * $com_percentage)/100;
    //         $comission4 = $comission4 + $ac;
    //         $comission4 = round($comission4, 1);

    //     }
    //     $history5 = CoinTransfer::where('sender_id', '=', $user->id)->get();
    //     $total_sales5 = 0; 
    //     $comission5 = 0;
    //     foreach($history5 as $h5){
    //         // $total_sales5 = $total_sales5 + $h5->sent_coins;
    //         $cc = $h5->sent_coins;
    //         $ac = ($cc * $com_percentage)/100;
    //         $comission5 = $comission5 + $ac;
    //         $comission5 = round($comission5, 1);
    //     }
    

     
    //     $daily_data = array (
    //         "sales" => $total_sales1,
    //         "comission" => $comission1,

            
    //     );
    //     $weekly_data = array (
    //         "sales" => $total_sales2,
    //         "comission" => $comission2,
            
    //     );
    //     $monthly_data = array (
    //         "sales" => $total_sales3,
    //         "comission" => $comission3,
    //     );
    //     $all_time_data = array (
    //         "sales" => $total_sales4,
    //         "comission" => $comission4,
            
    //     );
    //     unset($user->comissions);
    //     $user['comissions'] = $comissions;
        
    //     $data = array(
    //     "status"=>200,
    //     "response"=>"true",
    //     "message" => "Success",
    //     "data" => array(
    //         "daily_data" => $daily_data,
    //         "weekly_data" => $weekly_data,
    //         "monthly_data" => $monthly_data,
    //         "all_time_data" => $all_time_data,
    //         "user" => $user,
    //         "available_for_withdraw" => $comission5,

    //     )
    //     );
    //     return response()->json($data,200);
    //     }

    // }
    public function test(){
        // return 'Hi';
        return Carbon::now();
        $user =  User::find(13);
        $user->contacts;
        $user->images;
        
        // return $user->roles;
        
        $comissions = $user->comissions;
        $newArray = [] ;
        $comissionArray = json_decode(json_encode($comissions), true);
        $lastIndex = array_key_last($comissionArray);
        for($i=0;$i<count($comissions);$i++){
           
            // return $comissions[$i];
            if($i != $lastIndex ){
                $dateOne = $comissions[$i]->created_at;
                $dateTwo = $comissions[$i+1]->created_at;
                $newArray[$i]['dateOne'] = $dateOne;
                $newArray[$i]['dateTwo'] = $dateTwo;
                $newArray[$i]['percentage'] = $comissions[$i]->comission_percentage;
            }else{
                $dateOne = $comissions[$i]->created_at;
                $dateTwo = null;
                $newArray[$i]['dateOne'] = $dateOne;
                $newArray[$i]['dateTwo'] = $dateTwo;
                $newArray[$i]['percentage'] = $comissions[$i]->comission_percentage;
            }

            
            
           
           
        }
        // return $newArray;
        $totalComission = 0;
        $total_sales = 0; 
        foreach ($newArray as $na){
            if($na['dateTwo'] == null){
                // return $na;
            $history1 = CoinTransfer::where('sender_id', 13)->where('withdraw',1)->where( 'created_at', '>', Carbon::now()->subDays(60))->whereBetween('created_at', [$na['dateOne'], Carbon::today()])->get();
            // return $history1;
        
        $comission1 = 0;
        foreach($history1 as $h1){
            $total_sales1 = $total_sales + $h1->sent_coins;
            $cc = $h1->sent_coins;
            $ac = ($cc * $na['percentage'])/100;
            $comission1 = $comission1 + $ac;
            $comission1 = round($comission1, 1);

        }
        $totalComission = $totalComission+$comission1;


            }else{
                // return $na;
            $history1 = CoinTransfer::where('sender_id', 13)->where('withdraw',1)->where( 'created_at', '>', Carbon::now()->subDays(60))->whereBetween('created_at', [$na['dateOne'], $na['dateTwo']])->get();
            // return $history1;
        
        $comission1 = 0;
        foreach($history1 as $h1){
            $total_sales1 = $total_sales + $h1->sent_coins;
            $cc = $h1->sent_coins;
            $ac = ($cc * $na['percentage'])/100;
            $comission1 = $comission1 + $ac;
            $comission1 = round($comission1, 1);

        }
        $totalComission = $totalComission+$comission1;


            }
            
        }
        return $totalComission;
        
    }
    public function index(){
        $user =  Auth::user();
        $user->contacts;
        $user->images;
        
        // return $user->roles;
        if($user->roles == '2'){
            //Here
            $comissions = $user->comissions;
        $newArray = [] ;
        $comissionArray = json_decode(json_encode($comissions), true);
        $lastIndex = array_key_last($comissionArray);
        for($i=0;$i<count($comissions);$i++){
           
            // return $comissions[$i];
            if($i != $lastIndex ){
                $dateOne = $comissions[$i]->created_at;
                $dateTwo = $comissions[$i+1]->created_at;
                $newArray[$i]['dateOne'] = $dateOne;
                $newArray[$i]['dateTwo'] = $dateTwo;
                $newArray[$i]['percentage'] = $comissions[$i]->comission_percentage;
            }else{
                $dateOne = $comissions[$i]->created_at;
                $dateTwo = null;
                $newArray[$i]['dateOne'] = $dateOne;
                $newArray[$i]['dateTwo'] = $dateTwo;
                $newArray[$i]['percentage'] = $comissions[$i]->comission_percentage;
            }

            
            
           
           
        }
        // FirstOne
        
        $totalComission1 = 0;
        $total_sales1 = 0; 
        foreach ($newArray as $na){
            if($na['dateTwo'] == null){
                
            $history1 = CoinTransfer::where('sender_id', $user->id)->where('withdraw',1)->where( 'created_at', '>=', Carbon::today())->whereBetween('created_at', [$na['dateOne'], Carbon::now()])->get();
            
        
        $comission1 = 0;
        foreach($history1 as $h1){
            $total_sales1 = $total_sales1 + $h1->sent_coins;
            $cc = $h1->sent_coins;
            $ac = ($cc * $na['percentage'])/100;
            $comission1 = $comission1 + $ac;
            $comission1 = round($comission1, 1);

        }
        $totalComission1 = $totalComission1+$comission1;


            }else{
               
            $history1 = CoinTransfer::where('sender_id', $user->id)->where('withdraw',1)->where( 'created_at', '>=', Carbon::today())->whereBetween('created_at', [$na['dateOne'], $na['dateTwo']])->get();
           
        
        $comission1 = 0;
        foreach($history1 as $h1){
            $total_sales1 = $total_sales1 + $h1->sent_coins;
            $cc = $h1->sent_coins;
            $ac = ($cc * $na['percentage'])/100;
            $comission1 = $comission1 + $ac;
            $comission1 = round($comission1, 1);

        }
        $totalComission1 = $totalComission1+$comission1;


            }
            
        }
        // return $totalComission1;
        // return $total_sales1; 
        //FirstEndHere
        //SecondHere

        $totalComission2 = 0;
        $total_sales2 = 0; 
        foreach ($newArray as $na){
            if($na['dateTwo'] == null){
                
            $history2 = CoinTransfer::where('sender_id', $user->id)->where('withdraw',1)->where( 'created_at', '>', Carbon::now()->subDays(7))->whereBetween('created_at', [$na['dateOne'], Carbon::now()])->get();
            
        
        $comission2 = 0;
        foreach($history2 as $h2){
            $total_sales2 = $total_sales2 + $h2->sent_coins;
            $cc = $h2->sent_coins;
            $ac = ($cc * $na['percentage'])/100;
            $comission2 = $comission2 + $ac;
            $comission2 = round($comission2, 1);

        }
        $totalComission2 = $totalComission2+$comission2;


            }else{
               
            $history2 = CoinTransfer::where('sender_id', $user->id)->where('withdraw',1)->where( 'created_at', '>', Carbon::now()->subDays(7))->whereBetween('created_at', [$na['dateOne'], $na['dateTwo']])->get();
           
        
        $comission2 = 0;
        foreach($history2 as $h2){
            $total_sales2 = $total_sales2 + $h2->sent_coins;
            $cc = $h2->sent_coins;
            $ac = ($cc * $na['percentage'])/100;
            $comission2 = $comission2 + $ac;
            $comission2 = round($comission2, 1);

        }
        $totalComission2 = $totalComission2+$comission2;


            }
            
        }
        // return $totalComission2;
        // return $total_sales2; 

        //SecondEndHere
        //ThirdHere

        $totalComission3 = 0;
        $total_sales3 = 0; 
        foreach ($newArray as $na){
            if($na['dateTwo'] == null){
                
            $history3 = CoinTransfer::where('sender_id', $user->id)->where('withdraw',1)->where( 'created_at', '>', Carbon::now()->subDays(30))->whereBetween('created_at', [$na['dateOne'], Carbon::now()])->get();
            
        
        $comission3 = 0;
        foreach($history3 as $h3){
            $total_sales3 = $total_sales3 + $h3->sent_coins;
            $cc = $h3->sent_coins;
            $ac = ($cc * $na['percentage'])/100;
            $comission3 = $comission3 + $ac;
            $comission3 = round($comission3, 1);

        }
        $totalComission3 = $totalComission3+$comission3;


            }else{
               
            $history3 = CoinTransfer::where('sender_id', $user->id)->where('withdraw',1)->where( 'created_at', '>', Carbon::now()->subDays(30))->whereBetween('created_at', [$na['dateOne'], $na['dateTwo']])->get();
           
        
        $comission3 = 0;
        foreach($history3 as $h3){
            $total_sales3 = $total_sales3 + $h3->sent_coins;
            $cc = $h3->sent_coins;
            $ac = ($cc * $na['percentage'])/100;
            $comission3 = $comission3 + $ac;
            $comission3 = round($comission3, 1);

        }
        $totalComission3 = $totalComission3+$comission3;


            }
            
        }
        // return $totalComission3;
        // return $total_sales3; 

        //ThirdEndHere
        //FourthHere

        $totalComission4 = 0;
        $total_sales4 = 0; 
        foreach ($newArray as $na){
            if($na['dateTwo'] == null){
                
            $history4 = CoinTransfer::where('sender_id', $user->id)->where('withdraw',1)->whereBetween('created_at', [$na['dateOne'], Carbon::now()])->get();
            
        
        $comission4 = 0;
        foreach($history4 as $h4){
            $total_sales4 = $total_sales4 + $h4->sent_coins;
            $cc = $h4->sent_coins;
            $ac = ($cc * $na['percentage'])/100;
            $comission4 = $comission4 + $ac;
            $comission4 = round($comission4, 1);

        }
        $totalComission4 = $totalComission4+$comission4;


            }else{
               
            $history4 = CoinTransfer::where('sender_id', $user->id)->where('withdraw',1)->whereBetween('created_at', [$na['dateOne'], $na['dateTwo']])->get();
           
        
        $comission4 = 0;
        foreach($history4 as $h4){
            $total_sales4 = $total_sales4 + $h4->sent_coins;
            $cc = $h4->sent_coins;
            $ac = ($cc * $na['percentage'])/100;
            $comission4 = $comission4 + $ac;
            $comission4 = round($comission4, 1);

        }
        $totalComission4 = $totalComission4+$comission4;


            }
            
        }

        // return $totalComission4;
        // return $total_sales4; 

        //FourthEndHere
        $availableForWithDraw = WithDraw::where('user_id',$user->id)->first();
        if($availableForWithDraw == null ){
            $afw = 0;
        }elseif($availableForWithDraw->withdraw_comission == null){
            $afw = $availableForWithDraw->total_comission;
        }else{
            $afw = $availableForWithDraw->total_comission - $availableForWithDraw->withdraw_comission;
        }
            //To Here
            $comissions = array(
            "id" => $user->comissions[0]->id,
            "comission_percentage"=> $user->comissions[0]->comission_percentage,
                    "user_id"=>  $user->comissions[0]->user_id,
                    "created_at"=>  $user->comissions[0]->created_at,
                    "updated_at"=>  $user->comissions[0]->updated_at
        );
        // return $user->comissions->comission_percentage;
        
        // $history1 = CoinTransfer::where('sender_id', '=', $user->id)->where( 'created_at', '>', Carbon::today())->get();
        // $total_sales1 = 0; 
        // $comission1 = 0;
        // foreach($history1 as $h1){
        //     $total_sales1 = $total_sales1 + $h1->sent_coins;
        //     $cc = $h1->sent_coins;
        //     $ac = ($cc * $com_percentage)/100;
        //     $comission1 = $comission1 + $ac;
        //     $comission1 = round($comission1, 1);

        // }
        
       
        


        // $history2 = CoinTransfer::where('sender_id', '=', $user->id)->where( 'created_at', '>', Carbon::now()->subDays(7))->get();
        // $total_sales2 = 0; 
        // $comission2 = 0;
        // foreach($history2 as $h2){
        //     $total_sales2 = $total_sales2 + $h2->sent_coins;
        //     $cc = $h2->sent_coins;
        //     $ac = ($cc * $com_percentage)/100;
        //     $comission2 = $comission2 + $ac;
        //     $comission2 = round($comission2, 1);


        // }


        // $history3 = CoinTransfer::where('sender_id', '=', $user->id)->where( 'created_at', '>', Carbon::now()->subDays(30))->get();
        // $total_sales3 = 0; 
        // $comission3 = 0;
        // foreach($history3 as $h3){
        //     $total_sales3 = $total_sales3 + $h3->sent_coins;
        //     $cc = $h3->sent_coins;
        //     $ac = ($cc * $com_percentage)/100;
        //     $comission3 = $comission3 + $ac;
        //     $comission3 = round($comission3, 1);

        // }

        // $history4 = CoinTransfer::where('sender_id', '=', $user->id)->get();
        // $total_sales4 = 0; 
        // $comission4 = 0;
        // foreach($history4 as $h4){
        //     $total_sales4 = $total_sales4 + $h4->sent_coins;
        //     $cc = $h4->sent_coins;
        //     $ac = ($cc * $com_percentage)/100;
        //     $comission4 = $comission4 + $ac;
        //     $comission4 = round($comission4, 1);

        // }
        // $history5 = CoinTransfer::where('sender_id', '=', $user->id)->get();
        // $total_sales5 = 0; 
        // $comission5 = 0;
        // foreach($history5 as $h5){
        //     // $total_sales5 = $total_sales5 + $h5->sent_coins;
        //     $cc = $h5->sent_coins;
        //     $ac = ($cc * $com_percentage)/100;
        //     $comission5 = $comission5 + $ac;
        //     $comission5 = round($comission5, 1);
        // }
    

     
        $daily_data = array (
            "sales" => $total_sales1,
            "comission" => $totalComission1,

            
        );
        $weekly_data = array (
            "sales" => $total_sales2,
            "comission" => $totalComission2,
            
        );
        $monthly_data = array (
            "sales" => $total_sales3,
            "comission" => $totalComission3,
        );
        $all_time_data = array (
            "sales" => $total_sales4,
            "comission" => $totalComission4,
            
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
            "available_for_withdraw" => intval($afw),

        )
        );
        return response()->json($data,200);
        }

    }
    public function alr(){
        // $a = 0 ;
        $points = Point::where('round_id',1)->where('package_id',1)->orderBy('points', 'desc')->get();
        $second = Point::where('round_id',1)->where('package_id',1)
        ->orderBy('points', 'desc')
        ->pluck('points');
        $points = json_decode(json_encode($second), true);
        // return $points;
        $points = array_values(array_unique($points)) ;
      
        $all = array();
        foreach($points as $key=>$value){
        $all[] = $value['points'];
        }

        rsort($all);
        return $all[1];
        return $second;

        $package = Package::select('accumulative_price')->where('id',3)->first();
        $package = $package->accumulative_price;
        // return $package ;
        $companyPercentage = AppComission::select('app_comission')->first();
        $companyPercentage = $companyPercentage->app_comission;
        // return $companyPercentage;
        $new_width = ($package / 100) * $companyPercentage;
        return $new_width;
        $lastThreeClosedRounds = Round::select('name','starting_date','ending_date')->latest()->where('status',2)->take(3)->get();

        return $lastThreeClosedRounds;
        


    }
    public function testz(){
        $arr = [];
        $datz = [];
        $round = Round::where('id',64)->first();
        $packages = $round->packages;
        for ($i = 0; $i < count($packages); $i++) {
            $FirstJackPot = [];
            $FirstJackPotDates = [];
            $SecondJackPot = [];
            $SecondJackPotDates = [];
            $ThirdJackPot = [];
            $ThirdJackPotDates = [];
            $points = Point::where('round_id',64)->where('package_id',$packages[$i]->id)->orderBy('points', 'desc')->get();
            $pluckPoints = Point::where('round_id',64)->where('package_id',$packages[$i]->id)->orderBy('points', 'desc')->pluck('points');
            $pointValues = json_decode(json_encode($pluckPoints), true);
            // return $points;
            $pointValues = array_values(array_unique($pointValues)) ;
            foreach($points as $pt){

                if(array_key_exists(0,$pointValues) && $pt->points == $pointValues[0]){    
                    array_push($FirstJackPot,$pt->user->id); 
                    array_push($FirstJackPotDates,$pt->created_at); 
                }elseif(array_key_exists(1,$pointValues) && $pt->points == $pointValues[1]){

                    array_push($SecondJackPot,$pt->user->id); 
                    array_push($SecondJackPotDates,$pt->created_at); 
                }elseif(array_key_exists(2,$pointValues) && $pt->points == $pointValues[2]){

                    array_push($ThirdJackPot,$pt->user->id); 
                    array_push($ThirdJackPotDates,$pt->created_at); 
                }



                
                
            }
            $arr[$i]['FirstJackPotUserIds'] =  $FirstJackPot;
            $datz[$i]['FirstJackPotUserDates'] =  $FirstJackPotDates;
            $arr[$i]['SecondJackPotUserIds'] =  $SecondJackPot;
            $datz[$i]['SecondJackPotUserDates'] =  $SecondJackPotDates;
            $arr[$i]['ThirdJackPotUserIds'] =  $ThirdJackPot;
            $datz[$i]['ThirdJackPotUserDates'] =  $ThirdJackPotDates;
            
            
          
        }
        $data = array(
            "Ids" => $arr,
            "Dates" => $datz

        );
        return response()->json($data,200);
    }

    
}
