<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReservationController extends Controller
{

    public function getAll()
    {
        $reservations = Reservation::all();
        return response()->json([
            'reservations' => $reservations
        ]);
    }
    public function getById($id) {}
    public function create(Request $req)
    {
        $validator = Validator::make(
            $req->all(),
            [
                'user_id' => 'required|exists:users,id',
                'park_id' => 'required|exists:parks,id',
                'start_date' => 'required|date|after_or_equal:today|before:end_date',
                'end_date' => 'required|date|after:start_date',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                "errors" => $validator->errors()
            ]);
        }
        try {
            Reservation::create([
                'user_id' => $req->user_id,
                'park_id' => $req->park_id,
                'start_date' => $req->start_date,
                'end_date' => $req->end_date,
            ]);
            return response()->json([
                "success" => "Reservation created successfully"
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "error" => $th->getMessage()
            ], 500);
        }
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'start_date' => 'required|date|after_or_equal:today|before:end_date',
            'end_date' => 'required|date|after:start_date',
            'status' => '|in:canceled',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $reservation = Reservation::find($id);

            $reservation->update($request->all());

            return response()->json(['success' => 'Reservation updated successfully'], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
    public function getReservationById($id)
    {
        $reservation = Reservation::where("user_id", $id)->get();
        return response()->json(["reservations" => $reservation]);
    }
}
