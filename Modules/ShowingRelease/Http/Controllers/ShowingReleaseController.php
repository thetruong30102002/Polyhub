<?php

namespace Modules\ShowingRelease\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Cinema\Entities\Cinema;
use Modules\City\Entities\Cities;
use Modules\Movie\Entities\Movie;
use Modules\Room\Entities\Room;
use Modules\Seat\Entities\Seat;
use Modules\SeatShowtimeStatus\Entities\SeatShowtimeStatus;
use Modules\ShowingRelease\Entities\ShowingRelease;
use Modules\ShowingRelease\Http\Requests\CreateShowingReleaseRequest;
use Modules\ShowingRelease\Http\Requests\UpdateShowingReleaseRequest;
use Modules\Ticket\Entities\Ticket;

class ShowingReleaseController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $title = "ShowingRelease";
        $cities = Cities::all();
        $cinemas = collect();
        $rooms = collect();
        $movies = Movie::all();
    
        if ($request->filled('city_id')) {
            $cinemas = Cinema::where('city_id', $request->input('city_id'))->get();
        }
    
        if ($request->filled('cinema_id')) {
            $rooms = Room::where('cinema_id', $request->input('cinema_id'))->get();
        }
    
        $query = ShowingRelease::with(['movie', 'room.cinema.city']);
    
        if ($request->filled('room_id')) {
            $query->where('room_id', $request->input('room_id'));
        }
    
        $list = $query->latest('id')->paginate(8);
        return view('showingrelease::index', compact('title', 'list', 'cities', 'cinemas', 'rooms', 'movies'));
    } 

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create($cinemaId = null)
    {
        $movie = Movie::pluck('name', 'id');
        $cities = Cities::pluck('name', 'id'); 
        $rooms = [];
        if ($cinemaId) {
            $rooms = Room::where('cinema_id', $cinemaId)->pluck('name', 'id');
        }
        $data = ShowingRelease::all();
        $title = "ShowingRelease create";
        return view('showingrelease::create', compact('data', 'cities', 'movie','title','rooms'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(CreateShowingReleaseRequest $request)
    {
        // create new release_seats
        DB::beginTransaction();
        try {
            $showingRelease = new ShowingRelease();
            $showingRelease->movie_id = $request->movie_id;
            $showingRelease->room_id = $request->room_id;
            $showingRelease->date_release = Carbon::createFromFormat('Y-m-d', $request->date_release);
            $showingRelease->time_release = Carbon::createFromFormat('H:i', $request->time_release);
            $showingRelease->save();
            $seats = Seat::where('room_id', $request->room_id)
                        ->get();
            foreach ($seats as $seat) {
                SeatShowtimeStatus::create([
                    'seat_id' => $seat->id,
                    'showtime_id' => $showingRelease->id,
                    'status' => false
                ]);
            }
            DB::commit();
        }catch(\Exception $e) {
            DB::rollBack();
            return redirect()->route('showingrelease.create')->with('error', 'Add ShowingRelease Not Successfully!');
        }
        return redirect()->route('showingrelease.index')->with('success', 'Add ShowingRelease Successfully!');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $showingRelease = ShowingRelease::with('room', 'movie')->find($id);
        $showSeats = SeatShowtimeStatus::with('seat')->where('showtime_id', $id)
        ->get();
        $groupedSeats = $showSeats->groupBy(function ($seatStatus) {
            if($seatStatus->seat){
                return $seatStatus->seat->row;
            }
        });
        $title = "ShowingRelease Show";
        return view('showingrelease::show', compact('showingRelease', 'groupedSeats','title'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $show= ShowingRelease::findOrFail($id);
    $movie = Movie::pluck('name', 'id');
    $rooms = Room::where('cinema_id', $show->room->cinema_id)->pluck('name', 'id');
    $title = "Edit Showing Release";
        return view('showingrelease::edit', compact('show', 'movie', 'rooms','title'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateShowingReleaseRequest $request, $id)
    {
        $showingRelease = ShowingRelease::find($id);
        $showingRelease->movie_id = $request->movie_id;
        $showingRelease->room_id = $request->room_id;

        $showingRelease->date_release =  $request->date_release;
        $showingRelease->time_release = Carbon::createFromFormat('H:i', $request->time_release);
        $showingRelease->save();

        return redirect()->route('showingrelease.index')->with('success', 'ShowingRelease Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $showingRelease = ShowingRelease::find($id);

        // Kiểm tra nếu showingrelease đã tồn tại trong bảng ticket_seats
        $existsInTicketSeats = DB::table('ticket_seats')->where('showing_release_id', $id)->exists();

        if ($existsInTicketSeats) {
            return redirect()->route('showingrelease.index')->with('error', 'Cannot delete ShowingRelease as it is associated with a ticket.');
        }

        $showingRelease->delete();

        return redirect()->route('showingrelease.index')->with('success', 'Deleted ShowingRelease Successfully!');
    }

    public function getCinemasByCity($cityId) {
        $cinemas = Cinema::where('city_id', $cityId)->get();
        return response()->json($cinemas);
    }
    
    public function getAllMovies()
    {
        try {
            $movies = Movie::all(); // Lấy tất cả các phim
            return response()->json($movies);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Có lỗi xảy ra'], 500);
        }
    }
    
    public function getShowingReleasesByMovie($movieId, $cinemaId) {
        try {
            $date = request()->query('date'); // Lấy ngày từ tham số truy vấn
            $rooms = Room::where('cinema_id', $cinemaId)->pluck('id');
            $query = ShowingRelease::with(['movie', 'room'])
                ->where('movie_id', $movieId)
                ->whereIn('room_id', $rooms);
            if ($date) {
                $query->whereDate('date_release', $date);
            }
            // Phân trang với 5 bản ghi mỗi trang
            $showingReleases = $query->latest('id')->paginate(5);
            
            return response()->json([
                'showingReleases' => $showingReleases->items(),
                'pagination' => $showingReleases->appends(request()->query())->links('vendor.pagination.bootstrap-5')->toHtml()
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Có lỗi xảy ra'], 500);
        }
    }
}