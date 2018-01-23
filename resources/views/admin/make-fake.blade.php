@extends('app')

@section('content')

    {!! Form::open(['url' =>  url("/admin/reservation/make"), 'method' => 'post', 'id' => 'payment-form', 'class' => 'page-form']) !!}

    <div class="row">
        <div class="col-md-8">
            @include('flash')
            <div class="form-group">
                {!! Form::label('place', 'Lieu de réservation :') !!}
                <select class="form-control" id="place" name="place">
                    <option value="1">Chalet</option>
                    <option value="0" disabled>Extension (pas encore disponible)</option>
                </select>
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

    {!! Form::hidden('name', Auth::user()->name , ['required' => 'required']) !!}

    <div class="row">
        <div class="col-md-8">
            <button type="submit" class="btn btn-primary btn-block">Réserver pour <span id="price">0</span>€</button>
        </div>
        <div class="col-md-4">
            <div id="spinner"><img src="{!! asset('images/spinner.svg') !!}"></div>
        </div>
    </div>


    {!! Form::close() !!}


    <!-- Le script de gestion des dates est chargé afin d'utiliser le calendrier.
         Le script de paiement n'est pas chargé car on ne réalise aucun paiement ici.
         -->
    @include('reservation.script-date')


@endsection