@extends('Backend.layouts.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-0">
                <div class="border-bottom title-part-padding">
                    <h4 class="card-title mb-0">Add new room</h4>
                </div>
                <div class="card-body">
                    {{-- content start --}}
                    <section class="container">
                        <div class="card">
                            <div class="card-body">
                                <form action="" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12 input-group my-4">
                                            <span class="input-group-text">name</span>
                                            <input class="form-control" type="text" name="name">
                                        </div>
                                        <div class="col input-group my-4">
                                            <span class="input-group-text">City</span>
                                            <select id="city-select" name="city_id" class="form-select">
                                                <option value="">Select city</option>
                                                @foreach ($cities as $city)
                                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col input-group my-4">
                                            <span class="input-group-text">Cinema</span>
                                            <select id="cinemaSelect" name="cinema_id" class="form-select" disabled>
                                                <option value="">Select cinema</option>
                                            </select>
                                        </div>
                                        <div class="col-12 my-4">
                                            <div class="d-md-flex align-items-center">
                                                <div class="ms-auto mt-3 mt-md-0">
                                                    <button type="submit" class="btn btn-primary  rounded-pill px-4">
                                                        <div class="d-flex align-items-center">
                                                            Add new
                                                        </div>
                                                    </button>
                                                </div>
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
                                </form>
                            </div>
                        </div>
                    </section>
                    {{-- content end --}}
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/js/apps/selectCinemas.js') }}"></script>
@endsection
