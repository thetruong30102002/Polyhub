@extends('Backend.layouts.app')
@section('content')
    {{-- nav start --}}
    <div class="card shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body d-flex align-items-center justify-content-between p-4">
            <h4 class="fw-semibold mb-0">Update</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="../dark/index.html">Home</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">seat</li>
                </ol>
            </nav>
        </div>
    </div>
    {{-- nav end --}}


    <section class="container">
        <div class="card">
            <div class="card-body">
                <h5 class="mb-3">Update seat</h5>
                <form action="{{ route('admin.seat.update', [$seat->id]) }}" method="POST">
                    @csrf
                    <input type="hidden" name="room_id" value="{{ $seat->room->id }}">
                    <div class="row">
                        <div class="col input-group">
                            <span class="input-group-text">Status</span>
                            <select name="status" class="form-select" id="inputGroupSelect04">
                                <option value="1" {{ $seat->status == 1 ? "selected" : ''  }}>seat broken</option>
                                <option value="0" {{ $seat->status == 0 ? "selected" : ''  }}>seat stable</option>
                            </select>
                        </div>
                        <div class="col input-group">
                            <span class="input-group-text">Type</span>
                            <select name="seat_type" class="form-select" id="inputGroupSelect04">
                                @foreach($seat_types as $seat_type)
                                    <option value="{{ $seat_type->id }}"  @if($seat->seat_type_id == $seat_type->id ) selected @endif>{{ $seat_type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 my-4">
                            <div class="d-md-flex align-items-center">
                                <div class="ms-auto mt-3 mt-md-0">
                                    <button type="submit" class="btn btn-primary  rounded-pill px-4">
                                        <div class="d-flex align-items-center">
                                            Submit
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
@endsection
