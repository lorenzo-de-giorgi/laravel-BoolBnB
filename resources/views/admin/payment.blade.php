@extends('layouts.admin')
@section('content')
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sponsorship Payment</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://js.braintreegateway.com/web/dropin/1.33.0/js/dropin.min.js"></script>
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
    <div id="content" style="display: none">
        <form id="payment-form" action="{{ route('admin.braintree.checkout') }}" method="POST">
            @csrf
            
            <div class="card mb-3" style="max-width: 30%; margin: 0 auto; margin-top:10px; margin-bottom:10px; padding: 20px;">
                <div style="width: 100%; margin: 0 auto;">
                    <input type="hidden" name="apartment_id" value="{{ $apartment->id }}">
                    <input type="hidden" name="sponsorship_id" value="{{ $sponsorship->id }}">
                    
                    <div class="form-group">
                        <label>Appartamento: </label>
                        <p>{{ $apartment->title }}</p>
                    </div>
                    
                    <div class="form-group">
                        <label>Sponsorizzazione: </label>
                        <p>{{ $sponsorship->name }} - €{{ $sponsorship->price }} per {{ $sponsorship->duration }} ore</p>
                    </div>
                    
                    <div id="dropin-container"></div>
                    <input type="hidden" name="payment_method_nonce" value="">
                    <div class="d-flex justify-content-center align-content-center">
                        <button type="submit" class="button button--small button--green">Pay</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script>
        // Hide loader and show content
        document.getElementById('loader').style.display = 'none';
        document.getElementById('content').style.display = 'block';
        document.addEventListener('DOMContentLoaded', function () {
            // console.log("Script caricato correttamente.");
            var form = document.querySelector('#payment-form');
    
            fetch('/admin/braintree/token')
                .then(response => response.json())
                .then(data => {
                    // console.log('Token fetched:', data);
                    var client_token = data.token;
                    
                    braintree.dropin.create({
                        authorization: client_token,
                        container: '#dropin-container'
    
                    }, function (createErr, instance) {
                        if (createErr) {
                            console.log('Create Error', createErr);
                            return;
                        }
                        console.log('Dropin instance created');
                        form.addEventListener('submit', function (event) {
                            event.preventDefault();
    
                            instance.requestPaymentMethod(function (err, payload) {
                                if (err) {
                                    console.log('Request Payment Method Error', err);
                                    return;
                                }
                                // console.log('Nonce received:', payload.nonce);
                                document.querySelector('input[name="payment_method_nonce"]').value = payload.nonce;
                                form.submit();
                            });
                        });
                    });
                })
                .catch(error => console.error('Error fetching client token:', error));
        });
    </script>
</body>

</html>
@endsection