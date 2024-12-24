@extends('Backend.layouts.app')

@section('content')
<div class="card">
    <div class="border-bottom title-part-padding">
        <h4 class="card-title mb-0">{{$title}}</h4>
    </div>
    <div class="card-body">
        <form class="needs-validation" action="{{ route('showingrelease.update', $show->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="movie_id">Movies</label>
                    <select name="movie_id" id="movie_id" class="form-control select-movie mt-2">
                        <option value="0">--Select movies--</option>
                        @foreach($movie as $id => $name)
                            <option value="{{ $id }}" {{ $show->movie_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('movie_id'))
                    <span class="error text-danger">{{ $errors->first('movie_id') }}</span>
                    @endif
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="room_id">Room</label>
                    <select name="room_id" id="room_id" class="form-control select-room mt-2" >
                        <option value="0">--Select room--</option>
                        @foreach($rooms as $id => $name)
                            <option value="{{ $id }}" {{ $show->room_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('room_id'))
                    <span class="error text-danger">{{ $errors->first('room_id') }}</span>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="date_release">Date</label>
                    <input type="date" name="date_release" id="date_release" class="form-control" value="{{ $show->date_release }}">
                    @if ($errors->has('date_release'))
                    <span class="error text-danger">{{ $errors->first('date_release') }}</span>
                    @endif
                </div>
               <div class="col-md-6 mb-3">
            <label class="form-label" for="date_release">Time</label>
            <input type="time" name="time_release" id="time_release" class="form-control"value="{{ \Carbon\Carbon::parse($show->time_release)->format('H:i') }}">
            @if ($errors->has('time_release'))
                <span class="error text-danger">{{ $errors->first('time_release') }}</span>
            @endif
          </div>
            </div>
            <button class="btn btn-primary mt-3 rounded-pill px-4" type="submit">
                Update
            </button>
            <a href="{{ route('showingrelease.index') }}" class="btn btn-secondary mt-3 rounded-pill px-4">Back</a>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var cinemaSelect = document.getElementById('cinema_id');
    if (cinemaSelect) {
        var selectedCinemaId = cinemaSelect.value;
        if (selectedCinemaId) {
            fetch(`/admin/rooms/${selectedCinemaId}`)
                .then(response => response.json())
                .then(data => {
                    var roomSelect = document.getElementById('room_id');
                    roomSelect.innerHTML = '<option value="0">--Select room--</option>';
                    data.forEach(room => {
                        roomSelect.innerHTML += `<option value="${room.id}">${room.name}</option>`;
                    });
                });
        }
    }
});
</script>
@endsection
