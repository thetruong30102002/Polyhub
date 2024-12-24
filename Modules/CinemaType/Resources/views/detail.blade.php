@extends('Backend.layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-0">
            <div class="border-bottom title-part-padding">
                <h4 class="card-title mb-0">detail cinematype</h4>
            </div>
            <div class="card-body">
                {{-- content start --}}
                <section>
                    <form action="{{ route('admin.cinematype.update', [$cinemaType->id]) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ $cinemaType->name }}">
                                </div>
                            </div>
                            <!--/span-->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">cinema</label>
                                    <select class="form-control form-select" name="cinema_id">
                                        @foreach ($cinemas as $cinema)
                                            <option class="{{ $cinema->id == $cinemaType->cinema_id ? 'text-danger' : '' }}"
                                                value="{{ $cinema->id }}"
                                                {{ $cinema->id == $cinemaType->cinema_id ? 'selected' : '' }}>{{ $cinema->name }}
                                            </option>
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
                        </div>
                        @if ($errors->any())
                            <div>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li><span class="text-danger">{{ $error }}</span></li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </form>
                </section>
                {{-- content end --}}
            </div>
        </div>
    </div>
</div>

@endsection
