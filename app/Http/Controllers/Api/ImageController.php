<?php

namespace App\Http\Controllers\Api;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ImageController extends Controller
{
    
    public function upload(Request $request){


        // Role::create([
        //    'name'=> 'ey', 
        //    'slug'=> 'yow', 
        // ]); 

        if($request->hasFile('imageFilepond')){
            return $request->file('imageFilepond')->store('uploads/schools/images', 'public');
        } 
        return 'no path';
        // if($request->hasFile('imageFilepond')){

        //  $request->file('imageFilepond ')->store('school/image', 'public');
        //  return  response()->json('succes', 200);
        // }

        return  response()->json('suces',200);

    }

}
