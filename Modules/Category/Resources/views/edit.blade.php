@extends('Backend.layouts.app')

@section('content')

    <div class="card">
        <div class="card-body">
            <h1 class="card-title">Edit Category</h1>

            <a href="{{ route('categories.index') }}"><button class="btn btn-warning" style="margin: 20px 0 20px 0;">Back</button></a>

            <div>
                <form action="{{ route('categories.update', ['category' => $category->id]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="" class="form-label">Name:</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name', $category->name) }}">
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Parent Category:</label>

                        <select class="form-control" name="category_id">
                            <option value="">None</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ $category->category_id == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>

                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>

        </div>
    </div>
    
@endsection