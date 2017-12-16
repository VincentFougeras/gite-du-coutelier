@extends('app')

@section('content')

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <?php setlocale(LC_TIME, 'French'); ?>
        <p>{{ 'Du ' . $reservation->beginning->formatLocalized('%A %d %B %Y') . ' au ' . $reservation->end->formatLocalized('%A %d %B %Y')
                    . ' dans ' . ($reservation->is_chalet ? 'le chalet' : 'l\'extension') . ' (' . $reservation->number_of_people . ')'}}</p>
    </div>
</div>
{!! Form::open(['url' =>  url('/reservation/charge'), 'id' => 'payment-form', 'files' => true]) !!}
@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<input type="hidden" name="reservation_id" value="{{ $reservation->id }}">
<div class="form-group" id="address-group">
    {!! Form::label('name', 'Nom :') !!}
    {!! Form::text('name', null, ['class' => 'form-control','placeholder' => 'Jean Dupont','required' => 'required']) !!}
</div>

<div class="form-group" id="address-group">
    {!! Form::label('address', 'Adresse :') !!}
    {!! Form::text('address', null, ['class' => 'form-control','placeholder' => '1 rue des Champs-Elysées','required' => 'required']) !!}
</div>

<div class="form-group" id="email-group">
    {!! Form::label('email', 'Adresse e-mail :') !!}
    {!! Form::email('email', null, ['class' => 'form-control','placeholder' => 'jean.dupont@gmail.com','required' => 'required']) !!}
</div>
<div class="form-group">
    <label for="password">Mot de passe :</label>
    <input name="password" type="password" class="form-control" required="required">
</div>
<div class="form-group">
    <label for="password_confirmation">Confirmer le mot de passe :</label>
    <input name="password_confirmation" type="password" class="form-control" required="required">
</div>

<div class="form-group">
    <label for="id_scan">Scan d'une pièce d'identité
        <span data-toggle="tooltip" title="La pièce d'identité est utilisée pour éviter les fraudes de carte de crédit">&#10067;</span><br/>
        <span class="text-muted">(Formats acceptés : JPEG, PNG. Taille maximale : 5 Mo)</span></label>
    {!! Form::file('id_scan', ['accept' => 'image/*','required' => 'required']) !!}
</div>

<div class="group">
    <label>
        <span>Card</span>
        <div id="card-element" class="field"></div>
    </label>
</div>
<button type="submit">Réserver pour {{$reservation->amount/100}}€</button>
<div class="outcome">
    <div class="error"></div>
    <div class="success">
        Success! Your Stripe token is <span class="token"></span>
    </div>
</div>
{!! Form::close() !!}

<script>
    var stripe = Stripe("{!! env('STRIPE_PUB_KEY') !!}");
    var elements = stripe.elements();

    var card = elements.create('card', {
        placeholder: "ddd",
        style: {
            base: {
                iconColor: '#666EE8',
                color: '#31325F',
                lineHeight: '40px',
                fontWeight: 300,
                fontFamily: 'Helvetica Neue',
                fontSize: '15px',

                '::placeholder': {
                    color: '#CFD7E0',
                },
            },
        }
    });
    card.mount('#card-element');

    function setOutcome(result) {
        var successElement = document.querySelector('.success');
        var errorElement = document.querySelector('.error');
        successElement.classList.remove('visible');
        errorElement.classList.remove('visible');

        if (result.token) {
            // Use the token to create a charge or a customer
            stripeTokenHandler(result.token);
        } else if (result.error) {
            errorElement.textContent = result.error.message;
            errorElement.classList.add('visible');
        }
    }

    card.on('change', function(event) {
        setOutcome(event);
    });

    document.querySelector('form').addEventListener('submit', function(e) {
        e.preventDefault();
        var form = document.querySelector('form');
        var extraDetails = {
            name: form.querySelector('input[name=name]').value,
        };
        stripe.createToken(card, extraDetails).then(setOutcome);
    });

    function stripeTokenHandler(token) {
        // Insert the token ID into the form so it gets submitted to the server
        var form = document.getElementById('payment-form');
        var hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'stripeToken');
        hiddenInput.setAttribute('value', token.id);
        form.appendChild(hiddenInput);

        // Submit the form
        form.submit();
    }

</script>
<style>
    * {
        font-family: "Helvetica Neue", Helvetica;
        font-size: 15px;
        font-variant: normal;
        padding: 0;
        margin: 0;
    }

    html {
        height: 100%;
    }

    body {
        background: #E6EBF1;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100%;
    }

    form {
        width: 480px;
        margin: 20px 0;
    }

    .group {
        background: white;
        box-shadow: 0 7px 14px 0 rgba(49,49,93,0.10),
        0 3px 6px 0 rgba(0,0,0,0.08);
        border-radius: 4px;
        margin-bottom: 20px;
    }

    .group label {
        position: relative;
        color: #8898AA;
        font-weight: 300;
        height: 40px;
        line-height: 40px;
        margin-left: 20px;
        display: flex;
        flex-direction: row;
    }

    .group label:not(:last-child) {
        border-bottom: 1px solid #F0F5FA;
    }

    label > span {
        width: 80px;
        text-align: right;
        margin-right: 30px;
    }

    .field {
        background: transparent;
        font-weight: 300;
        border: 0;
        color: #31325F;
        outline: none;
        flex: 1;
        padding-right: 10px;
        padding-left: 10px;
        cursor: text;
    }

    .field::-webkit-input-placeholder { color: #CFD7E0; }
    .field::-moz-placeholder { color: #CFD7E0; }

    button {
        float: left;
        display: block;
        background: #666EE8;
        color: white;
        box-shadow: 0 7px 14px 0 rgba(49,49,93,0.10),
        0 3px 6px 0 rgba(0,0,0,0.08);
        border-radius: 4px;
        border: 0;
        margin-top: 20px;
        font-size: 15px;
        font-weight: 400;
        width: 100%;
        height: 40px;
        line-height: 38px;
        outline: none;
    }

    button:focus {
        background: #555ABF;
    }

    button:active {
        background: #43458B;
    }

    .outcome {
        float: left;
        width: 100%;
        padding-top: 8px;
        min-height: 24px;
        text-align: center;
    }

    .success, .error {
        display: none;
        font-size: 13px;
    }

    .success.visible, .error.visible {
        display: inline;
    }

    .error {
        color: #E4584C;
    }

    .success {
        color: #666EE8;
    }

    .success .token {
        font-weight: 500;
        font-size: 13px;
    }

</style>

@endsection