@extends('Backend.layouts.app')

@section('content')
    <div class="mx-2">
        <div class="card shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body d-flex align-items-center justify-content-between p-4">
                <a href="{{ route('actor.list') }}">
                    <h4 class="fw-semibold mb-0"> {{ $title }} </h4>
                </a>

            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="mb-4 pb-2 align-items-center">
                    <h5 class="mb-0"> {{ $title2 }} </h5>
                </div>
                <form action="{{ route('actor.update', $actor->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div>
                        <div class="card-body">
                            <h5>Person Info</h5>
                            <div class="row pt-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label"> Name</label>
                                        <input type="text" name="name" readonly value="{{ $actor->name }}" id="firstName"
                                            class="form-control" placeholder="John doe" />
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="mb-3 has-success">
                                        <label class="form-label">Gender</label>
                                        <select class="form-select" name="gender" disabled="true">
                                            @if ($actor->gender == 'Male')
                                                <option value="0">Select gender</option>
                                                <option value="{{ $actor->gender }}" selected>{{ $actor->gender }}
                                                </option>

                                                <option value="Female">Female</option>
                                            @else
                                                <option value="0">Select gender</option>
                                                <option value="{{ $actor->gender }}" selected>{{ $actor->gender }}
                                                </option>

                                                <option value="Male">Male</option>
                                            @endif
                                        </select>

                                    </div>
                                    <span class="text-danger">{{ $errors->first('gender') }}</span>
                                </div>
                                <!--/span-->
                            </div>
                            <!--/row-->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3 has-success">
                                        <label class="form-label">Avatar</label>
                                        <input type="file" id="" class="form-control" name="avatar" disabled="true" />

                                    </div>
                                    <div>
                                        <img src="{{ asset($actor->avatar) }}" width="100px"
                                            alt="">
                                    </div>
                                    <span class="text-danger">{{ $errors->first('avatar') }}</span>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="mb-3 has-success">
                                        <label class="form-label">Movie</label>
                                        <select class="form-select" name="movies[]" multiple disabled>
                                        
                                            @foreach ($movies as $movie)
                                            @if (!$movie->movie_id)
                                            <option value="{{ $movie->id }}" 
                                              @if (in_array($movie->id, $actor->movies->pluck('id')->toArray())) selected @endif>
                                              {{ $movie->name }}
                                            </option>
                                                @include('actor::partials.children_movies', ['movies' => $movies, 'parent_id' => $movie->id, 'char' => '|---', 
                                                'selectedMovies' => $actor->movies->pluck('id')->toArray()])
                                            @endif
                                        @endforeach
                                        </select>
                                        <span class="text-danger">{{ $errors->first('movie_id') }}</span>

                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <!--/row-->

                        </div>

                        <div class="form-actions">
                            <div class="card-body border-top">
                                {{-- <button type="submit" class="btn btn-success rounded-pill px-4">
                                    Save
                                </button> --}}
                                <a href=" {{ route('actor.edit', $actor->id) }} ">
                                    <button type="button" class="btn bg-warning-subtle text-danger rounded-pill px-4 ms-6">
                                        Edit
                                    </button>
                                </a>
                                <a href=" {{ route('actor.list') }} ">
                                    <button type="button" class="btn bg-danger-subtle text-danger rounded-pill px-4 ms-6">
                                        Cancel
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
