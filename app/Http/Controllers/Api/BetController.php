<?php

namespace App\Http\Controllers\Api;

use App\User;
use Carbon\Carbon;
use App\Models\Game;
use App\Models\Image;
use App\Models\Round;
use App\Models\Contact;
use App\Models\Package;
use App\Models\WithDraw;
use Illuminate\Support\Str;
use App\Models\CoinTransfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class BetController extends Controller
{
    public function betSubmit(Request $request)
    {
        DB::beginTransaction();
        try {
        $selected_answerz = trim($request->selected_answers, '[]');
        $selected_answers = explode(",", $selected_answerz);
        $game_idz = trim($request->game_ids, '[]');
        $game_ids = explode(",", $game_idz);
        $round_id = $request->round_id;
        $package_id = $request->package_id;
        $name = $request->name;
        $email = $request->email;
        $phone = $request->phone;
        //Getting Selected Package Details
        // $pk = Package::where('id',$package_id)->first();
        $package = Package::where('id',$package_id)->first();
        //Adding Price in Accumulative Price For Bet
        $packageUpdate = Package::find($package->id);
        $packageUpdate->accumulative_price = $package->accumulative_price + $package->participation_fee;
        $packageUpdate->save();
        //Getting Round Details
        $round = Round::where('id', $round_id)->first();
        $games = $round->games;
        $packages = $round->packages;

        //Retreiving User and Agent Record
        if ($email != null && $phone != null && $name != null ) {
            $agent = Auth::user();
            $userForUpdateCoins = User::find($agent->id);
            //Getting Users Current Coins
            $userAvailableCoins = $agent->coins;
            $user = User::where('email',$email)->first();
            
            if ($user === null) {
            //Regestring User
            $password = Hash::make("123456");
            $remember_token = Str::random(10);
            $code = random_int(10000, 99999);
            $userCreate = new User();
            $userCreate->name = $name;
            $userCreate->email = $email;
            $userCreate->password = $password;
            $userCreate->coins = '0';
            $userCreate->remember_token = $remember_token;
            $userCreate->roles = '1';
            $userCreate->auth_code = "$code";
            $userCreate->save();
        
       
            //Regestring User Contact
            $contact = New Contact();
            $contact->phone = $phone;
            $contact->whatsapp = $phone;
            $contact->email = $email;
            $contact->user()->associate($userCreate);
            $contact->save();
            
            //Assigning User Image
            $image =  New Image();
            $image->url = 'https://i.pinimg.com/originals/51/f6/fb/51f6fb256629fc755b8870c801092942.png';
            $image->user()->associate($userCreate);
            $image->save();

            $user = User::where('id',$userCreate->id);
            
            }

        }else{
            $user = Auth::user();
            //Getting Users Current Coins
            $userAvailableCoins = $user->coins;
            $userForUpdateCoins = User::find($user->id);
            $agent = null;
        }


        
        //Current TimeStamp for Bet Submission Date
        $submitDate = Carbon::now();
        //Getting Participation Fee Selected
        $participation_fee = $package->participation_fee;
        
        //Checking Users Coin Available for Bet
        if ($userAvailableCoins >= $participation_fee) {
            //Updating Coins Afer Bet
            $userRemainingCoins = $userAvailableCoins - $participation_fee;
            $userForUpdateCoins->coins = $userRemainingCoins;
            $userForUpdateCoins->save();
            //Record For Agent
            if($agent != null){
                $coinTransfer = new CoinTransfer(); 
                $coinTransfer->sender_id = $agent->id;
                $coinTransfer->receiver_id = $user->id;
                $coinTransfer->sent_coins = $participation_fee;
                $coinTransfer->withdraw = 1;
                $coinTransfer->save();

                $comissions = $agent->comissions;
                $comissionLog = [] ;
                $comissionArray = json_decode(json_encode($comissions), true);
                $lastIndex = array_key_last($comissionArray);
                for($i=0;$i<count($comissions);$i++){
                    if($i != $lastIndex ){
                        $dateOne = $comissions[$i]->created_at;
                        $dateTwo = $comissions[$i+1]->created_at;
                        $comissionLog[$i]['dateOne'] = $dateOne;
                        $comissionLog[$i]['dateTwo'] = $dateTwo;
                        $comissionLog[$i]['percentage'] = $comissions[$i]->comission_percentage;
                    }else{
                        $dateOne = $comissions[$i]->created_at;
                        $dateTwo = null;
                        $comissionLog[$i]['dateOne'] = $dateOne;
                        $comissionLog[$i]['dateTwo'] = $dateTwo;
                        $comissionLog[$i]['percentage'] = $comissions[$i]->comission_percentage;
                        }
                }
                $totalComission = 0;
                foreach ($comissionLog as $log){
                    if($log['dateTwo'] == null){
                        $historyLog = CoinTransfer::where('sender_id', $agent->id)->where('withdraw',1)->whereBetween('created_at', [$log['dateOne'], Carbon::now()])->get();
                    }else{
                        $historyLog = CoinTransfer::where('sender_id', $agent->id)->where('withdraw',1)->whereBetween('created_at', [$log['dateOne'], $log['dateTwo']])->get();
                    }
                        $agentComission = 0;
                        foreach($historyLog as $history){
                            $sentCoins = $history->sent_coins;
                            $currentComission = ($sentCoins * $log['percentage'])/100;
                            $agentComission = $agentComission + $currentComission;
                            $agentComission = round($agentComission, 1);

                        }
                        $totalComission = $totalComission+$agentComission;
                    // }else{
               
                    //     $historyLog = CoinTransfer::where('sender_id', $sender->id)->where('withdraw',1)->whereBetween('created_at', [$log['dateOne'], $log['dateTwo']])->get();
                    //     $agentComission = 0;
                    //     foreach($historyLog as $history){
                    //     $sentCoins = $history->sent_coins;
                    //     $currentComission = ($sentCoins * $log['percentage'])/100;
                    //     $agentComission = $agentComission + $currentComission;
                    //     $agentComission = round($agentComission, 1);

                    //     }
                    //     $totalComission = $totalComission+$agentComission;
                    // }
            
                }
                //Comission Available For WithDraw Update
                $commision = WithDraw::where('user_id',$agent->id)->first();
                if($commision){
                    $comissionUpdate = WithDraw::find($commision->id);
                    $comissionUpdate->total_comission = $totalComission;
                    $comissionUpdate->save();

                }else{
                    $insertTotalComission = new WithDraw();
                    $insertTotalComission->total_comission = $totalComission;
                    $insertTotalComission->save();
                }
            }
            //Insert Bet Record Against User 
            
            DB::table('round_user')->insert([
                'round_id' => $round_id,
                'user_id' => $user->id,
                'created_at' => $submitDate,
                'updated_at' => $submitDate,
            ]);
            //Inserting User Selected Answers In DB
            for ($i = 0; $i < count($round->games); $i++) {
                DB::table('bid_results')->insert([
                    'round_id' => $round_id,
                    'user_id' => $user->id,
                    'game_id' => $game_ids[$i],
                    'answer' => $selected_answers[$i],
                    'package_id' => $package_id,
                    'created_at' => $submitDate,
                    'updated_at' => $submitDate
                ]);
            } 
            //Retreiving User's Submitted Answers
            $userAnswers = DB::table('bid_results')
                            ->where('user_id', $user->id)
                            ->where('round_id', $round_id)
                            ->where('created_at',$submitDate)->get();
            //User's Selected Answer's Array For Response
            $ansArray = [];
            for($k=0;$k<count($userAnswers);$k++){
                $game = Game::where('id',$userAnswers[$k]->game_id)->first();
                                
                $ansArray[$k]['id'] = $userAnswers[$k]->id;
                $ansArray[$k]['team_a'] = $game->team_a;
                $ansArray[$k]['team_b'] = $game->team_b;
                $ansArray[$k]['winner'] = $userAnswers[$k]->answer;
                $ansArray[$k]['championship'] = $game->name;
                $ansArray[$k]['happening_date'] = $game->happening_date;
                
            }
            //WidgetSwitches For Screen 
            foreach($games as $game){

                $game['widegtSwitch0']= null ;
                $game['widegtSwitch1']= null ;
                $game['widegtSwitch2']= null ;
            
                
            //  $ressult1 = DB::table('bid_results')
            // ->where('user_id', $user->id)
            // ->where('round_id', $round->id)
            // ->where('game_id', $game->id)
            // ->get();
            
            // $gta =  str_replace(' ', '', $game->team_a);
            // $gtb = str_replace(' ', '', $game->team_b);
            // $gtd = 'Draw';
            // $gto = str_replace(' ', '', $ressult1[0]->answer);
            // if(strtoupper($gta) == strtoupper($gto)){
            //     $game['widegtSwitch0']= true ;
            //     $game['widegtSwitch1']= false ;
            //     $game['widegtSwitch2']= false ;
            // }else if(strtoupper($gtb) == strtoupper($gto)){
            //     $game['widegtSwitch0']= false ;
            //     $game['widegtSwitch1']= false ;
            //     $game['widegtSwitch2']= true ;
            // }else if(strtoupper($gtd) == strtoupper($gto)){
            //     $game['widegtSwitch0']= false ;
            //     $game['widegtSwitch1']= true ;
            //     $game['widegtSwitch2']= false ;
            // }
        }
        //Round Detail For Response
        $roundComplete = array(
            'id' => $round->id,
            'name' => $round->name,
            'starting_date' => $round->starting_date,
            'ending_date' => $round->ending_date,
            'created_at' => $round->created_at,
            'updated_at' => $round->updated_at,
            'selected_package' => $package,
            'packages' => $packages,
            'games' => $games,
        );
        //Refresh User and Agent For Fresh Records
        $updatedUser = User::find($user->id);
        $updatedUser['phone'] = $updatedUser->contacts[0]->phone;
        if($agent != null){
            $updatedAgent = User::find($agent->id);
            $updatedAgent['phone'] = $updatedAgent->contacts[0]->phone;
        }else{
            $updatedAgent = null;
        }
        //Data Array For Response
        $data = array(
            "status" => 200,
            "response" => "true",
            "message" => "Record Inserted",
            "bid" => true,
            "bet_date" => $submitDate,
            "user" => $updatedUser,
            "agent" => $updatedAgent,
            "round" => $roundComplete,
            "userAnswers" => $ansArray,
        );
        DB::commit();
        return response()->json($data, 201);
        }else{
            DB::rollback();
            $data = array(
                "status" => 429,
                "response" => "true",
                "message" => "You Don't have enough Coins",
            );   
            return response()->json($data, 429);
        }
    }catch(\Exception $ex){
        DB::rollback();
            $data = array(
                "status" => 429,
                "response" => "true",
                "message" => "Some Issue Caught",
            );
            return response()->json($data, 429);
        }
    }  
}
