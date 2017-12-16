@extends('app')

@section('content')

    <?php $cpt = 0; ?>

    @include('flash')

    <table class="table table-hover">
        <tr><th>Date de début</th><th>Date de fin</th><th>Coût</th><th>Lieu</th><th>Nombre de résidents</th></tr>
    @foreach($reservations as $reservation)
        <tr class="reservation_tr" {!! $cpt == 0 ? 'data-toggle="tooltip" data-placement="bottom" title="Plus de détails"' : '' !!}>
            <td><a href="{{ url('/my/reservation/'. $reservation->id) }}"></a>{{ $reservation->beginning }}</td>
            <td>{{ $reservation->end }}</td>
            <td>{{ $reservation->amount / 100 }}€</td>
            <td>{{ $reservation->is_chalet ? "Le chalet" : "L'extension" }}</td>
            <td>{{ $reservation->number_of_people }}</td>
        </tr>
        <?php $cpt++; ?>
    @endforeach
    </table>

    <script>
        $(function () {
            var first_reservation = $('[data-toggle="tooltip"]');
            first_reservation.tooltip().trigger('manual');
            first_reservation.tooltip('show');
            setTimeout(function(){
                first_reservation.tooltip('hide');
                first_reservation.tooltip('destroy');
            }, 2500);

        });
        $(document).ready(function(){
            $('.reservation_tr').click(function(){
                window.location.href = $(this).find('a').prop('href');
            });
        });
    </script>

@endsection
