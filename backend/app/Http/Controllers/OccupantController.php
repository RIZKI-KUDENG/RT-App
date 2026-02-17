<?php

namespace App\Http\Controllers;

use App\Models\HouseOccupant;
use App\Models\Occupant;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OccupantController extends Controller
{
    public function index(){
        $occupants = Occupant::all();
        return response()->json([
            'success' => true,
            'data' => $occupants
        ]);
    }
    public function store(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'ktp' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|in:permanent,contract',
            'phone' => 'required|string|max:255',
            'is_married' => 'required|boolean',
            'house_id' => 'nullable|exists:houses,id',
        ]);
        DB::beginTransaction();
        try{
        $ktp_path = null;
        if ($request->hasFile('ktp')){
            $ktp_path = $request->file('ktp')->store('ktp', 'public');
        }
        $occupant = Occupant::create([
            'name' => $validated['name'],
            'ktp' => $ktp_path,
            'status' => $validated['status'],
            'phone' => $validated['phone'],
            'is_married' => $validated['is_married'],
        ]);
        if($request->filled('house_id')){
            HouseOccupant::create([
            'house_id' => $validated['house_id'],
            'occupant_id' => $occupant->id,
            'start_date' => now(),
            ]);
        }
        }catch(\Exception $e){
            DB::rollBack();
            if(isset($ktp_path)){
                Storage::disk('public')->delete($ktp_path);
            }
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
