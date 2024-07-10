@extends('layouts.admin')
@section('content')
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sponsorship Payment</title>
        <script src="https://js.braintreegateway.com/web/dropin/1.42.0/js/dropin.js"></script>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body>
        <div class="loader"></div>
            <div class="card mb-3" style="max-width: 30%; margin: 0 auto; margin-top:10px; margin-bottom:10px; padding: 20px;">
                <div>
                    <h6>Price:</h6>
                    <p>{{$sponsorship->price}}</p>
                    <h6>Type of Sponsorship:</h6>
                    <p>{{$sponsorship->name}}</p>
                </div>
                <div style="width: 100%; margin: 0 auto;">
                    <div id="dropin-container"></div>
                    <div class="d-flex justify-content-center">
                        <button id="submit-button" class="button button--small button--green">Pay</button>
                    </div>
                </div>
        </div>
    </body>
    <script>
        fetch('/braintree/token')
            .then(response => response.json())
            .then(data => {
                braintree.dropin.create({
                    vaultManager: true,
                    authorization: data.token,
                    container: '#dropin-container'
                }, (error, dropinInstance) => {
                    if (error) console.error(error);

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
            });
    </script>
</html>
@endsection