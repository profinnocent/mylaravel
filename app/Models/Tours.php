<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tours extends Model
{
    use HasFactory;

    protected $fillable = [
        'destination',
        'slug',
        'tour_code',
        'description',
        'city',
       'country',
        'price',
        'visits',
        'rating'
    ];

}
