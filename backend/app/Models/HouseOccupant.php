<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HouseOccupant extends Model
{
    protected $guarded = ['id'];

    public function occupant(){
        return $this->belongsTo(Occupant::class);
    }

    public function house(){
        return $this->belongsTo(House::class);
    }
}
