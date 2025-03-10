<?php

namespace App\Http\Controllers;

use App\Models\Park;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ParkController extends Controller
{
    public function allParks()
    {
        $parks = Park::all();
        return response()->json(["parks" => $parks]);
    }

    public function createPark(Request $req){
        $validator = Validator::make(
            $req->all(),
            [
                'location' => 'string|required',
                'total_places' => 'integer|required|min:1',
            ]
            );
            if($validator->fails()){
                return response()->json([
                    'errors'=> $validator->errors()
                ]);
            };
            try {
                Park::create([
                    'location' => $req->location ,
                    'total_places' => $req->location ,
                ]);
                return response()->json([
                    "success" => "Park created successfully",
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    "error" => $th->getMessage(),
                ]);
            }
    }
}
