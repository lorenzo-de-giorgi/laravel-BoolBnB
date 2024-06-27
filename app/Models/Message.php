<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = 
    [
        'apartment_id',
        'name',
        'surname',
        'email',
        'date',
        'content',

    ];


    public function messages()
    {
        return $this->belongsTo(Message::class);
    }
}


