<?php

namespace App\Http\Controllers;

use App\Models\Classroom;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        //Session::put('message','test');
        //Session::flash('message','flash message');
        //return Session::get('message') || session('\message');
        //Session::remove('message');
        $classes = Classroom::all();
        return view('classrooms.index',compact('classes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('classrooms.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if($request->hasFile('cover_image')){
            $file = $request->file('cover_image');
            $path = $file->store('/images','uploads');
            $request->merge(['cover_image_path'=>$path]);
        }
        $request->merge(['code' => Str::random(8)]);
        $class = Classroom::create($request->all());

        return to_route('classrooms.index')->with('message','classroom added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Classroom $classroom)
    {
        //$class = Classroom::findOrFail($id);
        return view('classrooms.show',compact('classroom'));
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $class = Classroom::findOrFail($id);
        return view('classrooms.edit',compact('class'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        
        $class = Classroom::findOrFail($id);
        if($request->hasFile('cover_image')){
            $file = $request->file('cover_image');
            $path = $file->store('/images','uploads');
            $request->merge(['cover_image_path'=>$path]);
            Storage::disk('uploads')->delete($class->cover_image_path);

        }
        $class->update($request->all());
        return to_route('classrooms.index')->with('message','classroom updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $class = Classroom::findOrFail($id);
        Storage::disk('uploads')->delete($class->cover_image_path);
        $class->delete();
        return to_route('classrooms.index')->with('message','classroom deleted successfully');

    }
}
