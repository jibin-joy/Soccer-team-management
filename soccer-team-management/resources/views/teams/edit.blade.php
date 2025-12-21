<h2>Edit Team</h2>

<form method="POST" action="{{ route('teams.update', $team->id) }}">
    @csrf
    @method('POST')

    <input name="name" value="{{ old('name', $team->name) }}" placeholder="Team Name">

    <input name="coach_name" value="{{ old('coach_name', $team->coach_name) }}" placeholder="Coach Name">

    <button type="submit">Update</button>
</form>

<a href="{{ route('teams') }}">Back</a>
