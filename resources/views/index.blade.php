<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>WeddingExpo: Virtual Meeting Rooms</title>
        <!-- Fonts -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('default/css/style.css') }}" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

        <!-- Styles -->
        <style>
             /* html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
<<<<<<< Updated upstream

=======
>>>>>>> Stashed changes
            .card-img img{
                max-width: 100%;
            }

            .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
            }

            .switch input {
            opacity: 0;
            width: 0;
            height: 0;
            }

            .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
            }

            .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
            }

            input:checked + .slider {
            background-color: #2196F3;
            }

            input:focus + .slider {
            box-shadow: 0 0 1px #2196F3;
            }

            input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
            } 
            .slider.round {
            border-radius: 34px;
            }

            .slider.round:before {
            border-radius: 50%;
            }  */
        </style>
    </head>
    <body>
        <nav class="navbar navbar-expand-md navbar-light shadow-sm">
            <div class="container">
                <div class="mx-auto">
                    <a href="{{ url('/home') }}" class="navbar-left">
                        <img class="w-100 logo" src="{{ asset('Logo_150.png') }}">
                    </a>
                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">

                    </ul>
                    <ul class="navbar-nav navbar-nav-small">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('messages') }}">Messages</a>
                            </li>

                            @if(Auth::user()->role == 1)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('room/my-room') }}">My Room</a>
                            </li>
                            <label class="switch">
                                @if(Auth::user()->role == 1 && Auth::user()->online == 1)
                                    <input type="checkbox" class="online" value="0" checked>
                                @else
                                    <input type="checkbox" class="online" value="1">
                                @endif
                                <span class="slider round"></span>
                            </label>
                            @elseif(Auth::user()->role == 2)
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('user-list') }}">Users</a>
                                </li>
                            @endif
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <div class="flex-center pt-5 pb-5">
            {{-- @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('messages') }}">Messages</a>
                        @if(Auth::user()->role == 1)
                        <a href="{{ url('room/my-room') }}">My Room</a>
                        <label class="switch">
                            @if(Auth::user()->role == 1 && Auth::user()->online == 1)
                                <input type="checkbox" class="online" value="0" checked>
                            @else
                                <input type="checkbox" class="online" value="1">
                            @endif
                            <span class="slider round"></span>
                        </label>
                        @elseif(Auth::user()->role == 2)
                            <a href="{{ url('user-list') }}">Users</a>
                        @endif
                        <a href="{{ url('logout') }}">Logout</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endauth
                </div>
            @endif --}}

            

          <div class="container">
            <div class="content">
                <div class="title m-b-md">
                    WeddingExpo: Virtual Meeting Rooms
                </div>
                {{-- <div class="row">
                    @if($rooms)
                    @foreach ($rooms as $room)
                    @if ($room != null)
                    <div class="col-md-3">
                        <a href="{{ url('/room/join/'.$room['room']) }}">
                            <div class="card">
                                <div class="card-img">
                                @if ($room['avatar'] != null)

                                    <img class="card-img-top w-100" src="{{ URL::to('/storage/'.$room['avatar']) }}" alt="User Image">
                                @else
                                    <img class="card-img-top w-100" src="{{ URL::to('/storage/avatar/user.png') }}" alt="User Image">
                                @endif
                                </div>
                                <div class="card-body">
                                    {{ $room['name'] }}
                                </div>
                            </div>
                        </a>
                    </div>
                    @endif
                    @endforeach
                    @endif
                </div> --}}

                <div class="row">
                    @if($rooms)
                        @foreach ($rooms as $room)
                            @if ($room != null)
                                <div class="col-md-3 col-sm-6 col-12 ent-card-padding">
                                    <div class="card">
                                        <div class="database">
                                            @if($room['avatar'] != null)
                                                <img class="card-img-top" src="{{ asset('/storage/'.$room['avatar']) }}" alt="Card image">
                                            @else
                                                <img class="card-img-top" src="{{ asset('default/image/user-avatar.png') }}" alt="Card image">
                                            @endif
                                            @if($room['is_online'] == "0")
                                                <i class="fa fa-circle text-danger"></i>
                                            @else
                                                <i class="fa fa-circle text-success"></i>
                                            @endif
                                        </div>
                                        <div class="card-body">
                                        <h4 class="card-title">{{ $room['name'] }}</h4>
                                        <p class="card-text">{{ $room['sector'] }}</p>
                                        <p class="card-text">{{ $room['company'] }}</p>
                                        <a href="{{ url('/room/join/'.$room['room']) }}" class="btn btn-primary">Join</a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>

            </div>
          </div>

        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>

                $(document).on('click', ".online", function() {
                    var online = $(this).val();

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: "{{ url('status-update') }}",
                            type: "POST",
                            data:{
                                online:online
                            },
                            success: function(result) {
                                if(result.status == 'success'){
                                    var main_url = "{{ env('APP_URL') }}";
                                    location.href= main_url+'/room/my-room';
                                }

                            }
                        });

                });
        </script>
    </body>
</html>
