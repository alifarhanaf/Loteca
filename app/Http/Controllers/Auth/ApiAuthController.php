<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Carbon\Carbon;
use App\Models\Image;
use App\Models\Contact;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;


class ApiAuthController extends Controller
{
    public function register (Request $request) {
        if($request->has('admin')){
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'phone' => 'required|string|max:255',
                'whatsapp_phone' => 'required|string|max:255',
                'password' => 'required|string|min:6',
                'role' => 'required'
            ]);
            if ($validator->fails())
            {
                
                 return redirect()->back()->with('error',$validator->errors()->all()[0]);
            }
        $request['password']=Hash::make($request['password']);
        $request['remember_token'] = Str::random(10);
        // $code = Str::random(10);
        $code = random_int(10000, 99999);
        $user = new User();
        $user->name = request('name');
        $user->email = request('email');
        $user->password = request('password');
        $user->coins = '0';
        $user->remember_token = request('remember_token');
        $user->roles = 2;
        $user->auth_code = "$code";
        $user->save();
        // dd($request->role);
       
            // dd('Hi');
            $contact = New Contact();
            $contact->phone = $request->phone;
            $contact->whatsapp = $request->whatsapp_phone;
            $contact->email = $request->email;
            $contact->user()->associate($user);
            $contact->save();

            $image =  New Image();
            $image->url = 'https://i.pinimg.com/originals/51/f6/fb/51f6fb256629fc755b8870c801092942.png';
            $image->user()->associate($user);
            $image->save();

            $comission = New Comission();
            $comission->comission_percentage = $request->percent;
            $comission->user_id = $user->id;
            $comission->default = 1;
            $comission->save();
        
        
       
       
       
