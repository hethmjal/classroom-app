@extends('layout.master',['title' => 'Create Classwork'])
@section('content')
    <div class="container">
        <h1 class="mb-5">Create {{$type}}</h1>
        @if(session('error'))
        <div class="alert alert-danger">
         {{session('error')}}
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger">
          <ul>
            @foreach ($errors->all() as $err)
                <li>{{$err}}</li>
            @endforeach
          </ul>
        </div>
        @endif
        <form action=" {{route('classrooms.classworks.store',[$classroom->id,'type'=>$type])}} " method="post" enctype="multipart/form-data">
          @csrf
          @include('classworks._form',['label'=>'Create','type'=>$type])
        
      </form>
    </div>


    @endsection