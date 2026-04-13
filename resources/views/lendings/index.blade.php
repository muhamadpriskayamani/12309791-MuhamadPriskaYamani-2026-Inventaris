@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Lending Data</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="d-flex justify-content-end mb-3 gap-2">
            <a href="{{ route('lendings.export') }}" class="btn btn-success">
                Export Excel
            </a>
            @if (auth()->user()->role === 'staff')
                <a href="{{ route('lendings.create') }}" class="btn btn-primary">
                    + Add Lending
                </a>
            @endif
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Item</th>
                    <th>Total</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Edited By</th>
                    @if (auth()->user()->role === 'staff')
                        <th width="200">Action</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($lendings as $lending)
                    <tr>
                        <td>{{ $lending->id }}</td>
                        <td>
                            @foreach ($lending->lendingItems as $li)
                                {{ $li->item->name }}

                                <span class="badge {{ $li->status == 'Returned' ? 'bg-success' : 'bg-warning' }}">
                                    {{ $li->status }}
                                </span>

                                @if ($li->status == 'Not Returned' && auth()->user()->role === 'staff')
                                    <form action="{{ route('lending-items.return', $li->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        <button class="btn btn-sm btn-success"
                                            onclick="return confirm('Return this item?')">
                                            ✔
                                        </button>
                                    </form>
                                @endif

                                <br>
                            @endforeach
                        </td>
                        <td>
                            @foreach ($lending->lendingItems as $li)
                                {{ $li->total }}<br>
                            @endforeach
                        </td>
                        <td>{{ $lending->borrower_name }}</td>
                        <td>{{ $lending->description }}</td>
                        <td>{{ strtolower(\Carbon\Carbon::parse($lending->created_at)->timezone(config('app.timezone'))->locale('id')->translatedFormat('d F Y H:i')) }}
                        </td>
                        <td>
                            {{-- <span class="badge {{ $lending->status == 'Returned' ? 'bg-success' : 'bg-warning' }}">
                                {{ $lending->status }}
                            </span> --}}
                            @php
                                $allReturned = $lending->lendingItems->every(fn($li) => $li->status === 'Returned');
                            @endphp

                            <span class="badge {{ $allReturned ? 'bg-success' : 'bg-warning' }}">
                                {{ $allReturned ? 'Returned' : 'Not Returned' }}
                            </span>
                        </td>
                        <td>{{ $lending->edited_by }}</td>
                        @if (auth()->user()->role === 'staff')
                            <td>
                                @if ($lending->status == 'Not Returned')
                                    <form action="{{ route('lendings.returned', $lending->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        <button class="btn btn-success btn-sm"
                                            onclick="return confirm('Mark this item as returned?')">
                                            Returned
                                        </button>
                                    </form>
                                @endif

                                <a href="{{ route('lendings.show', $lending->id) }}" class="btn btn-info btn-sm">
                                    View
                                </a>
                            </td>
                        @endif
                    </tr>
                @empty
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
