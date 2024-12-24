@extends('Backend.layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="d-md-flex justify-content-between mb-9">
                <div class="mb-9 mb-md-0">
                    <h1 class="card-title" style="font-size: 1.5rem">Bill</h1>
                </div>
                <div class="d-flex align-items-center">
                    <form action="{{ route('bill.index') }}" method="GET" class="position-relative me-3 w-100">
                        <input type="text" class="form-control search-chat py-2 ps-5" id="text-srh" name="search"
                            placeholder="Search" value="{{ request()->input('search') }}">
                        <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                    </form>
                    <div class="dropdown">
                        <a href="#" class="btn border shadow-none px-3" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="ti ti-dots-vertical fs-5"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-3" href=""><i
                                    class="fs-4 ti ti-plus"></i>Add</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">User Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Grand Total</th>
                        <th scope="col">Created At</th>
                        <th scope="col">Updated At</th>
                        <th scope="col">Handles</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bills as $key => $item)
                        @if (!$item->category_id)
                            <tr>
                                <td>{{ $item->user->name }}</td>
                                <td>{{ $item->user->email }}</td>
                                <td>{{ number_format($item->grand_total, 0, ',', '.') . ' ₫' }}</td>
                                <td>{{ $item->created_at }}</td>
                                <td>{{ $item->updated_at }}</td>
                                <td>
                                    <div class="dropdown dropstart">
                                        <a href="#" class="text-muted " id="dropdownMenuButton" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="ti ti-dots-vertical fs-5"></i>
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <li>
                                                <a class="dropdown-item d-flex align-items-center gap-3" href="{{ route('bill.show', ['bill' => $item->id]) }}"><i
                                                    class="fs-4 ti ti-plus"></i>Detail</a>
                                            </li>
                                            {{-- <li>
                                                <a class="dropdown-item d-flex align-items-center gap-3" href="{{ route('categories.edit', ['category' => $item->id]) }}"><i
                                                    class="fs-4 ti ti-edit"></i>Edit</a>
                                            </li>
                                            <li>
                                                <form action="{{ route('categories.destroy', ['category' => $item->id]) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" style="border: none; background-color: unset; width: 100%; padding: 0 0 0 0">
                                                        <a class="dropdown-item d-flex align-items-center gap-3" type="submit"><i
                                                    class="fs-4 ti ti-trash"></i>Delete</a> 
                                                    </button>
                                                </form>
                                            </li> --}}
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            
                        @endif
                    @endforeach
                </tbody>
            </table>
            {{ $bills->links('vendor.pagination.bootstrap-5') }}
        </div>
    </div>
@endsection
