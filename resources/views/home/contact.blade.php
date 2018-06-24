@extends('app')

@section('title', '- Contact')

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <h1>Contact
                <span class="flags">
                    <img src="{{ asset("images/flags/fr.png") }}"/>
                    <img src="{{ asset("images/flags/uk.png") }}"/>
                    <img src="{{ asset("images/flags/dl.png") }}"/>
                </span>
            </h1>

            <p>Vous pouvez aussi nous contacter par téléphone au <strong>{{ env("PHONE_LAETITIA") }}</strong> ou au <strong>{{ env("PHONE_FRANCOIS") }}</strong>.</p>

            @include("flash")

            {!! Form::open(array('url' => 'contact', 'method' => 'post')) !!}

            <div class="form-group">
                {!! Form::label('name', 'Votre nom') !!}
                {!! Form::text('name', $name, ['required' => 'required', 'class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('email', 'Votre email') !!}
                {!! Form::email('email', $email, ['required' => 'required', 'class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('subject', 'Sujet') !!}
                {!! Form::text('subject', null, ['required' => 'required', 'class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('message', 'Votre message') !!}
                {!! Form::textarea('message', null, ['required' => 'required', 'class' => 'form-control', 'rows' => '4']) !!}
            </div>

            {!! Form::submit('Envoyer', ['class' => 'btn btn-primary']) !!}

            {!! Form::close() !!}

        </div>
    </div>

@stop