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

        $views = View::select('apartment_id', 'date', DB::raw('count(*) as view_count'))
        ->whereHas('apartment', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->groupBy('apartment_id', 'date')
        ->get();

      /*   $randomColor = sprintf('rgba(%d, %d, %d, %f)', rand(0, 255), rand(0, 255), rand(0, 255), 1); */
        $labels = $views->pluck('date')->unique()->values()->toArray();
        $datasets = [];
        foreach ($views->groupBy('apartment_id') as $apartmentId => $viewGroup) {
            $data = [];
            foreach ($labels as $label) {
                $view = $viewGroup->firstWhere('date', $label);
                $data[] = $view ? $view->view_count : 0;
            }

            $randomColor = $this->random_color();
            $datasets[] = [
                'label' => "Apartment $apartmentId",
                'backgroundColor' =>  $randomColor,
                'borderColor' =>  $randomColor,
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


    private function random_color() {
        return sprintf('rgba(%d, %d, %d, %f)', rand(0, 255), rand(0, 255), rand(0, 255), 0.6);
    }
}
