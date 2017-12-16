
<?php $amount = 35000; ?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>

    <script src="https://js.stripe.com/v3/"></script>
    {!! Html::style('css/stripe.css') !!}
</head>
<body>
    <!--<script
            src="https://checkout.stripe.com/checkout.js" class="stripe-button"
            data-key="{ env("STRIPE_PUB_KEY") }}"
            data-amount="{ $amount }}"
            data-name="Fougaron Demo"
            data-description="Paiement de { $amount/100 }}€ pour le chalet"
            data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
            data-locale="auto"
            data-currency="eur">
    </script>-->
        <div class="cell example example2">
            <form>
                <!--action="{ url('/reservation/charge') }}" method="POST"-->
                {{ csrf_field() }}
                <div class="row">
                    <div class="field">
                        <input id="example2-address" class="input empty" type="text" required="">
                        <label for="example2-address">Address</label>
                        <div class="baseline"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="field half-width">
                        <input id="example2-city" class="input empty" type="text" required="">
                        <label for="example2-city">City</label>
                        <div class="baseline"></div>
                    </div>
                    <div class="field quarter-width">
                        <input id="example2-state" class="input empty" type="text" placeholder="CA" required="">
                        <label for="example2-state">State</label>
                        <div class="baseline"></div>
                    </div>
                    <div class="field quarter-width">
                        <input id="example2-postal-code" class="input empty" type="text" placeholder="94107" required="">
                        <label for="example2-postal-code">ZIP</label>
                        <div class="baseline"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="field">
                        <div id="example2-card-number" class="input empty"></div>
                        <label for="example2-card-number">Card Number</label>
                        <div class="baseline"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="field half-width">
                        <div id="example2-card-expiry" class="input empty"></div>
                        <label for="example2-card-expiry">Expiration</label>
                        <div class="baseline"></div>
                    </div>
                    <div class="field half-width">
                        <div id="example2-card-cvc" class="input empty"></div>
                        <label for="example2-card-cvc">CVC</label>
                        <div class="baseline"></div>
                    </div>
                </div>
                <input type="submit" value="Pay $25">
                <div class="error" role="alert"><svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17">
                        <path class="base" fill="#000" d="M8.5,17 C3.80557963,17 0,13.1944204 0,8.5 C0,3.80557963 3.80557963,0 8.5,0 C13.1944204,0 17,3.80557963 17,8.5 C17,13.1944204 13.1944204,17 8.5,17 Z"></path>
                        <path class="glyph" fill="#FFF" d="M8.5,7.29791847 L6.12604076,4.92395924 C5.79409512,4.59201359 5.25590488,4.59201359 4.92395924,4.92395924 C4.59201359,5.25590488 4.59201359,5.79409512 4.92395924,6.12604076 L7.29791847,8.5 L4.92395924,10.8739592 C4.59201359,11.2059049 4.59201359,11.7440951 4.92395924,12.0760408 C5.25590488,12.4079864 5.79409512,12.4079864 6.12604076,12.0760408 L8.5,9.70208153 L10.8739592,12.0760408 C11.2059049,12.4079864 11.7440951,12.4079864 12.0760408,12.0760408 C12.4079864,11.7440951 12.4079864,11.2059049 12.0760408,10.8739592 L9.70208153,8.5 L12.0760408,6.12604076 C12.4079864,5.79409512 12.4079864,5.25590488 12.0760408,4.92395924 C11.7440951,4.59201359 11.2059049,4.59201359 10.8739592,4.92395924 L8.5,7.29791847 L8.5,7.29791847 Z"></path>
                    </svg>
                    <span class="message"></span></div>
            </form>
            <div class="success">
                <div class="icon">
                    <svg width="84px" height="84px" viewBox="0 0 84 84" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <circle class="border" cx="42" cy="42" r="40" stroke-linecap="round" stroke-width="4" stroke="#000" fill="none"></circle>
                        <path class="checkmark" stroke-linecap="round" stroke-linejoin="round" d="M23.375 42.5488281 36.8840688 56.0578969 64.891932 28.0500338" stroke-width="4" stroke="#000" fill="none"></path>
                    </svg>
                </div>
                <h3 class="title">Payment successful</h3>
            </div>
        </div>
