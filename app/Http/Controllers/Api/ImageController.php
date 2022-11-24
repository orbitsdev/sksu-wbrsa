<?php

namespace App\Http\Controllers\Api;

use App\Models\Role;
use App\Models\Image;
use App\Models\School;
use Illuminate\Http\Request;
use App\Models\TemporaryStorage;
use App\Http\Controllers\Controller;

use function PHPUnit\Framework\isEmpty;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{


    public function uploadToLocal(Request $request){

        if($request->hasFile('files')){

            $image = $request->file('files');
            $file_name = $image->getClientOriginalName();
            $folder = uniqid('files', true);
            $image->storeAs('tmp/'. $folder , $file_name);
            
            TemporaryStorage::create([
                'folder' => $folder,
                'file' => $file_name
            ]);
            return $folder;
        }
        return '';

        // if($request->hasFile('images')){

           
        //     return $request->file('images')->store('tmp', 'public');
        // }

    }


    public function deleteFromLocal(Request $request){
        


        $tmp_file = TemporaryStorage::where('folder', $request->input('folder'))->first();
        if($tmp_file){
            
            Storage::deleteDirectory('tmp/'.$tmp_file->folder);
            $tmp_file->delete();
            return response()->json('success');
            
        }

    }

    // public function deleteFromLocal(Request $request){
        

    //     $tmp_file = TemporaryStorage::where('folder', $request->getContent())->first();
    //     if($tmp_file){
            
    //         Storage::deleteDirectory('tmp/'.$tmp_file->folder);
    //         $tmp_file->delete();
    //         return response()->json('success');
            
    //     }

    // }
    
}
