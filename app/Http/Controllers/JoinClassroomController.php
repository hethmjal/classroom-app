<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Scopes\UserClassroomScope;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JoinClassroomController extends Controller
{

    public function create($id)
    {
        //return $id;
        $classroom = Classroom::withoutGlobalScope(UserClassroomScope::class)
        ->active()
        ->findOrFail($id);
        try {
            $this->exists($id,Auth::id());
        } catch (Exception $e) {
            return to_route('classrooms.show',$classroom->id);
        }
        return view('classrooms.join',compact('classroom'));
    }

    public function store(Request $request,$id)
    {
        
        $request->validate([
            'role' =>'in:student,teacher',
        ]);

        $classroom = Classroom::withoutGlobalScope(UserClassroomScope::class)
        ->active()
        ->findOrFail($id);

        try {
            $this->exists($id,Auth::id());
        } catch (Exception $e) {
            return to_route('classrooms.show',$id);
        }

       $classroom->join(auth()->id(),$request->input('role','student'));
    

        return to_route('classrooms.show',$classroom->id);

    }

    protected function exists($classroom_id,$user_id){
        $exists = DB::table('classroom_user')
        ->where('classroom_id', $classroom_id)
        ->where('user_id',$user_id)
        ->exists();
       if($exists){
            throw new Exception('User already joined classroom');
       }
    }

}
