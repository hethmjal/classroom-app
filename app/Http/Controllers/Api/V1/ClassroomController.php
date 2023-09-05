<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClassroomCollection;
use App\Http\Resources\ClassroomResource;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classrooms = Classroom::with('user:id,name', 'topics:classroom_id,name')
            ->withCount('students as students')
            ->get();

        //return response()->json(new ClassroomCollection($classrooms), 200);

        return response()->json(
            ClassroomResource::collection($classrooms),
            200
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (! Auth::guard('sanctum')->user()->tokenCan('classrooms.create')) {
            abort(403);
        }
        $request->validate([
            'name' => 'required',
        ]);

        $classroom = Classroom::create($request->all());

        return response()->json([
            'code' => 200,
            'message' => __('Classroom created!'),
            'classroom' => new ClassroomResource($classroom),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Classroom $classroom)
    {
        if (! Auth::guard('sanctum')->user()->tokenCan('classrooms.show')) {
            abort(403);
        }
        //$classroom = Classroom::with('students')->find($id);
        $classroom->load('user')->loadCount('students');

        return new ClassroomResource($classroom);
        //return $classroom;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Classroom $classroom)
    {
        if (! Auth::guard('sanctum')->user()->tokenCan('classrooms.update')) {
            abort(403);
        }
        $request->validate([
            'name' => "sometimes|required|unique:classrooms,name,$classroom->id",
            'section' => 'sometimes|required',
        ]);
        $classroom->update($request->all());

        return [
            'code' => 200,
            'message' => __('Classroom update!'),
            'classroom' => $classroom,
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //  return $id;

        if (! Auth::guard('sanctum')->user()->tokenCan('classrooms.delete')) {
            abort(403, 'can not delete classroom');
        }

        Classroom::destroy($id);

        return [
            'code' => 200,
            'message' => __('Classroom deleted!'),

        ];
    }
}
