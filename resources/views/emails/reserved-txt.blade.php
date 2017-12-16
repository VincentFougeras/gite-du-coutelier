{{$user->name}}, votre réservation au Gite du Fougaron a été validée !

==============================

Voici les informations concernant le séjour :
 - Dates du séjour : Du {{ $reservation->beginning }} au {{ $reservation->end }}
 - Prix du séjour : {{ $reservation->amount / 100 }}€
 - Nombre de résidents attendu : {{ $reservation->number_of_people }}
 - Lieu de la réservation : {{ $reservation->is_chalet ? "le chalet" : "l'extension" }}

Vous pouvez désormais vous connecter au site à l'adresse suivante :
{{ URL::route("login") }}
pour avoir un récapitulatif de votre réservation, pour écrire dans notre livre d'or, ou pour faire une nouvelle réservation plus rapidement.
