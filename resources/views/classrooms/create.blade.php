@extends('layout.master',['title' => 'Create Classroom'])
@section('content')
    <div class="container">
        <h1 class="mb-5">Create Classroom</h1>
        

        <form action=" {{route('classrooms.store')}} " method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="name" id="name" placeholder="Classroom Name">
                <label for="name">Classroom Name</label>
              </div>

              <div class="form-floating mb-3">
                <input type="text" class="form-control" name="section" id="section" placeholder="Section">
                <label for="section">Section</label>
              </div>

              <div class="form-floating mb-3">
                <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject">
                <label for="subject">Subject</label>
              </div>

              <div class="form-floating mb-3">
                <input type="text" class="form-control" name="room" id="room" placeholder="Room">
                <label for="room">Room</label>
              </div>

              <div class="form-floating mb-3">
                <input type="file" class="form-control" name="cover_image" id="cover_image_path" placeholder="Cover image">
                <label for="cover_image_path">Cover image</label>
              </div>

              <button type="submit" class="btn btn-primary">Create Class</button>
        </form>
    </div>


    @endsection