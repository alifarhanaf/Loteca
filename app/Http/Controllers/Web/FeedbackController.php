<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index(){
        $feedback = Feedback::all();
        foreach($feedback as $fb){
            $user = User::where('id',$feedback->user_id)->first();
            $feedback['user_name'] = $user->name;
        }
        $data = array(
            "feedbacks" => $feedback,
        );
        return view('feedback')->with($data);
    }
}
