<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sponsorship Payment</title>
        <script src="https://js.braintreegateway.com/web/dropin/1.42.0/js/dropin.js"></script>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body>
        <div id="dropin-container"></div>
        <button id="submit-button">Pay</button>
    </body>
    <script>
        fetch('/admin/braintree/token')
            .then(response => response.json())
            .then(data => {
                braintree.dropin.create({
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

                            fetch('/admin/braintree/checkout', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    payment_method_nonce: payload.nonce,
                                    amount: '10.00' // Cambia l'importo a seconda delle tue necessità
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