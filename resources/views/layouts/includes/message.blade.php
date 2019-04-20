<div class="row">
    <div class="col">
            @if(count($errors)>0)
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                            {{$error}}
                    </div>
                @endforeach
            @endIf
            @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <button type="b utton" class="close" data-dismiss="alert">&times;</button>
                        {{session('success')}}
                    </div>
            @endIf
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    {{session('error')}}
                </div>
            @endIf
            @if(isset($success) && !empty($success))
                <div class="alert alert-success alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    {{$success}}
                </div>
            @endIf
    </div>
</div>