@extends('layout.master',['title' => 'Classrooms List'])
@section('description', 'classrooms app')
    @section('content')
    
    <div class="container">
      
      @if(session('message'))
      <div class="alert alert-success" role="alert">
        {{session('message')}}
      
      </div>    
        @endif
        <h1 class="mb-4">Classrooms</h1>
        
        <div class="row">
         

                @foreach ($classes as $class)
                <div class="col-md-3">
                <div class="card" style="">
                    <img src="{{asset('uploads/'.$class->cover_image_path)}}" width="400" height="150" class="card-img-top" alt="...">
                    <div class="card-body">
                      <h5 class="card-title">{{$class->name}} </h5>
                      <p class="card-text">{{$class->section}}</p>
                      <a href="{{route('classrooms.show',$class->code)}}" class="btn btn-primary">show</a>
                      <a href="{{route('classrooms.edit',$class->id)}}" class="btn btn-success">edit</a>
                      <button type="submit" class="btn btn-danger deleteBtn" onclick="deleteTopic({{$class->id}})">delete</button>
                        <form action="{{route('classrooms.destroy',$class->id)}}" id="deleteForm{{$class->id}}" method="post">
                            @csrf
                            @method('delete')
                        </form>
                    </div>
                  </div>
            </div>

            @endforeach


          
          


        </div>
   
    </div>
    @push('js')
    <script>

        var elements = document.getElementsByClassName("deleteBtn");
        var deleteTopic = function(id) {
            $("#deleteForm"+id).submit(); // Submit the form
        };

    </script>
    @endpush
   

@endsection
