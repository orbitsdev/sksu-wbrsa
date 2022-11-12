<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    public function getUsers(){
        
        $users = User::all();
        return response()->json($users);
    }

    public function getCurrentUser(Request $request){       
        
        $user = $request->user();
        $roles = $request->user()->roles()->pluck('name');
        if($user){
            return response()->json(['user'=> $user, 'roles'=> $roles], 200);
        }
        return response()->json(['Not Found'], 500);
        // return $request->user();
    }
}
