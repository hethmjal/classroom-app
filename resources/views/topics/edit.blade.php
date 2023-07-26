@extends('layout.master',['title' => $topic->classroom->name.' - update topic'])
@section('content')

              <div class="container">
                <h1 class="mb-5">Create topic</h1>
                
        
                <form action=" {{route('classrooms.topics.update',[$topic->classroom->id,$topic->id])}} " method="post">
                    @csrf
                    @method('put')
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" value="{{$topic->name}}" name="name" id="name" placeholder="Classroom Name">
                        <label for="name">topic Name</label>
                      </div>
        
                   
                  
        
                      <button type="submit" class="btn btn-primary">Update topic</button>
                </form>
            </div>
        
           
   


    @endsection