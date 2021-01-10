<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>WeddingExpo: Virtual Meeting Rooms</title>

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
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
            .card-img img{
                max-width: 100%;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        @if(Auth::user()->role == 1)
                        <a href="{{ url('room/my-room') }}">My Room</a>
                        @elseif(Auth::user()->role == 2)
                            <a href="{{ url('user-list') }}">Users</a>
                        @endif
                        <a href="{{ url('logout') }}">Logout</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endauth
                </div>
            @endif
          <div class="container">
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="card">
                        <div class="card-header">
                            User List
                        </div>
                        <div class="card-body">
                            @if(Session::has('success'))
                                <div class="alert alert-success alert-dismissible">
                                    <strong>Success!</strong> {{ Session::get('success') }}
                                </div>
                            @endif
                            <form action="{{ url('assign-exhibitor') }}" method="POST" class="form-horizontal">
                                @csrf
                                @foreach($users as $user)
                                    @if($user->role != 2)
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" name="user_id[{{ $user->id }}]" class="form-check-input" value="1" {{ ($user->role == 1) ? 'checked' : '' }}>{{ $user->name.' '.$user->lastname }}
                                        </label>
                                    </div>
                                    @endif
                                @endforeach

                                <div class="form-group pt-1">
                                    <button class="btn btn-success mx-auto d-flex">Assign</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
    </body>
</html>
