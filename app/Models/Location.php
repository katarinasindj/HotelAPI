<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    // Definisanje imena tabele ukoliko nije automatski prepoznato
    protected $table = 'locations';

    // Definisanje dozvoljenih kolona za masovno dodjeljivanje vrijednosti
    protected $fillable = [
        'city',
        'state',
        'country',
        'zip_code',
        'address'
    ];

    // Definisanje relacije sa itemima
    public function items()
    {
        return $this->hasMany(Item::class, 'location_id');
    }
}
