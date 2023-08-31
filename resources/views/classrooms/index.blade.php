@extends('layout.master',['title' => 'Classrooms List'])
@section('description', 'classrooms app')
    @section('content')
    
    <div class="container">
      
      @if(session('message'))
      <div class="alert alert-success" role="alert">
        {{session('message')}}
      
      </div>    
        @endif

        
       <div class="d-flex  justify-content-between">
        
           
        <h1 class="mb-4">Classrooms</h1>


      
      <div class="">
        <a href="{{route('classrooms.create')}}" class="btn btn-lg btn-primary ">Create Classrooms</a> 

        <a href="{{route('classrooms.trached')}}" class="btn btn-lg btn-danger ">Trached Classrooms</a> 

      </div>
     

     </div>
        <div class="row">
         

                @foreach ($classes as $class)
                <div class="col-md-3">
                <div class="card" style="">
                  
                    <img src="{{$class->cover_image_url}}" width="400" height="90" class="card-img-top" alt="...">
                    <div class="card-body">
                      <h5 class="card-title">{{$class->name}} </h5>
                      <p class="card-text">{{$class->section}}</p>
                      <a href="{{route('classrooms.show',$class->id)}}" class="btn btn-sm btn-primary">{{__('View')}}</a>
                      <a href="{{route('classrooms.edit',$class->id)}}" class="btn btn-sm btn-success">{{__('Edit')}}</a>
                      <button type="submit" class="btn btn-sm btn-danger deleteBtn" onclick="deleteTopic({{$class->id}})">{{__('Delete')}}</button>
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
