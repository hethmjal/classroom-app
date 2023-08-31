@extends('layout.master',['title' => $classroom->name.' | Classworks'])
@section('content')
    <div class=" container">
      <div class="row">

        @if(session('success'))
        <div class="alert alert-success">
          {{session('success')}}
        </div>
        @endif
      

        @if(session('error'))
        <div class="alert alert-danger">
          {{session('error')}}
        </div>
        @endif

      <div class="col-md-8">

    
        <h1 class="mb-5">{{$classroom->name}} - #{{$classroom->id}} </h1>
        @if(session('message'))
        <div class="alert alert-success" role="alert">
          {{session('message')}}
        
        </div>    
          @endif
  
        <h2>{{$classwork->title}}</h2>
        <hr>
        <p> {!!$classwork->description!!}</p>
        
            <h4 >Commments</h4>

        <form class="mb-2" action=" {{route('comments.store')}}" 
            method="post" enctype="multipart/form-data">
            @csrf
               <input type="hidden" name="classwork_id" value="{{$classwork->id}}"/>
               <input type="hidden" name="type" value="classwork"/>

              <div class="form-floating mb-2">
                <textarea class="form-control @error('content') is-invalid @enderror"
                 name="content" id="descripticontenton" placeholder="Comment" cols="15" rows="5"></textarea>
                <label for="content">Comment</label>
              </div>
              
              <button type="submit" class="btn btn-primary">Comment</button>

        </form> 




        <div class="mt-4">

        @foreach ($classwork->comments as $comment)
            <div class="row">
                <div class="col-md-2">
                    <img src="{{$comment->user->avatar()}}" alt=""> 
                </div>
                <div class="col-md-10">
                    <p> By: {{$comment->user->name}}. Time: {{ $comment->created_at->diffForHumans(null,true,true) }} </p>
                  <p>  {{$comment->content}} </p>
                </div>
            </div>
        @endforeach
    </div>

  </div>


  <div class="col-md-4 mt-5">
    @can('submissions', $classwork) 
    <h3>Submission</h3>
    @if($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $err)
            <li>{{$err}}</li>
        @endforeach
      </ul>
    </div>
    @endif

  @if(count($submissions) <= 0)

    <form action="{{route('submissions.store',$classwork->id)}}" method="POST" enctype="multipart/form-data">
   @csrf
      <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Upload Files</label>
        <input type="file" name="files[]" class="form-control" multiple>
      </div>
      
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
 
  @else
  <ul>

  
  @foreach ($submissions as $submission)
      <li> <a href="{{route('submissions.file',$submission->id)}}"> {{$loop->index + 1}} </a> </li>
  @endforeach 
</ul>
  @endif
  @endcan

</div>
    </div>

  </div>

    @endsection