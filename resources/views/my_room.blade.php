@extends('layouts.app')

@section('content')
<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Virtual Wedding Expo</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

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

            /* Rounded sliders */
            .slider.round {
            border-radius: 34px;
            }

            .slider.round:before {
            border-radius: 50%;
            }
        </style>

        <!-- Scripts -->
        <script src="//media.twiliocdn.com/sdk/js/video/v1/twilio-video.min.js"></script>
        <script>
            Twilio.Video.createLocalTracks({
                audio: true,
                video: { width: 300 }
            }).then(function(localTracks) {
                return Twilio.Video.connect('{{ $accessToken }}', {
                    name: '{{ $roomName }}',
                    tracks: localTracks,
                    video: { width: 300 }
                });
            }).then(function(room) {
                console.log('Successfully joined a Room: ', room.name);

                room.participants.forEach(participantConnected);

                var previewContainer = document.getElementById(room.localParticipant.sid);
                if (!previewContainer || !previewContainer.querySelector('video')) {
                    participantConnected(room.localParticipant);
                }

                room.on('participantConnected', function(participant) {
                    console.log("Joining: '" + participant.identity + "'");
                    participantConnected(participant);
                });

                room.on('participantDisconnected', function(participant) {
                    console.log("Disconnected: '" + participant.identity + "'");
                    participantDisconnected(participant);
                });
            });

            function participantConnected(participant) {
                console.log('Participant "%s" connected', participant.identity);

                const div = document.createElement('div');
                div.id = participant.sid;
                div.setAttribute("style", "float: left; margin: 10px;");
                div.innerHTML = "<div style='clear:both'>"+participant.identity+"</div>";

                participant.tracks.forEach(function(track) {
                    trackAdded(div, track)
                });

                participant.on('trackAdded', function(track) {
                    trackAdded(div, track)
                });
                participant.on('trackRemoved', trackRemoved);

                document.getElementById('media-div').appendChild(div);
            }

            function participantDisconnected(participant) {
                console.log('Participant "%s" disconnected', participant.identity);

                participant.tracks.forEach(trackRemoved);
                document.getElementById(participant.sid).remove();
            }

            function trackAdded(div, track) {
                div.appendChild(track.attach());
                var video = div.getElementsByTagName("video")[0];
                if (video) {
                    video.setAttribute("style", "max-width:300px;");
                }
            }

            function trackRemoved(track) {
                track.detach().forEach( function(element) { element.remove() });
            }

            function partcipantLeave(){
                Twilio.Video.connect('{{ $accessToken }}', {
                    name: '{{ $roomName }}',
                }).then(function(room) {
                    room.on('participantDisconnected', function(participant) {
                        console.log("Disconnected: '" + participant.identity + "'");
                        participantDisconnected(participant);
                    });
                    room.disconnect();
                    location.href= "{{ env('APP_URL') }}";
                })
            }
        </script>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endauth
                </div>
            @endif

            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('room/my-room/close') }}">Close My Room</a>
                        <label class="switch">
                            @if(Auth::user()->role == 1 && Auth::user()->online == 1)
                                <input type="checkbox" class="online" value="0" checked>
                            @else
                                <input type="checkbox" class="online" value="1">
                            @endif
                            <span class="slider round"></span>
                        </label>
                        <a href="{{ url('logout') }}">Logout</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endauth
                </div>
            @endif
            <div class="content">
                <div class="title m-b-md">
                    Virtual Wedding Expo
                </div>

                <div id="media-div">

                </div>
            </div>
        </div>
        <!-- jQuery library -->
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
                                    partcipantLeave();
                                }

                            }
                        });

                });
        </script>
    </body>
</html>
