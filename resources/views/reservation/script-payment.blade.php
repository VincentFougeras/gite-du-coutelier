<script>
    var stripe = Stripe("{!! env('STRIPE_PUB_KEY') !!}");
    var elements = stripe.elements();

    // Custom styling can be passed to options when creating an Element.
    var style = {
        base: {
            color: '#32325d',
            lineHeight: '18px',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '14px',
            '::placeholder': {
                color: '#aab7c4'
            }
        },
        invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
        }
    };
    var card = elements.create('card', {style: style});


    card.mount('#card-element');

    function setOutcome(result) {
        var errorElement = document.querySelector('.error');
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

    var form = document.getElementById('payment-form');
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        var extraDetails = {
            name: form.querySelector('input[name=name]').value,
        };
        stripe.createToken(card, extraDetails).then(setOutcome);
    });

    function stripeTokenHandler(token) {
        // Insert the token ID into the form so it gets submitted to the server
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

    .StripeElement {
        background-color: white;
        padding: 10px 12px;
        border-radius: 4px;
        border: 1px solid #ccc;
        box-shadow: 0 1px 3px 0 #e6ebf1;
        -webkit-transition: box-shadow 150ms ease;
        transition: box-shadow 150ms ease;
    }

    .StripeElement--focus {
        box-shadow: 0 1px 3px 0 #cfd7df;
    }

    .StripeElement--invalid {
        border-color: #fa755a;
    }

    .StripeElement--webkit-autofill {
        background-color: #fefde5 !important;
    }


    /** {
        font-family: "Helvetica Neue", Helvetica;
        font-size: 15px;
        font-variant: normal;
        padding: 0;
        margin: 0;
    }*/

    html {
        height: 100%;
    }
/*
    body {
        background: #E6EBF1;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100%;
    }*/

    .group {
        background: white;
        /*box-shadow: 0 7px 14px 0 rgba(49,49,93,0.10),
        0 3px 6px 0 rgba(0,0,0,0.08);
        border-radius: 4px;
        */
        border-radius: 4px;margin-bottom: 20px;
    }

    .group label {
        position: relative;
        color: #8898AA;
        font-weight: 300;
        height: 40px;
        line-height: 40px;
       /* margin-left: 20px;*/
        display: flex;
        flex-direction: row;
        margin-bottom : 0;
    }

   /* .group label:not(:last-child) {
        border-bottom: 1px solid #F0F5FA;
    }*/
/*
    label > span {
        width: 80px;
        text-align: right;
        margin-right: 30px;
    }*/

    .field {
        background: transparent;
        font-weight: 300;
        border: 1px solid #ccc;
        color: #31325F;
        outline: none;
        flex: 1;
        padding-right: 10px;
        padding-left: 10px;
        cursor: text;
    }

    .field::-webkit-input-placeholder { color: #CFD7E0; }
    .field::-moz-placeholder { color: #CFD7E0; }



    .outcome {
        float: left;
        width: 100%;
        padding-top: 8px;
        min-height: 24px;
        text-align: center;
    }

    .error {
        display: none;
        font-size: 13px;
    }

    .error.visible {
        display: inline;
    }

    .error {
        color: #E4584C;
    }

</style>