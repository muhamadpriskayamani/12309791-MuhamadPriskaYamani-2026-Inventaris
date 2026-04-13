@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-semibold mb-0">Items Table</h4>

            <div class="d-flex gap-2">
                @if (auth()->user()->role === 'admin')
                    <a href="{{ route('items.export') }}" class="btn btn-success">Export Excel</a>
                    <a href="{{ route('items.create') }}" class="btn btn-primary">+ Add Item</a>
                @endif
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success rounded-3">{{ session('success') }}</div>
        @endif

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="px-4">#</th>
                                <th>Category</th>
                                <th>Name</th>
                                <th>Total</th>
                                <th>Available</th>
                                <th>Lending Total</th>
                                <th>Repair</th>
                                @if (auth()->user()->role === 'admin')
                                    <th class="text-center">Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($items as $item)
                                <tr>
                                    <td class="px-4">{{ $loop->iteration }}</td>
                                    <td>{{ $item->category->name ?? '-' }}</td>
                                    <td class="fw-medium">{{ $item->name }}</td>
                                    <td>{{ $item->total }}</td>
                                    <td>
                                        <span class="badge bg-success text-white">
                                            {{ $item->available }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-info text-dark">
                                            @if (auth()->user()->role === 'admin' && $item->active_lending_count > 0)
                                                <a href="{{ route('lendings.index', ['item_id' => $item->id]) }}"
                                                    class="text-decoration-none text-dark">
                                                    {{ $item->active_lending_count }}
                                                </a>
                                            @else
                                                {{ $item->active_lending_count ?? 0 }}
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-warning text-dark">
                                            {{ $item->repair ?? 0 }}
                                        </span>
                                    </td>
                                    @if (auth()->user()->role === 'admin')
                                        <td class="text-center">
                                            <div class="d-flex gap-2 justify-content-center">
                                                <a href="{{ route('items.edit', $item->id) }}"
                                                    class="btn btn-warning btn-sm rounded-3 px-3">
                                                    Edit
                                                </a>
                                                <form action="{{ route('items.destroy', $item->id) }}" method="POST"
                                                    onsubmit="return confirm('Yakin hapus item {{ $item->name }}?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm rounded-3 px-3">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">No items found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
