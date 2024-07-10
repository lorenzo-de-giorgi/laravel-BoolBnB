<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\ApartmentSponsorship;
use App\Models\Admin;

use App\Models\Sponsorship;
use Braintree\Gateway;

use Illuminate\Http\Request;

class BraintreeController extends Controller
{
    protected $gateway;
    
    public function __construct()
    {
        $this->gateway = new Gateway([
            'environment' => config('services.braintree.environment'),
            'merchantId' => config('services.braintree.merchant_id'),
            'publicKey' => config('services.braintree.public_key'),
            'privateKey' => config('services.braintree.private_key'),
        ]);
    }

    // public function index($id){
    //     $sponsorships = ApartmentSponsorship::findOrFail($id);
    //     return view('admin.payment', compact('sponsorships'));
    // }
    public function confirmPayment($id)
    {
        // Trova la sponsorizzazione per ID
        $sponsorship = Sponsorship::findOrFail($id);

        // Passa i dettagli della sponsorizzazione alla vista
        return view('admin.payment', compact('sponsorship'));
    }

    public function token(){
        $clientToken = $this->gateway->clientToken()->generate();
        return response()->json(['token' => $clientToken]);
    }

    public function checkout(Request $request)
    {
        $nonce = $request->input('payment_method_nonce');
        $amount = $request->input('amount');

        $result = $this->gateway->transaction()->sale([
            'amount' => $amount,
            'paymentMethodNonce' => $nonce,
            'options' => [
                'submitForSettlement' => true
            ]
        ]);

        if ($result->success) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'error' => $result->message]);
        }
    }
}