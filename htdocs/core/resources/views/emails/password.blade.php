Hallo, {{$user->username}}
<br>
<br>
Klicken Sie hier um Ihr Passwort zurückzusetzen: <a title="Passwort zurücksetzen" target="_blank" href="{{ url('password/reset/' . $token) }}">{{ url('password/reset/' . $token) }}</a>