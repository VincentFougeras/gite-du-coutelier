@extends('app')

@section('content')

    <table class="table table-hover">
        <tr><th>Date de début</th><th>Date de fin</th><th>Coût</th><th>Lieu</th><th>Nb. de résidents</th><th>Utilisateur</th></tr>
    @foreach($reservations as $reservation)
        <tr {!! $reservation->trashed() ? 'class="reservation_tr reservation_annulee"' : 'class="reservation_tr"'  !!}>
            <td><a href="{{ url('admin/reservation/'.$reservation->id) }}"></a>{{ $reservation->beginning }}</td>
            <td>{{ $reservation->end }}</td>
            <td>{{ $reservation->amount / 100 }}€</td>
            <td>{{ $reservation->is_chalet ? "Le chalet" : "L'extension" }}</td>
            <td>{{ $reservation->number_of_people }}</td>
            <td>{{ $reservation->user->name }}</td>
            <td>
            </td>
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