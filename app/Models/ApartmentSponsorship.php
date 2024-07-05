<?php

namespace App\Models;
use App\Models\Apartment;
use App\Models\Sponsorship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot; 

class ApartmentSponsorship extends Pivot
{
    use HasFactory;
    protected $table = 'apartment_sponsorships';
    protected $fillable = ['id', 'apartment_id', 'sponsorship_id', 'name', 'price', 'start_time', 'end_time'];

    public function apartment(){
        return $this->belongsToMany(Apartment::class);
    }
    public function sponsorship(){
        return $this->belongsToMany(Sponsorship::class);
    }
}
