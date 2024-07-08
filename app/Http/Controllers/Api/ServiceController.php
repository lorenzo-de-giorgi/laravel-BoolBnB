<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {

        $service = Service::all();
        return response()->json([
            'status' => 'success',
            'message' => 'Ok',
            'results' => $service
        ], 200);
    }
}