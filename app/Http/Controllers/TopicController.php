<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Topic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($classroom_id)
    {
        $class = Classroom::findOrFail($classroom_id);
        $topics = Topic::where('classroom_id',$classroom_id)->get();
        return view('topics.index',compact('class','topics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($classroom_id)
    {
        $class = Classroom::findOrFail($classroom_id);
        return view('topics.create',compact('class'))->with('message','Topic added successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,$classroom_id)
    {
        $class = Classroom::findOrFail($classroom_id);
        $topic = Topic::create($request->all());
        return to_route('classrooms.topics.index',$request->classroom_id);
    }

    public function show($id)
    {
        $topic = Topic::findOrFail($id);
        return $topic; // view('topics.index',compact('cltopicass','topics'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($classroom_id,$id)
    {
        $class = Classroom::findOrFail($classroom_id);
        $topic = Topic::findOrFail($id);
        $classes = Classroom::all();
        return view('topics.edit',compact('topic','classes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$classroom_id, $id)
    {
        $class = Classroom::findOrFail($classroom_id);

        $topic = Topic::findOrFail($id);
        $topic->update($request->all());
        return to_route('classrooms.topics.index',$topic->classroom_id)->with('message','Topic updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($classroom_id,$id)
    {
        $class = Classroom::findOrFail($classroom_id);

        $topic = Topic::findOrFail($id);
        $topic->delete();
        return to_route('classrooms.topics.index',$topic->classroom_id)->with('message','Topic deleted successfully');

    }


    public function trached($classroom_id)
    {
      // return $classroom_id;
        $class = Classroom::findOrFail($classroom_id);

        $topics = Topic::where('classroom_id',$classroom_id)->onlyTrashed()->latest('deleted_at')->get();
        return view('topics.trached',compact('topics'));
    }


    public function restore($classroom_id,$id)
    {
        $class = Classroom::findOrFail($classroom_id);

        $topic = Topic::onlyTrashed()->findOrFail($id);
        $topic->restore();
        return to_route('classrooms.topics.index',$topic->classroom_id)
        ->with('message',"topic ({$topic->name}) restored successfully");     
    }

    public function forceDelete($classroom_id,$id)
    {
        $class = Classroom::findOrFail($classroom_id);

        $topic = Topic::withTrashed()->findOrFail($id);
        $topic->forceDelete();
        return to_route('topics.trached',$topic->classroom_id)
        ->with('message',"topic ({$topic->name}) deleted successfully");     
    }


}
