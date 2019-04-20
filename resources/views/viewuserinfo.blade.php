@extends('layouts.app')

@section('content')




    <div class="row profile">
            <div class="col-md-3">
                <div class="profile-sidebar">
                    <!-- SIDEBAR USERPIC -->
                    <div class="profile-userpic">
                            <img class="w-25 h-25 img-fluid rounded mx-auto d-block" src="/storage/cover_images/{{$users->profilePic}}" class="img-responsive">
                    </div>
                    <!-- END SIDEBAR USERPIC -->
                    <!-- SIDEBAR USER TITLE -->
                    <div class="profile-usertitle">
                        <div class="profile-usertitle-name">
                                {{$users->name}} ({{$users->status}})
                        </div>
                        <div class="profile-usertitle-job">
                               With us, since {{ (int)((strtotime("now") - strtotime($users->created_at))/(60*60*24)) }} days</label>
                        </div>
                    </div>
                    <!-- END SIDEBAR USER TITLE -->
                    <!-- SIDEBAR BUTTONS -->
                    <!-- END SIDEBAR BUTTONS -->
                    <!-- SIDEBAR MENU -->
                    <div class="profile-usermenu">
                        <ul class="nav">
                            
                                <li onclick="openTab(event,'tabone')">
                                    <a href="#">
                                    <i onclick="event.preventDefault()" class="fa fa-plus-circle"></i>
                                    User Info</a>
                                </li>
                                <li onclick="openTab(event,'tabtwo')">
                                        <a href="#">
                                        <i onclick="event.preventDefault()" class="fa fa-plus-circle"></i>
                                        More Info</a>
                                    </li>
                            <li onclick="openTab(event,'tabthree')" >
                                <a href="#">
                                <i onclick="event.preventDefault()" class="fa fa-eye"></i>
                                Experience </a>
                            </li>
                        </ul>
                    </div>
                    <!-- END MENU -->
                </div>
            </div>
            <div class="col-md-9">
                <div class="profile-content">
                        <div id="tabone" class="card-body tab" style="display:block">
                                <img class="w-25 h-25 img-fluid rounded mx-auto d-block" src="/storage/cover_images/{{$users->profilePic}}" onclick="document.getElementById('profilePic').click()">
                                
                                <div class="card-body">
                                <h4 class="card-title">{{$users->name}} ({{$users->status}})</h4><label> Thank you for last {{ (int)((strtotime("now") - strtotime($users->created_at))/(60*60*24)) }} days of your services</label>
                                    <blockquote class="blockquote">
                                        <?php 
                                            $blockquote = explode("~" , $users->blockquote);
                                        ?>
                                    <p class="mb-0" id="blockquote">{{$blockquote[0]}}</p>
                                    <footer class="blockquote-footer"  >
                                        <p id="blockquotefooter">{{$blockquote[1]}}</p>
                                    </footer>
                                    </blockquote>
                                </div>        
                            </div>
                            <script>
                                function updateBlockquote(){
                                    var value = document.getElementById('blockquote').innerHTML+"~"+document.getElementById('blockquotefooter').innerHTML;
                                    document.getElementById('blockquoteinput').value = value;
                                }
                            </script>
                            <div id="tabtwo" class="card-body tab" style="display:none">
                                
                                    {!! Form::open(['id'=>'editprofileform','action'=>'UsersController@store','enctype'=>'multipart/form-data','method'=>'POST']) !!}
                                        <div class="input-group">
                                        <input type="hidden" value="~" name="blockquote" id="blockquoteinput">
                                            <div class="input-group-prepend"><span class="input-group-text">Full Name</span></div><input name="fname" class="form-control" type="text" value="{{$users->fname}}" placeholder="First and middle name"><input value="{{$users->lname}}" class="form-control" type="text" name="lname" placeholder="Last name">
                                            <div class="input-group-append"></div>
                                        </div>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text">Email address</span></div><input name="email" class="form-control" type="text" value="{{$users->email}}" readonly>
                                            <div class="input-group-append"></div>
                                        </div>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text">Profile Image</span></div><input name="profilePic" onchange="document.getElementById('editprofileform').submit()" class="form-control" type="file" id="profilePic">
                                            <div class="input-group-append"></div>
                                        </div>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text">Contact</span></div><input name="mobile" class="form-control" type="text" placeholder="Mobile number" value="{{$users->mobile}}"><input class="form-control" type="text" value="{{$users->phone}}" placeholder="Optional number" name="phone">
                                            <div class="input-group-append"></div>
                                        </div>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text">Location<br></span></div><input class="form-control" type="text" id="location" readonly name="location" value="{{$users->location}}">
                                            <div class="input-group-append">
                                                <button class="btn btn-success" id="viewMap" type="button" style="width:44px;" onclick="loadMap(event)"><i class="fa fa-map-marker" style="font-size:21px;"></i></button>
                                            </div>
                                        </div>
                                        <div id="map-frame">
                                        <script src = "https://maps.googleapis.com/maps/api/js"></script>      
                                        <?php
                                            $latlng = explode("~",$users->location);
                                            $lat = $latlng[0];
                                            $lng = $latlng[1];
                                        ?>
                                        <script>
                                        var map, infoWindow;
                                        function loadMap(e) {
                                            e.preventDefault();
                                            var mapOptions = {
                                                center:{lat: {{$lat}}, lng: {{$lng}}},
                                                zoom:17
                                            }
                                            infoWindow = new google.maps.InfoWindow;
                                            map = new google.maps.Map(document.getElementById("sample"),mapOptions);
                                                infoWindow.setPosition({lat: {{$lat}}, lng: {{$lng}}});
                                                infoWindow.setContent('Set '+{{$lat}}+','+{{$lng}});
                                                infoWindow.open(map);
        
                                            if(document.getElementById('location').value == "27.0~85.0"){
                                                //geolocation
                                                if (navigator.geolocation) {
                                                    navigator.geolocation.getCurrentPosition(function(position) {
                                                        var pos = {
                                                        lat: position.coords.latitude,
                                                        lng: position.coords.longitude
                                                        };
                                                        infoWindow.setPosition(pos);
                                                        infoWindow.setContent('You are here');
                                                        infoWindow.open(map);
                                                        document.getElementById('location').value = pos.lat+"~"+pos.lng;
                                                        map.setCenter(pos);
                                                    }, function() {
                                                        handleLocationError(true, infoWindow, map.getCenter());
                                                    });
                                                } else {
                                                // Browser doesn't support Geolocation
                                                handleLocationError(false, infoWindow, map.getCenter());
                                                }
                                            }
        
                                            var marker = new google.maps.Marker({
                                                
                                                map: map,
                                                });
                                            map.addListener('click', function(a) {
                                                //alert(a.latLng.toUrlValue())
                                                document.getElementById('location').value =a.latLng.lat()+"~"+a.latLng.lng();
                                                var pos = {
                                                    lat: a.latLng.lat(),
                                                    lng: a.latLng.lng()
                                                    };
                                                window.setTimeout(function() {
                                                    map.panTo(a.latLng);
                                                    infoWindow.setPosition(pos);
                                                    infoWindow.setContent('Set '+pos.lat+','+pos.lng);
                                                    infoWindow.open(map);
                                                }, 1000);
                                                
                                            });  
                                    }
                                    function handleLocationError(browserHasGeolocation, infoWindow, pos) {
                                            infoWindow.setPosition(pos);
                                            infoWindow.setContent(browserHasGeolocation ?
                                                                'Error: The Geolocation service failed.' :
                                                                'Error: Your browser doesn\'t support geolocation.');
                                            infoWindow.open(map);
                                        }
                                    
                                       </script>
                                        
                                       <div id = "sample" class="w-25 h-25 mx-auto" style ="min-width:400px; min-height:400px;"></div>
                                    </div>
                        
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text">Skills</span></div><input class="form-control" id="skills" type="text">
                                            <div class="input-group-append">
                                                <button onclick="addCheckBox(event,document.getElementById('skills'))" class="btn btn-success" type="button" style="font-size:16px;">
                                                    <i class="fa fa-plus-circle" style="font-size:21px;"></i>
                                                </button>                                               
                                            </div>
                                        </div>
                                        <script>
                                                function addCheckBox(e,val){
                                                    e.preventDefault();
                                                    var div = document.createElement("div");
                                                        div.class = "form-check";
                                                    
                                                    var node = document.createElement("input");
                                                        node.class = "form-check-input";
                                                        node.type = "checkbox";
                                                        node.name = "skillrequired[]";
                                                        node.value = val.value;
                                                        node.checked = "checked"; 
                                                    
                                                    var label = document.createElement("label");
                                                        label.class = "form-check-label";
                                                        label.innerHTML = val.value;
                                                    
                                                    val.value="";
                                                
                                                    div.appendChild(node);
                                                    div.appendChild(label);
        
                                                    var element = document.getElementById('skillList');
                                                    
                                                    element.appendChild(div);
        
                                                }
                                            </script>
                                            <div id="skillList">
                                                    <?php 
                                                    echo $users->skills;
                                                        $skills = explode("~",$users->skills);
                                                    ?>
                                                    @foreach ($skills as $item)
                                                        <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" name="skillrequired[]" value="{{$item}}" checked>
                                                        <label class="form-check-label">{{$item}}</label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                        <div id='editprofilesubmitbtn' class="btn-group" role="group"><button class="btn btn-primary" type="submit">Edit Profile</button><button class="btn btn-primary" type="reset">Reset Profile</button></div>
                                    {!! Form::close() !!}
                                
                            </div>
                            <div id="tabthree" class="card-body tab" style="display:none">
                                
                                    <h1>Average performance (Good)</h1>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <caption>Achievements<br></caption>
                                            <thead>
                                                <tr>
                                                    <th>Job</th>
                                                    <th>Skill required</th>
                                                    <th>Rating</th>
                                                    <th>Details</th>
                                                </tr>
                                            </thead>
                                            <tbody><?php
                                                $summation = 0;
                                            ?>
                                                    @foreach ($tasks as $item)
                                                        
                                                        <tr>
                                                        <td>{{ $item->task->jobname }}</td>
                                                        <td>{{ str_replace('~',', ',$item->task->skillrequired) }}<br></td>
                                                        
                                                        <td><?php 
                                                       
                                                            $i=$item->rated;
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
        
                                                        <td><i class="fa fa-eye" style="font-size:21px;"></i></td>
                                                        </tr>
                                                    
        
                                                    @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td></td>
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
                                                    <td>{{ count($tasks) }} Jobs</td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                
                            </div>
                </div>
            </div>
        </div>
@endsection
