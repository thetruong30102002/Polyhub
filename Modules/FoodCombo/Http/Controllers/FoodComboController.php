<?php

namespace Modules\FoodCombo\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Modules\FoodCombo\Entities\FoodCombo;
use Modules\FoodCombo\Http\Requests\CreateFoodComboRequest;
use Modules\FoodCombo\Http\Requests\UpdateFoodComboRequest;

class FoodComboController extends Controller
{
    public function index(Request $request)
    {
        $title = "FoodCombo";
        $searchTerm = $request->input('search');
        $sortField = $request->input('sort_field', 'id'); 
        $sortDirection = $request->input('sort_direction', 'desc'); 

        $foodCombos = FoodCombo::search($searchTerm)->orderBy($sortField, $sortDirection)->paginate(8);

        return view('foodcombo::index', compact('foodCombos','searchTerm','sortField','sortDirection','title'));
    }

    public function create()
    {
        $title = "FoodCombo Create";
        return view('foodcombo::create', compact('title'));
    }

    public function store(CreateFoodComboRequest $request)
    {
    $foodComboData = $request->except(['avatar']);
    $pathFile = Storage::putFile('foodcombos', $request->file('avatar'));
    $foodComboData['avatar'] = 'storage/' . $pathFile;
    $foodCombo = FoodCombo::create($foodComboData);
    return redirect()->route('foodcombos.index')->with('success', 'Add FoodCombo Successfully!');
    }

    public function show($id)
    {
        $foodCombo = FoodCombo::find($id);
        $title = "FoodCombos Show";
        return view('foodcombo::show', compact('foodCombo'));
    }

    public function edit($id)
    {
        $foodCombo = FoodCombo::find($id);
        $title = "FoodCombo Edit";
        return view('foodcombo::edit', compact('foodCombo','title'));
    }

    public function update(UpdateFoodComboRequest $request, $id)
    {
    $foodCombo = FoodCombo::findOrFail($id);
    $foodComboData = $request->except(['avatar']);
    
    if ($request->hasFile('avatar')) {
        if ($foodCombo->avatar && file_exists(public_path($foodCombo->avatar))) {
            unlink(public_path($foodCombo->avatar));
        }
        $pathFile = Storage::putFile('foodcombos', $request->file('avatar'));
        $foodComboData['avatar'] = 'storage/' . $pathFile;
    }
        $foodCombo->update($foodComboData);
        return redirect()->route('foodcombos.index')->with('success', 'FoodCombo Updated successfully!');
    }
    public function destroy($id){
    $foodCombo = FoodCombo::findOrFail($id);

    if ($foodCombo->avatar && file_exists(public_path($foodCombo->avatar))) {
        unlink(public_path($foodCombo->avatar));
    }
    $foodCombo->delete();
    return redirect()->route('foodcombos.index')->with('success', 'Deleted FoodCombo Successfully!');
    }

    public function updateStatus(Request $request, $id)
    {
    $foodCombo = FoodCombo::findOrFail($id);
    $foodCombo->status = $request->input('status');
    $foodCombo->save();
    return redirect()->back()->with('success', 'Food combo status updated successfully.');
    }  
}
