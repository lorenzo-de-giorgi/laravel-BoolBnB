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

        // Recupera le visualizzazioni raggruppate per apartment_id e data
        $views = View::select('apartment_id', 'date', DB::raw('count(*) as view_count'), 'apartments.title')
            ->join('apartments', 'views.apartment_id', '=', 'apartments.id')
            ->whereHas('apartment', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->groupBy('apartment_id', 'date', 'apartments.title')
            ->get();

        // Inizializza l'array per i grafici
        $charts = [];

        // Cicla attraverso i gruppi di visualizzazioni per ogni appartamento
        foreach ($views->groupBy('apartment_id') as $apartmentId => $viewGroup) {
            // Ottieni le date uniche come etichette
            $labels = $viewGroup->pluck('date')->unique()->values()->toArray();
            $title = $viewGroup->first()->title;
            // Inizializza l'array dei dati
            $data = [];
            foreach ($labels as $label) {
                $view = $viewGroup->firstWhere('date', $label);
                $data[] = $view ? intval($view->view_count) : 0;
            }

            // Genera un colore casuale per il grafico
            $randomColor = $this->random_color();

            // Crea il dataset per il grafico corrente
            $dataset = [
                'label' => $title,
                'backgroundColor' =>  $randomColor,
                'borderColor' =>  $randomColor,
                'data' => $data,
            ];

            // Crea il grafico per l'appartamento corrente
            $chart = app()->chartjs
                ->name('lineChart' . $apartmentId)
                ->type('line')
                ->size(['width' => 400, 'height' => 200])
                ->labels($labels)
                ->datasets([$dataset])
                ->options([
                    'plugins' => [
                        'legend' => [
                            'display' => true,
                            
                            'title' => [
                                'align' => 'end',
                                'color'=> $randomColor,
                                'text' => $title,
                                'display' => true,
                                'font' => [
                                    'size' => 40
                                ]

                            ],
                            'labels' => [
                                'color'=> $randomColor,
                                'font' => [
                                    'weight' => 'bolder',
                                ]
                                
                                
                            ],
                        ],
                    ],
                ]);

            // Aggiungi il grafico all'array dei grafici
            $charts[$apartmentId] = $chart;
        }

        // Passa l'array dei grafici alla vista
        return view('admin.dashboard', compact('charts', 'views'));
    }

    private function random_color()
    {
        return sprintf('rgba(%d, %d, %d, %f)', rand(0, 255), rand(0, 255), rand(0, 255), 1);
    }
}