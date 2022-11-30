<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    public function uploadFile(Request $request){

       $file = $request->file('refund_proof');
       $path = 'upload/image/';
       
    
       $storage = \Storage::disk('oss');

    // return response()->json([\Storage::disk(),$request->all(), $file,config('filesystems.disks') ], 200);
        $filename = $file->getClientOriginalName();
      
      try {
        $storage->put($path.$filename, file_get_contents($file));
      } catch (Exception $e)
      {
        \Log::info(['failed to upload file', $path, $file, $e->getMessage()]);
        return false;
      }

      return $path.$filename;
    }


    public function storetolocal(Request $request){

      $file = $request->file('image');
      $filename = $file->getClientOriginalName();

      // STORE
     if(Storage::disk('local')->put('files/'.$filename, file_get_contents($file) )){
        return  response()->json(['succes'], 200);
     }

     return response()->json(['failed'], 500);

    }



}
