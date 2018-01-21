<h2><img width="32" src="{!! asset('images/large-icon.png') !!}" alt="Icône"/> La réservation a été effectuée !</h2>

<p>{{ $reservation->user->name }}, vous avez effectué une réservation dans {{($reservation->is_chalet ? 'le chalet' : 'l\'extension')}}.</p>

<table>
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
</table>

<p>Vous pouvez désormais
    <a href="{{ url('/my/reservations') }}" target="_blank">accéder aux détails de votre réservation</a>,
    <a href="{{ url('/contact') }}" target="_blank">nous contacter</a>, ou
    <a href="{{ url('/visitors-book') }}" target="_blank">écrire sur le livre d'or après votre séjour</a>.
</p>

<style>
    @import url('https://fonts.googleapis.com/css?family=Gabriela');
    body {
        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
    }
    table {
        border-collapse: collapse;
    }
    th, td {
        border: 1px solid #535554;
        padding: 5px;
        text-align: left;
    }
    h2 {
        font-family: 'Gabriela', serif;
        font-weight: normal;
        color : #62502b;
    }
    a {
        color: #977b43;
    }
    a:hover, a:focus {
        color: #62502b;
        text-decoration: underline;
    }
    img {
        position : relative;
        top : 6px;
    }
</style>