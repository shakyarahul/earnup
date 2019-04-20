@extends('layouts.app')

@section('content')
<div class="chat_list">
    <ul class="list-group">
        @if($messages->count() > 0)
            @foreach ($messages as $message)
                <li class="list-group-item">
                    <div class="pull-left hidden-xs">
                        <div>
                            <img class="img-circle" title="User1" style="width:50px;height:50px;border-radius:100px;" src="/storage/cover_images/{{$message->profilePic}}">                    
                        </div>
                    </div>
                <small class="pull-right text-muted">Expire in {{$message->expiry}}</small>
                    <div>
                        <small class="list-group-item-heading text-muted text-primary">{{$message->email}}</small>
                        <p class="list-group-item-text">
                            <?= $message->message ?>
                        </p>
                    </div>
                </li>
            @endforeach
        @else
            <li class="list-group-item">
                <div>
                    <small class="list-group-item-heading text-muted text-primary">No messages</small>
                    
                </div>
            </li>
        @endif
       
    </ul>
</div>
@endsection
