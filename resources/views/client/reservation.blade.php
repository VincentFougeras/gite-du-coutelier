@extends('app')

@section('content')

    <a href="{{ url('/my/reservations') }}">Retour aux réservations</a>

    @include('flash')

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
            <th>Date de création de la réservation</th>
            <td>{{ $reservation->created_at }}</td>
        </tr>
    </table>

    <p>La réservation peut être annulée
        <a href="#" data-toggle="popover" data-content="<ul><li>2 semaines avant pour une semaine en pleine saison</li><li>1 semaine avant pour une semaine hors saison</li><li>1 jour avant pour un week-end</li></ul>">
            jusqu'à un certain temps</a> avant la date du séjour.</p>
    <p>Si vous annulez la réservation, la somme payée vous sera remboursée.</p>
    @if($is_cancellable)
        {!! Form::open(['method' => 'DELETE', 'url' => ['my/reservation', $reservation->id]]) !!}
        {!! Form::submit('Annuler la réservation', ['class' => 'btn btn-danger']) !!}
        {!! Form::close() !!}
    @endif

    <script>
        $(function () {
            $('[data-toggle="popover"]').popover({html : true, placement : 'top'});
        })
    </script>

@endsection