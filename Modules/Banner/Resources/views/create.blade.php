@extends('Backend.layouts.app')
@section('content')
<div class="card">
    <div class="border-bottom title-part-padding">
        <h4 class="card-title mb-0">{{ $title }}</h4>
    </div>
    <div class="card-body">
        <form class="needs-validation" action="{{ route('banners.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required/>
                    @if ($errors->has('name'))
                        <span class="error text-danger">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="image">Image</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*" onchange="previewImage(event)" required/>
                    @if ($errors->has('image'))
                        <span class="error text-danger">{{ $errors->first('image') }}</span>
                    @endif
                    <img id="image-preview" class="form-control mt-2" src="#" alt="Preview" style="display: none; width: 150px ; height: 150px;"/>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label class="form-label" for="note">Note</label>
                    <textarea name="note" id="note" class="form-control">{{ old('note') }}</textarea>
                    @if ($errors->has('note'))
                        <span class="error text-danger">{{ $errors->first('note') }}</span>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="status">Status</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="display" name="status" value="display" {{ old('status') === 'display' ? 'checked' : '' }}>
                        <label class="form-check-label" for="display">Display</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="hide" name="status" value="hide" {{ old('status') === 'hide' ? 'checked' : '' }}>
                        <label class="form-check-label" for="hide">Hide</label>
                    </div>
                    @if ($errors->has('status'))
                        <span class="error text-danger">{{ $errors->first('status') }}</span>
                    @endif
                </div>
            </div>
            <button class="btn btn-primary mt-3 rounded-pill px-4" type="submit">Submit form</button>
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
