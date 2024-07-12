<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\View;

class ViewController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->all();

        $new_view = new View();
        $new_view->fill($data);
        $new_view->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Ok',
        ], 200);
    }
}
