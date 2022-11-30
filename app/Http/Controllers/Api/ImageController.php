<?php

namespace App\Http\Controllers\Api;

use App\Models\Role;
use App\Models\Image;
use App\Models\School;
use Illuminate\Http\Request;
use App\Models\TemporaryStorage;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Support\Carbon;

use function PHPUnit\Framework\isEmpty;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{


    public function uploadToLocal(Request $request)
    {

        if ($request->hasFile('files')) {

            $image = $request->file('files');
            $filename = $image->getClientOriginalName();
            $folder = strtotime(now());

            // store in public
            //  $image->storeAs('images/'.$folder, $filename, 'public_uploads' );
            $image->storeAs('tmp/' . $folder, $filename, 'local');


            TemporaryStorage::create([
                'folder' => $folder,
                'file' => $filename
            ]);


            return response()->json(['folder' => $folder, 'file' => $filename]);
        }
        return '';
    }


    public function deleteUnsaveLocalFile(Request $request)
    {
        $files = $request->input('files');

        if (count($files) > 0) {

            foreach ($files as $file) {
                Storage::deleteDirectory('tmp/' . $file['folder']);
                $tmp_file  = TemporaryStorage::where('folder', $file['folder'])->first();
                $tmp_file->delete();
            }

            return response()->json(['success'], 200);
        }

        return response()->json(['success'], 500);
    }


    public function deleteFromLocal(Request $request)
    {


        $tmp_file = TemporaryStorage::select('folder', 'file')->where('folder', $request->input('folder'))->first();
        if($tmp_file){
            Storage::disk('local')->deleteDirectory('tmp/'.$tmp_file->folder);
            $tmp_file->delete();
        }
        return response()->json([$tmp_file->folder,$tmp_file->file, $tmp_file["folder"], $tmp_file["file"]]);
    }
}
