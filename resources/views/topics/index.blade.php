@extends('layout.master',['title' => (count($topics)>0 ? $topics[0]->classroom->name : 'Classroom') .' - Topics'])
@section('content')   

<div class="container">
    @if(session('message'))
    <div class="alert alert-success" role="alert">
      {{session('message')}}
    
    </div>    
      @endif
        <h1>Topics</h1>
       
        <div class="col-md-2 border rounded p-3 text-center mb-2">
            <div class="form-floating mt-3">
              <a href="{{route('topics.create',$class->id)}}" class=""><h4>Create Topic</h4></a> 
            </div>
        </div>

        <div class="row mt-5">
         

                @foreach ($topics as $topic)
                <div class="col-md-2">
                <div class="card" style="">
                    <div class="card-body">
                      <h5 class="card-title">{{$topic->name}} </h5>
                      <p class="card-text"></p>
                      <a href="{{route('topics.edit',$topic->id)}}" class="btn btn-success">edit</a>
                      <button type="button" class="btn btn-danger deleteBtn" onclick="deleteTopic({{$topic->id}})" id="">delete</button>

                      <form action="{{route('topics.delete',$topic->id)}}" id="deleteForm{{$topic->id}}" method="post">
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
