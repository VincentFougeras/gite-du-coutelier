<h1>{{$user->name}}, votre réservation au Gite du Fougaron a été validée !</h1>

<p>Voici les informations concernant le séjour :</p>

<ul>
    <li>Dates du séjour : Du {{ $reservation->beginning }} au {{ $reservation->end }}</li>
    <li>Prix du séjour : {{ $reservation->amount / 100 }}€</li>
    <li>Nombre de résidents attendu : {{ $reservation->number_of_people }}</li>
    <li>Lieu de la réservation : {{ $reservation->is_chalet ? "le chalet" : "l'extension" }}</li>
</ul>

<p>
    Vous pouvez désormais <a href="{{ URL::route("login") }}">vous connecter au site</a> pour avoir un récapitulatif de votre réservation,
    pour écrire dans notre livre d'or, ou pour faire une nouvelle réservation plus rapidement.
</p>
