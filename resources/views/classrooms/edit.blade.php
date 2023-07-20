@extends('layout.master',['title' => $class->name.' - update'])
@section('content')
    <div class="container">
        <h1 class="mb-5">Edit Classroom</h1>
        

        <form action=" {{route('classrooms.update',$class->id)}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="form-floating mb-3">
                <input type="text" class="form-control" value="{{$class->name}}" name="name" id="name" placeholder="Classroom Name">
                <label for="name">Classroom Name</label>
              </div>

              <div class="form-floating mb-3">
                <input type="text" class="form-control" value="{{$class->section}}" name="section" id="section" placeholder="Section">
                <label for="section">Section</label>
              </div>

              <div class="form-floating mb-3">
                <input type="text" class="form-control" value="{{$class->subject}}" name="subject" id="subject" placeholder="Subject">
                <label for="subject">Subject</label>
              </div>

              <div class="form-floating mb-3">
                <input type="text" class="form-control" value="{{$class->room}}" name="room" id="room" placeholder="Room">
                <label for="room">Room</label>
              </div>

              <div class="form-floating">
              <img src="{{asset('uploads/'.$class->cover_image_path)}}" width="150" height="150" >
              </div>
              <div class="form-floating mb-3">
                <input type="file" class="form-control" name="cover_image" id="cover_image_path" placeholder="Cover image">
                <label for="cover_image_path">Cover image</label>
              </div>

              <button type="submit" class="btn btn-primary">Update Class</button>
        </form>
    </div>


    @endsection
