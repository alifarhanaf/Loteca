<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Round;
use App\Models\Package;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MyLeagueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $now = Carbon::now();
        $now->toDateString();
        $round = Round::where('starting_date', '<=', $now)
        ->where('ending_date', '>=', $now)
        ->first();

        $user = Auth::user();
        $add_round = new Round();
        $add_round->name = $request->name;
        $add_round->starting_date = $round->starting_date;
        $add_round->ending_date = $round->ending_date;
        $add_round->status = 1;
        $add_round->tag = "custom";
        $add_round->creator_id = $user->id;
        $add_round->joining_id = mt_rand(100000, 999999);
        $add_round->save();

        if(count($round->games)>0){
            $arr = [];
            foreach($round->games as $gms){
                array_push($arr,$gms->id);
            }
            $add_round->games()->attach($arr);
        }
        foreach($round->packages as $Pkg){
         $package = new Package();
         $package->participation_fee = $Pkg->participation_fee ;
         $package->accumulative_price = $Pkg->accumulative_price ;
         $package->round_id = $add_round->id;
         $package->save();
        }
        $round = Round::where('id',$add_round->id)->first();
        $packages = $round->packages;
        $games = $round->games;
        $user = Auth::user();
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
        $data = array( 
            "status"=>200,
            "response"=>"true",
            "message" => "Success",
            "bid" => false,
            "user" => $user,
            "round"=> $roundComplete,
         );
         return response()->json($data,200);
    }


    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
