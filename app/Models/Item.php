<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    // Definisanje imena tabele ukoliko nije automatski prepoznato
    protected $table = 'items';

    // Definisanje dozvoljenih kolona za masovno dodjeljivanje vrijednosti
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

    // Definisanje relacije sa lokacijom
    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }
}
