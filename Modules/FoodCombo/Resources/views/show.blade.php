@extends('Backend.layouts.app')

@section('content')
<div class="card">
    <div class="border-bottom title-part-padding">
        <h4 class="card-title mb-0">Food Combo Details</h4>
    </div>
    <div class="card-body">
        <form class="needs-validation">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $foodCombo->name }}" disabled />
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="price">Price</label>
                    <input type="number" class="form-control" id="price" name="price" value="{{ $foodCombo->price }}" disabled />
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label class="form-label" for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" disabled>{{ $foodCombo->description }}</textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="avatar" class="form-label">Avatar</label>
                    <img src="{{ asset($foodCombo->avatar) }}" alt="{{ $foodCombo->name }}" class="img-fluid" id="avatar-preview">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Status</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" id="display" value="1" {{ $foodCombo->status == 1 ? 'checked' : '' }} disabled>
                        <label class="form-check-label" for="display">Display</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" id="hide" value="0" {{ $foodCombo->status == 0 ? 'checked' : '' }} disabled>
                        <label class="form-check-label" for="hide">Hide</label>
                    </div>
                </div>
            </div>
            <a href="{{ route('foodcombos.index') }}" class="btn btn-secondary mt-3 rounded-pill px-4">Back</a>
        </form>
    </div>
</div>
@endsection
