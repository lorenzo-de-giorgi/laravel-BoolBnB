<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\View;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $views = View::select('apartment_id', DB::raw('DATE(date) as date'), DB::raw('count(*) as view_count'))
            ->whereHas('apartment', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->groupBy('apartment_id', DB::raw('DATE(date)'))
            ->get();

        // Prepara i dati per Chart.js
        $labels = $views->pluck('date')->unique()->values()->toArray();
        $datasets = [];
        foreach ($views->groupBy('apartment_id') as $apartmentId => $viewGroup) {
            $data = [];
            foreach ($labels as $label) {
                $view = $viewGroup->firstWhere('date', $label);
                $data[] = $view ? $view->view_count : 0;
            }
            $datasets[] = [
                'label' => "Apartment $apartmentId",
                'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                'borderColor' => "rgba(38, 185, 154, 0.7)",
                'data' => $data,
            ];
        }

        $chartjs = app()->chartjs
            ->name('lineChart')
            ->type('line')
            ->size(['width' => 400, 'height' => 200])
            ->labels($labels)
            ->datasets($datasets)
            ->options([]);

        return view('admin.dashboard', compact('chartjs'));
    }
}