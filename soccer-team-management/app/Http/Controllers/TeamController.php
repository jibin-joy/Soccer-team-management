<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::all();
        return view('teams.index', compact('teams'));
    }

    public function show($id)
    {
        $team = Team::with('players')->findOrFail($id);
        return view('teams.show', compact('team'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name'        => 'required|string|max:255',
                'coach_name' => 'required|string|max:255',
            ],
            [
                'name.required'        => 'Team name is required',
                'name.string'          => 'Team name must be a valid text',
                'coach_name.required' => 'Coach name is required',
                'coach_name.string'   => 'Coach name must be a valid text',
            ]
        );

        Team::create($request->all());
        return redirect()->back();
    }

    public function edit($id)
    {
        $team = Team::findOrFail($id);
        return view('teams.edit', compact('team'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'name'        => 'required|string|max:255',
                'coach_name' => 'required|string|max:255',
            ],
            [
                'name.required'        => 'Team name is required',
                'name.string'          => 'Team name must be a valid text',
                'coach_name.required' => 'Coach name is required',
                'coach_name.string'   => 'Coach name must be a valid text',
            ]
        );

        $team = Team::findOrFail($id);
        $team->update($request->only('name', 'coach_name'));

        return redirect()->route('teams')->with('success', 'Team updated successfully');
    }


    public function destroy($id)
    {
        $team = Team::findOrFail($id);
        $team->delete();
        return redirect()->route('teams')->with('success', 'Team deleted successfully');
    }

    public function toggleStatus($id)
    {
        $team = Team::findOrFail($id);
        $team->status = !$team->status;
        $team->save();

        return response()->json([
            'status' => $team->status
        ]);
    }

}

