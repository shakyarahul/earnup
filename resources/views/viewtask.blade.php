@extends('layouts.app')

@section('content')

                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-header">
                                    <ul class="nav nav-tabs card-header-tabs">
                                        <li class="nav-item"><a class="nav-link" onclick="openTab(event,'tabone')" href="#">Feedbacklist</a></li>
                                        <li class="nav-item"><a class="nav-link" onclick="openTab(event,'tabtwo')" href="#">Add new task</a></li>
                                        <li class="nav-item"><a class="nav-link" onclick="openTab(event,'tabthree')" href="#">My Jobs</a></li>
                                    </ul>
                                </div>
                                <div id="tabone" class="card-body tab" style="display:block">
                                    <h1>Performance</h1>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <caption>Achievements<br></caption>
                                            <thead>
                                                <tr>
                                                    <th>Job</th>
                                                    <th>Rating</th>
                                                    <th>Details</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $summation =0;  ?>
                                                @foreach ($tasks as $task)
                                                <tr>
                                                        <td>{{$task->task->jobname}}</td>
                                                        <td><?php 
                                                        $i=$task->rated;
                                                        $j =5;
                                                        $summation+=$i;
                                                        ?>
                                                        
                                                        @while ($j > 0)
                                                            @if($i>0)
                                                                <i class="fa fa-star" style="color:rgb(0,255,0);font-size:10px;"></i>
                                                                <?php $i--; ?>
                                                                <?php $j--; ?>
                                                                @continue
                                                            @endIf

                                                            <?php $j--; ?>
                                                            <i class="fa fa-star-o" style="color:rgb(152,237,152);font-size:10px;"></i>
                                                        @endwhile
                                                            </td>
                                                        <td><a onclick="showHideToggler(event,'moreinfo{{$task->id}}')"><i class="fa fa-eye" style="font-size:21px;"></i></a></td>
                                                </tr>
                                                <tr id="moreinfo{{$task->id}}" style="display:none">
                                                    <td colspan="3">{{$task->description}}</td>
                                                </tr>
                                                        
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td>Average Rating</td>
                                                    <td>
                                                        @if (count($tasks) != 0)
                                                        <?php 
                                                        $average = round($summation/count($tasks));
                                                        $j = 5;
                                                        ?>
                                                        
                                                            @while ($j > 0)
                                                                @if($average > 0)
                                                                    <i class="fa fa-star" style="color:rgb(0,255,0);font-size:10px;"></i>
                                                                    <?php 
                                                                    $average--; ?>
                                                                    <?php $j--; ?>
                                                                    @continue
                                                                @endIf

                                                                <?php $j--; ?>
                                                                <i class="fa fa-star-o" style="color:rgb(152,237,152);font-size:10px;"></i>
                                                            @endwhile
                                                        @endif
                                                    </td>
                                                    <td><?= count($tasks) ?> Jobs</td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <div id="tabtwo" class="card-body tab" style="display:none">
                                    <h4 class="card-title">Add new task</h4>
                                    {!! Form::open(['action'=>'TasksController@store','method'=>'POST']) !!}
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text">Job Name</span></div>
                                            <input type="hidden" name="jobId" id="jobIdForUpdate" value=""/>
                                            <input class="form-control" type="text" placeholder="Job Title" name="jobname" id="jobNameForUpdate">
                                            
                                            <div class="input-group-append"></div>
                                        </div>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text">Pay</span></div>
                                            
                                            <input class="form-control" type="text" name="pay" id="payForUpdate" placeholder="Amount in NPR">

                                            <div class="input-group-append"></div>
                                        </div>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text">Skill Required</span></div>
                                            
                                            <input class="form-control" type="text" id="skills"  id="skillsForUpdate">
                                            
                                            <div class="input-group-append">
                                            <button class="btn btn-success" type="button" onclick="addCheckBox(event,document.getElementById('skills'))" style="font-size:16px;"><i class="fa fa-plus-circle" style="font-size:21px;"></i></button>
                                            
                                            </div>
                                        
                                        </div>
                                        <script>
                                            function addCheckBox(e,val){
                                                e.preventDefault();
                                                var div = document.createElement("div");
                                                    div.class = "form-check";
                                                
                                                var node = document.createElement("input");
                                                    node.type = "checkbox";
                                                    node.className = "skillrequired";
                                                    node.name = "skillrequired[]";
                                                    node.value = val.value;
                                                    node.checked = "checked"; 
                                                
                                                var label = document.createElement("label");
                                                    label.class = "form-check-label";
                                                    label.innerHTML = val.value;
                                            
                                                div.appendChild(node);
                                                div.appendChild(label);

                                                var element = document.getElementById('skillList');
                                                
                                                val.value="";
                                                element.appendChild(div);

                                            }
                                        </script>
                                        <div id="skillList">
                                            
                                        </div>
                                        
                                        <div class="form-group"><label>Job Desciption</label>
                                        
                                            <textarea id="article-ckeditor" class="form-control" name="jobdescription" placeholder="Description about the job"></textarea>
                                        </div>
                                        <div class="form-check"><input class="form-check-input" type="checkbox" value="1" id="formCheck-1"><label class="form-check-label" for="formCheck-1">Is the pay negotiable ?</label></div>
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-primary" type="submit"><i class="fa fa-envelope-o" style="font-size:52px;"></i></button>
                                            <button class="btn btn-primary" type="button" 
                                                style="background-color:rgb(0,255,0);"  
                                                onclick="loadMap()" ><i class="fa fa-map-marker" style="font-size:52px;"></i></button>
                                        </div>
                                    {!! Form::close() !!}
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="mb-0">Qualified Workers near your&nbsp;location</h5>
                                        </div>
        <div class="card-body"><div class="map-frame">
                <script src = "https://maps.googleapis.com/maps/api/js"></script>
                <script>
                    loadMap();
                       function loadMap() {
                        <?php 
                            $latlngAuthUser = auth()->user()->location;
                            $latlngAuthUser = explode("~",$latlngAuthUser);
                        ?>
                        var s = document.getElementsByClassName('skillrequired');
                        var xhttp = new XMLHttpRequest();
                        var skills = "";
                        for(var i=0;i<s.length;i++){
                            if(i==0){
                                skills = s[i].value;
                            }else{
                                skills = skills + "~" + s[i].value;
                            }
                            
                        }
                        alert(s.length);
                        
                        xhttp.onreadystatechange = function() {
                            if (this.readyState == 4 && this.status == 200) {
                                var users = JSON.parse(this.responseText);
                                loadmore(users);
                            }
                        };
                        qdata = <?=$latlngAuthUser[0]."%20".$latlngAuthUser[1] ?>;
                        xhttp.open("GET", '/api/users?skill='+skills, true);
                        xhttp.send();
                    }
                    function loadmore(users){
                        
                        var latUser = <?= $latlngAuthUser[0] ?>;
                        var lngUser = <?= $latlngAuthUser[1] ?>;
                        var mapOptions = {
                            center:new google.maps.LatLng(latUser,lngUser),
                            zoom:14
                        }
                        var map = new google.maps.Map(document.getElementById("sample"),mapOptions);
                        var marker =[];
                        var infowindow =[];

                        for(var i=0;i<users.data.length;i++){
                            loc = users.data[i].location.split("~");
                            marker[i] = new google.maps.Marker({
                                position: new google.maps.LatLng(loc[0],loc[1]),
                                map: map,
                            });
                            var tit= users.data[i].email;
                            contentString = '<div id="content">'+
                                        tit+
                                        '</div>';
                        
                            infowindow[i] = new google.maps.InfoWindow({
                                content: contentString
                            });
                                
                            
                            infowindow[i].open(map, marker[i]);
                            
                        }
                    }
           </script>
            
           <div id = "sample" style = "width:580px; height:400px;"></div>
        </div></div>
                                    </div>
                                </div>
                                <div id="tabthree" class="card-body tab" style="display:none">
                                    <h1>My Jobs</h1>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <caption>rating should be given according to the performance so that consumer like you do not cheated upon<br></caption>
                                            <thead>
                                                <tr>
                                                    <th>Jobname</th>
                                                    <th>Pay</th>
                                                    <th><i class="fa fa-star" style="color:rgb(0,255,0);font-size:10px;"></i></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <script>
                                                    
                                                    function showUpdateBox(e,id,jobname, pay, jobdescription, negotiable, skillrequired){
                                                        openTab(e,'tabtwo');
                                                        
                                                        skillrequired = skillrequired.split("~");
                                                        
                                                        for(i=0;i<skillrequired.length;i++){

                                                            addCheckBox(e,{'value': skillrequired[i]});        
                                                        }
                                                        
                                                        document.getElementById('jobIdForUpdate').value = id;
                                                        document.getElementById('jobNameForUpdate').value = jobname;
                                                        document.getElementById('payForUpdate').value = pay;
                                                        document.getElementById('negotiableForUpdate').value = negotiable;
                                                        CKEDITOR.instances.article-ckeditor.setData("asdsad");

                                                    }
                                                </script>
                                                <?php $summation =0;  ?>
                                                @foreach ($jobs as $job)
                                                <tr>
                                                        <td><?= date('d-m-y',strtotime($job->created_at)) ?>{{$job->jobname}}</td>
                                                        <td>{{$job->pay}}</td>

                                                        <td>
                                                        @if (!in_array("rated",$job->skillrequired))
                                                            <a onclick="showHideToggler(event,'morejobsinfo{{$job->id}}')">
                                                                rate
                                                            </a>
                                                            <?php $skill = implode("~",$job->skillrequired); ?>
                                                        <a onclick="showUpdateBox(event,'{{$job->id}}','{{$job->jobname}}','{{$job->pay}}','{{$job->jobdescription}}','{{$job->negotiable}}','{{$skill}}')">
                                                                    update
                                                            </a>
                                                        @else
                                                            rated
                                                        @endif                                                        
                                                        
                                                        </td>
                                                </tr>
                                                
                                                @if (in_array("rated",$job->skillrequired))
                                                   @continue
                                                @endif
                                                <tr id="morejobsinfo{{$job->id}}" style="display:none">
                                                    <td colspan="4">
                                                        {!! Form::open(['action'=>'RatingsController@store','method'=>'POST']) !!}
                                                            <div class="input-group">
                                                                <div class="input-group-prepend"><span class="input-group-text">Worker</span></div>
                                                                
                                                                <input class="form-control" type="text" name="userId" placeholder="Username of person you hired">
                                                                <input type="hidden" name="taskId" value="{{$job->id}}" />
                    
                                                                <div class="input-group-append"></div>
                                                            </div>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend"><span class="input-group-text">Rating</span></div>
                                                                
                                                                <select name="rated">
                                                                    <option value="5">Excellent</option>
                                                                    <option value="4">Very Good</option>
                                                                    <option value="3">Good</option>
                                                                    <option value="2">Average</option>
                                                                    <option value="1">Worst</option>
                                                                </select>
                                                                
                                                                <div class="input-group-append"></div>
                                                            </div>
                                                            <div class="form-group"><label>Comments</label>
                                                            
                                                            <textarea class="form-control" name="description" placeholder="Put a review on his skill on {{$job->jobname}}"></textarea>
                                                                <div class="input-group-append">
                                                                    <button class="btn btn-success" type="submit" style="font-size:16px;">Send review</button>
                                                                </div>
                                                            </div>

                                                            {!! Form::close() !!}

                                                    </td>
                                                </tr>
                                                        
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td>Total Jobs</td>
                                                    <td><?= count($jobs) ?> Jobs</td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
@endsection
