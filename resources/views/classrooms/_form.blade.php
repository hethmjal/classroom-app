<div class="form-floating mb-3">
    <input type="text" value="{{old('name',$class->name)}}" class="form-control  @error('name') is-invalid @enderror" name="name" id="name" placeholder="Classroom Name">
    <label for="name">Classroom Name</label>
  </div>

  <div class="form-floating mb-3">
    <input type="text" value="{{old('section',$class->section)}}" class="form-control @error('section') is-invalid @enderror" name="section" id="section" placeholder="Section">
    <label for="section">Section</label>
  </div>

  <div class="form-floating mb-3">
    <input type="text" value="{{old('subject',$class->subject)}}" @class(['form-control', 'is-invalid' => $errors->has('subject')])    name="subject" id="subject" placeholder="Subject">
    <label for="subject">Subject</label>
  </div>

  <div class="form-floating mb-3">
    <input type="text" value="{{old('room',$class->room)}}" class="form-control  @error('room') is-invalid @enderror" name="room" id="room" placeholder="Room">
    <label for="room">Room</label>
  </div>
    @if($class->cover_image_path) 
    <div class="form-floating">
        <img src="{{asset('uploads/'.$class->cover_image_path)}}" width="150" height="150" >
        </div>
    @endif
  
  <div class="form-floating mb-3">
    <input type="file" class="form-control @error('cover_image') is-invalid @enderror" name="cover_image" id="cover_image_path" placeholder="Cover image">
    <label for="cover_image_path">Cover image</label>
  </div>

  <button type="submit" class="btn btn-primary">{{$btn_label}}</button>