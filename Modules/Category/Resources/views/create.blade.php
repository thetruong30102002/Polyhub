@extends('Backend.layouts.app')

@section('content')

    <div class="card">
        <div class="card-body">
            <h1 class="card-title">Add Category</h1>

            <a href="{{ route('categories.index') }}"><button class="btn btn-warning" style="margin: 20px 0 20px 0;">Back</button></a>

            <div>
                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="" class="form-label">Name:</label>
                        <input type="text" class="form-control" name="name" value="">
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Parent ID:</label>

                        <select class="form-select" name="category_id">
                            <option value="">Select a category</option>
                            @foreach ($categories as $item)
                                @if (!$item->category_id)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @include('category::partials.children_categories_create', ['categories' => $categories, 'parent_id' => $item->id, 'char' => '|---'])
                                @endif
                            @endforeach
                        </select>

                    </div>

                    <button type="submit" class="btn btn-primary">Add</button>
                </form>
            </div>

        </div>
    </div>

    

    {{-- <div class="card w-100">
        <div class="card-body">
            <h1 class="card-title">Card title</h1>

            <select class="form-select" aria-label="Default select example">
                <option value="">Select a category</option>
                @foreach ($categories as $item)
                    @if (!$item->category_id)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @include('category::partials.children_categories', ['categories' => $categories, 'parent_id' => $item->id, 'char' => '|---'])
                    @endif
                @endforeach
            </select>
        </div>
    </div> --}}

@endsection