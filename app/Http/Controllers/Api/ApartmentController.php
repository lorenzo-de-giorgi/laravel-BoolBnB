<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Apartment;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class ApartmentController extends Controller
{
    public function index(Request $request)
    {
        $services = $request->query('services');
        $latitudeRef = $request->query('lat');
        $longitudeRef = $request->query('lon');
        $radius = $request->query('radius');
        $minBeds = $request->query('minBeds');
        $minRooms = $request->query('minRooms');
    
        $apartmentsQuery = Apartment::with('services');
    
        if ($services) {
            $servicesArray = explode(',', $services);
            $apartmentsQuery->whereHas('services', function (Builder $query) use ($servicesArray) {
                $query->whereIn('services.id', $servicesArray);
            }, '=', count($servicesArray));
        }
    
        if ($latitudeRef && $longitudeRef && $radius) {
            $apartmentsQuery->select(
                '*',
                DB::raw("(6371 * acos(cos(radians($latitudeRef)) 
                 * cos(radians(latitude)) 
                 * cos(radians(longitude) - radians($longitudeRef)) 
                 + sin(radians($latitudeRef)) 
                 * sin(radians(latitude)))) AS distance")
            )
            ->having('distance', '<', $radius)
            ->orderBy('distance');
        }
    
        if ($minBeds) {
            $apartmentsQuery->where('beds_num', '>=', $minBeds);
        }
    
        if ($minRooms) {
            $apartmentsQuery->where('rooms_num', '>=', $minRooms);
        }
    
        $apartments = $apartmentsQuery->get();
    
        return response()->json([
            'status' => 'success',
            'message' => 'ok',
            'results' => $apartments
        ], 200);
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
