@extends('Backend.layouts.app')

@section('content')
<style>
    .iconlist{
        width: 25px;
        height: 25px;
        margin-right: 10px;
        display: inline-block;
    }

    .placed{
        background-color: grey !important;
        border: 0 !important;
    }

    .seat{
        height: 32px;
        width: 42px;
        margin: 3px;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    .seat a{
        line-height: 32px;
        text-align: center; 
        display: block;
        width: 100%;
        color: white !important;
    }

    .seat:hover {
        background-color: rgb(204, 204, 204) !important;
    }
</style>
<div class="card">
    <div class="border-bottom title-part-padding">
      <h4 class="card-title mb-0">{{$title}}</h4>
    </div>
    <div class="card-body">
        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label" for="movie_id">Movies</label>
            <input type="text" id="movie_id" class="form-control mt-2" value="{{ $showingRelease->movie->name }}" readonly/>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label" for="room_id">Room</label>
            <input type="text" id="room_id" class="form-control mt-2" value="{{ $showingRelease->room->name}}" readonly/>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label" for="date_release">Date</label>
            <input type="date" id="date_release" class="form-control" value="{{ $showingRelease->date_release }}" readonly/>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label" for="time_release">Time</label>
            <input type="time" id="time_release" class="form-control" value="{{ \Carbon\Carbon::parse( $showingRelease->time_release)->format('H:i') }}" readonly/>
          </div>
        </div>
        <a href="{{ route('showingrelease.index') }}" class="btn btn-secondary mt-3 rounded-pill px-4">Back</a>
    </div>
</div>

 {{-- list seats --}}
 <section class="my-5">
    <div class="container">
        <div style="width: 70%" class="mx-auto">
            <div class="row row-cols-12 g-lg-3">
                @foreach ($groupedSeats as $rows)
                    @foreach ($rows as $row)
                        <div class="col-1">
                            <div  class="seat p-1 border {{ $row->seat->seat_type_id == 1 ? 'border-success' : '' }} {{ $row->seat->seat_type_id == 2 ? 'border-danger' : '' }} {{ $row->seat->seat_type_id == 3 ? 'bg-danger' : '' }} {{ $row->status == 1 ? 'placed' : '' }}">
                                <span class="dropdown dropstart">
                                    <a href="#" class="text-muted" aria-expanded="false">
                                        {{ strtoupper($row->seat->row) }}{{ $row->seat->column }}
                                    </a>
                                </span>
                            </div>
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
    {{-- type of seats --}}
    <div style="width: 40%; margin-top: 50px" class="container mx-auto">
        <div>
            <div class="row justify-content-around">
                <div class="col-6">
                    <div class="border bg-primary iconlist"></div> <span>Checked</span>
                </div>
                <div class="col-6">
                    <div class="border border-success iconlist"></div> <span>Standard</span>
                </div>
                <div class="col-6">
                    <div class="border bg-secondary iconlist"></div>   <span>Placed</span>
                </div>
                <div class="col-6">
                    <div class="border border-danger iconlist"></div> <span>VIP</span>
                </div>
                <div class="col-6">
                    <div class="border bg-dark iconlist"></div> <span>Cannot select</span>
                </div>
                <div class="col-6">
                    <div class="border bg-danger iconlist"></div> <span>Couple</span>
                </div>
            </div>
        </div>
    </div>
</section>
{{-- list seats end --}}
@endsection

