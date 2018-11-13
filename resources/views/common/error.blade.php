@if(count($errors) > 0)
    <ul>
       @foreach($errors->all() as $error)
           <li class="alert alert-danger">
               <i class="fa fa-times"></i>{{$error}}
           </li>
       @endforeach
    </ul>
@endif