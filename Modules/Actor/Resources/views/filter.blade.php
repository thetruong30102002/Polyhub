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
                            <form class="position-relative me-3 w-100" method="post" action=" {{ route('actor.filter') }} ">
                                @csrf
                                <select name="gender" class="form-select" onchange="this.form.submit()">
                                    <option value="">All Genders</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </form>
                            <form class="position-relative me-3 w-100" action="{{ route('actor.search') }}" method="post"
                                onsubmit>
                                @csrf
                                <input type="text" class="form-control search-chat py-2 ps-5" id="text-srh"
                                    placeholder="Search" name='text'>
                                <i
                                    class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                            </form>
                            <div class="dropdown">
                                <a href="#" class="btn border shadow-none px-3" id="dropdownMenuButton"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ti ti-dots-vertical fs-5"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-3"
                                            href="{{ route('actor.create') }}"><i class="fs-4 ti ti-plus"></i>Add</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-3"
                                            href="{{ route('actor.bin') }}"><i class="fs-4 ti ti-edit"></i>Bin</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-3" href="#"><i
                                                class="fs-4 ti ti-trash"></i>Delete</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive overflow-x-auto latest-reviews-table">
                        <table class="table mb-0 align-middle text-nowrap table-bordered">
                            <thead class="text-dark fs-4">
                                <tr class="text-center">

                                    <th scope="col">ID

                                    </th>
                                    <th scope="col">Name

                                    </th>
                                    <th scope="col">Gender

                                    </th>
                                    <th scope="col">Avatar

                                    </th>
                                    <th scope="col">Movies

                                    </th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($page as $item)
                                    <tr>

                                        <td>
                                            <div class="d-flex align-items-center product text-truncate">
                                                <div class="ms-3 product-title">
                                                    <h6 class="fs-4 mb-0 text-truncate-2">
                                                        {{ $item->id }}
                                                    </h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center text-truncate">
                                                <div class="ms-7">
                                                    <h5 class="mb-1 fs-4"> {{ $item->name }}</h5>

                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center text-truncate">
                                                <div class="ms-7">
                                                    <h5 class="mb-1 fs-4"> {{ $item->gender }}</h5>

                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <img src="{{ asset($item->avatar) }}" alt="" width="100px">
                                        </td>

                                        <td>

                                            @foreach ($item->movies as $movie)
                                                {{ $movie->name }}
                                                @if (!$loop->last)
                                                    , <br>
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            <div class="dropdown dropstart">
                                                <a href="#" class="text-muted " id="dropdownMenuButton"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ti ti-dots-vertical fs-5"></i>
                                                </a>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-3"
                                                            href=" {{ route('actor.show', $item->id) }} "><i
                                                                class="fs-4 ti ti-plus"></i>Detail</a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-3"
                                                            href="{{ route('actor.edit', $item->id) }}"><i
                                                                class="fs-4 ti ti-edit"></i>Edit</a>
                                                    </li>
                                                    <li>

                                                        <form action="{{ route('actor.delete', $item->id) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('delete')
                                                            <input type="hidden" name="id"
                                                                value="{{ $item->id }}">
                                                            <button type="submit"
                                                                class="dropdown-item d-flex align-items-center gap-3"
                                                                onclick="return confirm('Delete now?')"><i
                                                                    class="fs-4 ti ti-trash"></i> Delete </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $page->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
