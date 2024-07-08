<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use DateTime;
use Illuminate\Http\Request;
use App\Models\ApartmentSponsorship;
use Illuminate\Support\Facades\Auth;
use App\Models\Apartment;
use App\Models\Sponsorship;
use Carbon\Carbon;

class ApartmentSponsorshipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $apartmentSponsorship = ApartmentSponsorship::all();
        return view('admin.apartment_sponsorship.index', compact('apartmentSponsorship'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $id = Auth::id();
        $apartments = Apartment::where('user_id', $id)->get();
        $sponsorships = Sponsorship::all();
        // dd($apartments);
        return view('admin.apartment_sponsorship.create', compact('apartments', 'sponsorships'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // defines the time of the zone
        date_default_timezone_set('Europe/Rome');
        $start_time = Carbon::now();
        $end_time = Carbon::now();
        $apartmentSponsorship = ApartmentSponsorship::all();
        $sponsorships = Sponsorship::all();
        $apartments = Apartment::all();
        $form_data = $request->all();
        $apartmentId = Apartment::findOrFail($form_data['apartment_id']);
        $sponsorshipId = Sponsorship::findOrFail($form_data['sponsorship_id']);
        $form_data['name'] = $sponsorshipId->name;
        $form_data['price'] = $sponsorshipId->price;
        $form_data['start_time'] = $start_time;
        // add time to sponsorships
        if($form_data['name'] == 'Bronze'){
            $form_data['end_time'] = $end_time->addHours(24);
        } elseif ($form_data['name'] == 'Silver'){
            $form_data['end_time'] = $end_time->addHours(72);
        } else {
            $form_data['end_time'] = $end_time->addHours(144);
        }
        ApartmentSponsorship::create($form_data);
        return redirect()->route('admin.apartment_sponsorship.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
