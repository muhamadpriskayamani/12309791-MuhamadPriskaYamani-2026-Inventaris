@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-semibold mb-0">Table Category</h4>

            <div class=" d-flex gap-2">
                <a href="{{ route('categories.export') }}" class="btn btn-success rounded-3 px-4">
                    Export Excel
                </a>
                <a href="{{ route('categories.create') }}" class="btn btn-primary rounded-3 px-4">
                    + Tambah Category
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
                                <th>Division PJ</th>
                                <th>Total Items</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td class="px-4">{{ $categories->firstItem() + $loop->index }}</td>
                                    <td class="fw-medium">{{ $category->name }}</td>
                                    <td>{{ $category->division_pj }}</td>
                                    <td>
                                        <span class="badge bg-secondary">
                                            {{ $category->items->count() }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('categories.edit', $category->id) }}"
                                            class="btn btn-warning btn-sm rounded-3 px-3">
                                            Edit
                                        </a>

                                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-danger btn-sm rounded-3 px-3"
                                                onclick="return confirm('Yakin hapus category ini?')">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>

                <div class="card-footer border-0 bg-white px-4 py-3">
                    {{ $categories->links() }}
                </div>

            </div>
        </div>

    </div>
@endsection
