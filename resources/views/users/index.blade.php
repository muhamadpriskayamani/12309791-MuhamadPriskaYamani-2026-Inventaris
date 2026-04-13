@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h4 class="fw-semibold mb-0">Daftar Users</h4>
                @if (!empty($role))
                    <small class="text-muted">Filter: {{ ucfirst($role) }}</small>
                @endif
            </div>

            <div class="d-flex gap-2">
                @if (empty($role))
                    <a href="{{ route('users.export', ['role' => 'admin']) }}" class="btn btn-success rounded-3 px-4">
                        Export Admin
                    </a>
                    <a href="{{ route('users.export', ['role' => 'staff']) }}" class="btn btn-success rounded-3 px-4">
                        Export Staff
                    </a>
                @else
                    <a href="{{ route('users.export', ['role' => $role]) }}" class="btn btn-success rounded-3 px-4">
                        Export {{ ucfirst($role) }}
                    </a>
                @endif
                <a href="{{ route('users.create') }}" class="btn btn-primary rounded-3 px-4">
                    + Tambah User
                </a>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="px-4">#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td class="px-4">{{ $loop->iteration }}</td>

                                    <td class="fw-medium">{{ $user->name }}</td>

                                    <td class="text-muted">{{ $user->email }}</td>

                                    <td>
                                        <span class="badge bg-secondary">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        @if ($user->role === 'staff')
                                            <form method="POST" action="{{ route('users.reset-password', $user) }}"
                                                class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-info btn-sm rounded-3 px-3"
                                                    onclick="return confirm('Reset password staff ini?')">
                                                    Reset Password
                                                </button>
                                            </form>
                                        @else
                                            <a href="{{ route('users.edit', $user) }}"
                                                class="btn btn-warning btn-sm rounded-3 px-3">
                                                Edit
                                            </a>
                                        @endif

                                        <form method="POST" action="{{ route('users.destroy', $user) }}" class="d-inline">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-danger btn-sm rounded-3 px-3"
                                                onclick="return confirm('Hapus user ini?')">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        Tidak ada user.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>

            </div>
        </div>

    </div>
@endsection
