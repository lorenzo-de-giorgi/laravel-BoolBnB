<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\View;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $views = View::whereHas('apartment', function($query) use ($userId){
            $query->where('user_id', $userId);
        })->get();
        return view('admin.dashboard', compact('views'));
    }
}
