<?php

namespace App\Http\Controllers\Web;

use App\User;
use Carbon\Carbon;
use App\Models\WithDraw;
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
                $comm = $user->comissions->where('default',1)->first();
            $com_percentage = $comm->comission_percentage;
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
        $agent = User::find($id);

        // $cid = $user->comissions[0]->id;
        foreach($agent->comissions as $ac){
            $comission = Comission::find($ac->id);
            $comission->default = 0;
            $comission->save();
        }
        $comission = new Comission();
        $comission->comission_percentage = $request->percent;
        $comission->user_id = $agent->id;
        $comission->default = 1;
        $comission->save();
        return redirect()->route('agent_grid')->with('success','Comission Updated Successfully');

    }
}
