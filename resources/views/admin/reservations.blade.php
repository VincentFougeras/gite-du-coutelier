@extends('app')

@section('content')

    <p class="top-margin"><a href="{{ url('admin/reservation/make') }}">Faire une fausse réservation</a></p>

    <table class="table table-hover">
        <tr><th>Date de début</th><th>Date de fin</th><th>Coût</th><th>Lieu</th><th>Nb. de résidents</th><th>Utilisateur</th></tr>
    @foreach($reservations as $reservation)
        <tr class="reservation_tr {!! $reservation->trashed() ? 'reservation_annulee"' : ''  !!} {!! $reservation->number_of_people === 0 ? 'reservation_fake"' : ''  !!}">
            <td><a href="{{ url('admin/reservation/'.$reservation->id) }}"></a>{{ $reservation->beginning }}</td>
            <td>{{ $reservation->end }}</td>
            <td>{{ $reservation->amount / 100 }}€</td>
            <td>{{ $reservation->is_chalet ? "Chalet 1" : "Chalet 2" }}</td>
            <td>{{ $reservation->number_of_people }}</td>
            <td>{{ $reservation->user->name }}</td>
        </tr>
    @endforeach
    </table>

    <!-- Pagination (10 items per page) -->
    {{ $reservations->links() }}

    <script>
        $(document).ready(function(){
            $('.reservation_tr').click(function(){
                window.location.href = $(this).find('a').prop('href');
            });
        });
    </script>

@endsection