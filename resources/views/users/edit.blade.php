@extends('layouts.app')

@section('content')
    <div class="container">

        @if ($errors->any())
            <div class="alert alert-danger rounded-3">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body p-4">

                        <h4 class="mb-4 fw-semibold">Edit User</h4>

                        <form method="POST" action="{{ $formAction ?? route('users.update', $user->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label fw-medium">Name</label>
                                <input name="name" value="{{ old('name', $user->name) }}" class="form-control rounded-3"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-medium">Email</label>
                                <input name="email" value="{{ old('email', $user->email) }}"
                                    class="form-control rounded-3" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-medium">Role</label>
                                <select name="role" class="form-select rounded-3" required
                                    {{ isset($disableRole) && $disableRole ? 'disabled' : '' }}>
                                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin
                                    </option>
                                    <option value="staff" {{ old('role', $user->role) == 'staff' ? 'selected' : '' }}>Staff
                                    </option>
                                </select>
                                @if (isset($disableRole) && $disableRole)
                                    <input type="hidden" name="role" value="{{ $user->role }}">
                                @endif
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-medium">New Password</label>
                                <input type="password" name="password" class="form-control rounded-3">
                                <small class="text-muted">Kosongkan jika tidak ingin mengubah password</small>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ $cancelRoute ?? route('users.index') }}"
                                    class="btn btn-light border rounded-3 px-4">
                                    ← Kembali
                                </a>

                                <button class="btn btn-primary rounded-3 px-4">
                                    Update
                                </button>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection
