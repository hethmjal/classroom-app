<?php

namespace App\Http\Controllers;

use App\Models\Classwork;
use App\Models\ClassworkUser;
use App\Models\Submission;
use App\Rules\ForbiddenFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class SubmissionController extends Controller
{
    public function store(Request $request,Classwork $classwork)
    {
        $this->authorize('submissions',$classwork);

        $request->validate([
            'files.*'=>['file',new ForbiddenFile('application/x-msdownload',)],
        ]);
        
        $assigned = $classwork->users()->where('id',Auth::id())->exists();

        if (!$assigned) {
            dd($assigned);
            abort(403);
        }

        DB::beginTransaction();
        try{
            $data = [];
            foreach ($request->file('files') as  $file) {
                $data[] = [
                    'classwork_id' => $classwork->id,
                    'content' => $file->store('submissions/'.$classwork->id) ,
                    'type' => 'file',
                    
                ] ;
                } 
                $user = Auth::user();
                $user->submissions()->createMany($data);
                //Submission::insert($data);   
                
                ClassworkUser::where([
                    'user_id' => Auth::id(),
                    'classwork_id' => $classwork->id
                    ])
                    ->update([
                        'status' => 'submitted',
                        'submitted_at' => now(),
                    ]);
                    DB::commit();
        } catch(Throwable $e){
            DB::rollBack();
            return back()->with('erroe',$e->getMessage());
        }
       

        return back()->with('success','work submitted !');
    }

    public function file(Submission $submission)
    {
        $user = Auth::user();
        $isOwoner = $submission->user_id == $user->id;
        $isTeacher = $submission->classwork->classroom->teachers()->where('id',$user->id)->exists();
         // check if the user is classwork teacher or Owner
        if (!($isOwoner || $isTeacher)) {
            abort(403);
        }
       return response()->file(storage_path('app/'.$submission->content));
    }
}
