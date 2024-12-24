@extends('Backend.layouts.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-0">
                <div class="card-body">
                    <div class="d-md-flex justify-content-between mb-9">
                        <div class="mb-9 mb-md-0">
                            <h5 class="card-title">{{ $title }}</h5>
                        </div>
                        <div class="d-flex align-items-center">
                            <form id="search-form" class="position-relative me-3 w-100" action="{{ route('banners.index') }}" method="GET">
                                <input type="text" class="form-control search-chat py-2 ps-5" id="text-srh" name="search"
                                       placeholder="Search" value="{{ request()->get('search') }}">
                                <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                            </form>
                            <div class="dropdown">
                                <a href="#" class="btn border shadow-none px-3" id="dropdownMenuButton"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ti ti-dots-vertical fs-5"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-3" href="{{ route('banners.create') }}">
                                            <i class="fs-4 ti ti-plus"></i>Add
                                        </a>
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
                                    <th>Image</th>
                                    <th>Note</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($banners as $banner)
                                    <tr>
                                        <td>
                                            <div class="ms-3 product-title">
                                                <h6 class="fs-4 mb-0 text-truncate-2">{{ $banner->name }}</h6>
                                            </div>
                                        </td>
                                        <td>
                                            @if (!empty($banner->image))
                                            <img src="{{ asset($banner->image) }}" id="tablenew" alt="" class="img-fluid flex-shrink-0" width="150px" height="150px">
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center text-truncate">
                                                <h6 class="mb-0 fw-light">{{ $banner->note }}</h6>
                                            </div>
                                        </td>
                                        <td>
                                            <form action="{{ route('banners.updateStatus', $banner->id) }}" method="post">
                                                @csrf
                                                @method('patch')
                                                @if($banner->status == 1)
                                                    <button type="submit" class="badge rounded-pill bg-success-subtle text-success border-success border">
                                                        Display
                                                    </button>
                                                    <input type="hidden" name="status" value="0">
                                                @else
                                                    <button type="submit" class="badge rounded-pill bg-danger-subtle text-danger border-danger border">
                                                        Hide
                                                    </button>
                                                    <input type="hidden" name="status" value="1">
                                                @endif
                                            </form>
                                        </td>
                                        <td>
                                            <div class="dropdown dropstart">
                                                <a href="#" class="text-muted " id="dropdownMenuButton" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i class="ti ti-dots-vertical fs-5"></i>
                                                </a>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-3" href="{{ route('banners.show', $banner->id) }}">
                                                            <i class="fs-4 ti ti-eye"></i>Detail
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-3" href="{{ route('banners.edit', $banner->id) }}">
                                                            <i class="fs-4 ti ti-edit"></i>Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('banners.destroy', $banner->id) }}" method="post" onsubmit="return confirm('Do you want to delete this banner?')">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="submit" class="dropdown-item d-flex align-items-center gap-3">
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
                            {{ $banners->links('vendor.pagination.bootstrap-5') }}
                        </div>
                    
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('text-srh').addEventListener('input', function () {
            if (this.value === '') {
                document.getElementById('search-form').submit();
            }
        });
    </script>
@endsection
