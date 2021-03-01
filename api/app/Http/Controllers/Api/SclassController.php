<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SclassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        phpinfo();
        $classes = DB::table('sclasses')->get();

        return response()->json($classes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'class_name' => 'required|unique:sclasses|max:25',
        ]);

        $data = [];
        $data['class_name'] = $request->class_name;
        $insert = DB::table('sclasses')->insert($data);

        return $insert ? response('Inserted successfully') :
            response('Error to insert');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $show = DB::table('sclasses')->where(['id' => $id])->first();

        return response()->json($show);
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
        $data = [];
        $data['class_name'] = $request->class_name;
        $insert = DB::table('sclasses')->where(['id' => $id])->update($data);

        return $insert ? response('Updated successfully') :
            response('Error to update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $store = DB::table('sclasses')->where(['id'=> $id])->delete();

        return $store ? response('Deleted') : response('Already deleted');
    }
}
