<?php

namespace App\Http\Controllers\Web;

use App\User;
use DateTime;
use Carbon\Carbon;
use App\Models\Game;
use App\Models\Point;
use App\Models\Round;
use App\Models\Result;
use App\Models\Winner;
use App\Models\Package;
use App\Models\RoundUser;
use App\Models\CoinTransfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class DashboardController extends Controller
{
    public function index(){
        return view ('home');
    }
    public function createRound(){
        //   Carbon::today()->toDateString();
        $games = Game::where('happening_date', '>=', Carbon::today()->toDateString())->get();
        // return $games;
        $data = array(
            "games"=> $games,
        );
        return view ('createRound')->with($data);
    }
    
    public function submitRound(Request $request){
        DB::beginTransaction();
        try {
        
       
        $date0 = DateTime::createFromFormat("m/d/Y" , request('start_date'));
        $starting_date = $date0->format('Y-m-d');
        $date1 = DateTime::createFromFormat("m/d/Y" , request('end_date'));
        $ending_date = $date1->format('Y-m-d');
       
       
        $round = new Round();
        $round->name = request('name');
        $round->starting_date = $starting_date;
        $round->ending_date = $ending_date;
        $round->tag = 'original';
        $round->status = 1;
        $round->save();
        $package = new Package();
        $package->participation_fee =  request('first_package');
        $package->accumulative_price = 0;
        $package->round_id = $round->id;
        $package->save();
        $package = new Package();
        $package->participation_fee =  request('second_package');
        $package->accumulative_price = 0;
        $package->round_id = $round->id;
        $package->save();
        $package = new Package();
        $package->participation_fee =  request('third_package');
        $package->accumulative_price = 0;
        $package->round_id = $round->id;
        $package->save();
        
        $round->games()->attach(request('checkbox'));
        DB::commit();
        return redirect()->back()->with('success', 'Round Created Successfully'); 
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()->with('error',$ex->getMessage());
        }
         

    }
    public function roundGrid(){
        $rounds = Round::all();
        foreach($rounds as $round){
            $winner = Winner::where('round_id',$round->id)->first();
        if($winner){
            $round['finalize'] = 1;
        }else{
            $round['finalize'] = 0;
        }
        }
        $data = array(
            "rounds"=> $rounds,
        );
        
        return view ('roundGrid')->with($data);
    }
    public function destroyRound($id){
        DB::beginTransaction();
        try {
       
        Round::destroy($id);
        DB::commit();
        return redirect()->back()->with('success','Round Deleted Successfully');
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()->with('error',$ex->getMessage());
        }
    }
   

    public function createGame(){
        return view ('createGame');
    }

    public function submitGame(Request $request){
        
        DB::beginTransaction();
        try {
        $date = DateTime::createFromFormat("m/d/Y" , request('happening_date'));
        $newDate = $date->format('Y-m-d');
        // $happening_date = str_replace("/","-",request('happening_date'));
        // $newDate = date("Y-m-d", strtotime($happening_date));
        $game = new Game();
        $game->name = request('name');
        $game->happening_date = $newDate;
        $game->team_a = request('team_a');
        $game->team_b = request('team_b');
        $flagAName = time().'.'.$request->flag_a->extension();
        $flagBName = time().'1.'.$request->flag_b->extension();  
        $path = base_path() . '/public/storage/Flags/';
        $pathsave =  '/storage/Flags/';
        $request->flag_a->move($path, $flagAName);
        $request->flag_b->move($path, $flagBName);
        $flagAurl = $pathsave.$flagAName;
        $flagBurl = $pathsave.$flagBName;
        $game->flag_a = $flagAurl;
        $game->flag_b = $flagBurl;
        $game->save();
        DB::commit();
        return redirect()->back()->with('success', 'Game Created Successfully'); 
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()->with('error',$ex->getMessage());
        }
         
    }
    public function gameGrid(){
        $games = Game::OrderBy('created_at', 'desc')->get();
        // return $games;
        // $sorted = $games->orderBy('created_at', 'desc');
        // $games = Game::sortBy('created_at', 'ASC')->get();
        $data = array(
            "games"=> $games,
        );
        return view ('gameGrid')->with($data);

    }
    public function closeRound($id){
        $round_id = $id;
        $round = Round::find($round_id); 
        $round->status = 2;
        $round->save();
        return redirect()->back()->with('success','Round Closed Successfully');

    }
    

    public function finalizeRound(Request $request,$id){
        $winner = Winner::where('round_id',$id)->first();
        if($winner){
            return redirect()->back()->with('error','Already Finalized This Round.');
        }
        // DB::beginTransaction();
        // try {
            
           
        $round_id = $id;
        $round = Round::find($round_id); 
        $round->status = 2;
        $round->save();
        $round = Round::where('id',$round_id)->first();
        $totalGames = count($round->games);
        $packages = $round->packages;
        // $roundUsers = RoundUser::where('round_id',$round_id)->get();
        $roundUsers = DB::table('round_user')->where('round_id',$round_id)->get();
        $roundUsersIds = [];
        $roundUserDates = [];
        $test = [];
        $test1 = [];
        foreach($roundUsers as $ru){
            array_push($roundUsersIds,$ru->user_id);
            array_push($roundUserDates,$ru->created_at);

        }
        
        // for($i=0;$i<count($roundUsersIds);$i++){
        //     $ruc = User::where('id',$roundUsersIds[$i])->first();
        //     $userAnswers = DB::table('bid_results')
        //     ->where('user_id', $ruc->id)
        //     ->where('round_id', $round_id)
        //     ->where('created_at',$roundUserDates[$i])->get();
            
        //     $i = 0;
        //     foreach($userAnswers as $UA){
         
        //     $gm = Game::where('id',$UA->game_id)->first();
        //     if($gm->results){
        //     $gameAnswer0 = $gm->results->Answer;
            
        //        $oAnswer =  str_replace(' ', '', $gameAnswer0);
        //        $uAnswer = str_replace(' ', '', $UA->answer);
               
        //     if(strtoupper($oAnswer) == strtoupper($uAnswer)){
                
        //         $i++;
                
        //     }
        // }else{
        //     DB::rollback();
        //     return redirect()->back()->with('error','You have Not Added Game Results Yet.     Kindly Add Answers First.');
        // }
        // }
        // $point = new Point();
        // $point->round_id = $round_id;
        // $point->user_id = $ruc->id;
        // $point->package_id = $userAnswers[0]->package_id;
        // $point->points = $i;
        // $point->total_points = $totalGames;
        // $point->created_at = $roundUserDates[$i];
        // $point->save();

        // }
        $roundUsersC = User::findMany($roundUsersIds);
        $j = 0;
         
        foreach($roundUsersC as $ruc ){
            dd($roundUserDates[$j]);
        

        $userAnswers = DB::table('bid_results')
        ->where('user_id', $ruc->id)
        ->where('round_id', $round_id)
        ->where('created_at',$roundUserDates[$j])->get();
        // return $userAnswers;
        $i = 0;
        foreach($userAnswers as $UA){
         
            $gm = Game::where('id',$UA->game_id)->first();
            if($gm->results){
            $gameAnswer0 = $gm->results->Answer;
               $oAnswer =  str_replace(' ', '', $gameAnswer0);
               $uAnswer = str_replace(' ', '', $UA->answer);
              
            if(strtoupper($oAnswer) == strtoupper($uAnswer)){
                
                $i++;
                
            }
        }else{
            // DB::rollback();
            return redirect()->back()->with('error','You have Not Added Game Results Yet.     Kindly Add Answers First.');
        }
        }
        

        $point = new Point();
        $point->round_id = $round_id;
        $point->user_id = $ruc->id;
        $point->package_id = $userAnswers[0]->package_id;
        $point->points = $i;
        $point->total_points = $totalGames;
        $point->save();
        $j++;

        
        }

        //Old Commented
        // $userAnswers = DB::table('bid_results')
        // ->where('user_id', $user_id)
        // ->where('round_id', $round_id)->get();
        // dd($userAnswers);
        // $round = Round::where('id',$round_id)->first();
        // $totalGames = count($round->games);
        // $i = 0;
        // foreach($userAnswers as $UA){
         
        //     $gm = Game::where('id',$UA->game_id)->first();
        //     $gameAnswer0 = $gm->results->Answer;
        //     dd($gameAnswer0 . $UA->answer);
        //     if($gameAnswer0 === $UA->answer){
                
        //         $i++;
        //         dd($i);
        //     }
        // }//EndForeach
        // $point = new Point();
        // $point->round_id = $round_id;
        // $point->user_id = $user_id;
        // $point->package_id = $package_id;
        // $point->points = $i;
        // $point->total_points = $totalGames;
        // $point->save();


        // $round = Round::where('id',$round_id)->first();
        
        
        $arr = [];
        $datz = [];
        for ($i = 0; $i < count($packages); $i++) {
            $multipleWinners = [];
            $multipleWinners2 = [];
            $multipleWinners3 = [];
            $multipleWinners4 = [];
            $multipleWinners5 = [];
            $multipleWinners6 = [];
            $multipleWinnersDates = [];
            $multipleWinnersDates2 = [];
            $multipleWinnersDates3 = [];
            $multipleWinnersDates4 = [];
            $multipleWinnersDates5 = [];
            $multipleWinnersDates6 = [];
            $points = Point::where('round_id',$round_id)->where('package_id',$packages[$i]->id)->orderBy('points', 'desc')->get();
           
            $totalGames = count($round->games);
            foreach($points as $pt){

                
                if($pt->points == $totalGames){    
                    array_push($multipleWinners,$pt->user->id); 
                    array_push($multipleWinnersDates,$pt->created_at); 
                }
                if(empty($multipleWinners) && $pt->points == ($totalGames-1)){

                    array_push($multipleWinners2,$pt->user->id); 
                    array_push($multipleWinnersDates2,$pt->created_at);
                }
                if(empty($multipleWinners2) && $pt->points == ($totalGames-2)){

                    array_push($multipleWinners3,$pt->user->id); 
                    array_push($multipleWinnersDates3,$pt->created_at);
                }
                if(empty($multipleWinners3) && $pt->points == ($totalGames-3)){

                    array_push($multipleWinners4,$pt->user->id);
                    array_push($multipleWinnersDates4,$pt->created_at); 
                }
                if(empty($multipleWinners4) && $pt->points == ($totalGames-4)){

                    array_push($multipleWinners5,$pt->user->id);
                    array_push($multipleWinnersDates5,$pt->created_at); 
                }
                if(empty($multipleWinners5) && $pt->points == ($totalGames-5)){

                    array_push($multipleWinners6,$pt->user->id); 
                    array_push($multipleWinnersDates6,$pt->created_at);
                }
            }
            if(!empty($multipleWinners)){
                
                $arr[$i] =  $multipleWinners;
                $datz[$i] =  $multipleWinnersDates;
            }elseif(!empty($multipleWinners2)){
                $arr[$i] =  $multipleWinners2;
                $datz[$i] =  $multipleWinnersDates2;
            }elseif(!empty($multipleWinners3)){
                $arr[$i] =  $multipleWinners3;
                $datz[$i] =  $multipleWinnersDates3;
            }elseif(!empty($multipleWinners4)){
                $arr[$i] =  $multipleWinners4;
                $datz[$i] =  $multipleWinnersDates4;
            }elseif(!empty($multipleWinners5)){
                $arr[$i] =  $multipleWinners5;
                $datz[$i] =  $multipleWinnersDates5;
            }elseif(!empty($multipleWinners6)){
                $arr[$i] =  $multipleWinners6;
                $datz[$i] =  $multipleWinnersDates6;
            }

            
          
        }
        // return $arr;
       //Start Winners
        for ($i = 0; $i < count($packages); $i++) {
            $totalCoinsApplied = $packages[$i]->accumulative_price;
            $winnersTotal = count($arr[$i]);
            $CoinPerHead = $totalCoinsApplied/$winnersTotal;
            for($j=0;$j<count($arr[$i]);$j++){
                $points = Point::where('round_id',$round_id)->where('package_id',$packages[$i]->id)->where('user_id',$arr[$i][$j])->where('created_at',$datz[$i][$j])->first();
                 $points->winning_coins = $CoinPerHead;
                 $points->save();
                $winner = new Winner();
                $winner->round_id = $round_id;
                $winner->user_id = $arr[$i][$j];
                $winner->package_id = $packages[$i]->id;
                $winner->prize = $CoinPerHead;
                $winner->save();

            }
            
            // foreach($arr[$i] as $a){
            //      $points = Point::where('round_id',$round_id)->where('package_id',$packages[$i]->id)->where('user_id',$a)->first();
            //      $points->winning_coins = $CoinPerHead;
            //      $points->save();
            //     $winner = new Winner();
            //     $winner->round_id = $round_id;
            //     $winner->user_id = $a;
            //     $winner->package_id = $packages[$i]->id;
            //     $winner->prize = $CoinPerHead;
            //     $winner->save();
            // }
            

        }
        //EndWinners

        
       
        

        // return true;
        // DB::commit();
        return redirect()->back()->with('success', 'Round Successfully Finalized',); 
        // } catch (\Exception $ex) {
        //     DB::rollback();
        //     return redirect()->back()->with('error',$ex->getMessage());
        // }
       
        

    }
    // public function submitGame(Request $request){
         // return $request->all();
    //     $game = New Game();
    //     $game->name = $request->name;
    //     $game->team_a = $request->team_a;
    //     $game->team_b = $request->team_b;
    //     $game->happening_date = $request->happening_date;
    //     $game->save();

    



    // }
    public function gameAnswerGrid(){
        $results = Result::all();
        $ids = [];
        foreach($results as $rs){
            array_push($ids,$rs->game_id);

        }
        $games = Game::whereNotIn('id', $ids)->get();
       
        $data = array(
            "games"=> $games,
        );
        return view ('gameAnswers')->with($data);
    }
    public function submitAnswer(Request $request, $id){
        DB::beginTransaction();
        try {
        $result = New Result();
        $result->Answer = $request->name;
        $result->game_id = $id;
        $result->save();
        // return $request->all();
        DB::commit();
        return redirect()->back()->with('success', 'Answer Successfully Submitted',); 
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()->with('error',$ex->getMessage());
        }


    }
    public function sendMail(){
        $to_name = 'Farhan Ali';
        $to_email = 'farhanaliyt@gmail.com';
        $data = array('name'=>"Sam Jose", "passcode" => "axYc6789");
     
        Mail::send('emails.mail', $data, function($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)
            ->subject('Loteca Registration');
            $message->from('info@loteca.com','Team Loteca');
        });
        echo 'Email Sent Check kro';
    }
    public function dashboard(){
        $history1 = CoinTransfer::where( 'created_at', '>', Carbon::today())->get();
        $total_sales1 = 0; 
        foreach($history1 as $h1){
            $total_sales1 = $total_sales1 + $h1->sent_coins;
        }
        $history2 = CoinTransfer::where( 'created_at', '>', Carbon::now()->subDays(7))->get();
        $total_sales2 = 0; 
        foreach($history2 as $h2){
            $total_sales2 = $total_sales2 + $h2->sent_coins;
        }
        $history3 = CoinTransfer::where( 'created_at', '>', Carbon::now()->subDays(30))->get();
        $total_sales3 = 0; 
        foreach($history3 as $h3){
            $total_sales3 = $total_sales3 + $h3->sent_coins;
        }
        $history4 = CoinTransfer::get();
        $total_sales4 = 0;
        foreach($history4 as $h4){
            $total_sales4 = $total_sales4 + $h4->sent_coins;
        }
        $sales_data = array (
            "daily_sales" => $total_sales1,
            "weekly_sales" => $total_sales2,
            "monthly_sales" => $total_sales3,
            "all_sales" => $total_sales4,
        );
        $users = User::where('roles','1')->get();
        $totalUsers = count($users);
        $agents = User::where('roles','2')->get();
        $totalAgents = count($agents);

        $now = Carbon::now();
        $now->toDateString();
        //  return $now;
        $round = Round::where('starting_date', '<=', $now)
            ->where('ending_date', '>=', $now)->where('tag', 'original')->where('status',1)
            ->first();
            if($round){
            $roundName = $round->name;
            $totalGames = count($round->games);
            }else{
                $roundName = 'No Live Round';
                $totalGames = 'N/A';
            }
            $multipleWinnersMonthly = [];
            $points = Point::orderBy('points', 'desc')->where( 'created_at', '>', Carbon::now()->subDays(30))->get();
            for ($i = 0; $i < count($points); $i++) {
           
                $aa = Point::where('user_id',$points[$i]->user->id)->where( 'created_at', '>', Carbon::now()->subDays(30))->get();
                $count = 0;
                foreach($aa as $a){
                    $count  = $count + $a->points;
                }
                $points[$i]->user['image'] = $points[$i]->user->images[0]->url;
                $points[$i]->user['Winning Coins'] = $count*10;
                if(!in_array($points[$i]->user, $multipleWinnersMonthly, true)){
                    array_push($multipleWinnersMonthly,$points[$i]->user);
                }
            }
            $multipleWinnersMonthly = array_values(array_unique($multipleWinnersMonthly));
            $brray = collect($multipleWinnersMonthly)->sortBy('Winning Coins')->reverse()->toArray();
            $brraySorted = array_values($brray);
            $monthlyLeaderBoard = $brraySorted;
            $admin = User::where('roles','3')->first();
            $totalCoins = $admin->coins;
            //Best Agents

            $agentsAllTime = [];
            $soldCoins = CoinTransfer::get();
            // dd(count($soldCoins));
            for ($i = 0; $i < count($soldCoins); $i++) {
                // dd($soldCoins);
                $user = User::find($soldCoins[$i]->sender_id);
                
                // $soldCoins['user'] = $user;
                $aa = CoinTransfer::where('sender_id',$user->id)->get();
                $count = 0;
                foreach($aa as $a){
                    $count  = $count + $a->sent_coins;
                }
                // return $soldCoins;
                $user['image'] = $user->images[0]->url;
                $user['sold_Coins'] = $count;
                $soldCoins[$i]['user'] =  $user;

                // $soldCoins[$i]['user'][0]['image'] = $user->images[0]->url;
                // $soldCoins[$i]['user']['sold_Coins'] = $count;
                if(!in_array($soldCoins[$i]['user'], $agentsAllTime, true)){
                    array_push($agentsAllTime,$soldCoins[$i]['user']);
                }
            }
            $agentsAllTime = array_values(array_unique($agentsAllTime));
            $array = collect($agentsAllTime)->sortBy('sold_Coins')->reverse()->toArray();
            $arraySorted = array_values($array);
            $topAgents = $arraySorted;
            // dd($topAgents);



            $data =  array(
                "sales" => $sales_data,
                "totalAgents" => $totalAgents,
                "totalUsers" => $totalUsers,
                "totalGames" => $totalGames,
                "totalCoins" => $totalCoins,
                "roundName" => $roundName,
                "monthlyLeaderBoard" => $monthlyLeaderBoard,
                "topAgents" => $topAgents,
            );
            return view('home')->with($data);
        


        
    }
    public function coins(){
        return view('sendCoins');

    }
    public function transferCoins(Request $request){
        // return $request;
        $user =  User::where('roles','3')->first();
        $check = User::where('email',$request->email)->first();
        if($check){

        
        // return $user->coins;
        if($user->coins >= $request->coins){
            $cc = $user->coins - $request->coins;
            $sender = User::find($user->id);
            $sender->coins = $cc ;
            $sender->save();
            $receiver = User::where('email',$request->email)->first();
            $receiver->coins = $receiver->coins + $request->coins;
            $receiver->save();
            $ct = new CoinTransfer(); 
            $ct->sender_id = $sender->id;
            $ct->receiver_id = $receiver->id;
            $ct->sent_coins = $request->coins;
            $ct->save();
            return redirect()->back()->with('success','Coins Transferred Successfully');
            // $agent = Auth::user();
            // $updatedUser = User::where('email',$request->email)->first();

            // $data = array(
            //     "status" => 200,
            //     "response" => "true",
            //     "message" => "Coins Sent Successfully" ,
            //     "agent" => $agent,
            //     "user" => $updatedUser,
            //     "coins_transferred" => $request->coins,
            //     "transfer_date" => $ct->created_at,
            //     );
            //     return response()->json($data,200);

        }else{
            return redirect()->back()->with('error','You Dont have Enough Coins');

        }
    }else{
        return redirect()->back()->with('error','User Does Not Exist');
    }

    }
}
