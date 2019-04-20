<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('fonts/font-awesome.min.css') }}" rel="stylesheet">
     <!-- Scripts -->
     <script src="{{ asset('js/jquery.min.js') }}" defer></script>
</head>
<body>
        <div class="container">
            <nav class="navbar navbar-light navbar-expand-md">
                    <div class="container-fluid"><a class="navbar-brand" href="{{ url('/') }}">Earn Up</a><button class="navbar-toggler" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
                        <div class="collapse navbar-collapse"
                            id="navcol-1">
                            <ul class="nav navbar-nav">
                                <li class="nav-item" role="presentation"><a class="nav-link active" href="#">ABOUT US</a></li>
                                <li class="nav-item" role="presentation"><a class="nav-link active" href="#">CONTACT US</a></li>
                            </ul>
                        </div>
                    </div>
                </nav>
                
                <div class="row" id="side-navbar" style="display: none">
                        <div class="col col-md-10" style="background-color:#eea6b4;">
                            <div class="card"><img onclick="showHideToggler(event,'side-navbar')" class="card-img-top w-100 d-block" src="{{ asset('img/logo.jpg') }}">
                                <div class="card-body" style="padding:10px;background-color:#ffa7b0;margin:-1px;">
                                    
                                @guest
                                <form class="form-horizontal"  method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text" style="padding:5px;"><i class="fa fa-user" style="font-size:24px;"></i></span></div><input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus type="email" >                                    
                                            <div class="input-group-append"></div>                                    
                                        </div>
                                        @if ($errors->has('email'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                        @endif
                                        
                                        
        
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text" style="padding:5px;"><i class="fa fa-key" style="font-size:17px;"></i></span></div><input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required type="text">
                                            <div class="input-group-append"><button class="btn btn-success" type="submit"><i class="fa fa-sign-in" style="font-size:21px;"></i></button></div>
                                        </div>
        
                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
        
                                        <div class="form-group">
                                            <div class="col-md-8 offset-md-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                
                                                    <label class="form-check-label" for="remember">
                                                        {{ __('Remember Me') }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    @if (Route::has('password.request'))
                                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                                {{ __('Forgot Your Password?') }}
                                            </a>
                                    @endif
                                    @if (Route::has('register'))
                                    <ul class="list-group">
                                        <a href="{{ route('register') }}" style="text-decoration: none;color: black"><li class="list-group-item" style="margin:0px 0px 10px;background-color:#d29ea8;">
                                            <span>REGISTER</span><i class="fa fa-user-plus float-right" style="font-size:23px;"></i>
                                        </li></a>
                                    </ul>
                                    @endif
                                @else
                                {{ Auth::user()->name }}<hr>
                                    <ul class="list-group">
                                        <a style="text-decoration: none;color: black" href="{{ url('users/'.auth()->user()->id.'/edit') }}" ><li class="list-group-item" style="margin:0px 0px 10px;background-color:#d29ea8;"><span>VIEW PROFILE</span><i class="fa fa-home float-right" style="font-size:23px;"></i></li></a>
                                    <a style="text-decoration: none;color: black" href="{{url('users/'.auth()->user()->id.'/edit')}}" ><li class="list-group-item" style="margin:0px 0px 10px;background-color:#d29ea8;"><span>EDIT PROFILE</span><i class="fa fa-home float-right" style="font-size:23px;"></i></li></a>
                                    <a style="text-decoration: none;color: black" href="{{url('ratings')}}" ><li class="list-group-item" style="margin:0px 0px 10px;background-color:#d29ea8;"><span>ADD TASK</span><i class="fa fa-plus-square float-right" style="font-size:23px;"></i></li></a>
                                        <a style="text-decoration: none;color: black" href="{{url('ratings')}}" ><li class="list-group-item" style="margin:0px 0px 10px;background-color:#d29ea8;"><span>VIEW TASK</span><i class="fa fa-tasks float-right" style="font-size:23px;"></i></li></a>
                                        <a style="text-decoration: none;color: black" href="{{url('messages')}}" ><li class="list-group-item" style="margin:0px 0px 10px;background-color:#d29ea8;"><span>MESSAGES</span><i class="fa fa-tasks float-right" style="font-size:23px;"></i></li></a>
                                        <a style="text-decoration: none;color: black" href="{{ route('logout') }}"
                                                onclick="event.preventDefault();
                                                              document.getElementById('logout-form').submit();"><li class="list-group-item" style="margin:0px 0px 10px;background-color:#d29ea8;"><span>
                                                 {{ __('LOGOUT') }}
                                        </span><i class="fa fa-sign-out float-right" style="font-size:23px;"></i></li></a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                @csrf
                                        </form>  
                                    </ul>
                                @endguest
                                </div>
                            </div>
                            <ul class="list-group">
                                <a style="text-decoration: none;color: black" href="{{ url('/') }}"><li class="list-group-item" style="margin:0px 0px 10px;background-color:#d29ea8;"><span>HOME</span><i class="fa fa-home float-right" style="font-size:23px;"></i></li></a>
                                <li class="list-group-item" style="margin:0px 0px 10px;background-color:#d29ea8;"><span>CONTRIBUTION</span></li>
                            </ul>
                        </div>
                        
                </div>
                
                
        
                        <div class="row">
                                <div class="col" style="background-color:#ffa7b0;">
                                        <div class="row">
                                                <div class="col"><a onclick="showHideToggler(event,'side-navbar')" href="#" style="font-size:38px;color:#000000;float: right;"><i class="fa fa-th-list" style="color:#909fa9;padding:5px;"></i></a></div>
                                            </div>
                                        @include('layouts.includes.message')
                                    @yield('content')
                                <div class="row"><div class="col align-content-center">
                                    Copyright &COPY;2018
                                </div>          
                            </div>
                        </div>
                   
                 </div>
            </div>
            <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/holder/2.4.1/holder.js"></script>
            <!-- Scripts -->
            <script src="{{ asset('js/jquery.min.js') }}" defer></script>
            <!-- Scripts -->
            <script src="{{ asset('js/script.js') }}" defer></script>
            
            <script src = "/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
            <script>
            CKEDITOR.replace('article-ckeditor');
            </script>
</body>
</html>
