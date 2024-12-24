@extends('Backend.layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="d-md-flex justify-content-between mb-9">
                <div class="mb-9 mb-md-0">
                    <h1 class="card-title" style="font-size: 1.5rem">Bill</h1>
                </div>
                
            </div>

            <div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="movie_id">Username :</label>
                            <input type="text" id="movie_id" class="form-control mt-2" value="{{ $bill->user->name }}" readonly/>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="room_id">Email :</label>
                            <input type="text" id="room_id" class="form-control mt-2" value="{{ $bill->user->email }}" readonly/>
                        </div>

                         <div class="col-md-6 mb-3">
                            <label class="form-label" for="time_release">Cinema :</label>
                            <input type="text" id="time_release" class="form-control" value="{{ $cinema->name }}" readonly/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="time_release">Movie :</label>
                            <input type="text" id="time_release" class="form-control" value="{{ $movie->name }}" readonly/>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="time_release">Room :</label>
                            <input type="text" id="time_release" class="form-control" value="{{ $room->name }}" readonly/>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="date_release">Food Combo :</label>
                            @foreach ($food_combo as $food_item)
                            <input style="margin-top: 7px;" type="text" id="date_release" class="form-control" 
                            value="{{ $food_item->food_combo->name . ' - ' . number_format($food_item->price, 0, ',', '.') . ' ₫ ' . '(qty: ' . $food_item->quantity . ')' }}" 
                            readonly />                     
                            @endforeach
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="date_release">Seat :</label>
                            @foreach ($bill->ticketSeats as $item)
                            <input style="margin-top: 7px;" type="text" id="date_release" class="form-control" 
                            value="{{ strtoupper($item->seat_showTime_status->seat->row) . $item->seat_showTime_status->seat->column . ' - ' . $item->seat_showTime_status->seat->seatType->name . ' ' . '(' . number_format($item->seat_showTime_status->seat->seatType->price, 0, ',', '.') . ' ₫' . ')' }}" 
                            readonly />                     
                            @endforeach
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="date_release">Grand Total :</label>
                            <input style="margin-top: 7px;" type="text" id="date_release" class="form-control" value="{{ number_format($bill->grand_total, 0, ',', '.') . ' ₫' }}" readonly/>
                        </div>

                        <div></div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="date_release">Barcode :</label>
                            <div>
                                <img src="data:image/png;base64,{{ $checkin->checkin_code }}" alt="Checkin Barcode">
                            </div>
                        </div>

                        </div>
                    <a href="{{ route('bill.index') }}" class="btn btn-secondary mt-3 rounded-pill px-4">Back</a>
            </div>
        </div>
    </div>
@endsection