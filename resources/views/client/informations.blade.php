@extends('app')

@section('content')

    <h3>Mon compte</h3>

    @include('flash')

    {!! Form::model($user, array('url' => 'my/informations', 'method' => 'put')) !!}

    <div class="form-group" id="address-group">
        {!! Form::label('name', 'Nom :') !!}
        {!! Form::text('name', null, ['class' => 'form-control','placeholder' => 'Jean Dupont','required' => 'required']) !!}
    </div>

    <div class="form-group" id="address-group">
        {!! Form::label('address', 'Adresse :') !!}
        {!! Form::text('address', null, ['class' => 'form-control','placeholder' => '1 rue des Champs-Elysées','required' => 'required']) !!}
    </div>

    <div class="form-group" id="email-group">
        {!! Form::label('email', 'Adresse e-mail :') !!}
        {!! Form::email('email', null, ['class' => 'form-control','placeholder' => 'jean.dupont@gmail.com','required' => 'required']) !!}
    </div>

    <div class="form-group">
        <label for="password">Mot de passe :</label>
        <input name="password" type="password" class="form-control" required="required">
    </div>

    <div class="form-group">
        <label for="password_confirmation">Confirmer le mot de passe :</label>
        <input name="password_confirmation" type="password" class="form-control" required="required">
    </div>

    <div>{!! Form::submit('Modifier des informations', ['class' => 'btn btn-primary']) !!}</div>

    {!! Form::close() !!}

@endsection
