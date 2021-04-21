<?php

namespace App\Http\Controllers\Api;

use App\Models\Round;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ResultController extends Controller
{
    public function resultsList(){
        $lastThreeClosedRounds = Round::select('id','name','starting_date','ending_date')->latest()->where('status',2)->take(3)->get();
            $data = array(
                "status" => 200,
                "response" => "true",
                "message" => "Result Received",
                "lastClosedRounds" => $lastThreeClosedRounds,
            );
        return response()->json($data, 200);
    }
}
