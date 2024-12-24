@extends('Backend.layouts.app')
@section('content')
<div class="card">
    <div class="border-bottom title-part-padding">
        <h4 class="card-title mb-0">{{$title}}</h4>
    </div>
    <div class="card-body">
        <form class="needs-validation" action="/admin/movie" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name here" required>
                    @error('name')
                    <div class="text text-danger">{{ $message }}</div>
                    @enderror  
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="description">Description</label>
                    <input type="text" class="form-control" id="description" name="description" placeholder="Enter Description" required>
                    @error('description')
                    <div class="text text-danger">{{ $message }}</div>
                    @enderror 
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="duration">Duration</label>
                    <input type="number" class="form-control" id="duration" name="duration" placeholder="Enter Duration" required>
                    @error('duration')
                    <div class="text text-danger">{{ $message }}</div>
                    @enderror 
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="premiere_date">Premiere date</label>
                    <input type="date" class="form-control" id="premiere_date" name="premiere_date" placeholder="Enter Premiere date" required>
                    @error('premiere_date')
                    <div class="text text-danger">{{ $message }}</div>
                    @enderror 
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="director_id">Director</label>
                    <select class="form-select" id="director_id" name="director_id" required>
                        <option value="0"></option>
                        @foreach($director as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                    @error('director_id')
                    <div class="text text-danger">{{ $message }}</div>
                    @enderror 
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="photo">Choose Photo</label>
                    <input type="file" class="form-control" id="photo" name="photo" accept="image/*" required>
                    @error('photo')
                    <div class="text text-danger">{{ $message }}</div>
                    @enderror 
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="categories">Categories</label>
                    <select class="form-select" id="categories" name="categories[]" multiple required>
                        @foreach ($categories as $category)
                        @if (!$category->category_id)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @include('movie::partials.children_categories', ['categories' => $categories, 'parent_id' => $category->id, 'char' => '|---','selectedCategories' => []])
                        @endif
                        @endforeach
                    </select>
                    @error('categories')
                    <div class="text text-danger">{{ $message }}</div>
                    @enderror 
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