</body>
<script>
    var stripe = Stripe('pk_test_kHAJovl5UeUQHW65VpfIlqNH');

    /* Styles */
    (function() {
        'use strict';

        var elements = stripe.elements({
            fonts: [
                {
                    cssSrc: 'https://fonts.googleapis.com/css?family=Source+Code+Pro',
                },
            ],
        });

        // Floating labels
        var inputs = document.querySelectorAll('.cell.example.example2 .input');
        Array.prototype.forEach.call(inputs, function(input) {
            input.addEventListener('focus', function() {
                input.classList.add('focused');
            });
            input.addEventListener('blur', function() {
                input.classList.remove('focused');
            });
            input.addEventListener('keyup', function() {
                if (input.value.length === 0) {
                    input.classList.add('empty');
                } else {
                    input.classList.remove('empty');
                }
            });
        });

        var elementStyles = {
            base: {
                color: '#32325D',
                fontWeight: 500,
                fontFamily: 'Source Code Pro, Consolas, Menlo, monospace',
                fontSize: '16px',
                fontSmoothing: 'antialiased',

                '::placeholder': {
                    color: '#CFD7DF',
                },
                ':-webkit-autofill': {
                    color: '#e39f48',
                },
            },
            invalid: {
                color: '#E25950',

                '::placeholder': {
                    color: '#FFCCA5',
                },
            },
        };

        var elementClasses = {
            focus: 'focused',
            empty: 'empty',
            invalid: 'invalid',
        };

        var cardNumber = elements.create('cardNumber', {
            style: elementStyles,
            classes: elementClasses,
        });
        cardNumber.mount('#example2-card-number');

        var cardExpiry = elements.create('cardExpiry', {
            style: elementStyles,
            classes: elementClasses,
        });
        cardExpiry.mount('#example2-card-expiry');

        var cardCvc = elements.create('cardCvc', {
            style: elementStyles,
            classes: elementClasses,
        });
        cardCvc.mount('#example2-card-cvc');

        registerElements([cardNumber, cardExpiry, cardCvc], 'example2');
    })();



    function registerElements(elements, exampleName) {
        var formClass = '.' + exampleName;
        var example = document.querySelector(formClass);

        var form = example.querySelector('form');
        var resetButton = example.querySelector('a.reset');
        var error = form.querySelector('.error');
        var errorMessage = error.querySelector('.message');

        function enableInputs() {
            Array.prototype.forEach.call(
                form.querySelectorAll(
                    "input[type='text'], input[type='email'], input[type='tel']"
                ),
                function(input) {
                    input.removeAttribute('disabled');
                }
            );
        }

        function disableInputs() {
            Array.prototype.forEach.call(
                form.querySelectorAll(
                    "input[type='text'], input[type='email'], input[type='tel']"
                ),
                function(input) {
                    input.setAttribute('disabled', 'true');
                }
            );
        }

        // Listen for errors from each Element, and show error messages in the UI.
        elements.forEach(function(element) {
            element.on('change', function(event) {
                if (event.error) {
                    error.classList.add('visible');
                    errorMessage.innerText = event.error.message;
                } else {
                    error.classList.remove('visible');
                }
            });
        });

        // Listen on the form's 'submit' handler...
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            // Show a loading screen...
            example.classList.add('submitting');

            // Disable all inputs.
            disableInputs();

            // Gather additional customer data we may have collected in our form.
            var name = form.querySelector('#' + exampleName + '-name');
            var address1 = form.querySelector('#' + exampleName + '-address');
            var city = form.querySelector('#' + exampleName + '-city');
            var state = form.querySelector('#' + exampleName + '-state');
            var zip = form.querySelector('#' + exampleName + '-zip');
            var additionalData = {
                name: name ? name.value : undefined,
                address_line1: address1 ? address1.value : undefined,
                address_city: city ? city.value : undefined,
                address_state: state ? state.value : undefined,
                address_zip: zip ? zip.value : undefined,
            };

            // Use Stripe.js to create a token. We only need to pass in one Element
            // from the Element group in order to create a token. We can also pass
            // in the additional customer data we collected in our form.
            stripe.createToken(elements[0], additionalData).then(function(result) {
                // Stop loading!
                example.classList.remove('submitting');

                if (result.token) {
                    // If we received a token, show the token ID.
                    example.querySelector('.token').innerText = result.token.id;
                    example.classList.add('submitted');
                } else {
                    // Otherwise, un-disable inputs.
                    enableInputs();
                }
            });
        });

        resetButton.addEventListener('click', function(e) {
            e.preventDefault();
            // Resetting the form (instead of setting the value to `''` for each input)
            // helps us clear webkit autofill styles.
            form.reset();

            // Clear each Element.
            elements.forEach(function(element) {
                element.clear();
            });

            // Reset error state as well.
            error.classList.remove('visible');

            // Resetting the form does not un-disable inputs, so we need to do it separately:
            enableInputs();
            example.classList.remove('submitted');
        });
    }
</script>
</html>