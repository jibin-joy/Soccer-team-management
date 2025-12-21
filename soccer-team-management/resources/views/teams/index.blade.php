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

<h2>Create Team</h2>
<form method="POST" action="{{ route('teams.store') }}">
    @csrf

    <div>
        <input name="name" placeholder="Team Name" value="{{ old('name') }}">
        @error('name')
            <span style="color:red">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <input name="coach_name" placeholder="Coach Name" value="{{ old('coach_name') }}">
        @error('coach_name')
            <span style="color:red">{{ $message }}</span>
        @enderror
    </div>

    <button type="submit">Create</button>
</form>


<hr>

<h2>Teams List</h2>

<table border="1" cellpadding="8" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Sl No</th>
            <th>Team Name</th>
            <th>Coach</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @forelse ($teams as $index => $team)
            <tr id="team-row-{{ $team->id }}">
                <td>{{ $index + 1 }}</td>

                <td>
                    <a href="{{ route('teams.show', $team->id) }}">
                        {{ $team->name }}
                    </a>
                </td>

                <td>{{ $team->coach_name }}</td>

                <td>
                    <span id="team-status-{{ $team->id }}">
                        {{ $team->status ? 'Active' : 'Inactive' }}
                    </span>
                </td>

                <td>
                    <!-- Edit -->
                    <a href="{{ route('teams.edit', $team->id) }}">
                        Edit
                    </a>

                    <!-- Delete -->
                    <form action="{{ route('teams.destroy', $team->id) }}" method="POST" style="display:inline;"
                        onsubmit="return confirm('Are you sure?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>

                    <!-- Active / Inactive -->
                    <button onclick="toggleTeamStatus({{ $team->id }})">
                        {{ $team->status ? 'Deactivate' : 'Activate' }}
                    </button>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5">No teams found</td>
            </tr>
        @endforelse
    </tbody>
</table>
<script>
    function toggleTeamStatus(teamId) {

        let url = "{{ route('teams.toggleStatus', ':id') }}";
        url = url.replace(':id', teamId);

        fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                const statusText = document.getElementById(`team-status-${teamId}`);
                const button = event.target;

                if (data.status == 1) {
                    statusText.innerText = 'Active';
                    button.innerText = 'Deactivate';
                } else {
                    statusText.innerText = 'Inactive';
                    button.innerText = 'Activate';
                }
            });
    }
</script>
