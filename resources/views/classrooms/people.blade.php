@extends('layout.master',['title' => $classroom->name.' | Classworks'])
@section('content')
@push('css')
<style>
    hr{
        border: none;
            border-top: 3px double #000000;
            color: #000000;
            overflow: visible;
            text-align: center;
            height: 5px;
    }
.teacher:after {
    background: #fff;
    content: 'Teachers' ;
    padding: 0 4px;
    position: relative;
    top: -13px;
  }

  .student:after {
    background: #fff;
    content: 'Students' ;
    padding: 0 4px;
    position: relative;
    top: -13px;
  }
</style>

@endpush
    <div class="container">
        @if(session('message'))
        <div class="alert alert-success" role="alert">
          {{session('message')}}
        
        </div>    
          @endif
        <h1 class="mb-5">{{$classroom->name}} - people </h1>

        <div >
            <h3>Teachers</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th></th>
                    </tr>
               </thead>
               <tbody>
                @foreach ($classroom->teachers()->orderBy('name')->get() as $user)
                <tr>
                    <td>{{$loop->index +1}}</td>
                    <td> {{$user->name}} </td>
                    <td>
                        <form action="{{route('classrooms.people.destroy',$classroom->id)}}" method="post">
                            @csrf
                            @method('delete')
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                            <button type="submit" class="btn btn-sm btn-danger">remove</button>
                        </form>
                    </td>
                </tr>
                @endforeach
               
               </tbody>
            </table>
        </div>
      

        <div class="mt-5">
        

            <h3>Students</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th></th>
                    </tr>
               </thead>
               <tbody>
                @foreach ($classroom->students()->orderBy('name')->get() as $user)
                <tr>
                    <td>{{$loop->index +1}}</td>
                    <td> {{$user->name}} </td>
                    <td>
                        <form action="{{route('classrooms.people.destroy',$classroom->id)}}" method="post">
                            @csrf
                            @method('delete')
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                            <button type="submit" class="btn btn-sm btn-danger">remove</button>
                        </form>
                    </td>
                </tr>
                @endforeach
               
               </tbody>
            </table>
        </div>

    </div>
@endsection