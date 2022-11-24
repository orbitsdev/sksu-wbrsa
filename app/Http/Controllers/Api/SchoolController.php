<?php

namespace App\Http\Controllers\Api;

use App\Models\Image;
use App\Models\School;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
            
            
            $school = School::create($validated);



            if(count($request->input('files'))>0){
                    foreach($request->input('files') as $file){
                        $school->images()->create([
                            'file_name'=> $file,
                            'local_path'=> $file,
                            'url'=> null,
                        ]);
                    }      
            }
          

            if($school != null){
                return response()->json('School Added');
            }else{
                return response()->json('Error occur while saving data', 500 );
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
            'name'=> 'required',
            'address'=> 'required'
        ]);

         $school = School::find($id);

         if( $school->update($validated)){            
             return response()->json('success');
         }else{
            return response()->json('failed');
         }
       
        // $school->adress = $request->name;
        
        // if($school->save){

        //     return response()->json('succes');
            
        // }else{
        //     return response()->json('failed');
        // }



        
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

    public function uploadImage(Request $request){

        return response()->json($request->all());
        // if($request->hasFile('imageFilepond')){
        //     return $request->file('imageFilepond')->store('uploads/images', 'public');
        // }

        // return response()->json('succes');

    }
}
