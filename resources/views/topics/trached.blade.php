@extends('layout.master',['title' => (count($topics)>0 ? $topics[0]->classroom->name : 'Classroom') .' - Topics'])
@section('content')   

<section class="container mb-5">
      @if(session('message'))
    <div class="alert alert-success" role="alert">
      {{session('message')}}
    
    </div>    
      @endif

  


        
           
          <h1>Trached Topics</h1>       
 
 
    
       

    

        <div class="row mt-5">
         

                @foreach ($topics as $topic)
                <div class="col-md-3">
                <div class="card" style="">
                    <div class="card-body">
                      <h5 class="card-title">{{$topic->name}} </h5>
                      <p class="card-text"></p>
                      <div class="d-flex ">
                       
                     
                        <form action="{{route('topics.restore',[$topic->classroom->id,$topic->id])}}"  method="post">
                            @csrf
                            @method('put')
                            <button class="btn btn-sm btn-success mx-1" type="submit">Restore</button>
                        </form>

                        <form action="{{route('topics.forceDelete',[$topic->classroom->id,$topic->id])}}"  method="post">
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

@push('js')
<script>
   /*  var elements = document.getElementsByClassName("deleteBtn")

    var deleteTopic = function(id) {
        $("#deleteForm"+id).submit() // Submit the form
    }
 */
</script>
</section>
@endpush
   

@endsection
