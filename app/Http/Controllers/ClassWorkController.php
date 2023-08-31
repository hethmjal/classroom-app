<?php

namespace App\Http\Controllers;

use App\Events\ClassworkCreated;
use App\Listeners\PostInClassroomStreamListener;
use App\Models\Classroom;
use App\Models\Classwork;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use PhpParser\Node\Stmt\Global_;

class ClassWorkController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        //$this->authorizeResource(Classwork::class);
    }   

    protected function getType(Request $request)
    {
        $type = $request->query('type');
        $allowed_type = [Classwork::TYPE_QUESTION,Classwork::TYPE_ASSIGNMENT,Classwork::TYPE_MATERIAL];
        if(!in_array($type, $allowed_type)){
        
        }

        return $type; 
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request,Classroom $classroom)
    {
        $this->authorize('viewAny',[Classwork::class,$classroom]);
        
        $classworks = $classroom->classworks()
        ->withCount([
            'users as assigned_count' =>function($query){
                return $query->where('classwork_user.status','assigned');
            } ,
            'users as turnedin_count'=>function($query){
                return $query->where('classwork_user.status','submitted');
            },

            'users as graded'=>function($query){
                return $query->where('classwork_user.grade','!=',null);
            }
        ])
        ->with('topic')
        ->latest('published_at')->
        where(function($query){
            $query-> whereRaw("EXISTS (SELECT 1 FROM classwork_user
            WHERE classwork_user.classwork_id = classworks.id
            AND classwork_user.user_id = ? 
            )",[Auth::id()]);
            $query->orWhereRaw("EXISTS (SELECT 1 FROM classroom_user 
            WHERE classroom_user.classroom_id = classworks.classroom_id
            AND classroom_user.user_id = ?
            And classroom_user.role = ?
            )",[Auth::id(),'teacher']);
        })
        ->get();
  


        $classworks = $classworks->groupBy('topic_id');
       
        return view('classworks.index',compact('classworks','classroom'));
    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, Classroom $classroom)
    {
        $this->authorize('create',[Classwork::class,$classroom]);
        /* if(!Gate::allows('classworks.create',[$classroom]))
        {
            abort(403);
        } */
        $assigned = [];
        $classwork = new Classwork();
        $type = $this->getType($request);
        
        return view('classworks.create',compact('classroom','type','classwork','assigned'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,Classroom $classroom)
    {
        $this->authorize('create',[Classwork::class,$classroom]);

     
        $type = $this->getType($request);
        $request->validate(
            [
                'title' => 'required|string|max:255',
                'description' => ['nullable','string'],
                'topic_id' => ['nullable','int',/* 'exists:topics.id' */],
                'options.grade' => 'required_if:type,assignment',
                'options.due' => 'required_if:type,assignment',
            ],

        );
        $request->merge([
            'user_id' => Auth::id(),
            'type' => $type,
            //'classroom_id'=>$classroom->id,
        ]);
    

       try{

        DB::transaction(function() use($classroom,$request,$type) {
        
            
            $classwork = $classroom->classworks()->create( $request->all()  );
            $classwork->users()->attach( $request->input('students') );
            
            event(new ClassworkCreated($classwork));

        });
        
       } catch(QueryException $e){
        return back()->with('error',$e->getMessage());
       }
 
        return to_route('classrooms.classworks.index',$classroom->id)->with('message',__("Classwork created successfully"));
    }

    /**
     * Display the specified resource.
     */
    public function show(Classroom $classroom ,Classwork $classwork)
    {

        $this->authorize('view',$classwork);

        //Gate::authorize('classworks.view',[$classwork]);
       
        //$classwork->load('comments.user');
        $submissions = Auth::user()->submissions()
        ->where('classwork_id',$classwork->id)
        ->get();
        return view('classworks.show',compact('classroom','classwork','submissions'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Classroom $classroom ,Classwork $classwork)
    {
        
        $this->authorize('update',$classwork);

        $type = $classwork->type->value;
        
       $assigned = $classwork->users()->pluck('id')->toArray();
      // dd( $classroom->students,  $assigned );
        return view('classworks.edit',compact('classroom','classwork','type','assigned'));
       
    }

    /**
     * Update  the specified resource in storage.
     */
    public function update(Request $request,Classroom $classroom ,Classwork $classwork)
    {
        $this->authorize('update',$classwork);

        $request->validate(
            [
                'title' => 'required|string|max:255',
                'description' => ['nullable','string'],
                'topic_id' => ['nullable','int'],
                'options.grade' => 'required_if:type,assignment',
                'options.due' => 'required_if:type,assignment',
            ],
           
        );
       // return $request->all();

        $classwork->update($request->all());
        $classwork->users()->sync($request->input('students'));

        return to_route('classrooms.classworks.index',$classroom->id)->with('message',"classwork updated successfully");

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Classroom $classroom ,Classwork $classwork)
    {
        $this->authorize('delete',$classwork);

        $classwork->delete();
        return to_route('classrooms.classworks.index',$classroom->id)->with('message',$classwork->type->value." deleted successfully");

    }
}
