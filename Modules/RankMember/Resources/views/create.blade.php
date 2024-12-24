@extends('Backend.layouts.app')
@section('content')
<div class="card">
    <div class="border-bottom title-part-padding">
      <h4 class="card-title mb-0">{{$title}}</h4>
    </div>
    <div class="card-body">
      <form class="needs-validation" action="{{route('rankmember.store')}}" method="POST">
        @csrf
        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label" for="validationCustom01">Rank</label>
            <input type="text" class="form-control" id="validationCustom01" name="rank"
              value="{{old('rank')}}"  />
              @if ($errors->has('rank'))
                <span class="error text-danger">{{ $errors->first('rank') }}</span>
              @endif
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label" for="validationCustom02">Min Point</label>
            <input type="number" class="form-control" placeholder="Last name" name='min_points'
              value="{{old('min_points')}}"  />
              @if ($errors->has('min_points'))
                <span class="error text-danger">{{ $errors->first('min_points') }}</span>
              @endif
          </div>
        </div>
        <button class="btn btn-primary mt-3 rounded-pill px-4" type="submit">
          Submit form
        </button>
      </form>
    </div>
  </div>
@endsection