@if (session('success'))
    <div style="color: green; border:1px solid green; padding:10px; margin-bottom:10px;">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div style="color: red; border:1px solid red; padding:10px; margin-bottom:10px;">
        {{ session('error') }}
    </div>
@endif


<h2>
    {{ $team->name }} (Coach: {{ $team->coach_name }})
</h2>

<h3>Add Player</h3>

<form method="POST" action="{{ route('players.store') }}">
    @csrf

    <input type="hidden" name="team_id" value="{{ $team->id }}">

    <div>
        <input name="name" placeholder="Player Name" value="{{ old('name') }}">
        @error('name')
            <span style="color:red">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <input name="position" placeholder="Position" value="{{ old('position') }}">
        @error('position')
            <span style="color:red">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <input name="jersey_number" placeholder="Jersey Number" value="{{ old('jersey_number') }}">
        @error('jersey_number')
            <span style="color:red">{{ $message }}</span>
        @enderror
    </div>

    <button type="submit">Add Player</button>
</form>



<hr>

<h3>Players List</h3>

<table border="1" cellpadding="8" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Sl No</th>
            <th>Player Name</th>
            <th>Position</th>
            <th>Jersey No</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @forelse ($team->players as $index => $player)
            <tr id="player-row-{{ $player->id }}">
                <td>{{ $index + 1 }}</td>
                <td>{{ $player->name }}</td>
                <td>{{ $player->position }}</td>
                <td>{{ $player->jersey_number }}</td>

                <td>
                    <span id="player-status-{{ $player->id }}">
                        {{ $player->status ? 'Active' : 'Inactive' }}
                    </span>
                </td>

                <td>
                    <!-- Edit -->
                    <a href="{{ route('players.edit', $player->id) }}">
                        Edit
                    </a>

                    <!-- Delete -->
                    <form action="{{ route('players.destroy', $player->id) }}" method="POST" style="display:inline;"
                        onsubmit="return confirm('Are you sure?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>

                    <!-- Status Toggle -->
                    <button data-url="{{ route('players.toggleStatus', $player->id) }}"
                        onclick="togglePlayerStatus(this)">
                        {{ $player->status ? 'Deactivate' : 'Activate' }}
                    </button>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6">No players found</td>
            </tr>
        @endforelse
    </tbody>
</table>
<button type="button" onclick="window.location.href='{{ route('teams') }}'">
    Back
</button>
<hr>
