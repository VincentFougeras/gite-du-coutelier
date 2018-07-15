@extends('app')


@section('content')
    @include('flash')

    <h2>La réservation a été effectuée !</h2>

    <div class="row">
        <div class="col-md-6">
            <p>{{ $reservation->user->name }}, vous avez effectué une réservation dans {{($reservation->is_chalet ? 'le Chalet 1' : 'le Chalet 2')}}.</p>
            <p>Vous pouvez désormais
                <a href="{{ url('/my/reservations') }}" target="_blank">accéder aux détails de votre réservation</a>,
                <a href="{{ url('/contact') }}" target="_blank">nous contacter</a>, ou
                <a href="{{ url('/visitors-book') }}" target="_blank">écrire sur le livre d'or après votre séjour</a>.</p>
        </div>
        <div class="col-md-6">
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
                    <td>{{ $reservation->is_chalet ? "Chalet 1" : "Chalet 2" }}</td>
                </tr>
                <tr>
                    <th>Nb. de résidents</th>
                    <td>{{ $reservation->number_of_people }}</td>
                </tr>
            </table>
        </div>
    </div>

@endsection
