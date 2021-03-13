<?php

namespace App\Http\Controllers\Api;

use App\Models\Feedback;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FeedBackController extends Controller
{
    public function index(Request $request){
        $feedback = new Feedback();
        $feedback->content = $request->body;
        $feedback->type = $request->type;
        $feedback->user_id = Auth::user()->id;
        $feedback->save();

    }
}
