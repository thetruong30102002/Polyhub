<?php

namespace Modules\City\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\City\Entities\City;
use Modules\City\Http\Requests\CreateCityRequest;
use Modules\City\Http\Requests\UpdateCityRequest;
use Modules\City\Repositories\CityRepository;
use Modules\City\Repositories\CityRepositoryEloquent;

class CityController extends Controller
{

    protected $model;
    public function __construct(City $model)
    {
        $this->model = $model;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $cities = $this->model->paginate(10);
        return view('city::index', compact('cities'));
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
    public function store(CreateCityRequest $request)
    {
        $request->validated();
        $data = $request->all();
        $this->model->create($data);
        return redirect()->route('admin.city.index');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $city = $this->model->with('cinemas')->findOrFail($id);
        return view('city::show', compact('city'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $city = $this->model->find($id);
        return view('city::edit', compact('city'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateCityRequest $request, $id)
    {
        $request->validated();
        $data = $request->all();
        $this->model->find($id)->update($data);
        return redirect()->route('admin.city.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $this->model->find($id)->delete();
        return redirect()->route('admin.city.index');
    }
}
