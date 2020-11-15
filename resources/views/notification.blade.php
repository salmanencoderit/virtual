@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Notification - User wurde angelegt - Zugangsdaten - Rolle: {{ $role }}') }}</div>

                <div class="card-body">
                  <br>
                  Vielen Dank für Ihre Registrierung zur Virtual Wedding Expo!<br><br>
                  Diese Website soll Ihnen helfen - nach der Hochzeitsmesse - mit den Besuchern in Kontakt<br>
                  zu treten. Sie finden unten stehend Ihre LoginDaten:<br><br>
                  Ihre E-Mail Adresse für das Login: {{ $email }}<br>
                  Ihr Passwort (Case-sensitive):     {{ $password }}<br>
                  <br>
                  <hr>
                  <br>
                  Ihr Namen: {{ $name }} {{ $lastname }}<br>
                  Ihre Firma: {{ $company }} - Branche: {{ $sector }}
                  <br><br>
                  Sie können gleich nach der Messe mit Ihren Kunden über diese Seite virtuel in Kontakt treten!<br>
                  <br>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
