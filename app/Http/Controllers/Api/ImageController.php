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


    public function uploadToLocal(Request $request)
    {


        if ($request->hasFile('files')) {

            $image = $request->file('files');
            $file_name = $image->getClientOriginalName();
            $file_extension = $image->getClientOriginalExtension();
            $folder = uniqid('files', true);
            $image->storeAs('tmp/' . $folder, $file_name);

            TemporaryStorage::create([
                'folder' => $folder,
                'file' => $file_name
            ]);

            // if you want to use objec
            return response()->json(['folder' => $folder, 'file' => $file_name],200);
            //return $folder;
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
        if ($tmp_file) {
            $actual_file = $tmp_file;
            Storage::deleteDirectory('tmp/' . $tmp_file->folder);
            $tmp_file->delete();

            return response()->json(['folder' => $actual_file->folder, 'file' => $actual_file->file],200);
            // return $actual_file;

        }

        return '';
    }
}
