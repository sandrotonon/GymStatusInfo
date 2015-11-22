@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Ups!</strong> Das Formular wurde nicht korrekt ausgefüllt.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif