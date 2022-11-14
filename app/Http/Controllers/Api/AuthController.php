<?php

namespace App\Http\Controllers\Api;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    public function logout(Request $request){


     $accessToken = $request->bearerToken();
     if($accessToken){

         $token = PersonalAccessToken::findToken($accessToken);
         $token->delete();
     }
    // Get access token from database

    // Revoke token
    return response()->json(['msg'=> 'Succesfuly logout']);
    }

    public function login(Request $request){

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);
     
        $user = User::where('email', $request->email)->first();
     
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
     
        return $user->createToken($request->device_name)->plainTextToken;

    }
    public function register(Request $request){
        
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);

       
        $user =   User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $osas = Role::where('name', 'osas')->pluck('id')->first();

        if($osas){
            $user->roles()->attach($osas);
        }
        
        if($user){
            return response()->json($user);
        }
        return response()->json(['msg'=> 'Register Error'] , 500);
    }


}
