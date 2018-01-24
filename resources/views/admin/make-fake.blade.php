@extends('app')

@section('content')

    {!! Form::open(['url' =>  url("/admin/reservation/make"), 'method' => 'post', 'id' => 'payment-form', 'class' => 'page-form']) !!}

    @include('reservation.place-and-dates')

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