<?php

namespace Modules\ShowingRelease\Http\Controllers\api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Movie\Entities\Movie;
use Modules\Room\Entities\Room;
use Modules\SeatShowtimeStatus\Entities\SeatShowtimeStatus;
use Modules\SeatType\Entities\SeatType;
use Modules\ShowingRelease\Entities\ShowingRelease;
use Modules\ShowingRelease\Http\Requests\UpdateShowingReleaseRequest;

class ShowingReleaseController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($movie_id) {}

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        $movie = Movie::pluck('name', 'id');
        $room = Room::pluck('name', 'id');
        $data = ShowingRelease::all();
        return response()->json([
            'data' => $data,
            'room' => $room,
            'movie' => $movie
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param CreateShowingReleaseRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $showingRelease = new ShowingRelease();
        $showingRelease->movie_id = $request->movie_id;
        $showingRelease->room_id = $request->room_id;
        $showingRelease->date_release = Carbon::createFromFormat('Y-m-d', $request->date_release);
        $showingRelease->time_release = Carbon::createFromFormat('H:i', $request->time_release);
        $showingRelease->save();

        return response()->json(['data' => $showingRelease, 'success' => 'Thêm thành công'], 201);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($showingReleaseId)
    {
        $showingRelease = ShowingRelease::with(['room', 'room.cinema.city', 'movie']) // Tải các quan hệ 'room' và 'room.city'
            ->find($showingReleaseId);
        return response()->json([
            'data' => $showingRelease,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        $show = ShowingRelease::find($id);
        if ($show) {
            $movie = Movie::pluck('name', 'id');
            $room = Room::pluck('name', 'id');
            return response()->json([
                'show' => $show,
                'movie' => $movie,
                'room' => $room
            ]);
        }
        return response()->json(['error' => 'Not Found'], 404);
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateShowingReleaseRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateShowingReleaseRequest $request, $id)
    {
        $showingRelease = ShowingRelease::find($id);
        if ($showingRelease) {
            $showingRelease->movie_id = $request->movie_id;
            $showingRelease->room_id = $request->room_id;
            $showingRelease->date_release =  $request->date_release;
            $showingRelease->time_release = Carbon::createFromFormat('H:i', $request->time_release);
            $showingRelease->save();
            return response()->json(['data' => $showingRelease, 'success' => 'Cập nhật thành công!']);
        }
        return response()->json(['error' => 'Not Found'], 404);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $showingRelease = ShowingRelease::find($id);
        if ($showingRelease) {
            $showingRelease->delete();
            return response()->json(['success' => 'Xóa thành công!']);
        }
        return response()->json(['error' => 'Not Found'], 404);
    }

    public function getSeatsByShowtime($showtime_id)
    {
        // Lấy toàn bộ ghế theo showtime_id
        $seats = SeatShowtimeStatus::where('showtime_id', $showtime_id)
            ->with('seat', 'seat.seatType') // Sử dụng with() để tải quan hệ
            ->get();

        return response()->json($seats);
    }

    public function updateSeatStatus(Request $request, $showtime_id, $seat_id)
    {
        // Validate request
        $request->validate([
            'status' => 'required|boolean',
        ]);

        // Tìm ghế theo showtime_id và seat_id
        $seat = SeatShowtimeStatus::where('showtime_id', $showtime_id)
            ->where('seat_id', $seat_id)
            ->first();

        if (!$seat) {
            return response()->json(['message' => 'Seat not found'], 404);
        }

        // Cập nhật status của ghế
        $seat->status = $request->status;
        $seat->save();

        return response()->json(['message' => 'Seat status updated successfully']);
    }

    public function getSeatType()
    {
        $SeatType = SeatType::all();
        return response()->json($SeatType);
    }

    public function getShowingbyMovie($movie_id)
    {
        $today = Carbon::today();
        $tenDaysLater = $today->copy()->addDays(10); // Ngày sau 10 ngày từ hôm nay
        $now = Carbon::now('Asia/Ho_Chi_Minh'); // Đặt múi giờ phù hợp với cơ sở dữ liệu
        $query = ShowingRelease::where('movie_id', $movie_id)
            ->whereBetween('date_release', [$today, $tenDaysLater])
            ->where('time_release', '>=', $now) // Chỉ lấy các suất chiếu từ giờ trở đi
            ->with(['room', 'room.cinema.city', 'movie'])
            ->get();

        return response()->json([
            'data' => $query,
        ]);
    }


    public function getStatusSeat($id)
    {
        // Tìm ghế theo ID
        $seatStatus = SeatShowtimeStatus::where('id', $id)->first();

        // Kiểm tra nếu ghế tồn tại
        if ($seatStatus) {
            // Trả về trạng thái của ghế dưới dạng true/false
            return response()->json(['status' => $seatStatus->status === 1]);
        } else {
            // Nếu không tìm thấy ghế, trả về lỗi 404
            return response()->json(['error' => 'Seat not found'], 404);
        }
    }
}
