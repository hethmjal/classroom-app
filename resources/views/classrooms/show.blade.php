@extends('layout.master',['title' => $classroom->name.' - Classroom'])
@section('content')

@push('css')
<style>
    .bg-img{
      background-image: 
        url("{{$classroom->cover_image_url}}");
        font-family: 'Changa', sans-serif;
        /*  height: 500px; */ /* You must set a specified height */
        background-position: center; /* Center the image */
        background-repeat: no-repeat; /* Do not repeat the image */
        background-size: cover;x
    }
  </style>
@endpush
    <div class="container  ">
        <div class="row">
         <div class="rounded col-md-12 bg-img " style="height: 240px; width: 100%">
     
      <div class="d-flex align-items-start flex-column " style="height: 240px;">
         <div class="mt-auto ">
            <h1 class="text-white">{{$classroom->name}} (#{{$classroom->id}})</h1>
            <h3 class="text-white">{{$classroom->section}}</h3>
         </div>
      </div>
     
         </div>
        </div>

        <div class="row">
        <div class="col-md-3">
        <div class="border rounded text-center my-2">
            <span class="fs-2 text-success">{{$classroom->code}}</span>
        </div>

        <h5>Share Link</h5>
        <div class="d-flex align-items-center">
            <div  class="">
                <input  id="link" type="text" class="form-control" value="{{$invitaion_link}}"  readonly>
    
            </div>
            <div class="ml-1" >
                <button onclick="myFunction()" class="mx-1 btn btn-sm btn-outline-success">Copy</button>
    
            </div>
      
        </div>

        <div  class="my-2">
           <p> <a href="{{route('classrooms.classworks.index',$classroom->id)}}" class="btn btn-outline-dark" target="_blank">Classworks</a> </p>

        </div>

        <div  class="my-2">
            <p> <a href="{{route('classrooms.people',$classroom->id)}}" class="btn btn-outline-dark" target="_blank">Memebers</a> </p>
 
         </div>


        </div>

        <div class="col-md-7">

      

        </div>

        <div class="col-md-2">
            <div class="border rounded  my-2 text-center">
                <div class="form-floating mb-3">
                  <a href="{{route('classrooms.topics.index',$classroom->id)}}" class=""><h2>Topics</h2></a> 
                  </div>
            </div>
    


        </div>
   
    </div>
</div>

@push('js')
<script>
    function myFunction() {
// Get the text field
var copyText = document.getElementById("link");

// Select the text field
copyText.select();
copyText.setSelectionRange(0, 99999); // For mobile devices

// Copy the text inside the text field
navigator.clipboard.writeText(copyText.value);

// Alert the copied text
}
</script>
@endpush
    @endsection