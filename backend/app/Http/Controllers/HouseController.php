<?php

namespace App\Http\Controllers;

use App\Models\House;

use Illuminate\Http\Request;

class HouseController extends Controller
{
    public function index(){
        $houses = House::with('currentOccupant.occupant')->get();

        return response()->json([
            'success' => true,
            'data' => $houses
        ]);
    }
}
