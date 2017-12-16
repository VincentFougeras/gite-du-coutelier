@extends('app')


@section('content')
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    Réservation effectuée :
    {{ $reservation->user->name }}, vous avez effectué une réservation
    {{ 'du ' . $reservation->beginning . ' au ' . $reservation->end
                        . ' dans ' . ($reservation->is_chalet ? 'le chalet' : 'l\'extension') . ' pour ' . $reservation->number_of_people . ' personnes.'}}
    Prix de la réservation : {{ $reservation->amount/100 }}€

    <p>Vous pouvez revenir voir vos réservations en vous reconnectant au site.</p>
@endsection
