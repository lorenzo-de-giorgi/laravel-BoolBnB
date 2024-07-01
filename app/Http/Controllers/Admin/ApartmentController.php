<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Apartment;
use Illuminate\Http\Request;
use Illuminate\Auth\Console\ClearResetsCommand;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AddressController;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreApartmentRequest;
use App\Http\Requests\UpdateApartmentRequest;

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
    public function store(StoreApartmentRequest $request)
    { 
        $street = $request->input('street');
        $cap = $request->input('cap');
        $city = $request->input('city');
        $province = $request->input('province');
        // $addressArray = [];
        // array_push($addressArray, $street, $cap, $city, $province);
        // $address = implode(', ', $addressArray);
        $address = $street . ', ' . $cap . ', ' . $city . ', ' . $province;
        $form_data = $request->validated();
        $form_data['slug'] = Apartment::generateSlug($form_data['title']);
        $form_data['user_id'] = Auth::id();
    
        $result = Apartment::getCoordinatesFromAddress($address);
        $latitude = $result['latitude'];
        $longitude = $result['longitude'];
        $new_apartment = New Apartment();
        if ($request->hasFile('image')) {
            $imagePaths= [];
           foreach ($request->file('image') as $image){
            $path = Storage::put('apartment_images', $image);
            $imagePaths[] = $path;
           }
           $new_apartment->image = json_encode($imagePaths);
        }
        
        //dd($form_data);
      
        $new_apartment->title = $form_data['title'];
        $new_apartment->user_id = Auth::id();
        $new_apartment->slug = Apartment::generateSlug($form_data['title']);
        $new_apartment->beds_num = $form_data['beds_num'];
        $new_apartment->rooms_num = $form_data['rooms_num'];
        $new_apartment->bathrooms_num = $form_data['bathrooms_num'];
        $new_apartment->square_meters = $form_data['square_meters'];
        $new_apartment->visibility = $form_data['visibility'];
        $new_apartment->latitude = $latitude;
        $new_apartment->longitude = $longitude;
        $new_apartment->address = $address;
        $new_apartment->save();
        //dd($new_apartment);
        
       /*  Apartment::create($form_data); */
        return redirect()->route('admin.apartments.index');
    }

/**
     * Display the specified resource.
     */
    public function show(Apartment $apartment){
      
        return view('admin.apartments.show', compact('apartment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Apartment $apartment)
    {   
        $address = $apartment->address;
        $array = explode(', ', $address, 4);
        // dd($array);
        return view('admin.apartments.edit', compact('apartment', 'array'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateApartmentRequest $request, Apartment $apartment)
    {  
       /*  dd($request->input('deleted')); */
        $index = $request->input('deleted'); 
        $street = $request->input('street');
        $cap = $request->input('cap');
        $city = $request->input('city');
        $province = $request->input('province');
        // $addressArray = [];
        // array_push($addressArray, $street, $cap, $city, $province);
        // $address = implode(' ', $addressArray);
        $address = $street . ', ' . $cap . ', ' . $city . ', ' . $province;
        // $array = explode(',', $address);
        // dd($array);
        $form_data = $request->validated();
        $form_data['slug'] = Apartment::generateSlug($form_data['title']); 
        $form_data['user_id'] = Auth::id();
    
        $result = Apartment::getCoordinatesFromAddress($address);
        $latitude = $result['latitude'];
        $longitude = $result['longitude'];
       
        $apartmentImage = json_decode($apartment->image);
        array_splice($apartmentImage, $index, 1);
        
        if ($request->hasFile('image')) {
            $imagePaths= [];
           foreach ($request->file('image') as $image){
            $path = Storage::put('apartment_images', $image);
            array_push($apartmentImage, $path);
           
           }
         
          /*  $newImage = json_decode($imagePaths); */
         
        }
        $apartment->image = $apartmentImage;
        //dd($form_data)
        $apartment->title = $form_data['title'];
        $apartment->user_id = Auth::id();
        $apartment->slug = Apartment::generateSlug($form_data['title']);
      
        $apartment->beds_num = $form_data['beds_num'];
        $apartment->rooms_num = $form_data['rooms_num'];
        $apartment->bathrooms_num = $form_data['bathrooms_num'];
        $apartment->square_meters = $form_data['square_meters'];
        $apartment->visibility = $form_data['visibility'];
        $apartment->latitude = $latitude;
        $apartment->longitude = $longitude;
        $apartment->address = $address;
        $apartment->update();
        // dd($apartment);

    /*     if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $data['image'] = $path;
        } */
      
        return redirect()->route('admin.apartments.show', $apartment->slug);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Apartment $apartment)
    {
        if ($apartment->image) {
            Storage::delete($apartment->image);
        }
        $apartment->delete();
        return redirect()->route('admin.apartments.index');
    }
}   