@extends('layouts.app')

@section('content')

                        <div class="col col-md-4" style="background-color:#ffa7b0;">
                            <div class="row">
                                <div class="col"><a onclick="showHideToggler(event,'side-navbar')" href="#" style="font-size:38px;color:#000000;float: right;"><i class="fa fa-th-list" style="color:#909fa9;padding:5px;"></i></a></div>
                            </div>
                            <div class="row">
                                <div class="col" style="padding:25px;">
                                    <div class="row">
                                        <div class="col" style="padding:5px;">
                                                <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text" style="padding:5px;"><i class="fa fa-search" style="font-size:24px;"></i></span></div><input class="form-control" type="text">
                                                <div class="input-group-append"><span onclick="showHideToggler(event,'jobs-filter')" class="input-group-text" style="padding:5px;"><i class="fa fa-filter" style="font-size:24px;"></i></span></div>
                                                </div>                            
                                                <div class="row" >
                                                    <div id="jobs-filter" style="display:none">
                                                    <div class="col">
                                                        <form style="background-color:#eea6b4;padding:15px;" >
                                                            <div class="col">
                                                                <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text" style="padding:5px;">Type</span></div><input class="form-control" type="text">
                                                <div class="input-group-append"></div>
                                                </div>   
                                                            </div>
                                                            <div class="col"><label class="col-form-label">&nbsp;Baby Sitting&nbsp;<i class="fa fa-times"></i></label><label class="col-form-label">&nbsp;Hair dresser&nbsp;<i class="fa fa-times"></i></label><label class="col-form-label">&nbsp;Car washer&nbsp;<i class="fa fa-times"></i></label></div>
                                                            <div
                                                                class="col"><div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text" style="padding:5px;">Pay</span></div><input class="form-control" placeholder="Min" type="text"><input class="form-control" placeholder="Max" type="text">
                                                <div class="input-group-append"></div>
                                                </div>   </div>
                                                    <div class="col">
                                                        <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text" style="padding:5px;">Location</span></div><input class="form-control" type="text">
                                                <div class="input-group-append"></div>
                                                </div>
                                                    </div>
                                                    <div class="col"><label class="col-form-label">&nbsp;Patan&nbsp;<i class="fa fa-times"></i></label><label class="col-form-label">&nbsp;Baneshwor&nbsp;<i class="fa fa-times"></i></label></div>
                                                    </form>
                                                </div>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                
                                @include('layouts.includes.tasklist')
                            </div>
                        </div>
                        
                        
@endsection
