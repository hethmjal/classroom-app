@extends('layout.master',['title' => 'Classrooms List'])
@section('description', 'classrooms app')
    @section('content')
    
    <div class="container">
      
      @if(session('message'))
      <div class="alert alert-success" role="alert">
        {{session('message')}}
      
      </div>    
        @endif
        <h1 class="mb-4">Trached Classrooms</h1>
        
        <div class="row">
         

                @foreach ($classes as $class)
                <div class="col-md-3">
                <div class="card" style="">
                    <img  src="{{$class->cover_image_url}}" width="400" height="150" class="card-img-top" alt="...">
                    <div class="card-body">
                      <h5 class="card-title">{{$class->name}} </h5>
                      <p class="card-text">{{$class->section}}</p>
                      <div class="d-flex ">
                       
                     
                        <form action="{{route('classrooms.restore',$class->id)}}" id="deleteForm{{$class->id}}" method="post">
                            @csrf
                            @method('put')
                            <button class="btn btn-sm btn-success mx-1" type="submit">Restore</button>
                        </form>

                        <form action="{{route('classrooms.forceDelete',$class->id)}}" id="deleteForm{{$class->id}}" method="post">
                            @csrf
                            @method('delete')
                            <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                        </form>
                      </div>
                      
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
