@extends('layout.master',['title' => $classroom->name.' | Classworks'])
@section('content')
    <div class="container">
        <h1 class="mb-5">{{$classroom->name}} - #{{$classroom->id}} </h1>
        @if(session('message'))
        <div class="alert alert-success" role="alert">
          {{session('message')}}
        
        </div>    
          @endif
  
        <h2>Classworks</h2>
        @can('create', ["App\Models\Classwork",$classroom])
        <div class="dropdown mb-4" >
     
            
         
            <button class="btn btn-secondary dropdown-toggle " type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                + Create
            </button>

            <ul  class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <li>  
                    <a  class="dropdown-item" href="{{route('classrooms.classworks.create',[$classroom->id,'type'=>'assignment'])}}">Assignment</a></li>
                <li > 
                     <a class="dropdown-item" href="{{route('classrooms.classworks.create',[$classroom->id,'type'=>'material'])}}">Material</a></li>
                <li > 
                     <a class="dropdown-item" href="{{route('classrooms.classworks.create',[$classroom->id,'type'=>'question'])}}">Question</a></li>

            </ul>

        </div>
        @endcan 
          @forelse ($classworks as $group)
          <div class="my-5 accordion accordion-flush" id="accordionFlushExample">
         
          <h4>
          


            
            {{$group[0]->topic->name}}
          </h4>
          @foreach ($group as $classwork)
          <div class="accordion-item">
            <h2 class="accordion-header" id="flush-heading{{$classwork->id}}">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse{{$classwork->id}}" aria-expanded="false" aria-controls="flush-collapse{{$classwork->id}}">
               @if($classwork->type == 'assignment')
               <svg fill="black" focusable="false" width="24" height="24" viewBox="0 0 24 24" class="svg NMm5M hhikbc">
                <path d="M7 15h7v2H7zm0-4h10v2H7zm0-4h10v2H7z"></path>
                <path d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-.14 0-.27.01-.4.04a2.008 2.008 0 0 0-1.44 1.19c-.1.23-.16.49-.16.77v14c0 .27.06.54.16.78s.25.45.43.64c.27.27.62.47 1.01.55.13.02.26.03.4.03h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7-.25c.41
                 0 .75.34.75.75s-.34.75-.75.75-.75-.34-.75-.75.34-.75.75-.75zM19 19H5V5h14v14z"></path></svg>
               @elseif($classwork->type == 'material')
               <svg fill="black" focusable="false" width="24" height="24" viewBox="0 0 24 24" 
               class="svg"><path d="M18 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 
               18H6V4h2v8l2.5-1.5L13 12V4h5v16z"></path></svg>  
               @elseif($classwork->type == 'question')
                           
            <svg fill="black" focusable="false" width="24" height="24" viewBox="0 0 24 24" class=" ">
              <path d="M19 2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h4l3 3 3-3h4c1.1
               0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 16H5V4h14v14z"></path><path d="M11 15h2v2h-2zm1-8c1.1 0 2 
              .9 2 2 0 2-3 1.75-3 5h2c0-2.25 3-2.5 3-5 0-2.21-1.79-4-4-4S8 6.79 8 9h2c0-1.1.9-2 2-2z"></path></svg>

               @endif
               {{$classwork->title}}
              </button>
            </h2>
            <div id="flush-collapse{{$classwork->id}}" class="accordion-collapse collapse" aria-labelledby="flush-heading{{$classwork->id}}" data-bs-parent="#accordionFlushExample">
            
             
              <div class="accordion-body ">
                <div class="row">
                  <div class="col-md-6">
                    <div> {!! Str::words($classwork->description, 7) !!} </div> 
                  </div>

                  <div class="col-md-6">
                    <div class="row">
                      
                      <col-md-6>
                     
                        {{__("Assigned")}} 
                     
                       
                    
                        {{$classwork->assigned_count}}
                    
                
                    </col-md-6>

                    <col-md-6>
                  
                    
  

                    
                    {{__("Submitted")}} 
                     
                      {{$classwork->turnedin_count}}
                    
                     
                  </col-md-6>

                  <col-md-6>
                  
                    
  

                    
                  {{__("Graded")}} 
                   
                    {{$classwork->graded}}
                  
                   
                </col-md-6>
                    
                  </div>

                </div>
                
                    
              <div class="d-flex justify-content-end">
                <a href="{{route('classrooms.classworks.show',[$classroom->id,$classwork->id])}}" class=" mx-1 btn btn-sm btn-success ">show</a> 

                
                <a href="{{route('classrooms.classworks.edit',[$classroom->id,$classwork->id,'type'=>$classwork->type])}}" class=" mx-1 btn btn-sm btn-primary ">edit</a> 
               
                <form action="{{route('classrooms.classworks.destroy',[$classroom->id,$classwork->id])}}" method="post">
                  @csrf
                  @method("delete")
                  <button type="submit" class="mx-1 btn btn-sm btn-danger ">delete</button> 
                </form>
             
              </div>
            </div>

           
          
            </div>
          </div>
          @endforeach
       
        
          @empty
             <h3>No classworks found.</h3> 
            </div>

          @endforelse
           
          
           
    
    </div>


    @push('js')

    <script>
       classroomId = "{{$classroom->id}}";
    </script>
    @endpush

    @endsection