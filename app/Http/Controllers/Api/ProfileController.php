<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function updateUser(){

        // $user = Auth::user();
        $user = User::find(1);
        // return $user;
        $contact = $user->contacts;
        // return $contact;
        $user = User::find($user->id);
        $user->name = request('name');
        $user->email = request('email');
        $user->roles = request('role');
        $user->save();

        $contact = Contact::find($contact[0]->id);
        $contact->phone = request('phone');
        $contact->whatsapp = request('whatsapp');
        $contact->email = request('email');
        $contact->save();

        $data = array( 
            "status"=>200,
            "response"=>"true",
            "message" => "Successfully Updated",
            "data" => array(
                'role' => $user->roles,
                'user' => $user,
            ),
         );
         return response()->json($data,200);
        

    }
}
