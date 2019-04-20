@extends('layouts.app')

@section('content')

                        
                        <div class="row">
                                <div class="col">
                                    <ul class="list-group">
                                        <li class="list-group-item" style="margin:0px 0px 10px;background-color:#d29ea8;"><span>{{$task->jobname}}</span><i class="fa fa-car float-right" style="color:rgb(222,72,72);"></i></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row">
                                
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header" style="background-color:#d29ea8;">
                                        <h5 class="mb-0">{{$task->jobname}}</h5><em>{{$task->user_id->email}}</em><span class="float-right">
                                             @if ($task->negotiable == 1)
                                                 (negotiable)
                                            @endif {{$task->pay}}&nbsp;
                                             <i class="fa fa-rupee" style="font-size:19px;color:rgb(51,95,7);"></i></span></div>
                                        <div class="card-body" style="background-color:#eea6b4;">
                                        <input class="form-control-sm" type="date" value="{{date('Y-m-d',strtotime($task->created_at))}}" readonly style="padding:0px;">
                                            <h5>Description about the job</h5>
                                            <div class="card-text">
                                                <?= $task->jobdescription ?>
                                            </div>
                                            <div>
                                                <h6>Tags</h6>
                                                @foreach ($task->skillrequired as $skill)
                                                <label>&nbsp;{{$skill}}&nbsp;<i class="fa fa-times"></i></label>    
                                                @endforeach
                                                
                                            
                                            </div>
                                            <?php
                                                $direction = explode('~',$task->user_id->location);
                                            ?>
                                            <h5
                                        class="card-title mb-0">Location</h5><iframe src="https://maps.google.com/maps?q={{ $direction[0] }},{{ $direction[1] }}&hl=es;z=14&amp;output=embed" height="290" frameborder="0" style="border:0" allowfullscreen></iframe></div>
                                    </div>
                                    <div class="btn-group" role="group">
                                        
                                    <a href="{{ url('tasks/'.$id) }}?involve=true" class="btn btn-success btn-sm">I will do it</a>
                                    <a href="{{ url('tasks/'.$id) }}?involve=false" class="btn btn-danger btn-sm">I wanna negotiate</a>
                                       
                                    </div>
                                </div>
                            </div>
                            <hr><h2>Sugggested workers</h2><hr>
<div class="row w-100">
    @if(isset($suggestedUsers))
        @foreach ($suggestedUsers as $item)
            <div class="col-md-2 col-sm-6" onclick="window.location = ('{{url('users/'.$item->user_id)}}')">
                <div class="card border-info mx-sm-1 p-3" style="cursor:pointer;background: url(/storage/cover_images/{{$item->profilePic}})">
                    <div class="card border-info shadow text-info p-3 my-card">
                        <span class="fa fa-diamond" aria-hidden="true"></span>
                    </div>
                    <div class="text-info text-center mt-3"><h4>{{$item->name}}</h4></div>
                    <div class="text-info text-center mt-2"><h1>{{(isset($item->count))?$item->count."#":$item->visited."$"}}</h1></div>
                </div>
            </div>
        @endforeach    
    @endif
</div>
                        
@endsection
