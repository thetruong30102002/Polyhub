@extends('Backend.layouts.app')
@section('content')
@if (session('success') || session('error'))
    <script>
        window.onload = function() {
            @if (session('success'))
                alert("{{ session('success') }}");
            @endif
            @if (session('error'))
                alert("{{ session('error') }}");
            @endif
        }
    </script>
@endif
    <div class="row">
        <div class="col-12">
            <div class="card mb-0">
                <div class="card-body">
                    <div class="d-md-flex justify-content-between mb-9">
                        <div class="mb-9 mb-md-0">
                            <h5 class="card-title">{{ $title }}</h5>
                        </div>
                        <div class="d-flex align-items-center">
                            <form id="filter-form" class="d-flex" method="GET" action="/admin/movie">
                                <div class="position-relative me-3 w-100">
                                    <select name="director_id" class="form-select" onchange="this.form.submit()">
                                        <option value="">All Directors</option>
                                        @foreach($director as $dr)
                                            <option value="{{ $dr->id }}" @if(request('director_id') == $dr->id) selected @endif>{{ $dr->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            <div class="position-relative me-3 w-100">
                                <select name="categories_id" class="form-select" onchange="this.form.submit()">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $ca)
                                        <option value="{{ $ca->id }}" @if(request('categories_id') == $ca->id) selected @endif>{{ $ca->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="position-relative me-3 w-100">
                                <input type="text" class="form-control search-chat py-2 ps-5" id="text-srh" name="search" placeholder="Search" value="{{ request('search') }}">
                                <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                            </div>
                            </form>
                            <div class="dropdown">
                                <a href="#" class="btn border shadow-none px-3" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ti ti-dots-vertical fs-5"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-3" href="/admin/movie/create"><i class="fs-4 ti ti-plus"></i>Add</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive overflow-x-auto latest-reviews-table">
                        <table class="table mb-0 align-middle text-nowrap table-bordered">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Duration</th>
                                    <th>Premiere_date</th>
                                    <th>Image</th>
                                    <th>Director</th>
                                    <th>Category</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($movie as $mo)
                                    <tr>
                                        <td><p class="fs-4 mb-0 text-truncate-2">{{ $mo->name }}</p></td>
                                        <td><p class="fs-4 mb-0 text-truncate-2">{{ $mo->description }}</p></td>
                                        <td><p class="fs-4 mb-0 text-truncate-2">{{ $mo->duration}}</p></td>
                                        <td><p class="fs-4 mb-0 text-truncate-2">{{ $mo->premiere_date}}</p></td>
                                        <td><img src="{{asset($mo->photo)}}" id="tablenew" alt="" height="150px" width="200px"></td>
                                        <td>
                                            <p class="fs-4 mb-0 text-truncate-2">
                                                @forelse ($director as $dr)
                                                    @if ($mo->director_id == $dr->id)
                                                        {{$dr->name}}
                                                    @endif
                                                @empty
                                                @endforelse
                                            </p>
                                        </td>
                                        <td>
                                            <p class="fs-4 mb-0 text-truncate-2">
                                                @foreach($mo->categories as $category)
                                                    {{ $category->name }}
                                                    @if (!$loop->last)
                                                        ,
                                                    @endif
                                                @endforeach
                                            </p>
                                        </td>
                                        <td class="text-center">
                                            <form action="{{ route('movie.active', [$mo->id]) }}" method="post">
                                              @csrf
                                              @method('patch')
                                              @if($mo->activated)
                                                  <button type="submit" class="badge rounded-pill bg-success-subtle text-success border-success border" data-bs-toggle="tooltip">
                                                      Confirmed
                                                  </button>
                                                  <input type="hidden" name="is_active" value="0">
                                              @else
                                                  <button type="submit" class="badge rounded-pill bg-danger-subtle text-danger border-danger border" data-bs-toggle="tooltip">
                                                      Cancelled
                                                  </button>
                                                  <input type="hidden" name="is_active" value="1">
                                              @endif
                                          </form>
                                          </td>
                                        <td>
                                            <div class="dropdown dropstart">
                                                <a href="#" class="text-muted " id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ti ti-dots-vertical fs-5"></i>
                                                </a>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-3" href="/admin/movie/{{ $mo->id }}/edit"><i class="fs-4 ti ti-edit"></i>Edit</a>
                                                    </li>
                                                    <li>
                                                        <form action="/admin/movie/{{$mo->id}}" method="post">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="submit" class="dropdown-item d-flex align-items-center gap-3" onclick="return confirm('Do you want to delete?')">
                                                                <i class="fs-4 ti ti-trash"></i>Delete
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $movie->appends(request()->query())->links('vendor.pagination.bootstrap-5') }}
                      </div>
                </div>
            </div>
        </div>
    </div>
@endsection
