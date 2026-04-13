@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Lending Detail</h2>

    <div class="card">
        <div class="card-body">
            <p><strong>Name:</strong> {{ $lending->borrower_name }}</p>
            <p><strong>Description:</strong> {{ $lending->description }}</p>
            <p><strong>Date:</strong>
                {{ \Carbon\Carbon::parse($lending->created_at)->translatedFormat('d F Y H:i') }}
            </p>
            <p><strong>Status:</strong>
                <span class="badge {{ $lending->status == 'Returned' ? 'bg-success' : 'bg-warning' }}">
                    {{ $lending->status }}
                </span>
            </p>
            <p><strong>Edited By:</strong> {{ $lending->edited_by }}</p>

            <hr>

            <h5>Items</h5>
            <ul>
                @foreach ($lending->items as $li)
                    <li>{{ $li->item->name }} - {{ $li->total }}</li>
                @endforeach
            </ul>

            <a href="{{ route('lendings.index') }}" class="btn btn-secondary mt-3">
                Back
            </a>
        </div>
    </div>
</div>
@endsection
