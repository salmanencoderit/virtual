@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    {{-- @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif --}}

                    {{-- {{ __('You are logged in!') }} --}}
                    <form action="{{ url('/user/store-avatar') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="form-group">
                              <label for="exampleFormControlFile1">Add User avatar</label>
                              <input type="file" name="avatar" class="form-control-file" id="exampleFormControlFile1">
                            </div>
                            <button type="submit" class="btn btn-primary">Upload</button>
                    </form>
                    {{-- {!! Form::open(['url' => 'room/create']) !!}
                    {!! Form::label('roomName', 'Create or Join a Video Chat Room') !!}
                    {!! Form::text('roomName') !!}
                    {!! Form::submit('Go') !!}
                    {!! Form::close() !!} --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
