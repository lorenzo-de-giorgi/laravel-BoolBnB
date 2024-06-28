<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Apartment;
use Illuminate\Http\Request;
use Illuminate\Auth\Console\ClearResetsCommand;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AddressController;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {  
        $id = Auth::id();
        $apartments = Apartment::where('user_id', $id)->paginate(3);
        $apartments = Apartment::all();
        return view('admin.apartments.index', compact('apartments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.apartments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        $street = $request->input('street');
        $cap = $request->input('cap');
        $city = $request->input('city');
        $province = $request->input('province');
        $address = $street . ' ' . $cap . ' ' . $city . ' ' . $province;
        $form_data = $request->all();
        $form_data['slug'] = Apartment::generateSlug($form_data['title']);
        $form_data['user_id'] = Auth::id();
    
        $result = Apartment::getCoordinatesFromAddress($address);
        $latitude = $result['latitude'];
        $longitude = $result['longitude'];
       
        //dd($form_data);
        $new_apartment = New Apartment();
        $new_apartment->title = $form_data['title'];
        $new_apartment->user_id = Auth::id();
        $new_apartment->slug = Apartment::generateSlug($form_data['title']);
        $new_apartment->image = $form_data['image'];
        $new_apartment->beds_num = $form_data['beds_num'];
        $new_apartment->rooms_num = $form_data['rooms_num'];
        $new_apartment->bathrooms_num = $form_data['bathrooms_num'];
        $new_apartment->square_meters = $form_data['square_meters'];
        $new_apartment->latitude = $latitude;
        $new_apartment->longitude = $longitude;
        $new_apartment->address = $address;
        $new_apartment->save();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $data['image'] = $path;
        }
         
       /*  Apartment::create($form_data); */
        return redirect()->route('admin.apartments.index');
    }

/**
     * Display the specified resource.
     */
    public function show(Apartment $apartment)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Apartment $apartment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Apartment $apartment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Apartment $apartment)
    {
        //
    }
}