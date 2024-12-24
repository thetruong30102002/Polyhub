@extends('Backend.layouts.app')

@section('content')
    {{-- nav start --}}
    <div class="card shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body d-flex align-items-center justify-content-between p-4">
            <h4 class="fw-semibold mb-0">Create new city</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="{{ route('admin.city.index') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">city</li>
                </ol>
            </nav>
        </div>
    </div>
    {{-- nav end --}}

    {{-- content start --}}
    <section>

        <form action="{{ route('admin.city.store') }}" class="mt-4" method="POST">
            @csrf
            <div class="col-md-12">
                <div class="mb-3">
                    <label class="form-label" for="tb-fname">Name</label>
                    <input name="name" type="text" class="form-control rounded-pill" id="tb-fname" placeholder="Enter Name here">
                </div>
                @if ($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
            </div>
            <button class="btn btn-primary rounded-pill px-4 mt-3" type="submit">
                Submit form
            </button>
        </form>

    </section>
    {{-- content end --}}
@endsection
