@extends('layout.master',['title' => 'Create Classroom'])
@section('content')
    <div class="container">
        <h1 class="mb-5">Create Classroom</h1>
        @if($errors->any())
        <div class="alert alert-danger">
          <ul>
            @foreach ($errors->all() as $err)
                <li>{{$err}}</li>
            @endforeach
          </ul>
        </div>
        @endif
   
        <form action=" {{route('classrooms.store')}} " method="post" enctype="multipart/form-data">
            @csrf
            @include('classrooms._form',['btn_label'=>'Create Classroom'])
        </form>
    </div>


    @endsection