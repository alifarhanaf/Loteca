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
        return($request->all());

        $user = Auth::user();
        
        if($user->rounds){
            $arr = [];
            foreach($user->rounds as $rads){
                array_push($arr,$rads->id);
            }
            // return $arr;
            // return $arr;
            
            $result = array_search("$request->round_id",$arr);
            // return $result;
            if($result >= 0 || $result != '' ){
                $data = array( 
                    "status"=>409,
                    "response"=>"true",
                    "message" => "Record Already Present",
                    
                 );
                 return response()->json($data,409);
                // return $bid;
            }else{
                $user->rounds()->attach($request->round_id);

                foreach($request->answer as $As){
                    DB::table('bid_results')->insert([
                        'round_id' => $request->round_id ,
                        'user_id' => Auth::user()->id,
                        'game_id' => $As['gameid'],
                        'answer' => $As['result'],
    
                    ]);
                }
                $userAnswers = DB::table('bid_results')
                    ->where('user_id', $user->id)
                    ->where('round_id', $request->round_id)->get();
                    $round = Round::where('id',$request->round_id)->first();
                    $games = $round->games;
                    $packages = $round->packages;

                    $roundComplete = array(
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
                 return response()->json($data,409);

                

                
            }
        }  else{
            $bid = false;
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
