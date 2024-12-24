<?php

namespace Modules\Banner\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Banner\Entities\Banner;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $title = "List Banners";
        $query = Banner::query();

        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }

        $banners = $query->latest('id')->paginate(5);
        return view('banner::index',compact('banners', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $title = "Add Banner";
        return view('banner::create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'note' => 'nullable|string',
            'status' => 'required|in:display,hide'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $bannerData = $request->except(['image']);
        $pathFile = Storage::putFile('banners', $request->file('image'));
        $bannerData['image'] = 'storage/' . $pathFile;
        $bannerData['status'] = $request->input('status') === 'display' ? 1 : 0;

        Banner::create($bannerData);

        return redirect()->route('banners.index')->with('success', 'Banner created successfully!');
    }



    /**
     * Show the specified resource.
     */
    public function show(Banner $banner)
    {
        $title = "Detail Banner";
        return view('banner::show', compact('banner', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banner $banner)
    {
        $title = "Edit Banner";
        return view('banner::edit', compact('banner', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'note' => 'nullable|string',
            'status' => 'required|in:0,1',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
    
        $banner = Banner::find($id);
        $banner->name = $request->input('name');
        $banner->note = $request->input('note');
        $banner->status = $request->input('status');
        
        if ($request->hasFile('image')) {
            $pathFile = Storage::putFile('banners', $request->file('image'));
            $banner->image = 'storage/' . $pathFile;
        }
        
        $banner->save();
        
        return redirect()->route('banners.index')->with('success', 'Banner updated successfully!');
    }
    
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner)
    {
        if ($banner->image && file_exists(public_path($banner->image))) {
            unlink(public_path($banner->image));
        }

        $banner->delete();

        return redirect()->route('banners.index')->with('success', 'Banner deleted successfully.');
    }


    public function updateStatus(Request $request, $id)
    {
    $banner = Banner::findOrFail($id);
    $banner->status = $request->input('status');
    $banner->save();
    return redirect()->back()->with('success', 'Banner status updated successfully.');
    }  

}
