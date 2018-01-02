@extends('app')

@section('content')
    <?php
        if(Auth::check()){
            $postUrl = url("/reservation/logged-charge");
        }
        else {
            $postUrl = url("/reservation/charge");
        }
    ?>

    {!! Form::open(['url' =>  $postUrl, 'id' => 'payment-form', 'files' => true, 'class' => 'page-form']) !!}

    <div class="row">
        <div class="col-md-8">

            @include('flash')
            <div class="form-group">
                {!! Form::label('place', 'Lieu de réservation :') !!}
                {!! Form::select('place', array(1 => 'Chalet', 0 => 'Extension'), null, ['class' => 'form-control', 'id' => 'place']) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            {!! Form::label('dates', 'Dates de réservation:') !!}
            <div class="row" id="dates">
                <div class='col-sm-6'>
                    <div class="form-group">
                        <div class='input-group date' id='begin_group'>
                            <input type='text' class="form-control" placeholder="Début" required id="begin_date" name="beginning"/>
                            <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
                        </div>
                    </div>
                </div>
                <div class='col-sm-6'>
                    <div class="form-group">
                        <div class='input-group date' id='end_group'>
                            <input type='text' class="form-control" placeholder="Fin" required id="end_date" name="end"/>
                            <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="alert alert-info"><strong>Comment choisir ses dates</strong>
                <ul>
                    <li>Par défaut : <strong>du lundi au dimanche (6 nuits)</strong> renouvelable sur plusieurs semaines</li>
                    <li>En hiver (semaines 39 à 18), dans le chalet uniquement : <strong>du vendredi au dimanche (2 nuits)</strong></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="form-group" id="address-group">
                {!! Form::label('nb_people', 'Nombre de personnes :') !!}
                <select class="form-control" id="nb_people" name="nb_people">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option class="nb_people_extension" value="5">5</option>
                    <option class="nb_people_extension" value="6">6</option>
                </select>
            </div>
        </div>
    </div>

    @if(Auth::check())
        {!! Form::hidden('name', Auth::user()->name , ['required' => 'required']) !!}
    @else
        <div class="row">
            <div class="col-md-8">

                <div class="form-group" id="address-group">
                    {!! Form::label('name', 'Nom :') !!}
                    {!! Form::text('name', null, ['class' => 'form-control','placeholder' => 'Jean Dupont','required' => 'required']) !!}
                </div>

                <div class="form-group" id="address-group">
                    {!! Form::label('address', 'Adresse :') !!}
                    {!! Form::text('address', null, ['class' => 'form-control','placeholder' => '1 rue des Champs-Elysées','required' => 'required']) !!}
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-md-8">

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

            </div>
            <div class="col-md-4">
                <div class="alert alert-info">L'adresse e-mail et le mot de passe servent à vous enregistrer sur le site.
                    Vous pourrez ensuite vous connecter pour accéder à vos réservations ou pour écrire sur le livre d'or.
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label for="id_scan">Scan d'une pièce d'identité
                        <span class="text-muted">(Formats acceptés : JPEG, PNG. Taille maximale : 5 Mo)</span></label>
                    {!! Form::file('id_scan', ['accept' => 'image/*','required' => 'required']) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="alert alert-info">La pièce d'identité est utilisée pour éviter les risques de fraude.
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-md-8">

            <div class="form-group">
                <label for="card-element">Informations de paiement</label>
                <div id="card-element" class="field"></div>
            </div>
            <div class="outcome">
                <div class="error"></div>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <button type="submit" class="btn btn-primary btn-block">Réserver pour <span id="price">0</span>€</button>
        </div>
        <div class="col-md-4">
            <div id="spinner"><img src="{!! asset('images/spinner.svg') !!}"></div>
        </div>
    </div>


    {!! Form::close() !!}


    @include('reservation.script-date')
    @include('reservation.script-payment')


@endsection