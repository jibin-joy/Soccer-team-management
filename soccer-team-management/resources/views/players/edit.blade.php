<h2>Edit Player</h2>

<p>
    Team: <strong>{{ $player->team->name }}</strong>
</p>

<form method="POST" action="{{ route('players.update', $player->id) }}">
    @csrf
    @method('PUT')

    <div>
        <label>Player Name</label><br>
        <input type="text" name="name" value="{{ old('name', $player->name) }}" required>
    </div>

    <br>

    <div>
        <label>Position</label><br>
        <input type="text" name="position" value="{{ old('position', $player->position) }}" required>
    </div>

    <br>

    <div>
        <label>Jersey Number</label><br>
        <input type="number" name="jersey_number" value="{{ old('jersey_number', $player->jersey_number) }}" required>
    </div>

    <br>

    <div>
        <label>Status</label><br>
        <select name="status">
            <option value="1" {{ $player->status ? 'selected' : '' }}>Active</option>
            <option value="0" {{ !$player->status ? 'selected' : '' }}>Inactive</option>
        </select>
    </div>

    <br>

    <button type="submit">Update Player</button>
    <a href="{{ route('teams.show', $player->team_id) }}">Cancel</a>
</form>
