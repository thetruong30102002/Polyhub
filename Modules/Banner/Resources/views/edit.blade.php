@extends('Backend.layouts.app')
@section('content')
<div class="card">
    <div class="border-bottom title-part-padding">
        <h4 class="card-title mb-0">{{ $title }}</h4>
    </div>
    <div class="card-body">
        <form class="needs-validation" action="{{ route('banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $banner->name) }}" required/>
                    @if ($errors->has('name'))
                        <span class="error text-danger">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="image">Image</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*" onchange="previewImage(event)"/>
                    @if ($errors->has('image'))
                        <span class="error text-danger">{{ $errors->first('image') }}</span>
                    @endif
                    @if($banner->image)
                        <img id="image-preview" class="form-control mt-2" src="{{ asset($banner->image) }}" alt="Preview" style="width: 150px; height: 150px;"/>
                    @else
                        <img id="image-preview" class="form-control mt-2" src="#" alt="Preview" style="display: none; width: 150px; height: 150px;"/>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label class="form-label" for="note">Note</label>
                    <textarea name="note" id="note" class="form-control">{{ old('note', $banner->note) }}</textarea>
                    @if ($errors->has('note'))
                        <span class="error text-danger">{{ $errors->first('note') }}</span>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Status</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" id="display" name="status" value="1" {{ old('status', $banner->status) == '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="display">Display</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" id="hide" name="status" value="0" {{ old('status', $banner->status) == '0' ? 'checked' : '' }}>
                        <label class="form-check-label" for="hide">Hide</label>
                    </div>
                    @if ($errors->has('status'))
                        <span class="error text-danger">{{ $errors->first('status') }}</span>
                    @endif
                </div>
            </div>
            <button class="btn btn-primary mt-3 rounded-pill px-4" type="submit">Update Banner</button>
            <a href="{{ route('banners.index') }}" class="btn btn-secondary mt-3 rounded-pill px-4">Back</a>
        </form>
    </div>
</div>
<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('image-preview');
            output.src = reader.result;
            output.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection
