La réservation a été effectuée !

================================

{{ $reservation->user->name }}, vous avez effectué une réservation dans {{($reservation->is_chalet ? 'le chalet' : 'l\'extension')}}.

 - Date de début : {{ $reservation->beginning }}
 - Date de fin : {{ $reservation->end }}
 - Coût : {{ $reservation->amount / 100 }}€
 - Lieu : {{ $reservation->is_chalet ? "Le chalet" : "L'extension" }}
 - Nb. de résidents : {{ $reservation->number_of_people }}

Vous pouvez désormais accéder au site à l'adresse suivante : 
{{ URL::route("login") }}
pour accéder aux détails de votre réservation, nous contacter, ou écrire sur le livre d'or après votre séjour.
