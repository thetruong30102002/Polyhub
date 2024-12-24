@extends('Backend.layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <h1 class="card-title">Category Detail</h1>

            <a href="{{ route('categories.index') }}"><button class="btn btn-warning" style="margin: 20px 0 20px 0;">Back</button></a>

            <div>
                <form>
                    <div class="mb-3">
                        <label for="" class="form-label">Name:</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name', $category->name) }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Created At:</label>
                        <input type="text" class="form-control" name="created_at" value="{{ old('name', $category->created_at) }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Updated At:</label>
                        <input type="text" class="form-control" name="updated_at" value="{{ old('name', $category->updated_at) }}" disabled>
                    </div>

                    {{-- <button type="submit" class="btn btn-primary">Add</button> --}}
                </form>
            </div>

        </div>
    </div>
@endsection