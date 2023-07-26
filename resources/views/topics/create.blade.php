@extends('layout.master',['title' => $class->name.' - create topics'])
@section('content')
    <div class="container">
        <h1 class="mb-5">Create topic</h1>
        

        <form action=" {{route('classrooms.topics.store',$class->id)}} " method="post">
            @csrf
            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="name" id="name" placeholder="Classroom Name">
                <label for="name">topic Name</label>
              </div>

              <input type="hidden" class="form-control" name="classroom_id" value="{{$class->id}}">

          

              <button type="submit" class="btn btn-primary">Create topic</button>
        </form>
    </div>


    @endsection
