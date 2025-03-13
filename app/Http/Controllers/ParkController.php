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

    public function createPark(Request $req)
    {
        $validator = Validator::make(
            $req->all(),
            [
                'name' => "string|required",
                'location' => 'string|required',
                'total_places' => 'integer|required|min:1',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        };
        try {
            Park::create([
                'name' => $req->name,
                'location' => $req->location,
                'total_places' => $req->total_places,
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
    public function getById($id)
    {
        $park = Park::find($id);
        if (!$park) {
            return response()->json([
                'error' => 'Park not found',
            ], 404);
        }
        return response()->json(['park' => $park]);
    }

    public function deletePark($id)
    {
        $park = Park::find($id);
        if (!$park) {
            return response()->json([
                'error' => "Park not found"
            ], 404);
        }

        $park->delete();
        return response()->json([
            "success" => "Park deleted successfully"
        ], 200);
    }

    public function update(Request $req, $id)
    {
        $park = Park::find($id);
        if (!$park) {
            return response()->json([
                'error' => "Park not found"
            ], 404);
        }

        $validator = Validator::make(
            $req->all(),
            [
                'name' => "string|nullable",
                'location' => 'string|nullable',
                'total_places' => 'integer|nullable|min:1',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        };

        try {
            $park->update($req->all());
            return response()->json([
                "success" => "Park updated successfully",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "error" => $th->getMessage(),
            ]);
        }

    }
    
    public function statistiques()
    {
        $parks = Park::all();
        $totalParks = $parks->count();
        $totalPlaces = $parks->sum('total_places');
        return response()->json([
            "total_parks" => $totalParks,
            "total_places" => $totalPlaces,
        ]);
    }
public function searchByName(Request $request)
{
    $name = $request->query('name');
    $parks = Park::where('name', 'like', '%' . $name . '%')->get();
    return response()->json(['parks' => $parks]);
}

}
