@extends('Backend.layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-0">
                <div class="border-bottom title-part-padding">
                    <h4 class="card-title mb-0">add cinema</h4>
                </div>
                <div class="card-body">
                    {{-- content start --}}
                    <div>
                        <form action="{{ route('admin.cinema.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Name</label>
                                        <input type="text" class="form-control" name="name">
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">City</label>
                                        <select class="form-control form-select" name="city_id">
                                            <option>select city</option>
                                            @foreach ($cities as $city)
                                                <option value="{{ $city->id }}">{{ $city->name }}</option>
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
                                                    Add new
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
