<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Player;

class PlayerController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'team_id' => 'required|exists:teams,id',
            'name'          => 'required|string|max:255',
            'position'      => 'required|string|max:255',
            'jersey_number' => 'required|integer',
        ],[
            'name.required'          => 'Player name is required',
            'position.required'      => 'Position is required',
            'jersey_number.required' => 'Jersey number is required',
            'jersey_number.integer'  => 'Jersey number must be a number',
        ]);

        Player::create($request->all());
        return redirect()->back()->with('success', 'Player added successfully');
    }

    public function edit($id)
    {
        $player = Player::with('team')->findOrFail($id);
        return view('players.edit', compact('player'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'position'      => 'required|string|max:100',
            'jersey_number' => 'required|integer',
            'status'        => 'required|boolean',
        ]);

        $player = Player::findOrFail($id);

        $player->update([
            'name'          => $request->name,
            'position'      => $request->position,
            'jersey_number' => $request->jersey_number,
            'status'        => $request->status,
        ]);

        return redirect()->route('teams.show', $player->team_id)->with('success', 'Player updated successfully');
    }
    public function destroy($id)
    {
        Player::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Player deleted');
    }

    public function toggleStatus($id)
    {
        $player = Player::findOrFail($id);
        $player->status = !$player->status;
        $player->save();

        return response()->json(['status' => $player->status]);
    }

}
