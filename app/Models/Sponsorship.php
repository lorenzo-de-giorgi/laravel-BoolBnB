<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use app\Models\Apartment;

class Sponsorship extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'name',
        'price',
        'duration',
        'badge',
    ];

    public function apartments()
    {
        return $this->belongsToMany(Apartment::class);
    }

}
