<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Models\Image;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function updateUser(Request $request){
        // dd($request->image);
        // dd($request) ;

        $user = Auth::user();
        
    
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

        $imageName = time().'.'.$request->image->extension();  
        $path = base_path() . '/public/storage/UserImages/';
        $pathsave =  '/storage/UserImages/';
        $request->image->move($path, $imageName);
        $imageurl = $pathsave.$imageName;
        $image = Image::find($user->images[0]->id);
        $newURL = 'https://phpstack-526382-1675862.cloudwaysapps.com'.$imageurl;
        if($image){
            $image->url =  $newURL;
            $image->save();
        }else{

        
        $image = new Image();
        $image->url =$newURL;
        $image->user_id = Auth::user()->id;
        $image->save();
        }
        // $user->images[0]->url= 'https://phpstack-526382-1675862.cloudwaysapps.com'.$user->images[0]->url;
        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        $user->contacts;
        if($user->roles == 1){
            $role = 'User';
        }else if ($user->roles == 2){
            $role = 'Agent';
        }else if($user->roles == 3){
            $role = 'Manager';
            // return Redirect::to('dashboard');
        }
        $data = array( 
            "status"=>200,
            "response"=>"true",
            "message" => "Successfully Updated",
            "data" => array(
                'role' => $role,
                'token' => $token,
                'user' => $user,
            ),
         );
         return response()->json($data,200);
        

    }
}
