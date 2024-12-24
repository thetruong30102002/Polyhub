<?php

namespace Modules\Room\Http\Controllers\Api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Room\Entities\Room;
use Modules\Room\Http\Requests\ApiCreateRoomRequest;
use Modules\Room\Http\Requests\ApiUpdateRoomRequest;
use Modules\Room\Transformers\RoomResource;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    protected $model;

    public function __construct(Room $model)
    {
        $this->model = $model;
    }
    public function index()
    {
        $rooms = $this->model->with('cinema', 'seats')->paginate(10);
        $roomResource = RoomResource::collection($rooms)->response()->getData(true);

        return response()->json([
            'data' => $roomResource
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('room::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(ApiCreateRoomRequest $request)
    {
        $dataCreate = $request->all();
        $room = $this->model->create([
            'name' => $dataCreate['name'],
            'city_id' => $dataCreate['city_id'],
        ]);
        
        $roomResource = new RoomResource($room);
        return response()->json([
            'data' => $roomResource,
        ], Response::HTTP_OK);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $room = $this->model->with('cinema', 'seats')->findOrFail($id);
        $roomResource = new RoomResource($room);
        
        return response()->json([
            'data' => $roomResource
        ], Response::HTTP_OK);
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
    public function update(ApiUpdateRoomRequest $request, $id)
    {
        $room = $this->model->with('cinema', 'seats')->findOrFail($id);
        $dateUpdate = $request->all();
        $room->update($dateUpdate);

        $roomResource = new RoomResource($room);
        return response()->json([
            'data' => $roomResource
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $room = $this->model->findOrFail($id);
            $room->delete();
            DB::commit();
            $cinemaResource = new RoomResource($room);
            return response()->json([
               'message' => 'Room deleted successfully',
               'data' => $cinemaResource,
            ], Response::HTTP_OK);
        }catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
               'message' => 'Failed to delete room, please check your database to make sure the record exists',
               'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
