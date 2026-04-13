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

                    <h4 class="mb-4 fw-semibold">Edit Item</h4>

                    <form action="{{ route('items.update', $item->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-medium">Name</label>
                            <input type="text" name="name" value="{{ old('name', $item->name) }}"
                                class="form-control rounded-3" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-medium">Category</label>
                            <select name="category_id" class="form-select rounded-3" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id', $item->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-medium">Total</label>
                            <input type="number" name="total" value="{{ old('total', $item->total) }}"
                                class="form-control rounded-3" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-medium">
                                New Broke Item (currently: {{ $item->repair ?? 0 }})
                            </label>
                            <input type="number" name="repair" value="0" class="form-control rounded-3">
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('items.index') }}" class="btn btn-light border rounded-3 px-4">
                                ← Back
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