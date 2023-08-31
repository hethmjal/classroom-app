@extends('layout.master',['title' => (count($topics)>0 ? $topics[0]->classroom->name : 'Classroom') .' - Topics'])
@section('content')   

<section class="container mb-5">
      @if(session('message'))
    <div class="alert alert-success" role="alert">
      {{session('message')}}
    
    </div>    
      @endif

  
{{-- 
      <div class="row mb-5 ">
        <div class="col-md-4 col-6 mb-5 text-center">
          <div class="border rounded in-shadow   h-100 ">
            <div class="">
              <img src="{{asset('uploads/images/x5mLYKdG8WMKfPl25ck76hUUP9EYBGci9NN4MFS9.png')}}"  style="width: 100%" alt="">
            </div>
            <div class="px-3 pt-2">
            <h4>the title</h4>
            <p>
              descron diption iption description desption description
            </p>
              <div class="texr-center mt-auto mb-1">
              <button style="width: 80%">show</button>

            </div>
          </div>
          </div>
        </div>
      </div> --}}



       <div class="d-flex  justify-content-between">
        
           
          <h1>Topics</h1>       
 
 
        
        <div class="">
          <a href="{{route('classrooms.topics.create',$class->id)}}" class="btn btn-lg btn-primary ">Create Topic</a> 

          <a href="{{route('topics.trached',$class->id)}}" class="btn btn-lg btn-danger ">Trached Topic</a> 
        </div>
       

       </div>
    

        <div class="row mt-5">
         

                @foreach ($topics as $topic)
                <div class="col-md-3">
                <div class="card" style="">
                    <div class="card-body">
                      <h5 class="card-title">{{$topic->name}} </h5>
                      <p class="card-text"></p>
                      <a href="{{route('classrooms.topics.edit',[$topic->classroom->id,$topic->id])}}" class="btn btn-sm btn-success">edit</a>
                      <button type="button" class="btn btn-sm btn-danger deleteBtn" onclick="deleteTopic({{$topic->id}})" id="">delete</button>

                      <form action="{{route('classrooms.topics.destroy',[$topic->classroom->id,$topic->id])}}" id="deleteForm{{$topic->id}}" method="post">
                            @csrf
                            @method('delete')
                           
                        </form>
                    </div>
                  </div>
            </div>

            @endforeach

        </div>

@push('js')
<script>
    var elements = document.getElementsByClassName("deleteBtn")

    var deleteTopic = function(id) {
        $("#deleteForm"+id).submit() // Submit the form
    }

</script>
</section>
@endpush
   

@endsection
