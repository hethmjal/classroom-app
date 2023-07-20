@extends('layout.master',['title' => $classroom->name.' - Classroom'])
@section('content')
    <div class="container">
        <h1>{{$classroom->name}} (#{{$classroom->id}})</h1>
        <h3>{{$classroom->section}}</h3>
    
        <div class="row">
        <div class="col-md-3">
        <div class="border rounded p-3 text-center">
            <span class="fs-2 text-success">{{$classroom->code}}</span>
        </div>


        </div>

        <div class="col-md-7">

            <h1>topics</h1>

        </div>


        <div class="col-md-2">
            <div class="border rounded p-3 text-center">
                <div class="form-floating mb-3">
                  <a href="{{route('topics',$classroom->id)}}" class=""><h2>Topics</h2></a> 
                  </div>
            </div>
    


        </div>
   
    </div>
</div>

    @endsection