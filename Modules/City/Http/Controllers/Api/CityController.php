<?php

namespace Modules\City\Http\Controllers\Api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\City\Entities\City;
use Modules\City\Http\Requests\ApiCreateCityRequest;
use Modules\City\Http\Requests\ApiUpdateCityRequest;
use Modules\City\Transformers\CityResource;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    protected $model; 

    public function __construct(City $city)
    {
        $this->model = $city;
    }

    public function index()
    {
        $cities = $this->model->with('cinemas')->paginate(10);
        $cityResource = CityResource::collection($cities)->response()->getData();

        return response()->json([
            'data' => $cityResource
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('city::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(ApiCreateCityRequest $request)
    {
        $dataCreate = $request->all();
        $city = $this->model->create([
            'name' => $dataCreate['name']
        ]);
        
        $cityResource = new CityResource($city);
        return response()->json([
            'data' => $cityResource,
        ], Response::HTTP_OK);

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $city = $this->model->with('cinemas')->findOrFail($id);
        $cityResource = new CityResource($city);
        
        return response()->json([
            'data' => $cityResource
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('city::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(ApiUpdateCityRequest $request, $id)
    {
        $city = $this->model->with('cinemas')->findOrFail($id);
        $dateUpdate = $request->all();
        $city->update($dateUpdate);

        $cityResource = new CityResource($city);
        return response()->json([
            'data' => $cityResource
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
            $city = $this->model->findOrFail($id);
            $city->delete();
            DB::commit();
            $cityResource = new CityResource($city);
            return response()->json([
               'message' => 'city deleted successfully',
               'data' => $cityResource,
            ], Response::HTTP_OK);
        }catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
               'message' => 'Failed to delete city, please check your database to make sure the record exists',
               'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
