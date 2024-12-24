<?php

namespace Modules\Cinema\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Cinema\Entities\Cinema;
use Modules\Cinema\Http\Requests\ApiCreateCinemaRequest;
use Modules\Cinema\Http\Requests\ApiUpdateCinemaRequest;
use Modules\Cinema\Transformers\CinemaResource;

class CinemaController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */

    protected $model;

    public function __construct(Cinema $model) {
        $this->model = $model;
    }

    public function index()
    {
        $cinemas = $this->model->with('city', 'cinemaType', 'rooms')->get();
        $cinemaResource = CinemaResource::collection($cinemas)->response()->getData(true);

        return response()->json([
            'data' => $cinemaResource
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(ApiCreateCinemaRequest $request)
    {
        $dataCreate = $request->all();
        $cinema = $this->model->create([
            'name' => $dataCreate['name'],
            'city_id' => $dataCreate['city_id'],
        ]);
        
        $cinemaResource = new CinemaResource($cinema);
        return response()->json([
            'data' => $cinemaResource
        ], Response::HTTP_OK);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $cinema = $this->model->with('city', 'cinemaType', 'rooms')->findOrFail($id);
        $cinemaResource = new CinemaResource($cinema);
        
        return response()->json([
            'data' => $cinemaResource
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(ApiUpdateCinemaRequest $request, $id)
    {
        $cinema = $this->model->with('city', 'cinemaType', 'rooms')->findOrFail($id);
        $dateUpdate = $request->all();
        $cinema->update($dateUpdate);

        $cinemaResource = new CinemaResource($cinema);
        return response()->json([
            'data' => $cinemaResource
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $cinema = $this->model->findOrFail($id);
            $cinema->delete();
            DB::commit();
            $cinemaResource = new CinemaResource($cinema);
            return response()->json([
               'message' => 'Cinema deleted successfully',
               'data' => $cinemaResource,
            ], Response::HTTP_OK);
        }catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
               'message' => 'Failed to delete cinema, please check your database to make sure the record exists',
               'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        
    }
}
