@extends('Backend.layouts.app')

@section('content')
@if (session('success'))
        <script>
            window.onload = function() {
                alert("{{ session('success') }}");
            }
        </script>
@endif
@if (session('error'))
        <script>
            window.onload = function() {
                alert("{{ session('error') }}");
            }
        </script>
@endif
<div class="row">
    <div class="col-12">
        <div class="card mb-0">
            <div class="card-body">
                <div class="d-md-flex justify-content-between mb-9">
                    <div class="mb-9 mb-md-0">
                        <h5 class="card-title">rooms management</h5>
                    </div>
                    <div class="d-flex align-items-center">
                        {{-- filler --}}
                        <form id="filter-form" class="position-relative me-3 w-100" method="GET" action="{{ route('admin.room.index') }}">
                            <select name="city_id" class="form-select" onchange="this.form.submit()">
                                <option value="">All Cities</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}" @if(request('city_id') == $city->id) selected @endif>{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </form>
                        <form action="{{ route('admin.room.index') }}" class="position-relative me-3 w-100" method="GET">
                            <select name="cinema_id" class="form-select" onchange="this.form.submit()">
                                <option value="">All Cinemas</option>
                                @foreach ($cinemas as $cinema)
                                <option value="{{ $cinema->id }}" @if(request('cinema_id') == $cinema->id) selected @endif>{{ $cinema->name }}</option>
                                @endforeach
                            </select>
                        </form>
                        {{-- searching --}}
                        <form class="position-relative me-3 w-100" method="GET">
                            <input type="text" class="form-control search-chat py-2 ps-5" id="text-srh" placeholder="Search" name='search' value="{{ isset($_GET['search']) ? $_GET['search'] : '' }}">
                            <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                        </form>
                        <div class="dropdown">
                            <a href="{{ route('admin.room.create') }}" class="btn border shadow-none px-3"
                                id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ti ti-dots-vertical fs-5"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                <li>
                                    <a class="dropdown-item d-flex align-items-center gap-3"
                                        href="{{ route('admin.room.create') }}"><i class="fs-4 ti ti-plus"></i>Add</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="table-responsive overflow-x-auto latest-reviews-table">
                    <table class="table mb-0 align-middle text-nowrap table-bordered">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Cinema</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        {{-- table body start --}}
                        <tbody>
                            @foreach ($rooms as $room)
                            <tr>
                                <td>{{ $room->id }}</td>
                                <td>{{ $room->name }}</td>
                                <td>{{ $room->cinema->name }}</td>
                                <td>
                                    <div class="dropdown dropstart">
                                        <a href="#" class="text-muted " id="dropdownMenuButton" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="ti ti-dots-vertical fs-5"></i>
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <li>
                                                <a class="dropdown-item d-flex align-items-center gap-3"
                                                    href="{{ route('admin.room.show', [$room->id]) }}">
                                                    <i class="fs-4 ti ti-edit"></i>Detail
                                                </a>
                                            </li>
                                            <li>
                                                <a onclick="return confirm('Do you want to delete this rooms?')" class="dropdown-item d-flex align-items-center gap-3"
                                                    href="{{ route('admin.room.destroy', [$room->id]) }}">
                                                    <i class="fs-4 ti ti-trash"></i>Delete
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        {{-- table body end --}}
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-3">
        {{ $rooms->links('vendor.pagination.bootstrap-5') }}
    </div>
</div>
@endsection
