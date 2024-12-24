@extends('Backend.layouts.app')

@section('content')
    <div class="mx-2">
        <div class="card shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body d-flex align-items-center justify-content-between p-4">
               <a href="{{ route('attribute.list') }}"> <h4 class="fw-semibold mb-0"> {{ $title }} </h4></a>

            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="mb-4 pb-2 align-items-center">
                    <h5 class="mb-0"> {{ $title2 }} </h5>
                </div>
                <form action="{{ route('attribute.store') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div>
                        <div class="card-body">
                            {{-- <h5>Person Info</h5> --}}
                            <div class="row pt-3">
                              
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="mb-3 has-success">
                                        <label class="form-label">Movie</label>
                                        <select class="form-select" name="movie_id">
                                            <option value="">Select a Movie</option>
                                            @forelse ($movie as $item)
                                                <option value=" {{ $item->id }} "> {{ $item->name }} </option>
                                            @empty
                                            @endforelse
                                        </select>
                                        <span class="text-danger">{{ $errors->first('movie_id') }}</span>

                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label"> Name</label>
                                        <select class="form-select" name="name">
                                            <option value="">Select a Type</option>
                                           <option value="Image">Image</option>
                                           <option value="Trailer">Trailer</option>
                                           <option value="Rating">Rating</option> 
                                           <option value="Languge">Languge</option> 
                                        </select>
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    </div>
                                </div>
                            </div>
                            <!--/row-->
                            

                        </div>

                        <div class="form-actions">
                            <div class="card-body border-top">
                                <button type="submit" class="btn btn-success rounded-pill px-4">
                                    Save
                                </button>
                               <a href=" {{ route('attribute.list') }} ">
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
