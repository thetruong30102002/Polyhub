@extends('Backend.layouts.app')
@section('content')
@if (session('success') || session('error'))
<script>
    window.onload = function() {
        var message = "{{ session('success') ?: session('error') }}";
        alert(message);
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
                            <form id="filter-form" class="d-flex justify-content-between w-100">
                                <div class="flex-grow-1 mx-2">
                                    <select name="city_id" class="form-select" id="citySelect">
                                        <option value="">Select City</option>
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="flex-grow-1 mx-2">
                                    <select name="cinema_id" class="form-select" id="cinemaSelect" disabled>
                                        <option value="">Select Cinema</option>
                                    </select>
                                </div>

                                <div class="flex-grow-1 mx-2">
                                    <div class="d-flex align-items-center">
                                        <select name="movie_id" class="form-select" id="movieSelect" disabled>
                                            <option value="">Select Movie</option>
                                        </select>
                                        <div class="dropdown ms-2" id="addButtonContainer" style="display: none;">
                                            <a href="#" class="btn border shadow-none px-3" id="addButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ti ti-dots-vertical fs-5"></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center gap-3" href="#" id="addLink">
                                                        <i class="fs-4 ti ti-plus"></i>Add
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1 mx-2 d-flex align-items-center">
                                    <input type="date" name="date_filter" class="form-control" id="dateFilterInput" placeholder="Select Date">
                                    <button type="button" class="btn btn-primary ms-2" id="filterDateButton">Filter</button>
                                </div>
                            </form>
                        </div>

                    </div>
                    <div id="showingReleaseTable" class="table-responsive overflow-x-auto latest-reviews-table" style="display: none;">
                        
                        <table class="table mb-0 align-middle text-nowrap table-bordered">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th>Movie</th>
                                    <th>Image</th>
                                    <th>Room</th>
                                    <th>Time</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="showingReleaseBody">
                                <!-- Nội dung bảng sẽ được chèn bằng AJAX -->
                            </tbody>
                        </table>
                    </div>
                    <!-- Phần phân trang -->
                    <div id="paginationContainer" class="mt-3">
                        <!-- Nội dung phân trang sẽ được chèn bằng AJAX -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Chuyển URL của ảnh vào biến JavaScript để sử dụng trong mã JavaScript
        const assetUrl = "{{ asset('storage/movies') }}";
        document.getElementById('citySelect').addEventListener('change', function() {
            var cityId = this.value;
            if (cityId) {
                fetch(`/admin/cinemas/${cityId}`)
                    .then(response => response.json())
                    .then(cinemas => {
                        var cinemaSelect = document.getElementById('cinemaSelect');
                        cinemaSelect.innerHTML = '<option value="">Select Cinema</option>';
                        cinemas.forEach(cinema => {
                            cinemaSelect.innerHTML += `<option value="${cinema.id}">${cinema.name}</option>`;
                        });
                        cinemaSelect.disabled = false;

                        // Reset movie and showing release sections
                        document.getElementById('movieSelect').disabled = true;
                        document.getElementById('movieSelect').innerHTML = '<option value="">Select Movie</option>';
                        document.getElementById('showingReleaseTable').style.display = 'none';
                    });
            } else {
                document.getElementById('cinemaSelect').disabled = true;
                document.getElementById('cinemaSelect').innerHTML = '<option value="">Select Cinema</option>';
                document.getElementById('movieSelect').disabled = true;
                document.getElementById('movieSelect').innerHTML = '<option value="">Select Movie</option>';
                document.getElementById('showingReleaseTable').style.display = 'none';
            }
        });
        // lấy rạp
       document.getElementById('cinemaSelect').addEventListener('change', function() {
        var cinemaId = this.value;
        if (cinemaId) {
            fetch(`/admin/movies`)
                .then(response => response.json())
                .then(movies => {
                    if (Array.isArray(movies)) {
                        var movieSelect = document.getElementById('movieSelect');
                        movieSelect.innerHTML = '<option value="">Select Movie</option>';
                        movies.forEach(movie => {
                            movieSelect.innerHTML += `<option value="${movie.id}">${movie.name}</option>`;
                        });
                        movieSelect.disabled = false;
                        document.getElementById('addButtonContainer').style.display = 'block';

                        // Thiết lập URL cho nút Add với cinemaId
                        var addLink = document.getElementById('addLink');
                        addLink.href = `/admin/showingrelease/create/${cinemaId}`;
                    } else {
                        console.error('Dữ liệu không phải là mảng:', movies);
                        document.getElementById('movieSelect').disabled = true;
                        document.getElementById('addButtonContainer').style.display = 'none';
                    }
                })
                .catch(error => {
                    console.error('Có lỗi xảy ra:', error);
                    document.getElementById('movieSelect').disabled = true;
                    document.getElementById('addButtonContainer').style.display = 'none';
                });
        } else {
            document.getElementById('movieSelect').disabled = true;
            document.getElementById('movieSelect').innerHTML = '<option value="">Select Movie</option>';
            document.getElementById('showingReleaseTable').style.display = 'none';
            document.getElementById('addButtonContainer').style.display = 'none';
        }
    });
    // lấy phim
    document.getElementById('movieSelect').addEventListener('change', function() {
        var movieId = this.value;
        var cinemaId = document.getElementById('cinemaSelect').value;
        var selectedMovieName = this.options[this.selectedIndex].text;

        if (movieId && cinemaId) {
            // Lưu tên phim và ID phim vào Local Storage
            localStorage.setItem('selectedMovieName', selectedMovieName);
            localStorage.setItem('selectedMovieId', movieId);

            fetch(`/admin/showingreleases/${movieId}/${cinemaId}`)
                .then(response => response.json())
                .then(data => {
                    var showingReleaseBody = document.getElementById('showingReleaseBody');
                    showingReleaseBody.innerHTML = '';
                    if (Array.isArray(data.showingReleases) && data.showingReleases.length > 0) {
                        data.showingReleases.forEach(showingRelease => {
                            showingReleaseBody.innerHTML += `
                                <tr>
                                    <td>${showingRelease.movie.name}</td>
                                    <td><img src="${assetUrl}/${showingRelease.movie.photo.replace('storage/movies/', '')}" id="tablenew" alt="${showingRelease.movie.name}" height="150px" width="200px"></td>
                                    <td>${showingRelease.room.name}</td>
                                    <td>${new Date(showingRelease.time_release).toLocaleTimeString([], {hour: '2-digit', minute: '2-digit'})}</td>
                                    <td>${new Date(showingRelease.date_release).toLocaleDateString()}</td>
                                    <td>
                                        <div class="dropdown dropstart">
                                            <a href="#" class="text-muted " id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ti ti-dots-vertical fs-5"></i>
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center gap-3" href="/admin/showingrelease/${showingRelease.id}"><i class="fs-4 ti ti-plus"></i>Detail</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center gap-3" href="/admin/showingrelease/${showingRelease.id}/edit"><i class="fs-4 ti ti-edit"></i>Edit</a>
                                                </li>
                                                <li>
                                                    <form action="/admin/showingrelease/${showingRelease.id}" method="post" onsubmit="return confirm('Do you want to delete ?')">
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
                            `;
                        });
                        document.getElementById('showingReleaseTable').style.display = 'block';
                        // Hiển thị phân trang nếu có dữ liệu
                        if (data.pagination) {
                            document.getElementById('paginationContainer').innerHTML = data.pagination;
                        } else {
                            document.getElementById('paginationContainer').innerHTML = '';
                        }
                    } else {
                        showingReleaseBody.innerHTML = '<tr><td colspan="6" class="text-center">No showing releases available.</td></tr>';
                        document.getElementById('paginationContainer').innerHTML = ''; // Không hiển thị phân trang nếu không có dữ liệu
                    }
                })
                .catch(error => console.error('Có lỗi xảy ra:', error));
        } else {
            console.error('movieId hoặc cinemaId không hợp lệ');
        }
    });
// tìm kiếm
        document.getElementById('filterDateButton').addEventListener('click', function() {
        var movieId = document.getElementById('movieSelect').value;
        var cinemaId = document.getElementById('cinemaSelect').value;
        var selectedDate = document.getElementById('dateFilterInput').value;

        if (movieId && cinemaId && selectedDate) {
            fetch(`/admin/showingreleases/${movieId}/${cinemaId}?date=${selectedDate}`)
                .then(response => response.json())
                .then(data => {
                    var showingReleaseBody = document.getElementById('showingReleaseBody');
                    showingReleaseBody.innerHTML = '';
                    if (Array.isArray(data.showingReleases) && data.showingReleases.length > 0) {
                        data.showingReleases.forEach(showingRelease => {
                            showingReleaseBody.innerHTML += `
                                <tr>
                                    <td>${showingRelease.movie.name}</td>
                                    <td><img src="${assetUrl}/${showingRelease.movie.photo.replace('storage/movies/', '')}" id="tablenew" alt="${showingRelease.movie.name}" height="150px" width="200px"></td>
                                    <td>${showingRelease.room.name}</td>
                                    <td>${new Date(showingRelease.time_release).toLocaleTimeString([], {hour: '2-digit', minute: '2-digit'})}</td>
                                    <td>${new Date(showingRelease.date_release).toLocaleDateString()}</td>
                                    <td>
                                        <div class="dropdown dropstart">
                                            <a href="#" class="text-muted " id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ti ti-dots-vertical fs-5"></i>
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center gap-3" href="/admin/showingrelease/${showingRelease.id}"><i class="fs-4 ti ti-plus"></i>Detail</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center gap-3" href="/admin/showingrelease/${showingRelease.id}/edit"><i class="fs-4 ti ti-edit"></i>Edit</a>
                                                </li>
                                                <li>
                                                    <form action="/admin/showingrelease/${showingRelease.id}" method="post" onsubmit="return confirm('Do you want to delete ?')">
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
                            `;
                        });
                        document.getElementById('showingReleaseTable').style.display = 'block';
                        // Hiển thị phân trang nếu có dữ liệu
                        if (data.pagination) {
                            document.getElementById('paginationContainer').innerHTML = data.pagination;
                        } else {
                            document.getElementById('paginationContainer').innerHTML = '';
                        }
                    } else {
                        showingReleaseBody.innerHTML = '<tr><td colspan="6" class="text-center">No showing releases available.</td></tr>';
                        document.getElementById('paginationContainer').innerHTML = ''; // Không hiển thị phân trang nếu không có dữ liệu
                    }
                })
                .catch(error => console.error('Có lỗi xảy ra:', error));
        } else {
            console.error('movieId, cinemaId, hoặc date không hợp lệ');
        }
    });
// chuyển trang
    document.addEventListener('click', function(e) {
        if (e.target.closest('.pagination a')) {
            e.preventDefault();
            
            var url = e.target.closest('.pagination a').getAttribute('href');
            
            // Lấy giá trị của các tham số lọc
            var movieId = document.getElementById('movieSelect').value;
            var cinemaId = document.getElementById('cinemaSelect').value;
            var dateFilter = document.getElementById('dateFilterInput').value;

            // Thêm các tham số lọc vào URL phân trang
            var queryParams = new URLSearchParams(url.split('?')[1] || '');
            if (movieId) queryParams.set('movie_id', movieId);
            if (cinemaId) queryParams.set('cinema_id', cinemaId);
            if (dateFilter) queryParams.set('date_filter', dateFilter);

            var newUrl = `${url.split('?')[0]}?${queryParams.toString()}`;

            fetch(newUrl)
                .then(response => response.json())
                .then(data => {
                    // Cập nhật lại dữ liệu bảng và phân trang
                    var showingReleaseBody = document.getElementById('showingReleaseBody');
                    showingReleaseBody.innerHTML = ''; 
                    data.showingReleases.forEach(showingRelease => {
                        showingReleaseBody.innerHTML += `
                            <tr>
                                <td>${showingRelease.movie.name}</td>
                                <td><img src="${assetUrl}/${showingRelease.movie.photo.replace('storage/movies/', '')}" id="tablenew" alt="${showingRelease.movie.name}" height="150px" width="200px"></td>
                                <td>${showingRelease.room.name}</td>
                                <td>${new Date(showingRelease.time_release).toLocaleTimeString([], {hour: '2-digit', minute: '2-digit'})}</td>
                                <td>${new Date(showingRelease.date_release).toLocaleDateString()}</td>
                                <td>
                                    <div class="dropdown dropstart">
                                        <a href="#" class="text-muted" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ti ti-dots-vertical fs-5"></i>
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <li>
                                                <a class="dropdown-item d-flex align-items-center gap-3" href="/admin/showingrelease/${showingRelease.id}"><i class="fs-4 ti ti-plus"></i>Detail</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item d-flex align-items-center gap-3" href="/admin/showingrelease/${showingRelease.id}/edit"><i class="fs-4 ti ti-edit"></i>Edit</a>
                                            </li>
                                            <li>
                                                <form action="/admin/showingrelease/${showingRelease.id}" method="post" onsubmit="return confirm('Do you want to delete ?')">
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
                        `;
                    });
                    // Cập nhật phân trang mới
                    document.getElementById('paginationContainer').innerHTML = data.pagination;
                })
                .catch(error => console.error('Có lỗi xảy ra:', error));
        }
    });

    </script>
@endsection
