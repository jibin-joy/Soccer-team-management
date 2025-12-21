<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Team;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $teams = Team::where('status', 1)->get();

            if ($teams->isEmpty()) {
                return response()->json([
                    'status'  => false,
                    'message' => 'No teams found',
                    'data'    => []
                ], 404);
            }

            return response()->json([
                'status'  => true,
                'message' => 'Teams retrieved successfully',
                'data'    => $teams
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong while fetching teams'
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'coach_name' => 'required',
                ],
                [
                    'name.required' => 'Team name is required',
                    'coach_name.required' => 'Coach name is required',
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            $team = Team::create($validator->validated());

            return response()->json([
                'status'  => true,
                'message' => 'Team added successfully',
                'data'    => $team
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong while store teams'
            ], 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
            $team = Team::with('players')->findOrFail($id);
            return response()->json($team, 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong while showing teams'
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            $team = Team::find($id);

            if (!$team) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Team not found'
                ], 404);
            }

            $validator = Validator::make(
                $request->all(),
                [
                    'name'        => 'required|string|max:255',
                    'coach_name' => 'required|string|max:255',
                ],
                [
                    'name.required'        => 'Team name is required',
                    'coach_name.required' => 'Coach name is required',
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            $team->update($validator->validated());

            return response()->json([
                'status'  => true,
                'message' => 'Team updated successfully',
                'data'    => $team
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong while updating teams'
            ], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $team = Team::find($id);
            if (!$team) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Team not found'
                ], 404);
            }
            $team->delete();
            return response()->json([
                'status'  => true,
                'message' => 'Team deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong while destroying teams'
            ], 500);
        }
    }
}
