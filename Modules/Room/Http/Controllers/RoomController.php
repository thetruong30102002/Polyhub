<?php

namespace Modules\Room\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Cinema\Entities\Cinema;
use Modules\City\Entities\City;
use Modules\Room\Entities\Room;
use Modules\Room\Http\Requests\CreateRoomRequest;
use Modules\Room\Http\Requests\UpdateRoomRequest;
use Modules\ShowingRelease\Entities\ShowingRelease;

class RoomController extends Controller
{

    protected $model;

    public function __construct(Room $model){
        $this->model = $model;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $cities = City::all();
        $cinemaQuery = Cinema::with('city');
        $query = $this->model->with('cinema');
        if ($request->filled('city_id')) {
            $cinemaQuery->where('city_id', $request->city_id);
        }

        if ($request->filled('cinema_id')) {
            $query->where('cinema_id', $request->cinema_id);
        }

        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }

        $cinemas = $cinemaQuery->get();
        $rooms = $query->latest('id')->paginate(10);
        return view('room::index', compact('rooms', 'cities', 'cinemas'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $cities = City::all();
        $cinemas = Cinema::all();
        return view('room::create', compact('cinemas', 'cities'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(CreateRoomRequest $request)
    {
        $data = $request->all();
        $room = $this->model->create($data);
        $rows = [
            'a' => 1, 'b' => 1, 'c' => 1,
            'd' => 2, 'e' => 2, 'f' => 2,
            'g' => 3
        ];
        $seats = [];

        for ($column = 1; $column <= 12; $column++) {
            foreach ($rows as $row => $type) {
                $seats[] = [
                    'row' => $row,
                    'column' => $column,
                    'seat_type_id' => $type,
                    'status' => 0,
                    'room_id' => $room->id,
                 ];
            }
        }

        DB::table('seats')->insert($seats);
        return redirect()->route('admin.room.index')->with('success', 'Add room Successfully!');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $cinemas = Cinema::all();
        $room = $this->model->with('seats')->find($id);
        $seats = $room->seats->groupBy('row');
        return view('room::detail', compact('room','cinemas', 'seats'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('room::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateRoomRequest $request, $id)
    {
        $data = $request->all();
        $this->model->findOrFail($id)->update($data);
        return redirect()->route('admin.room.index')->with('success', 'Update room Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        // logic nếu còn xuất chiếu tại phòng thì không được xoá phòng
        $showingRelease = ShowingRelease::where('room_id', $id)
        ->orderBy('date_release', 'desc')
        ->first();
        if($showingRelease){
            if($showingRelease->date_release > Carbon::now()) {
                return redirect()->route('admin.room.index')->with('error', 'Cannot delete room while showing release is scheduled.');
            }
        }
        
        $this->model->findOrFail($id)->delete();
        return redirect()->route('admin.room.index')->with('success', 'Delete room Successfully!');
    }
}
