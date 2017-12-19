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

    <div class="row">
        <div class="col-md-6">
            {!! Form::open(['url' =>  $postUrl, 'id' => 'payment-form', 'files' => true]) !!}
            @include('flash')
            <div class="form-group">
                {!! Form::label('place', 'Lieu de réservation :') !!}
                {!! Form::select('place', array(1 => 'Chalet', 0 => 'Extension'), null, ['class' => 'form-control', 'id' => 'place']) !!}
            </div>
            <p>Réservations : du lundi au dimanche (6 nuits) renouvelable sur plusieurs semaines, ou du vendredi au dimanche (2 nuits)</p>
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

            @if(Auth::check())
                {!! Form::hidden('name', Auth::user()->name , ['required' => 'required']) !!}
            @else
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

                <div class="form-group">
                    <label for="id_scan">Scan d'une pièce d'identité
                        <span data-toggle="tooltip" title="La pièce d'identité est utilisée pour éviter les fraudes de carte de crédit">&#10067;</span><br/>
                        <span class="text-muted">(Formats acceptés : JPEG, PNG. Taille maximale : 5 Mo)</span></label>
                    {!! Form::file('id_scan', ['accept' => 'image/*','required' => 'required']) !!}
                </div>
            @endif

            <div class="form-group">
                <label for="card-element">Informations de paiement</label>
                <div id="card-element" class="field"></div>
            </div>
            <div class="outcome">
                <div class="error"></div>
            </div>

            <button type="submit" class="btn btn-primary">Réserver pour <span id="price">0</span>€</button>


            {!! Form::close() !!}
        </div>
    </div>


    @include('reservation.script-date')
    @include('reservation.script-payment')


@endsection