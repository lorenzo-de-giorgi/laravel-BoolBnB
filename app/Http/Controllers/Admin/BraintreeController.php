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

    public function confirmPayment(Request $request)
    {
        $apartment = Apartment::findOrFail($request->input('apartment_id'));
        $sponsorship = Sponsorship::where('id', $request->input('sponsorship_id'))->first();

        // Passa i dettagli della sponsorizzazione alla vista
        return view('admin.payment', compact('sponsorship', 'apartment'));
    }

    public function token(){
        $clientToken = $this->gateway->clientToken()->generate();
        return response()->json(['token' => $clientToken]);
    }

    public function checkout(Request $request)
    {
        $nonce = $request->input('payment_method_nonce');
        $apartment = Apartment::findOrFail($request->input('apartment_id'));
        $sponsorship = Sponsorship::findOrFail($request->input('sponsorship_id'));

        $amount = $sponsorship->price;

        $result = $this->gateway->transaction()->sale([
            'amount' => $amount,
            'paymentMethodNonce' => $nonce,
            'options' => [
                'submitForSettlement' => true
            ]
        ]);
        if ($result->success) {
            $currentDateTime = Carbon::now();
            list($hours, $minutes, $seconds) = explode(':', $sponsorship->duration);
            $endDateTime = $currentDateTime->copy()->addHours($hours)->addMinutes($minutes)->addSeconds($seconds);

            $existingSponsorship = $apartment->sponsorships()
                ->wherePivot('end_time', '>', $currentDateTime)
                // ->where('sponsorship_id', $sponsorship->id)
                // ->where('end_time', '>', $currentDateTime)
                ->first();
                if ($existingSponsorship) {
                    $endDateTimeExisting = Carbon::parse($existingSponsorship->pivot->end_time);
                    $diff = $currentDateTime->diff($endDateTimeExisting);
                    $remainingTime = $diff->format('%d days, %h hours, %i minutes e %s seconds');
    
                    return redirect()->route('admin.apartments.show', $apartment->slug)
                                     ->with('error', 'Sponsorship already active, ends in: ' . $remainingTime);
                } else {
                //Se lo sponsor non esiste, lo aggiungiamo
                $apartment->sponsorships()->attach($sponsorship->id, [
                    'start_time' => $currentDateTime,
                    'end_time' => $endDateTime,
                    'price' => $sponsorship->price,
                    'name' => $sponsorship->name,
                ]);
            }
            return redirect()->route('admin.payment_success', $apartment->slug)
                             ->with('success', 'Payment successful');
        } else {
            return redirect()->route('admin.apartments.show', $apartment->slug)
                             ->withErrors('Errore nella transazione: ' . $result->message);
        }
    }
}