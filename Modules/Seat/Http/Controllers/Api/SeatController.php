<?php

namespace Modules\Seat\Http\Controllers\Api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Seat\Entities\Seat;
use Modules\Seat\Http\Requests\ApiCreateSeatRequest;
use Modules\Seat\Http\Requests\ApiUpdateSeatRequest;
use Modules\Seat\Transformers\SeatResource;

class SeatController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    protected $model;

    public function __construct(Seat $model)
    {
        $this->model = $model;
    }
    public function index()
    {
        $seats = $this->model->with('room')->paginate(10);
        $roomResource = SeatResource::collection($seats)->response()->getData(true);

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
        return view('seat::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(ApiCreateSeatRequest $request)
    {
        
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $seat = $this->model->with('room')->findOrFail($id);
        $seatResource = new SeatResource($seat);
        
        return response()->json([
            'data' => $seatResource
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('seat::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(ApiUpdateSeatRequest $request, $id)
    {
        $seat = $this->model->with('room')->findOrFail($id);
        $dateUpdate = $request->all();
        $seat->update($dateUpdate);

        $seatResource = new SeatResource($seat);
        return response()->json([
            'data' => $seatResource
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
            $seat = $this->model->findOrFail($id);
            $seat->delete();
            DB::commit();
            $seatResource = new SeatResource($seat);
            return response()->json([
               'message' => 'Room deleted successfully',
               'data' => $seatResource,
            ], Response::HTTP_OK);
        }catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
               'message' => 'Failed to delete seat, please check your database to make sure the record exists',
               'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
