@extends('layout.master',['title' => 'Create Classroom'])
@section('content')
        <div class="d-flex flex-column align-items-center justify-content-center vh-100">
         
            <div>
                <h1 class="mb-5">Join Classroom</h1>
            </div>
            <div class="border p-5">
             
                <h1 class="mb-5">{{$classroom->name}}</h1>
    
                <form action=" {{route('classrooms.join',$classroom->id)}} " class="d-flex justify-content-center" method="post" enctype="multipart/form-data">
                    @csrf
                   <button type="submit"  class="btn btn-primary">Join Classroom</button>
                </form>
            </div>
          
        </div>
       


    @endsection