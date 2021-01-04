<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class ApiAuthController extends Controller
{
    public function register (Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required'
        ]);
        if ($validator->fails())
        {
            $errors = array(
                'errors' => $validator->errors()->all()
            );
            
            $data = array( 
                "status"=>422,
                "response"=>"false",
                "message" => "Errors Found",
                "data" => $errors,
             );
             return response()->json($data,422);
        }
        $request['password']=Hash::make($request['password']);
        $request['remember_token'] = Str::random(10);
        $user = new User();
        $user->name = request('name');
        $user->email = request('email');
        $user->password = request('password');
        $user->remember_token = request('remember_token');
        $user->roles = request('role');
        $user->save();
        if($user->roles == 1){
            $role = 'User';
        }else if ($user->roles == 2){
            $role = 'Agent';
        }else if($user->roles == 3){
            $role = 'Manager';
        }
        // return $user;
        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
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
                "message" => "Errors Found",
                "data" => $errors,
             );
             return response()->json($data,422);
        }
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
                }

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
    public function logout (Request $request) {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }
    public function user(){
        $user = User::find(1);
        return $user;
    }
    
}
