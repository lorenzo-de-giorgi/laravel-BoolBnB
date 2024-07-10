<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\ApartmentSponsorship;
use App\Models\Admin;

use App\Models\Sponsorship;
use Braintree\Gateway;
use Carbon\Carbon;

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
    public function confirmPayment()
    {
        // Trova la sponsorizzazione per ID
        // Passa i dettagli della sponsorizzazione alla vista
        return view('admin.payment');
    }

    public function token()
    {
        try {
            $clientToken = $this->gateway->clientToken()->generate();
            return response()->json(['token' => $clientToken]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function checkout(Request $request)
    {
        $nonce = $request->input('payment_method_nonce');
        $amount = $request->input('amount');

        try {
            $result = $this->gateway->transaction()->sale([
                'amount' => $amount,
                'paymentMethodNonce' => $nonce,
                'options' => [
                    'submitForSettlement' => true
                ]
            ]);

            if ($result->success) {
                $start_time = Carbon::now();
                $end_time = Carbon::now();
                $new_sponsorship = new ApartmentSponsorship();
                $sponsorshipId = $request->query('sponsorship_id');
                $apartmentId = $request->query('apartment_id');
                if (!$sponsorshipId || !$apartmentId) {
                    return abort(400, 'Missing parameters');
                }
                $sponsorship = Sponsorship::where('id', $sponsorshipId)->first();
                $apartment = Apartment::where('id', $apartmentId)->first();
                $new_sponsorship->name = $sponsorship->name;
                $new_sponsorship->start_time = $start_time;
                $new_sponsorship->end_time = $end_time;
                $new_sponsorship->price = 5;
                $new_sponsorship->status = 'completed'; 
                $new_sponsorship->save();

                return response()->json(['success' => true]);
            } else {
                // Logging dell'errore per debug
                \Log::error('Braintree Error: ' . $result->message);
                return response()->json(['success' => false, 'error' => $result->message], 400);
            }
        } catch (\Exception $e) {
            // Logging dell'eccezione per debug
            \Log::error('Braintree Exception: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}