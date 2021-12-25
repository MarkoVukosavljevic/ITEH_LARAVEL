<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barbie extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'hair_color',
        'eye_color',
        'length',
        'country_id',
        'price',
    ];

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
