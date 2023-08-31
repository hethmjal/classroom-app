<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Http\Request;

class ClassroomPeopleController extends Controller
{
  /*   public function __invoke(Classroom $classroom)
    {
        //dd($classroom->users,$classroom->classworks->first()->users[0]->pivot);
        return view('classrooms.people',compact('classroom'));
    } */

    public function index(Classroom $classroom)
    {
        //dd($classroom->users,$classroom->classworks->first()->users[0]->pivot);
        return view('classrooms.people',compact('classroom'));
    }
    public function destroy(Request $request,Classroom $classroom)
    {
        $request->validate([
            'user_id'=>['required',/* 'exists:classroom_user.user_id' */]
        ]);
        $user_id = $request->input('user_id');
        if($user_id == $classroom->user_id){
            return to_route('classrooms.people',$classroom->id)->with('message','can not remove user!');
        }
        $classroom->users()->detach($request->input('user_id'));
        return to_route('classrooms.people',$classroom->id)->with('message','user removed!');
    }
}
