<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    
    
    public function upload(Request $request){

        if($request->hasFile('imageFilePond')){
            
            return $request->file('imageFilePond')->store('tmp', 'public');
        }

        return '';
    }

    // public function processImage(Request $request){
    //     if($image = $request->get('image') ){
            
    //         $path = storage_path('app/public/upload'.$image);

    //         if(file_exists($path)){
    //              copy($path, public_path($image));
    //              unlink($path);
    //         }

    //     }
    // }
}
