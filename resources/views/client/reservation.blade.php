@extends('app')

@section('content')

    <a  href="{{ url('/my/reservations') }}">
        <span class="glyphicon glyphicon-arrow-left top-margin" aria-hidden="true"></span>
        Retour aux réservations</a>

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
            <td>{{ $reservation->is_chalet ? "Chalet 1" : "Chalet 2" }}</td>
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

    <p>La réservation peut être annulée tant que le nombre de jours avant la date du séjour est supérieur à la durée du séjour.</p>
    <p>Si vous annulez la réservation, la somme payée vous sera remboursée.</p>
    @if($is_cancellable)
        {!! Form::open(['method' => 'DELETE', 'url' => ['my/reservation', $reservation->id]]) !!}
        {!! Form::submit('Annuler la réservation', ['class' => 'btn btn-danger', 'id' => 'delete-btn']) !!}
        {!! Form::close() !!}
    @endif

    <div style="display: none;" id="dialog-confirm" title="Annuler la réservation ?">
        <p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>Etes vous sûr de vouloir annuler votre réservation ?</p>
    </div>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script>
        $(document).ready(function() {

            $("#dialog-confirm").dialog({
                autoOpen: false,
                modal: true
            });

            $("#delete-btn").click(function(e){
                e.preventDefault();

                $( "#dialog-confirm" ).dialog({
                    buttons: {
                        "Annuler la réservation": function() {
                            $( this ).dialog( "close" );
                            $('#delete-btn').trigger("click.confirmed");
                        },
                        "Retour": function() {
                            $( this ).dialog( "close" );
                        }
                    }
                });

                $("#dialog-confirm").dialog("open");
            })

        });


    </script>

@endsection