@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Notification - User wurde angelegt') }}</div>

                <div class="card-body">

                Ihre E-Mail Adresse für das Login: {{ $email }}<br>
                Ihr Passwort (Case-sensitive):     {{ $password }}<br>
                <br>
                <hr>
                <br>
                Ihr Namen: {{ $name }} {{ $lastname }}<br>
                Ihre Firma: {{ $company }} - Branche: {{ $sector }}
                <br><br>
                Sie können gleich nach der Messe mit Ihren Kunden über diese Seite kommunizieren!<br>
                <br>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
