<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $table = 'locations';

    protected $fillable = [
        'city',
        'state',
        'country',
        'zip_code',
        'address'
    ];

    public function items()
    {
        return $this->hasMany(Item::class, 'location_id');
    }
}
