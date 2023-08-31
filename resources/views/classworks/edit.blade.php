

    @extends('layout.master',['title' => 'Update Classwork'])
@section('content')
    <div class="container">
        <h1 class="mb-5">Update {{$classwork->type}}</h1>
        @if($errors->any())
        <div class="alert alert-danger">
          <ul>
            @foreach ($errors->all() as $err)
                <li>{{$err}}</li>
            @endforeach
          </ul>
        </div>
        @endif
        <form action=" {{route('classrooms.classworks.update',[$classroom->id,$classwork->id,'type'=>$type])}} " method="post" enctype="multipart/form-data">
          @csrf
          @method('put')
          @include('classworks._form',['label'=>'Update','type'=>$classwork->type])
         
      </form>
    </div>


    @endsection