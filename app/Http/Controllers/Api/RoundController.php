<?php

namespace App\Http\Controllers\Api;

use App\Models\Round;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\RoundCollection;
use App\Http\Resources\Round as SingleRound;

class RoundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $round = Round::where('id',1)->first();
        
        if($round){

        
        $games = $round->games;
        $user = Auth::user();
        
        if($user->rounds){
            $arr = [];
            foreach($user->rounds as $rads){
                array_push($arr,$rads->id);
            }
            // return $arr;
            if(empty($arr)){
                $bid = false;
            }else{

            
            $result = array_search("$round->id",$arr);
            // return $result;
            // return $result;
            if($result >= 0 || $result != '' ){
                $bid = true;
                // return $bid;
            }else{
                $bid = false;
            }

        }
        
        }  else{
            $bid = false;
        }
        $packages = $round->packages;
        $roundComplete = array(
            'id' => $round->id,
            'name' => $round->name,
            'starting_date' => $round->starting_date,
            'ending_date' => $round->ending_date,
            'created_at' => $round->created_at,
            'updated_at' => $round->updated_at,
            'packages' => $packages,
            'games' => $games,

        );
        if($bid == true){
            $userAnswers = DB::table('bid_results')
            ->where('user_id', $user->id)
            ->where('round_id', $round->id)->get();
        }else {
            $userAnswers = "No Bet Yet";
        }
        $data = array( 
            "status"=>200,
            "response"=>"true",
            "message" => "Success",
            "bid" => $bid,
            "user" => $user,
            "round"=> $roundComplete,
            "userAnswers" => $userAnswers,
         );
         return response()->json($data,200);

        }else{
            $data = array( 
                "status"=>404,
                "response"=>"true",
                "message" => "Record Not Found",
                
                
             );
             return response()->json($data,404);

        }

        
        
    }

    public function sb(Request $request){
        // return($request->all());
        $selected_answers = explode(",",$request->selected_answers);
        $game_ids = explode(",",$request->game_ids);
        $round_id = $request->round_id;
        $package_id = $request->package_id;
    
        // $ids = array("1","2","3");

        $user = Auth::user();
        
        if(count($user->rounds) > 0){
            $arr = [];
            foreach($user->rounds as $rads){
                array_push($arr,$rads->id);
            }
            // return $arr;
            if(!empty($arr)){
                // $arr = array('3','1','3');
            
            // $result = array_search("$round_id",$arr);
            // return $result;
            if(in_array("$round_id", $arr)){
                $data = array( 
                    "status"=>409,
                    "response"=>"true",
                    "message" => "Record Already Present",
                    
                 );
                 return response()->json($data,409);
                // return $bid;
            }else{
                $round = Round::where('id',$round_id)->first();
                $ct = count($round->games);
                // return $ct;
                $user->rounds()->attach($round_id);
                
                for($i=0;$i<count($round->games);$i++){
                    DB::table('bid_results')->insert([
                                'round_id' => $round_id ,
                                'user_id' => Auth::user()->id,
                                'game_id' => $game_ids[$i],
                                'answer' => $selected_answers[$i],
                                'package_id' => $package_id,
            
                            ]);

                }
                $userAnswers = DB::table('bid_results')
                    ->where('user_id', $user->id)
                    ->where('round_id', $round_id)->get();
                    $round = Round::where('id',$round_id)->first();
                    $games = $round->games;
                    $packages = $round->packages;

                    $roundComplete = array(
                        'id'=> $round->id,
                        'name' => $round->name,
                        'starting_date' => $round->starting_date,
                        'ending_date' => $round->ending_date,
                        'created_at' => $round->created_at,
                        'updated_at' => $round->updated_at,
                        'packages' => $packages,
                        'games' => $games,
            
                    );

            $data = array( 
                "status"=>200,
                "response"=>"true",
                "message" => "Record Inserted",
                "bid" => true,
                "user" => $user,
                "round" => $roundComplete,
                "userAnswers" => $userAnswers,


                
             );
             return response()->json($data,201);

                

                
            }
        } else{

            $round = Round::where('id',$round_id)->first();
                $ct = count($round->games);
                // return $ct;
                $user->rounds()->attach($round_id);
                
                for($i=0;$i<count($round->games);$i++){
                    DB::table('bid_results')->insert([
                                'round_id' => $round_id ,
                                'user_id' => Auth::user()->id,
                                'game_id' => $game_ids[$i],
                                'answer' => $selected_answers[$i],
                                'package_id' => $package_id,
            
                            ]);

                }
                $userAnswers = DB::table('bid_results')
                    ->where('user_id', $user->id)
                    ->where('round_id', $round_id)->get();
                    $round = Round::where('id',$round_id)->first();
                    $games = $round->games;
                    $packages = $round->packages;

                    $roundComplete = array(
                        'id'=> $round->id,
                        'name' => $round->name,
                        'starting_date' => $round->starting_date,
                        'ending_date' => $round->ending_date,
                        'created_at' => $round->created_at,
                        'updated_at' => $round->updated_at,
                        'packages' => $packages,
                        'games' => $games,
            
                    );

            $data = array( 
                "status"=>200,
                "response"=>"true",
                "message" => "Record Inserted",
                "bid" => true,
                "user" => $user,
                "round" => $roundComplete,
                "userAnswers" => $userAnswers,


                
             );
             return response()->json($data,201);
        }
    }
    $round = Round::where('id',$round_id)->first();
                $ct = count($round->games);
                // return $ct;
                $user->rounds()->attach($round_id);
                
                for($i=0;$i<count($round->games);$i++){
                    DB::table('bid_results')->insert([
                                'round_id' => $round_id ,
                                'user_id' => Auth::user()->id,
                                'game_id' => $game_ids[$i],
                                'answer' => $selected_answers[$i],
                                'package_id' => $package_id,
            
                            ]);

                }
                $userAnswers = DB::table('bid_results')
                    ->where('user_id', $user->id)
                    ->where('round_id', $round_id)->get();
                    $round = Round::where('id',$round_id)->first();
                    $games = $round->games;
                    $packages = $round->packages;

                    $roundComplete = array(
                        'id'=> $round->id,
                        'name' => $round->name,
                        'starting_date' => $round->starting_date,
                        'ending_date' => $round->ending_date,
                        'created_at' => $round->created_at,
                        'updated_at' => $round->updated_at,
                        'packages' => $packages,
                        'games' => $games,
            
                    );

            $data = array( 
                "status"=>200,
                "response"=>"true",
                "message" => "Record Inserted",
                "bid" => true,
                "user" => $user,
                "round" => $roundComplete,
                "userAnswers" => $userAnswers,


                
             );
             return response()->json($data,201);



    }

    public function llr(){
        $round = Round::where('id',1)->first(); 
        if($round){
            $games = $round->games;
            // return $games[0]->results;
            $arr = [];
            for($i=0;$i<count($games);$i++){
                $arr[$i]['id'] = $games[$i]->id;
                $arr[$i]['team_a'] = $games[$i]->team_a;
                $arr[$i]['team_b'] = $games[$i]->team_b;
                $arr[$i]['winner'] = $games[$i]->results[0]->Answer;

            }
            $data = array( 
                "status"=>200,
                "response"=>"true",
                "message" => "Result Received",
                
                "answers" => $arr,
                "round" => $round,


                
             );
            
           
            return $data;

        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
