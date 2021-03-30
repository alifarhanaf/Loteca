<?php

namespace App\Http\Controllers\Web;

use App\User;
use App\Models\Feedback;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FeedbackController extends Controller
{
    public function comment(){
        $comments = Feedback::where('type','0')->get();
        foreach($comments as $cm){
            $user = User::where('id',$cm->user_id)->first();
            $cm['user_name'] = $user->name;
        }
        $data = array(
            "comments" => $comments,
        );
        return view('comment')->with($data);
    }
    public function bug(){
        $bugs = Feedback::where('type','1')->get();
        foreach($bugs as $bg){
            $user = User::where('id',$bg->user_id)->first();
            $bg['user_name'] = $user->name;
        }
        $data = array(
            "bugs" => $bugs,
        );
        return view('bug')->with($data);
    }
    public function question(){
        $questions = Feedback::where('type','2')->get();
        foreach($questions as $qs){
            $user = User::where('id',$qs->user_id)->first();
            $qs['user_name'] = $user->name;
        }
        $data = array(
            "questions" => $questions,
        );
        return view('question')->with($data);
    }
}
