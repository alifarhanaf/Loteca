<?php

namespace App\Http\Controllers\Web;

use App\User;
use DateTime;
use Carbon\Carbon;
use App\Models\Game;
use App\Models\Point;
use App\Models\Round;
use App\Models\Winner;
use App\Models\Package;
use App\Models\RoundUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

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
    editRound

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
        $games = Game::all();
        $data = array(
            "games"=> $games,
        );
        return view ('gameGrid')->with($data);

    }
    

    public function finalizeRound(Request $request,$id){
        DB::beginTransaction();
        try {
            
           
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
        $test = [];
        $test1 = [];
        foreach($roundUsers as $ru){
            array_push($roundUsersIds,$ru->user_id);

        }
        $roundUsersC = User::findMany($roundUsersIds);
        foreach($roundUsersC as $ruc ){

        $userAnswers = DB::table('bid_results')
        ->where('user_id', $ruc->id)
        ->where('round_id', $round_id)->get();
        $i = 0;
        foreach($userAnswers as $UA){
         
            $gm = Game::where('id',$UA->game_id)->first();
            if($gm->results){
            $gameAnswer0 = $gm->results->Answer;
            // return $gameAnswer0 . $UA->answer;
            // array_push($test,$gameAnswer0);
            //     array_push($test1,$UA->answer);
               $oAnswer =  str_replace(' ', '', $gameAnswer0);
               $uAnswer = str_replace(' ', '', $UA->answer);
               // array_push($test,$gameAnswer0);
              //     array_push($test1,$UA->answer);
            if(strtoupper($oAnswer) == strtoupper($uAnswer)){
                
                $i++;
                
            }
        }else{
            DB::rollback();
            return redirect()->back()->with('error','You have Not Added Game Results Yet.     Kindly Add Answers First.');
        }
        }
        //EndForeach
        // $data = array(
        //     "oAnswer" => $test,
        //     "gAnswer" => $test1
        // );
        // return $data;

        $point = new Point();
        $point->round_id = $round_id;
        $point->user_id = $ruc->id;
        $point->package_id = $userAnswers[0]->package_id;
        $point->points = $i;
        $point->total_points = $totalGames;
        $point->save();

        
        }
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
        for ($i = 0; $i < count($packages); $i++) {
            $multipleWinners = [];
            $multipleWinners2 = [];
            $multipleWinners3 = [];
            $multipleWinners4 = [];
            $multipleWinners5 = [];
            $multipleWinners6 = [];
            $points = Point::where('round_id',$round_id)->where('package_id',$packages[$i]->id)->orderBy('points', 'desc')->get();
           
            $totalGames = count($round->games);
            foreach($points as $pt){

                
                if($pt->points == $totalGames){    
                    array_push($multipleWinners,$pt->user->id); 
                }
                if(empty($multipleWinners) && $pt->points == ($totalGames-1)){

                    array_push($multipleWinners2,$pt->user->id); 
                }
                if(empty($multipleWinners2) && $pt->points == ($totalGames-2)){

                    array_push($multipleWinners3,$pt->user->id); 
                }
                if(empty($multipleWinners3) && $pt->points == ($totalGames-3)){

                    array_push($multipleWinners4,$pt->user->id); 
                }
                if(empty($multipleWinners4) && $pt->points == ($totalGames-4)){

                    array_push($multipleWinners5,$pt->user->id); 
                }
                if(empty($multipleWinners5) && $pt->points == ($totalGames-5)){

                    array_push($multipleWinners6,$pt->user->id); 
                }
            }
            if(!empty($multipleWinners)){
                
                $arr[$i] =  $multipleWinners;
            }elseif(!empty($multipleWinners2)){
                $arr[$i] =  $multipleWinners2;
            }elseif(!empty($multipleWinners3)){
                $arr[$i] =  $multipleWinners3;
            }elseif(!empty($multipleWinners4)){
                $arr[$i] =  $multipleWinners4;
            }elseif(!empty($multipleWinners5)){
                $arr[$i] =  $multipleWinners5;
            }elseif(!empty($multipleWinners6)){
                $arr[$i] =  $multipleWinners6;
            }

            
          
        }
        // return $arr;
       
        for ($i = 0; $i < count($packages); $i++) {
            $totalCoinsApplied = $packages[$i]->accumulative_price;
            $winnersTotal = count($arr[$i]);
            $CoinPerHead = $totalCoinsApplied/$winnersTotal;
            foreach($arr[$i] as $a){
                 $points = Point::where('round_id',$round_id)->where('package_id',$packages[$i]->id)->where('user_id',$a)->first();
                 $points->winning_coins = $CoinPerHead;
                 $points->save();
                $winner = new Winner();
                $winner->round_id = $round_id;
                $winner->user_id = $a;
                $winner->package_id = $packages[$i]->id;
                $winner->prize = $CoinPerHead;
                $winner->save();
            }
            

        }

        
       
        

        // return true;
        DB::commit();
        return redirect()->back()->with('success', 'Round Successfully Finalized',); 
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()->with('error',$ex->getMessage());
        }
       
        

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
}
