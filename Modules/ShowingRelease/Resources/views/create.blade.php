@extends('Backend.layouts.app')

@section('content')
<div class="card">
    <div class="border-bottom title-part-padding">
        <h4 class="card-title mb-0">{{ $title }}</h4>
    </div>
    <div class="card-body">
        <form class="needs-validation" action="{{ route('showingrelease.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="movie_id">Movie</label>
                    <input type="text" name="movie_name" id="movie_name" class="form-control" value="{{ old('movie_name') }}" readonly>
                    <input type="hidden" name="movie_id" id="movie_id" >
                    @if ($errors->has('movie_id'))
                    <span class="error text-danger">{{ $errors->first('movie_id') }}</span>
                    @endif
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="room_id">Room</label>
                    <select name="room_id" id="room_id" class="form-control select-room mt-2" value="{{ old('room_id') }}">
                        <option value="0">--Select room--</option>
                        @foreach($rooms as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
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
                    <input type="date" name="date_release" id="date_release" class="form-control" value="{{ old('date_release') }}" >
                    @if ($errors->has('date_release'))
                    <span class="error text-danger">{{ $errors->first('date_release') }}</span>
                    @endif
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="time_release">Time</label>
                    <input type="time" name="time_release" id="time_release" class="form-control" value="{{ old('time_release') }}">
                    @if ($errors->has('time_release'))
                    <span class="error text-danger">{{ $errors->first('time_release') }}</span>
                    @endif
                </div>
            </div>
            <button class="btn btn-primary mt-3 rounded-pill px-4" type="submit">
                Submit form
            </button>
            <a href="{{ route('showingrelease.index') }}" class="btn btn-secondary mt-3 rounded-pill px-4">Back</a>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var movieId = localStorage.getItem('selectedMovieId');
    var movieName = localStorage.getItem('selectedMovieName');
    
    if (movieId && movieName) {
        document.getElementById('movie_id').value = movieId;
        document.getElementById('movie_name').value = movieName;
    } else {
        alert('Movie not selected. Please go back and select a movie.');
    }
});

document.querySelector('form').addEventListener('submit', function(e) {
    var movieIdInput = document.getElementById('movie_id');
    var movieNameInput = document.getElementById('movie_name');

    if (!movieIdInput.value || !movieNameInput.value) {
        alert('Movie is not selected or movie ID is missing!');
        e.preventDefault(); // Ngăn không cho form submit khi chưa có movie ID
    }
});
document.getElementById('movieSelect')?.addEventListener('change', function() {
    var movieId = this.value;
    var movieName = this.options[this.selectedIndex].text;

    // Lưu dữ liệu vào localStorage
    localStorage.setItem('selectedMovieId', movieId);
    localStorage.setItem('selectedMovieName', movieName);
});

document.getElementById('cinema_id')?.addEventListener('change', function() {
    var cinemaId = this.value;
    fetch(`/admin/rooms/${cinemaId}`)
        .then(response => response.json())
        .then(data => {
            var roomSelect = document.getElementById('room_id');
            roomSelect.innerHTML = '<option value="0">--Select room--</option>';
            data.forEach(room => {
                roomSelect.innerHTML += `<option value="${room.id}">${room.name}</option>`;
            });
        });
});

</script>
@endsection
