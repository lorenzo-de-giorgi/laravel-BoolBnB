<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use app\Models\Message;
use app\Models\Service;
use app\Models\User;
use app\Models\View;
use app\Models\Sponsorship;
class Apartment extends Model
{
    use HasFactory;

    protected $fillable = 
    [
        'user_id',
        'slug',
        'title',
        'beds_num',
        'rooms_num',
        'bathrooms_num',
        'square_meters',
        'address',
        'latitude',
        'longitude',
        'image',
        'visibility',
    ];    

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function services(){
        return $this->belongsToMany(Service::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function views()
    {
        return $this->hasMany(View::class);
    }

    public function sponsorhips(){
        return $this->belongsToMany(Sponsorship::class);
   }
}