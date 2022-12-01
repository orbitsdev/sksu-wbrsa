<?php

namespace App\Http\Controllers\Api;

use App\Models\Role;
use App\Models\Image;
use App\Models\School;
use Illuminate\Http\Request;
use App\Models\TemporaryStorage;
use App\Http\Controllers\Controller;
use App\Models\SchoolImage;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Support\Carbon;

use function PHPUnit\Framework\isEmpty;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{

    public function getFolder(Request $request){   
        $folder= $request->input('folder');
        $schoolImage =  SchoolImage::select('folder','file')->where('folder',$folder )->first();
        return response()->json([$schoolImage], 200);
           
    }

    
    public function uploadToLocal(Request $request)
    {
        if ($request->hasFile('files')) {
            $image = $request->file('files');
            $filename = $image->getClientOriginalName();
            $folder = uniqid().strtotime(now());
            $image->storeAs('tmp/'.$folder, $filename, 'public_uploads' );
            TemporaryStorage::create([
                'folder' => $folder,
                'file' => $filename
            ]);

            return response()->json(['folder' => $folder, 'file' => $filename, $filename]);
        }
        return '';
    }



    public function deleteUnsaveLocalFile(Request $request)
    {
        $files = $request->input('files');

        if (count($files) > 0) {

            foreach ($files as $file) {
                Storage::disk('public_uploads')->deleteDirectory('tmp/' . $file['folder']);
                TemporaryStorage::where('folder', $file['folder'])->delete();
   
            }

            return response()->json(['success'], 200);
        }

        return response()->json(['success'], 500);
    }


    public function deleteFromLocal(Request $request)
    {


        $tmp_file = TemporaryStorage::select('folder', 'file')->where('folder', $request->input('folder'))->first();
        
        if($tmp_file){
            Storage::disk('public_uploads')->deleteDirectory('tmp/'.$tmp_file->folder);
            TemporaryStorage::where('folder', $tmp_file->folder)->delete();
        }

        return response()->json(['folder' => $tmp_file ->folder, 'file' => $tmp_file ->file]);
    }
}
