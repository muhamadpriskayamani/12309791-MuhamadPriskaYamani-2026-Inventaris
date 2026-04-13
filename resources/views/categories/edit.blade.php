@extends('layouts.app')

@section('content')
    <div class="container">

        @if ($errors->any())
            <div class="alert alert-danger">
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

                        <h4 class="mb-4 fw-semibold">Edit Category</h4>

                        <form action="{{ route('categories.update', $category->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label fw-medium">Category Name</label>
                                <input type="text" name="name" value="{{ $category->name }}"
                                    class="form-control rounded-3" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-medium">Division</label>
                                <select name="division_pj" class="form-select rounded-3" required>
                                    <option value="Tata Usaha" {{ $category->division_pj == 'Tata Usaha' ? 'selected' : '' }}>Tata Usaha</option>
                                    <option value="Sarpras" {{ $category->division_pj == 'Sarpras' ? 'selected' : '' }}>Sarpras</option>
                                    <option value="Tefa" {{ $category->division_pj == 'Tefa' ? 'selected' : '' }}>Tefa</option>
                                </select>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('categories.index') }}" class="btn btn-light border rounded-3 px-4">
                                    ← Back
                                </a>

                                <button type="submit" class="btn btn-primary rounded-3 px-4">
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
