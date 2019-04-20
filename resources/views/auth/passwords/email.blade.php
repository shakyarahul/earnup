@extends('layouts.app')

@section('content')


        <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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
        </div>
    </div>
    @include('layouts.includes.tasklist')

@endsection
