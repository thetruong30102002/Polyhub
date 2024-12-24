<?php

namespace Modules\Actor\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Modules\Actor\Entities\Actor;
use Modules\Movie\Entities\Movie;
use Illuminate\Support\Facades\Facade;
class ActorController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $title = 'Actor';
        $title2 = 'List Actor';
        $movie = Movie::all();
        $actor = Actor::query()->orderByDesc('created_at');
        $page = $actor->paginate(4);
        return view('actor::index', compact('title','title2','page','actor','movie'));
        //return view('actor::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $title = ' Actor';
        $title2 = 'Add New Actor';
        $movies = Movie::all();
        return view('actor::create', compact('title','title2','movies'));
        // return view('actor::create');
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
            'name' => 'required',
            'gender' => 'required',
            'avatar' => 'required',
            'movies' => 'required'            
        ]);
        if($request->hasFile('avatar')){
            $request->validate([
                'avatar' => 'mimes:jpg,png,jpeg,gif'
            ]);
          

            $actorData = $request->except(['avatar','movies']);
            $pathFile = Storage::putFile('actors', $request->file('avatar'));
            $actorData['avatar'] = 'storage/' . $pathFile;
            $actor = Actor::query()->create($actorData);
            $actor->movies()->attach($request->input('movies'));

            return redirect('/admin/actor')->with('success', 'Add Actor Successfully!');


         
        
           
        }
       
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $actor = Actor::with('movies')->find($id);
        $title = ' Actor';
        $title2 = 'Detail Actor';
        $movies = Movie::all();
        return view('actor::show', compact('actor','title','title2','movies'));
        // return view('actor::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        // return view('actor::edit');
        $actor = Actor::find($id);
        $title = ' Actor';
        $title2 = 'Update Actor';
        $movies = Movie::all();
        return view('actor::edit', compact('actor','title','title2','movies'));
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
        $actorId = Actor::find($id);
        $request->validate([
            'name' => 'required',
            'gender' => 'required',
            'movies' => 'required'            
        ]);
        
       
        $actor = $request->except(['avatar','movies']);

        if($request->hasFile('avatar')){
            $pathFile = Storage::putFile('actors',$request->file('avatar'));
            $actor['avatar'] = 'storage/' . $pathFile;
        }

        $currentImage = $actorId->image;

        
        $actorId->update($actor);
        
        if($request->hasFile('avatar')
        && $currentImage
        && file_exists(public_path($currentImage)) 
        ) {
            unlink(public_path($currentImage));
        } 
        $actorId->movies()->sync($request->movies);
        return redirect('/admin/actor')->with('success', 'Actor Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
        $actor = Actor::find($id);
        $actor->delete();
        return redirect(route('actor.list'));

    }
    public function search(Request $request){
        $text = $request->text;
        $actor = Actor::where('name', 'like','%'.$text.'%');
        $title = 'Actor';
        $title2 = 'List Actor';
        $movie = Movie::all();
        $page = $actor->paginate(4);
       
        return view('actor::search', compact('title','title2','movie','page'));
    }
    public function filter(Request $request)
    {
        $gender = $request->input('gender', ''); // Lấy giá trị giới tính từ request
    
        // Tạo query để lọc dữ liệu theo giới tính
        $actorsQuery = Actor::query();
    
        if ($gender) {
            $actorsQuery->where('gender', $gender);
        }
    
        // Phân trang kết quả
        $page = $actorsQuery->paginate(4)->appends(['gender' => $gender]);
    
        $title = 'Actor';
        $title2 = 'List Actor';
        $movie = Movie::all();
    
        return view('actor::filter', compact('title', 'title2', 'page', 'movie'));
    }
    


    public function bin()
    {
        $listvalue = Actor::onlyTrashed();
        $page = $listvalue->paginate(4);
        $title = ' Actor';
        $title2 = 'List Bin Actor';
        $movie = Movie::all();
        return view('actor::bin', compact('listvalue','title','title2','movie','page'));
    }
    public function restore($id){
        Actor::onlyTrashed()->where('id', '=', $id)->restore();
        return redirect(route('actor.list'));
    }
    public function forceDelete($id){
        Actor::onlyTrashed()->where('id', '=', $id)->forceDelete();
        return redirect(route('actor.list'));
    }

}
