<?php

namespace App\Http\Controllers\Api;

use App\Models\Image;
use App\Models\School;
use App\Models\SchoolImage;
use Illuminate\Http\Request;
use GuzzleHttp\Promise\Create;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\TemporaryStorage;
use Illuminate\Support\Facades\Storage;


class SchoolController extends Controller
{

    public function deleteAllSchoolRecord(Request $request)
    {

        $schools = School::with('images')->get();
        if(count($schools)> 0){
            
            foreach ($schools as $schoolData) {
                if (count($schoolData->images) > 0) {
                    $this->deleteImage($schoolData);
                    $schoolData->images()->delete();
            
                }
                $schoolData->delete();
            }
    

            return response()->json([$schools],200);

        }
        return response()->json(['success'],500);
      
    

    }

    public function deleteMultipleSelectedSchoolRecord(Request $request)
    {

        $schools = $request->input('schools');

        if (count($schools) > 0) {
            $get_schools = School::whereIn('id', $schools)->with('images')->get();

            foreach ($get_schools as $schoolData) {
                if (count($schoolData->images) > 0) {
                    $this->deleteImage($schoolData);
                    $schoolData->images()->delete();
            
                }
                $schoolData->delete();
            }


            return response()->json(['success'], 200);
        }
        return response()->json(['failed'], 500);
    }

    public function searchSchool(Request $request)
    {

        $query = $request->input('query');
        $searched_schools =  School::where('name', 'like', '%' . $query . '%')->with('images')->paginate(10);
        return response()->json($searched_schools);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return School::with('images')->paginate(10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->json('ey  test infs');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'address' => 'required',
        ]);

        $school = School::create($validated);

        if (count($request->input('images')) > 0) {

            foreach ($request->input('images') as $fileData) {

                $school->images()->create([
                    'folder' => $fileData['folder'],
                    'file' => $fileData['file'],
                    'type' => 'features',
                ]);
                

                 $fromTemporaryFolder = 'tmp/' . $fileData['folder'] . '/' . $fileData['file'];
                 $toFilesFolder = 'files/' . $fileData['folder'] . '/' . $fileData['file'];
                 $temporaryFolderPath ='tmp/'.$fileData['folder']; 
                 
                 Storage::disk('public_uploads')->copy($fromTemporaryFolder, $toFilesFolder);
                 Storage::disk('public_uploads')->deleteDirectory($temporaryFolderPath);
                 TemporaryStorage::where('folder', $fileData['folder'])->delete();
            }
        }

        if ($school) {
            return response()->json(['success'], 200);
        } else {
            return response()->json(['Failed'], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {


        $validated = $request->validate([
            'name' => 'required',
            'address' => 'required'
        ]);

        $school = School::find($id);

        if ($school->update($validated)) {
            return response()->json(['success'], 200);
        } else {
            return response()->json(['failed'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $school = School::find($id);
        $this->deleteImage($school);
        $school->images()->delete();

        if ($school->delete()) {
            return response()->json('deleted');
        } else {
            return response()->json(['failed'], 500);
        }
    }


    public function deleteImage(School $school)
    {


        if (count($school->images) > 0) {   
            foreach ($school->images as $image) {
                Storage::disk('public_uploads')->deleteDirectory('files/' . $image["folder"]);
            }
        }
    }
}
