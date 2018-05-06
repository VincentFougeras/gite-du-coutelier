<h2><img width="32" src="{!! asset('images/large-icon.png') !!}" alt="Icône"/> La réservation a été annulée.</h2>

<p>{{ $reservation->user->name }}, vous avez annulé votre réservation au {{($reservation->is_chalet ? "Chalet 1" : "Chalet 2")}}
    du {{ $reservation->beginning }} au {{ $reservation->end }}.</p>
<p>Vous allez bientôt être remboursé d'un montant de {{ $reservation->amount / 100 }}€.</p>


<style>
    @import url('https://fonts.googleapis.com/css?family=Gabriela');
    body {
        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
    }
    h2 {
        font-family: 'Gabriela', serif;
        font-weight: normal;
        color : #62502b;
    }
    img {
        position : relative;
        top : 6px;
    }
</style>