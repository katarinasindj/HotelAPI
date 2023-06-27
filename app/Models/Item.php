<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $table = 'items';

    protected $fillable = [
        'name',
        'rating',
        'category',
        'location_id',
        'image',
        'reputation',
        'reputationBadge',
        'price',
        'availability'
    ];

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }
}
