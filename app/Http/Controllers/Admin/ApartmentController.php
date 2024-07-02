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
use App\Models\Service;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {  
        $id = Auth::id();
        $apartments = Apartment::where('user_id', $id)->paginate(3);
        // $apartments = Apartment::all();
        return view('admin.apartments.index', compact('apartments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $services = Service::all();
        return view('admin.apartments.create', compact('services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreApartmentRequest $request)
    { 
        $form_data = $request->validated();
        $form_data['slug'] = Apartment::generateSlug($form_data['title']);
        $form_data['user_id'] = Auth::id();
        $result = Apartment::getCoordinatesFromAddress($form_data['address']);
        $form_data['latitude'] = $result['latitude'];
        $form_data['longitude'] = $result['longitude'];
      
        if ($request->hasFile('image')) {
            $imagePaths= [];
           foreach ($request->file('image') as $image){
            $path = Storage::put('apartment_images', $image);
            $imagePaths[] = $path;
           }
           $form_data['image'] = json_encode($imagePaths);
        }
        
        $form_data['user_id'] = Auth::id();
       
        $new_apartment = Apartment::create($form_data);

        if ($request->has('services')) {
            $new_apartment->services()->attach($request->services);
        }
        
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
        $services = Service::all();
        $address = $apartment->address;
        $array = explode(', ', $address, 4);
        // dd($array);
        return view('admin.apartments.edit', compact('apartment', 'array', 'services'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateApartmentRequest $request, Apartment $apartment)
    { 
        // Estrai l'indice dell'immagine da eliminare
        $index = $request->input('toDelete');
        
        // Valida i dati del modulo
        $form_data = $request->validated();
        $form_data['slug'] = Apartment::generateSlug($form_data['title']);
        $form_data['user_id'] = Auth::id();
        // Ottieni le coordinate dall'indirizzo
        $result = Apartment::getCoordinatesFromAddress($form_data['address']);
        $form_data['latitude'] = $result['latitude'];
        $form_data['longitude'] = $result['longitude'];
        // Gestisci le immagini dell'appartamento
        $apartmentImage = json_decode($apartment->image, true);
       
            array_splice($apartmentImage, $index, 1);
        
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $image) {
                $path = Storage::put('apartment_images', $image);
                array_push($apartmentImage, $path);
            }
            $form_data['image'] = json_encode($apartmentImage);
        }
 
        // Sincronizza i servizi
        if ($request->has('services')) {
            $apartment->services()->sync($request->services);
        } else {
            $apartment->services()->sync([]);
        }
        // Reindirizza alla vista di dettaglio dell'appartamento
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