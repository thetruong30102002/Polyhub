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
                <form action="{{ route('actor.store') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div>
                        <div class="card-body">
                            <h5>Person Info</h5>
                            <div class="row pt-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label"> Name</label>
                                        <input type="text" name="name" id="firstName" class="form-control"
                                            placeholder="John doe" />
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="mb-3 has-success">
                                        <label class="form-label">Gender</label>
                                        <select class="form-select" name="gender">
                                            <option value="">Select a Gender</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
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
                                        <input type="file" id="" class="form-control" name="avatar" />

                                    </div>
                                    <span class="text-danger">{{ $errors->first('avatar') }}</span>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="mb-3 has-success">
                                      
                                        <select class="form-select" name="movies[]" multiple>
                                            @foreach ($movies as $movie)
                                                @if (!$movie->movie_id)
                                                    <option value="{{ $movie->id }}">{{ $movie->name }}</option>
                                                    @include('actor::partials.children_movies', [
                                                        'movies' => $movies,
                                                        'parent_id' => $movie->id,
                                                        'char' => '|---',
                                                        'selectedMovies' => [],
                                                    ])
                                                @endif
                                            @endforeach
                                        </select>
                                        <label for="movies">Movies</label>
                                        @error('movies')
                                            <div class="text text-danger">{{ $message }}</div>
                                        @enderror

                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <!--/row-->

                        </div>

                        <div class="form-actions">
                            <div class="card-body border-top">
                                <button type="submit" class="btn btn-success rounded-pill px-4">
                                    Save
                                </button>
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
