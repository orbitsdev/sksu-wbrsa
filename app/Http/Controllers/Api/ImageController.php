<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    
    public function upload(Request $request){

        if($request->hasFile('imageFilepond')){
            return $request->file('imageFilepond ')->store('school/image', 'public');
        }

        return  '';

    }

}
