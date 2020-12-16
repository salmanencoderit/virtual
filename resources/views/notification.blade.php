@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Notification - User wurde angelegt - Zugangsdaten') }}</div>

                <div class="card-body">
                  <br>
                  Vielen Dank für Ihre Registrierung zur {{ $messe }}. <br><br>
                  Sie befinden sich nun auf der Website der Virtual Wedding Expo!<br><br>
                  Diese Website soll Ihnen helfen - nach der {{ $messe }} - mit den Besuchern in Kontakt<br>
                  zu treten. Sie finden unten stehend Ihre LoginDaten:<br><br>
                  <hr>
                  Ihre E-Mail Adresse für das Login: {{ $user->email }}<br>
                  Ihr Passwort (Case-sensitive):     {{ $password }}<br>
                  <br>
                  <hr>
                  <br>
                  Ihr Namen: {{ $user->name }} {{ $user->lastname }}<br>
                  @if ($user->role === 1)

                  Rolle: Aussteller<br>

                  @endif
                  Ihre Firma: {{ $user->company }} - Branche: {{ $user->sector }}
                  <br><br>
                  Sie können gleich nach der Messe mit Ihren Kunden über diese Seite virtuel in Kontakt treten!<br>
                  <br>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
