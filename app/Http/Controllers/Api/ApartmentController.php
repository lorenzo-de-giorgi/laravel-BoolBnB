<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Apartment;

class ApartmentController extends Controller
{
    public function index()
    {
        $apartments = Apartment::with('services')->get();
        // dd($apartments);
        return response()->json([
            'status' => 'success',
            'message' => 'ok',
            'results' => $apartments
        ], 200);
    }

    public function show($slug)
    {
        $apartment = Apartment::where('slug', $slug)->with('services')->first();
        if($apartment){
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
