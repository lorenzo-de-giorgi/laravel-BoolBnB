<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    { 
         $data = json_decode(file_get_contents(__DIR__ . '\services.json'), true);
        foreach($data as $service){
            $new_service = new Service();
            $new_service->name = $service['name'];
            $new_service->icon = $service['icon'];
            $new_service->save();
        }
        
    }
}
