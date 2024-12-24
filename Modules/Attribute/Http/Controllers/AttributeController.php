<?php

namespace Modules\Attribute\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Attribute\Entities\Attribute;
use Modules\Movie\Entities\Movie;
class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        // return view('attribute::index');
        $listattr = Attribute::query()->orderByDesc('created_at');
        $page = $listattr->paginate(4);
        $title = ' Attribute';
        $title2 = 'List Attribute';
        $movie = Movie::all();
        return view('attribute::index', compact('listattr','movie', 'title', 'title2', 'page'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        // return view('attribute::create');
        $title = ' Attribute';
        $title2 = 'Add new Attribute';
        $movie = Movie::all();
        return view('attribute::create', compact('title', 'title2', 'movie'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'movie_id' => 'required',
            'name' => 'required'
        ]);


        $input = [
            'name' => $request->name,
            'movie_id' => $request->movie_id,
        ];

        Attribute::create($input);


        return redirect(route('attribute.list'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        // return view('attribute::show');
        $attribute = Attribute::find($id);
        $title = ' Attribute';
        $title2 = 'Update Attribute';
        $movie = Movie::all();
        return view('attribute::show', compact('attribute', 'title', 'title2', 'movie'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        // return view('attribute::edit');
          
        $attribute = Attribute::find($id);
        $title = ' Attribute';
        $title2 = 'Update Attribute';
        $movie = Movie::all();
        return view('attribute::edit', compact('attribute', 'title', 'title2', 'movie'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
        $attribute = Attribute::find($id);
        $request->validate([
            'movie_id' => 'required',
            'name' => 'required'
        ]);


        $input = [
            'name' => $request->name,
            'movie_id' => $request->movie_id,
        ];

       $attribute->update($input);


        return redirect(route('attribute.list'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
        $Attribute = Attribute::find($id);
        $Attribute->delete();
        return redirect(route('attribute.list'));
    }
    public function search(Request $request){
        $text = $request->text;
        $attribute = Attribute::where('name', 'like','%'.$text.'%');
        $title = 'Attribute';
        $title2 = 'List Attribute';
        $movie = Movie::all();
        $page = $attribute->paginate(4);
        return view('attribute::search', compact('title','title2','attribute','movie','page'));
    }
    public function bin()
    {
        $listvalue = Attribute::onlyTrashed();
        $page = $listvalue->paginate(4);
        $title = ' Attribute';
        $title2 = 'List Attribute';
        $movie = Movie::all();
        return view('attribute::bin', compact('listvalue','title','title2','movie','page'));
    }
    public function restore($id){
        Attribute::onlyTrashed()->where('id', '=', $id)->restore();
        return redirect(route('attribute.list'));
    }
    public function forceDelete($id){
        Attribute::onlyTrashed()->where('id', '=', $id)->forceDelete();
        return redirect(route('attribute.list'));
    }
}
