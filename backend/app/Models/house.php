<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    protected $guarded = ['id'];

    public function houseOccupants()
    {
        return $this->hasMany(HouseOccupant::class);
    }

    public function currentOccupants()
    {
        return $this->hasMany(HouseOccupant::class)->where('end_date', null);
    }
}
