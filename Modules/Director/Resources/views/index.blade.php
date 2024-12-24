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
                            <form id="filter-form" class="position-relative me-3 w-100" method="GET" action="/admin/director">
                                <input type="text" class="form-control search-chat py-2 ps-5" id="text-srh" name="search" placeholder="Search" value="{{ request('search') }}">
                                <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                            </form>
                            <div class="dropdown">
                                <a href="#" class="btn border shadow-none px-3" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ti ti-dots-vertical fs-5"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-3" href="/admin/director/create"><i class="fs-4 ti ti-plus"></i>Add</a>
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
                                    <th>Age</th>
                                    <th>Date Of Birth</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($director as $dr)
                                    <tr>
                                        <td><p class="fs-4 mb-0 text-truncate-2">{{ $dr->name }}</p></td>
                                        <td><p class="fs-4 mb-0 text-truncate-2">{{ $dr->age }}</p></td>
                                        <td><p class="fs-4 mb-0 text-truncate-2">{{ $dr->date_of_birth }}</p></td>
                                        <td>
                                            <div class="dropdown dropstart">
                                                <a href="#" class="text-muted" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ti ti-dots-vertical fs-5"></i>
                                                </a>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-3" href="/admin/director/{{ $dr->id }}/edit"><i class="fs-4 ti ti-edit"></i>Edit</a>
                                                    </li>
                                                    <li>
                                                        <form action="/admin/director/{{$dr->id}}" method="post">
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
                        {{ $director->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
