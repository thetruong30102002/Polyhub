
@extends('Backend.layouts.app')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card mb-0">
            <div class="border-bottom title-part-padding">
                <h4 class="card-title mb-0">update cinema</h4>
            </div>
            <div class="card-body">     
                {{-- content start --}}
                <div>
                    <form action="{{ route('admin.cinema.update', [$cinema->id]) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ $cinema->name }}">
                                </div>
                            </div>
                            <!--/span-->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">City</label>
                                    <select class="form-control form-select" name="city_id">
                                        @foreach ($cities as $city)
                                            <option class="{{ $cinema->city_id == $city->id ? 'text-danger' : '' }}" value="{{ $city->id }}" {{ $cinema->city_id == $city->id ? 'selected' : '' }} >{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-md-flex align-items-center">
                                    <div class="ms-auto mt-3 mt-md-0">
                                        <button type="submit" class="btn btn-primary  rounded-pill px-4">
                                            <div class="d-flex align-items-center">
                                                <i class="ti ti-send me-2 fs-4"></i>
                                                Update
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            @if ($errors->any())
                                <ul class="errors">
                                    @foreach ($errors->all() as $error)
                                        <li><span class="text-danger">{{ $error }}</span></li>
                                    @endforeach
                                </ul>
                            @endif

                        </div>
                    </form>

                </div>
                {{-- content end --}}
            </div>
        </div>
    </div>
</div>
@endsection
