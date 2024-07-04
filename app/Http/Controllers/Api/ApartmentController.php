<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Apartment;
use Illuminate\Support\Facades\DB;

class ApartmentController extends Controller
{
    public function index(request $request)
    {
        if ($request->query('beds_num')) {
            $apartments = Apartment::with('services')->where('beds_num', $request->query('beds_num'))->get();
        } else {
            $apartments = Apartment::with('services')->get();
        }
        if ($request->query('lat') && $request->query('lon') && $request->query('radius')) {
            //chatgpt
            // Ottieni i parametri dalla richiesta
            $latitudeRef = $request->input('lat');
            $longitudeRef = $request->input('lon');
            $radius = $request->input('radius');

            // Verifica che i parametri siano forniti
            // if (!$latitudeRef || !$longitudeRef || !$radius) {
            //     return response()->json(['error' => 'Missing required parameters'], 400);
            // }

            // Query per filtrare gli appartamenti in base alla distanza
            $apartments = DB::table('apartments')
                ->select(
                    '*',
                    DB::raw("(6371 * acos(cos(radians($latitudeRef)) 
                 * cos(radians(latitude)) 
                 * cos(radians(longitude) - radians($longitudeRef)) 
                 + sin(radians($latitudeRef)) 
                 * sin(radians(latitude)))) AS distance")
                )
                ->having('distance', '<', $radius)
                ->orderBy('distance')
                ->get();


            // dd($apartments);
            return response()->json([
                'status' => 'success',
                'message' => 'ok',
                'results' => $apartments
            ], 200);
        } else {
            $apartments = Apartment::all();
            return response()->json([
                'status' => 'success',
                'message' => 'ok',
                'results' => $apartments
            ], 200);
        }
    }

    public function show($slug)
    {
        $apartment = Apartment::where('slug', $slug)->with('services')->first();
        if ($apartment) {
            return response()->json([
                'status' => 'success',
                'message' => 'ok',
                'result' => $apartment
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Error'
            ], 400);
        }
    }

}
