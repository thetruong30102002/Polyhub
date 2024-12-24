<?php

namespace Modules\Movie\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Modules\Category\Entities\Category;
use Modules\Director\Entities\Director;
use Modules\Movie\Entities\Movie;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $title = "List Movies";
        $director = Director::all();
        $categories = Category::all();
        // Truy vấn phim với điều kiện lọc theo đạo diễn nếu có
        $query = Movie::with('director','categories');
        
        if ($request->filled('director_id')) {
            $query->where('director_id', $request->director_id);
        }

        if ($request->filled('categories_id')) {
            $query->whereHas('categories', function($q) use ($request) {
                $q->where('categories.id', $request->categories_id);
            });
        }

        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }
        
        $movie = $query->latest('id')->paginate(5);
        
        return view('movie::index', compact('movie', 'director', 'title','categories'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {   
        $title = "Add Movies";
        $director = Director::query()->pluck('name','id')->all();
        $categories = Category::all();
        return view('movie::create',compact('title','director','categories'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'duration' => 'required|numeric|min:60|max:240',
            'premiere_date' => 'required|date',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
        ]);
    
        // Nếu dữ liệu không hợp lệ, trả về thông báo lỗi và dữ liệu đã nhập trước đó
        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $movieData = $request->except(['photo', 'categories']);
        $pathFile = Storage::putFile('movies', $request->file('photo'));
        $movieData['photo'] = 'storage/' . $pathFile;
        $movie= Movie::query()->create($movieData);
        $movie->categories()->attach($request->input('categories'));
        return redirect('/admin/movie')->with('success', 'Add Movie Successfully!');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $title = "Edit Movie";
        $movie = Movie::with('categories')->find($id);;
        $director = Director::query()->pluck('name','id')->all();
        $categories = Category::all();
        return view('movie::edit', compact('movie','title','director','categories'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'duration' => 'required|numeric|min:60|max:240',
            'premiere_date' => 'required|date',
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'categories' => 'array',
            'categories.*' => 'exists:categories,id'
        ]);
    
        // Nếu dữ liệu không hợp lệ, trả về thông báo lỗi và dữ liệu đã nhập trước đó
        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $movieId = Movie::find($id);
        $movie = $request->except('photo','categories');

        if($request->hasFile('photo')){
            $pathFile = Storage::putFile('movies',$request->file('photo'));
            $movie['photo'] = 'storage/' . $pathFile;
        }

        $currentImage = $movieId->photo;
        
        $movieId->update($movie);
        
        if($request->hasFile('photo')
        && $currentImage
        && file_exists(public_path($currentImage)) 
        ) {
            unlink(public_path($currentImage));
        } 
        $movieId->categories()->sync($request->categories);
        return redirect('/admin/movie')->with('success', 'Movie Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $movie = Movie::find($id);

        $hasShowingRelease = $movie->showingReleases()->exists(); 
        $hasTicketSeat = $movie->ticketseats()->exists();
        $hasAttribute = $movie->attributes()->exists();
    
        if ($hasTicketSeat||$hasShowingRelease||$hasAttribute) {
            return redirect('/admin/movie')->with('error', 'Cannot delete the movie because this movie had showingrelease, ticket, or attributes.');
        }

        $movie -> delete();
        return redirect('/admin/movie')->with('success', 'Deleted successfully !');
    }

    public function toggleActivation(Request $request, $id)
    {
        $movie = Movie::findOrFail($id);
        $movie->activated = $request->input('is_active');
        $movie->save();
        return redirect('/admin/movie');
    }    
}

