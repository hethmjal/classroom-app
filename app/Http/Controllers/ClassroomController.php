<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClassroomRequest;
use App\Models\Classroom;
use App\Models\Scopes\UserClassroomScope;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ClassroomController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        //$this->authorizeResource(Classwork::class);
    }  

    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
          
        //Session::put('message','test');
        //Session::flash('message','flash message');
        //return Session::get('message') || session('\message');
        //Session::remove('message');
        $classes = Classroom::/* withoutGlobalScope(UserClassroomScope::class)-> */active('active')->get();
        return view('classrooms.index',compact('classes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('classrooms.create',['class' =>new Classroom()]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClassroomRequest $request)
    {
    
        if($request->hasFile('cover_image')){
            $file = $request->file('cover_image');
            $path = Classroom::uploadCoverImage($file);
            $request->merge(['cover_image_path'=>$path]);
        }
        // in creating event in Classroom model
       // $request->merge(['code' => Str::random(8)]);

        DB::beginTransaction();
        try {
         $class = Classroom::create($request->all());
         $class->join(auth()->id(),'teacher');


        DB::commit();
        } catch (Exception $e) {
         DB::rollBack();
         return back()->with('error',$e->getMessage());
        }
        

        
        return to_route('classrooms.index')->with('message','classroom created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Classroom $classroom)
    {
       
        //$class = Classroom::findOrFail($id);
       /*  $invitaion_link = URL::temporarySignedRoute('classrooms.join',now()
            ->addSeconds(60),
        [$classroom->id,'code'=>$classroom->code,]
       ); */

      $invitaion_link = URL::signedRoute('classrooms.join',[$classroom->id,'code'=>$classroom->code,]);
       
        return view('classrooms.show',compact('classroom','invitaion_link'));
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
    public function update(ClassroomRequest $request, $id)
    {
        
        $class = Classroom::findOrFail($id);
      
      
        if($request->hasFile('cover_image')){
            $file = $request->file('cover_image');
            $path = Classroom::uploadCoverImage($file);
            $request->merge(['cover_image_path'=>$path]);
           // $class->deleteCoverImage($class->cover_image_path);
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
        // in forceDeleted event in Classroom model
       // $class->deleteCoverImage($class->cover_image_path);
        $class->delete();
        return to_route('classrooms.index')
        ->with('message','classroom deleted successfully');
    }


    public function trached()
    {
        $classes = Classroom::onlyTrashed()->latest('deleted_at')->get();
        return view('classrooms.trached',compact('classes'));
    }


    public function restore($id)
    {
        $class = Classroom::onlyTrashed()->findOrFail($id);
        $class->restore();
        return to_route('classrooms.index')
        ->with('message',"classroom ({$class->name}) restored successfully");     
    }

    public function forceDelete($id)
    {
        $class = Classroom::withTrashed()->findOrFail($id);
        $class->forceDelete();
     //$class->deleteCoverImage($class->cover_image_path);
        return to_route('classrooms.trached')
        ->with('message',"classroom ({$class->name}) deleted successfully");     
    }

    
}
