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
    public function index($id)
    {
        $class = Classroom::findOrFail($id);
        $topics = Topic::where('classroom_id',$id)->get();
        return view('topics.index',compact('class','topics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $class = Classroom::findOrFail($id);
        return view('topics.create',compact('class'))->with('message','Topic added successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $topic = Topic::create($request->all());
        return to_route('topics',$request->classroom_id);
    }

 
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $topic = Topic::findOrFail($id);
        $classes = Classroom::all();
        return view('topics.edit',compact('topic','classes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $topic = Topic::findOrFail($id);
        $topic->update($request->all());
        return to_route('topics',$topic->classroom_id)->with('message','Topic updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $topic = Topic::findOrFail($id);
        $topic->delete();
        return to_route('topics',$topic->classroom_id)->with('message','Topic deleted successfully');

    }
}
