<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailables\Envelope;

class MessageController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->all();

        $new_messsage = new Message();
        $new_messsage->fill($data);
        $new_messsage->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Ok',
        ], 200);
    }
}