         return redirect()->back()->with('success','Agent Registered Successfully');

        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:255',
            'whatsapp_phone' => 'required|string|max:255',
            'password' => 'required|string|min:6',
            'role' => 'required'
        ]);
        if ($validator->fails())
        {
            // $errors = array(
            //     'message' => $validator->errors()->all()
            // );
            
            $data = array( 
                "status"=>422,
                "response"=>"false",
                "message" => $validator->errors()->all()[0],
                // "data" => $errors,
             );
             return response()->json($data,422);
        }
        $request['password']=Hash::make($request['password']);
        $request['remember_token'] = Str::random(10);
        // $code = Str::random(10);
        $code = random_int(10000, 99999);
        $user = new User();
        $user->name = request('name');
        $user->email = request('email');
        $user->password = request('password');
        $user->coins = '0';
        $user->remember_token = request('remember_token');
        $user->roles = request('role');
        $user->auth_code = "$code";
        $user->save();
        
       
           
            $contact = New Contact();
            $contact->phone = $request->phone;
            $contact->whatsapp = $request->whatsapp_phone;
            $contact->email = $request->email;
            $contact->user()->associate($user);
            $contact->save();

            $image =  New Image();
            $image->url = 'https://i.pinimg.com/originals/51/f6/fb/51f6fb256629fc755b8870c801092942.png';
            $image->user()->associate($user);
            $image->save();
        
        if($user->roles == 1){
            $role = 'User';
        }else if ($user->roles == 2){
            $role = 'Agent';
        }else if($user->roles == 3){
            $role = 'Manager';
        }
        // return $user;
        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        $to_name = request('name');
        $to_email = request('email');
        $data = array('name'=>request('name'), "passcode" => $code);
     
        Mail::send('emails.mail', $data, function($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)
            ->subject('Loteca Registration');
            $message->from('info@loteca.com','Team Loteca');
        });
        $data = array( 
            "status"=>201,
            "response"=>"true",
            "message" => "User Registered Successfully",
            'data' => array(
                'role' => $role,
                'token' => $token,
                'user' => $user,
            ),
         );
         return response()->json($data,201);
    }

    public function login (Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails())
        {
            $errors = array(
                'errors' => $validator->errors()->all()
            );
            $data = array( 
                "status"=>422,
                "response"=>"false",
                "message" => $validator->errors()->all()[0],
                // "data" => $errors,
             );
             return response()->json($data,422);
        }
        if($request->has('admin')){
            $user = User::where('email', $request->email)->first();
        if ($user ) {
            if($user->roles == 3){
                if (Hash::check($request->password, $user->password)) {
                    // Session::put('user', $user);
                    // session(['user' => $user]);
                    $request->session()->put('user', $user);
                    
                    return Redirect::to('dashboard')->with('success','Successfully Logged In');
                    
                    
                } else {
                    return redirect()->back()->with('error','Password Mismatch');
                    
                }

            }else{
                return redirect()->back()->with('error','You are not Authorized');
            }
            
        } else {
            return redirect()->back()->with('error','User does not exist');
            
        }


        }else{
            
        $user = User::where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                if($user->roles == 1){
                    $role = 'User';
                }else if ($user->roles == 2){
                    $role = 'Agent';
                }else if($user->roles == 3){
                    $role = 'Manager';
                    // return Redirect::to('dashboard');
                }
                $user->contacts;
                $user->images;

                $data = array( 
                    "status"=>200,
                    "response"=>"true",
                    "message" => "Successfully Logged In",
                    "data" => array(
                        'role' => $role,
                        'token' => $token,
                        'user' => $user,
                    ),
                 );
                 return response()->json($data,200);
            } else {
                $data = array( 
                    "status"=>422,
                    "response"=>"false",
                    "message" => "Password Mismatch",
                 );
                 return response()->json($data,422);
            }
        } else {
            $data = array( 
                "status"=>404,
                "response"=>"false",
                "message" => "User does not exist",
             );
             return response()->json($data,404);
        }

        }


    }
    public function logout (Request $request) {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }
    public function resendCode(){
        $user =  Auth::user();
        // $code = Str::random(10);
        $code = random_int(10000, 99999);
        $usr = User::find($user->id);
        $usr->auth_code = $code;
        $usr->save();
        $to_name = $user->name;
        $to_email = $user->email;
        $data = array('name'=>$user->name, "passcode" => $code);
     
        Mail::send('emails.mail', $data, function($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)
            ->subject('Loteca Registration');
            $message->from('info@loteca.com','Team Loteca');
        });
        $data = array( 
            "status"=>200,
            "response"=>"true",
            "message" => "Code Sent Successfully",
         );
         return response()->json($data,200);


        
    }
    public function confirmEmail(Request $request){
        $user =  Auth::user();
        if($user->auth_code == $request->code){
            $usr = User::find($user->id);
            $usr->email_verified_at = Carbon::now()->toDateTimeString();
            $usr->save();
            $data = array( 
                "status"=>200,
                "response"=>"true",
                "message" => "User Authenticated Successfully",
             );
             return response()->json($data,200);
        }else{
            $data = array( 
                "status"=>209,
                "response"=>"false",
                "message" => "Incorrect Details",
             );
             return response()->json($data,209);
        }

    }
    public function changePasswordCode(Request $request){
        // $code = Str::random(10);

        $code = random_int(10000, 99999);
        
        $to_name = "User";
        $to_email = $request->email;
        $data = array('name'=>"User", "passcode" => $code);
     
        Mail::send('emails.passwordReset', $data, function($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)
            ->subject('Loteca Password Reset Request');
            $message->from('info@loteca.com','Team Loteca');
        });
        $data = array( 
            "status"=>200,
            "response"=>"true",
            "message" => "Code Sent Successfully",
            "code" => "$code",
         );
         return response()->json($data,200);


        
    }
    public function updatePassword(Request $request){
        $request['password']=Hash::make($request['password']);
        $user = User::where('email',$request->email)->first();
        $user->password = $request->password;
        $user->save();
        $data = array( 
            "status"=>200,
            "response"=>"true",
            "message" => "Password Updated Successfully",
         );
         return response()->json($data,200);
    }
    public function registerForm(){
        return view('createAgent');
    }
    // public function updateUser(){

    //     $user = Auth::user();
    //     $flight = Flight::find(1);

    //     $flight->name = 'Paris to London';

    //     $flight->save();
    //     return $user;
    // }
    
}
