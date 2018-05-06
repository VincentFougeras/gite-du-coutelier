La réservation a été annulée.

================================

{{ $reservation->user->name }}, vous avez annulé votre réservation au {{($reservation->is_chalet ? "Chalet 1" : "Chalet 2")}} du {{ $reservation->beginning }} au {{ $reservation->end }}.
Vous allez bientôt être remboursé d'un montant de {{ $reservation->amount / 100 }}€.