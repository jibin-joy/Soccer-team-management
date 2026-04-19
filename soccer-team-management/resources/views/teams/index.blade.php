@extends('layouts.masterLayout')

@section('content')

    <div class="card shadow-sm mt-3">
        <div class="card-body">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0">Teams List</h4>

                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTeamModal">
                    + Create Team
                </button>
            </div>

            <!-- Alerts -->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Sl No</th>
                            <th>Team Name</th>
                            <th>Coach</th>
                            <th>Status</th>
                            <th width="230">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($teams as $index => $team)
                            <tr id="team-row-{{ $team->id }}">

                                <td>{{ $index + 1 }}</td>

                                <td>
                                    <a href="{{ route('teams.show', $team->id) }}"
                                    class="text-decoration-none fw-semibold text-primary">
                                        {{ $team->name }}
                                    </a>
                                </td>

                                <td>{{ $team->coach_name }}</td>

                                <td>
                                    <span id="team-status-{{ $team->id }}"
                                        class="badge {{ $team->status ? 'bg-success' : 'bg-danger' }}">
                                        {{ $team->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>

                                <td>
                                    <div class="d-flex flex-wrap gap-2">

                                        <!-- Edit -->
                                        <a href="{{ route('teams.edit', $team->id) }}"
                                        class="btn btn-sm btn-warning">
                                            Edit
                                        </a>

                                        <!-- Delete -->
                                        <form action="{{ route('teams.destroy', $team->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">
                                                Delete
                                            </button>
                                        </form>

                                        <!-- Toggle -->
                                        <button onclick="toggleTeamStatus({{ $team->id }})"
                                                class="btn btn-sm {{ $team->status ? 'btn-secondary' : 'btn-success' }}">
                                            {{ $team->status ? 'Deactivate' : 'Activate' }}
                                        </button>

                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">
                                    No teams found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Create Tean Modal Start --}}
    <div class="modal fade" id="createTeamModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Create Team</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <form method="POST" action="{{ route('teams.store') }}">
                        @csrf

                        <div class="mb-3">
                            <input class="form-control" name="name" placeholder="Team Name" value="{{ old('name') }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <input class="form-control" name="coach_name" placeholder="Coach Name" value="{{ old('coach_name') }}">
                            @error('coach_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Create</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
    {{-- Create Tean Modal Ends --}}

@endsection


@push('scripts')
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
@endpush

