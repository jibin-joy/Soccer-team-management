<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Player;

class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'team_id'       => 'required|exists:teams,id',
                'name'          => 'required|string|max:255',
                'position'      => 'required|string|max:255',
                'jersey_number' => 'required|integer',
            ],
            [
                'team_id.required'  => 'Team is required',
                'team_id.exists'    => 'Selected team does not exist',

                'name.required'     => 'Player name is required',
                'position.required' => 'Position is required',

                'jersey_number.required' => 'Jersey number is required',
                'jersey_number.integer'  => 'Jersey number must be a number',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $player = Player::create($validator->validated());

            return response()->json([
                'status'  => true,
                'message' => 'Player added successfully',
                'data'    => $player
            ], 201);

        } catch (\Exception $e) {
            \Log::error($e->getMessage());

            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong while creating player'
            ], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $team_id, string $id)
    {
        $player = Player::where('id', $id)->where('team_id', $team_id)->first();

        if (!$player) {
            return response()->json([
                'status'  => false,
                'message' => 'Player not found for this team'
            ], 404);
        }

        if (!$request->hasAny(['name', 'position', 'jersey_number'])) {
            return response()->json([
                'status'  => false,
                'message' => 'At least one field is required'
            ], 422);
        }

        $validator = Validator::make(
            $request->all(),
            [
                'name'          => 'sometimes|string|max:255',
                'position'      => 'sometimes|string|max:255',
                'jersey_number' => 'sometimes|integer',
            ],
            [
                'name.string'            => 'Player name must be a string',
                'position.string'        => 'Position must be a string',
                'jersey_number.integer'  => 'Jersey number must be a number',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $player->update($validator->validated());

            return response()->json([
                'status'  => true,
                'message' => 'Player updated successfully',
                'data'    => $player
            ], 200);

        } catch (\Exception $e) {
            \Log::error($e->getMessage());

            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong while updating player'
            ], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $player = Player::find($id);

        if (!$player) {
            return response()->json([
                'status'  => false,
                'message' => 'Player not found'
            ], 404);
        }

        try {
            $player->delete();

            return response()->json([
                'status'  => true,
                'message' => 'Player deleted successfully'
            ], 200);

        } catch (\Exception $e) {
            \Log::error($e->getMessage());

            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong while deleting player'
            ], 500);
        }
    }

}
