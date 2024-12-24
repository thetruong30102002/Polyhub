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
                            <form id="filter-form" class="position-relative me-3 w-100" method="GET">
                                <select name="rank_member_id" class="form-select" onchange="this.form.submit()">
                                    <option value="">All Rank</option>
                                    @foreach ($ranks as $rank)
                                    <option value="{{$rank->id}}" @if(request('rank_member_id') == $rank->id) selected @endif>{{$rank->rank}}</option>
                                    @endforeach
                                </select>
                            </form>
                            <form class="position-relative me-3 w-100" method="GET">
                                <input type="text" class="form-control search-chat py-2 ps-5" id="text-srh"
                                    placeholder="Search" name='q'>
                                <i
                                    class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive overflow-x-auto latest-reviews-table">
                        <table class="table mb-0 align-middle text-nowrap table-bordered">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th onclick="sortTable('name')" style="cursor: pointer;">
                                        Name
                                        @if (request('sort') == 'name')
                                            @if (request('direction') == 'asc')
                                                <i class="bi bi-caret-up-fill"></i>
                                            @else
                                                <i class="bi bi-caret-down-fill"></i>
                                            @endif
                                        @endif
                                    </th>
                                    <th>Email</th>
                                    <th>Avatar</th>
                                    <th>Address</th>
                                    <th onclick="sortTable('points')" style="cursor: pointer;">
                                        Points
                                        @if (request('sort') == 'name')
                                            @if (request('direction') == 'asc')
                                                <i class="bi bi-caret-up-fill"></i>
                                            @else
                                                <i class="bi bi-caret-down-fill"></i>
                                            @endif
                                        @endif
                                    </th>
                                    <th>Rank</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>
                                            <div class="ms-3 product-title">
                                                <h6 class="fs-4 mb-0 text-truncate-2">{{ $user->name }}</h6>
                                            </div>
                    </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center text-truncate">
                            <h6 class="mb-0 fw-light">{{ $user->email }}</h6>
                        </div>
                    </td>
                    <td>
                        @if (!empty($user->avatar))
                            <img src="{{ asset('storage/' . str_replace('public/', '', $user->avatar)) }}" alt=""
                                class="img-fluid flex-shrink-0" width="120" height="120">
                        @endif
                    </td>
                    <td>
                        <div class="d-flex align-items-center text-truncate">
                            <h6 class="mb-0 fw-light">{{ $user->address }}</h6>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center text-truncate">
                            <h6 class="mb-0 fw-light">{{ $user->points }}</h6>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center text-truncate">
                            <h6 class="mb-0 fw-light">{{ $user->rankMember->rank }}</h6>
                        </div>
                    </td>
                    <td class="text-center">
                        <form action="{{ route('user.active', [$user->id]) }}" method="post">
                            @csrf
                            @method('patch')
                            @if ($user->activated)
                                <button type="submit"
                                    class="badge rounded-pill bg-success-subtle text-success border-success border"
                                    data-bs-toggle="tooltip">
                                    Confirmed
                                </button>
                                <input type="hidden" name="is_active" value="0">
                            @else
                                <button type="submit"
                                    class="badge rounded-pill bg-danger-subtle text-danger border-danger border"
                                    data-bs-toggle="tooltip">
                                    Cancelled
                                </button>
                                <input type="hidden" name="is_active" value="1">
                            @endif
                        </form>
                    </td>
                    </tr>
                    @endforeach
                    </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    <!-- Hiển thị phân trang và giữ nguyên các tham số tìm kiếm và sắp xếp -->
                    {{ $page->appends(['q' => request()->get('q'), 'sort' => request()->get('sort'), 'direction' => request()->get('direction'), 'rank_member_id' => request()->get('rank_member_id')])->links('vendor.pagination.bootstrap-5') }}

                </div>
            </div>
        </div>
    </div>
    </div>
    <script>
        function sortTable(column) {
            const urlParams = new URLSearchParams(window.location.search);
            let direction = urlParams.get('direction') === 'asc' ? 'desc' : 'asc';

            urlParams.set('sort', column);
            urlParams.set('direction', direction);

            window.location.href = window.location.pathname + '?' + urlParams.toString();
        }
    </script>
@endsection
