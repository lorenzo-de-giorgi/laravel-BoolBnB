<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;
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
     
   public static function generateSlug($title)
    {
        $slug = Str::slug($title, '-');
        $count = 1;
        while (Apartment::where('slug', $slug)->first()) {
            $slug = Str::of($title)->slug('-') . "-{$count}";
            $count++;
        }
        return $slug;
    }

    public static function getCoordinatesFromAddress(string $address): array
    {
        $client = new \GuzzleHttp\Client([
            'verify' => false,
        ]);
       /*  $addressencode = urlencode($address); */
        $response = $client->get('https://api.tomtom.com/search/2/geocode/%27.'.$address.'.%27.json?&countrySet=IT&key=hIVJ6KmFQZmgUkP1BtrGvGv1TDEXnA7G');
        error_log(print_r($response,true));
        $data = json_decode($response->getBody(), true);
        $latitude = $data['results'][0]['position']['lat'];
        $longitude = $data['results'][0]['position']['lon'];
        return compact('latitude', 'longitude');
    }
}