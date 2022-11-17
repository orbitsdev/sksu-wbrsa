<?php

namespace App\Http\Controllers\Mail;

use Throwable;
use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\NewPasswordMail;

use App\Models\PasswordReset;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class NewPasswordMailController extends Controller

{


    public function hasProvider(){
        
        // $user = User::where('email', 'brianorbino@sksu.edu.ph')->first();
        $user = User::where('email', 'admin@gmail.com')->first();
        return response()->json(count($user->socialAccounts) <= 0);

    }
    

    public function sendEmailForPasswordReset(Request $request){

        $request->validate([
            'email' => 'required|email',
        ]);
        
        $user = User::where('email', $request->email)->first();

        
        
        
        if($user != null){  

                // if socialite account 

                if(count($user->socialAccounts)<= 0){
                    $token = $user->createToken($user->first_name)->plainTextToken;
                $domain = env('WEB_URL');
                $set_new_password_url = $domain."/set-new-password?email=".$user->email."&token=".$token;
                    
                if(!$userResetPass = PasswordReset::where('email', $user->email)->first()){
                    PasswordReset::create([
                        'email'=> $user->email,
                        'token'=> $token,
                    ]);
                }else{

                    $userResetPass->update([
                        'email'=> $user->email,
                        'token'=> $token,
                    ]);
                }
            

                Mail::to( $user->email, $user->first_name)->queue(new NewPasswordMail($user, $token, $set_new_password_url,));
                return response()->json($user->email);


                }else{

                    return response()->json([ $request->email.' is registered as Google Account  you cannot change the password of this email  in this application'], 404);
                }




                
            }else{
                return response()->json([ $request->email.' doesnt exist in this application '], 404);
            }

    }

    public function showPage(){
        $user  = User::first();
        $token = $user->createToken($user->first_name)->plainTextToken;
        $domain = env('WEB_URL');
        $set_new_password_url = $domain."/set-new-password?email=".$user->email."&token=".$token;
        return new NewPasswordMail($user, $token, $set_new_password_url);
    }

    public function setNewPassword(Request $request){

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        $password_reset  = PasswordReset::where('email', $request->email)->first();

        if($password_reset != null){

            if($password_reset->token != $request->token){
                return response()->json([ $request->email.' Token Mismatch '], 400);
            }else{
                
                       $account =  User::where('email', $request->email)->first();
                       $account->update([
                        'password'=> Hash::make($request->password),
                        ]);

                        return response()->json('Password Update');

            }

        }else{
            return response()->json([ $request->email.' doesnt exist '], 404);
        }
        

    }

}
