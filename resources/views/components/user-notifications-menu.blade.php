<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        Notifications @if($unreadCount) <span class="badge bg-info"> {{$unreadCount}} </span> @endif 
    </a>
    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
        @foreach ($notifications as $not)
        @if($not->unread())
        <li style="background-color: rgb(236, 236, 236)"><a class="dropdown-item" href="{{$not->data['link']}}?nid={{$not->id}}">
            {{$not->data['body']}}
            <br>
            <small>{{$not->created_at->diffForHumans()}}</small>
        </a></li>
        @else
        <li ><a class="dropdown-item" href="{{$not->data['link']}}?nid={{$not->id}}">
            {{$not->data['body']}}
            <br>
            <small>{{$not->created_at->diffForHumans()}}</small>
        </a></li>
        @endif
        @endforeach
 
      
    </ul>
  </li>