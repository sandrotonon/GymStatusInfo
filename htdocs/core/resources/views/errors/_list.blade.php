@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Fehler!</strong> Bitte überprüfen Sie Ihre Eingaben.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif