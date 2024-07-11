@extends('layouts.admin')
@section('content')
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sponsorship Payment</title>
    <script src="https://js.braintreegateway.com/web/dropin/1.42.0/js/dropin.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        #loader {
            display: block;
            --height-of-loader: 4px;
            --loader-color: #0071e2;
            width: 130px;
            height: var(--height-of-loader);
            border-radius: 30px;
            background-color: rgba(0, 0, 0, 0.2);
            position: fixed;
            /* changed to fixed */
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        #loader::before {
            content: "";
            position: absolute;
            background: var(--loader-color);
            top: 0;
            left: 0;
            width: 0%;
            height: 100%;
            border-radius: 30px;
            animation: moving 1s ease-in-out infinite;
        }

        @keyframes moving {
            50% {
                width: 100%;
            }

            100% {
                width: 0;
                right: 0;
                left: unset;
            }
        }
    </style>
</head>

<body>
    <!-- Loader -->
    <div id="loader"></div>

    <!-- Contenuto della pagina -->
    <div id="content" style="display: none;">
        <div class="card mb-3"
            style="max-width: 30%; margin: 0 auto; margin-top:10px; margin-bottom:10px; padding: 20px;">
            <div style="width: 100%; margin: 0 auto;">
                <div id="dropin-container"></div>
                <div class="d-flex justify-content-center">
                    <button id="submit-button" class="button button--small button--green">Pay</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            fetch('/braintree/token')
                .then(response => response.json())
                .then(data => {
                    braintree.dropin.create({
                        authorization: data.token,
                        container: '#dropin-container'
                    }, (error, dropinInstance) => {
                        if (error) {
                            console.error(error);
                            return;
                        }

                        // Hide loader and show content
                        document.getElementById('loader').style.display = 'none';
                        document.getElementById('content').style.display = 'block';

                        document.getElementById('submit-button').addEventListener('click', () => {
                            dropinInstance.requestPaymentMethod((error, payload) => {
                                if (error) {
                                    console.error(error);
                                    return;
                                }

                                fetch('/braintree/checkout', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify({
                                        payment_method_nonce: payload.nonce,
                                        amount: '{{$sponsorship->price}}' // Cambia l'importo a seconda delle tue necessità
                                    })
                                }).then(response => response.json())
                                    .then(data => {
                                        if (data.success) {
                                            alert('Payment successful!');
                                        } else {
                                            alert('Payment failed: ' + data.error);
                                        }
                                    });
                            });
                        });
                    });
                }).catch(error => {
                    console.error('Error fetching token:', error);
                    document.getElementById('loader').style.display = 'none';
                });
        });
    </script>
</body>

</html>
@endsection