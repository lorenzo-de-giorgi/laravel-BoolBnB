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
        $id = Auth::id();
        $ownapartment = Apartment::where('user_id', $id)->pluck('id');
        $apartmentSponsorship = ApartmentSponsorship::whereIn('apartment_id', $ownapartment)->get();
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
       //
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
