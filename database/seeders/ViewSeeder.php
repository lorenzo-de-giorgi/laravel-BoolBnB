<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\View;

class ViewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = json_decode(file_get_contents(__DIR__ . '/views.json'), true);
        foreach($data as $view){
            $new_view = new View();
            $new_view->apartment_id = $view['apartment_id'];
            $new_view->ip_address = $view['ip_address'];
            $new_view->date = $view['date'];
            $new_view->save();
        }
    }
}
