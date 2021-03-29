<?php

namespace App\Http\Controllers\Web;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function userGrid(){
        $users = User::where('roles','1')->get();
        // $users->images;
        // $users->contacts;
        foreach($users as $user){
            $user->images;
            $user->contacts;
            
        }
        // return $users;
        $data = array(
            'users' => $users,
        );
        return view('userGrid')->with($data);
        
    }
}
