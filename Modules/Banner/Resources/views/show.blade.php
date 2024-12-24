@extends('Backend.layouts.app')
@section('content')
<div class="card">
    <div class="border-bottom title-part-padding">
        <h4 class="card-title mb-0">{{ $title }}</h4>
    </div>
    <div class="card-body">
        <form>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="name">Name</label>
                    <input type="text" class="form-control" id="name" value="{{ $banner->name }}" disabled/>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="image">Image</label>
                    @if($banner->image)
                        <img src="{{ asset($banner->image) }}" alt="Banner Image" class="img-fluid" style="width: 150px; height: 150px;"/>
                    @else
                        <p class="form-control-plaintext">No image available</p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label class="form-label" for="note">Note</label>
                    <textarea class="form-control" id="note" disabled>{{ $banner->note }}</textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Status</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" id="display" value="1" {{ $banner->status == 1 ? 'checked' : '' }} disabled>
                        <label class="form-check-label" for="display">Display</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" id="hide" value="0" {{ $banner->status == 0 ? 'checked' : '' }} disabled>
                        <label class="form-check-label" for="hide">Hide</label>
                    </div>
                </div>
            </div>
            <a href="{{ route('banners.index') }}" class="btn btn-secondary mt-3 rounded-pill px-4">Back</a>
        </form>
    </div>
</div>
@endsection
