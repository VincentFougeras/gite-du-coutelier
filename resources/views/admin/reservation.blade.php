@extends('app')

@section('content')

    <a  href="{{ url('/admin/reservations') }}">
        <span class="glyphicon glyphicon-arrow-left top-margin" aria-hidden="true"></span>
        Retour aux réservations</a>

    @if($reservation->trashed())
        <h3 class="text-danger">Réservation annulée.</h3>
    @endif

    <h3>Détails de la réservation</h3>
    <table class="table">
        <tr>
            <th>Date de début</th>
            <td>{{ $reservation->beginning }}</td>
        </tr>
        <tr>
            <th>Date de fin</th>
            <td>{{ $reservation->end }}</td>
        </tr>
        <tr>
            <th>Coût</th>
            <td>{{ $reservation->amount / 100 }}€</td>
        </tr>
        <tr>
            <th>Lieu</th>
            <td>{{ $reservation->is_chalet ? "Le chalet" : "L'extension" }}</td>
        </tr>
        <tr>
            <th>Nb. de résidents</th>
            <td>{{ $reservation->number_of_people }}</td>
        </tr>
        <tr>
            <th>ID de la transaction Stripe</th>
            <td>{{ $reservation->stripe_transaction_id }}</td>
        </tr>
        <tr>
            <th>Date de création de la réservation</th>
            <td>{{ $reservation->created_at }}</td>
        </tr>
    </table>

    <h3>Détails du client</h3>
    <table class="table">
        <tr>
            <th>Nom</th>
            <td>{{ $reservation->user->name }}</td>
        </tr>
        <tr>
            <th>Adresse email</th>
            <td>{{ $reservation->user->email }}</td>
        </tr>
        <tr>
            <th>Adresse</th>
            <td>{{ $reservation->user->address }}</td>
        </tr>
        <tr>
            <th>Photo de la carte d'identité</th>
            <td><div class="img-thumbnail"><a href="{!! asset('images/id_scan/'.$reservation->user->id_scan) !!}">
                        <img src="{!! asset('images/id_scan/'.$reservation->user->id_scan) !!}" alt="ID scan"/>
                </a></div>
            </td>
        </tr>
        <tr>
            <th>ID du client Stripe (de la dernière réservation)</th>
            <td>{{ $reservation->user->stripe_customer_id }}</td>
        </tr>
        <tr>
            <th>Date de création du compte</th>
            <td>{{ $reservation->user->created_at }}</td>
        </tr>
        <tr>
            <th>Nombre de réservations</th>
            <td>{{ count($reservation->user->reservations) }}</td>
        </tr>

    </table>

@endsection