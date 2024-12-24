@extends('Backend.layouts.app')
@section('content')
<div class="card">
    <div class="border-bottom title-part-padding">
        <h4 class="card-title mb-0">{{$title}}</h4>
    </div>
    <div class="card-body">
        <form action="/admin/blog" enctype="multipart/form-data" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="title">Title</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title here" required>
                    @error('title')
                    <div class="text text-danger">{{ $message }}</div>
                    @enderror  
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="short_desc">Short Description</label>
                    <input type="text" class="form-control" id="short_desc" name="short_desc" placeholder="Enter Short Description here" required>
                    @error('short_desc')
                    <div class="text text-danger">{{ $message }}</div>
                    @enderror  
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label" for="content">Content</label>
                    <textarea name="content" id="mytextarea" class="form-control"></textarea>
                    @error('content')
                    <div class="text text-danger">{{ $message }}</div>
                    @enderror 
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="formFile">Image</label>
                    <input class="form-control" type="file" id="formFile" name="image" required>
                    @error('image')
                    <div class="text text-danger">{{ $message }}</div>
                    @enderror 
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="categories_id">Category</label>
                    <select class="form-select" id="categories_id" name="categories_id" required> 
                        <option value="">Select a category</option>
                        @foreach ($categories as $item)
                            @if (!$item->category_id)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @include('blog::partials.children_categories', ['categories' => $categories, 'parent_id' => $item->id, 'char' => '|---'])
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="d-md-flex align-items-center">
                <div class="ms-auto mt-3 mt-md-0">
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <div class="d-flex align-items-center">
                            <i class="ti ti-send me-2 fs-4"></i>
                            Submit
                        </div>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
