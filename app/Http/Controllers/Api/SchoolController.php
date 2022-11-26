<?php

namespace App\Http\Controllers\Api;

use App\Models\Image;
use App\Models\School;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SchoolImage;
use GuzzleHttp\Promise\Create;

class SchoolController extends Controller
{
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
                'name'=> 'required',
                'address'=> 'required',
            ]);
            

            // return response()->json(count($request->input('files')));

                $school = School::create($validated);

              
                // return response()->json(count($request->input('files')));

                if( count($request->input('files')) > 0 ){

                    foreach ($request->input('files') as $fileData) {
                        
                            $school->images()->create([
                                'folder'=> $fileData['folder'],
                                'file'=> $fileData['file'],
                                'type'=> 'features',
                            ]);

                      }

                }
            return $school;
            // if($school){
            //     return response()->json('success', 200);
            // }else{
            //     return response()->json('Failed', 500);
            // }


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
            'name'=> 'required',
            'address'=> 'required'
        ]);

         $school = School::find($id);

         if( $school->update($validated)){            
             return response()->json('success');
         }else{
            return response()->json('failed');
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
            
        if($school->delete()){
            return response()->json('deleted');
        }else{
            return response()->json('failed' , 500);
            
        }
    }

   
}
