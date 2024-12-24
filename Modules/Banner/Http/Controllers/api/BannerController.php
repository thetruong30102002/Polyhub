<?php

namespace Modules\Banner\Http\Controllers\api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Banner\Entities\Banner;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $banners = Banner::where('status', 1)->latest('id')->paginate(6);
        $i = 45;

        // Thay đổi giá trị của $i cho từng banner
        $banners->getCollection()->transform(function ($banner) use (&$i) {
            $banner->i = $i; // Thêm biến $i vào mỗi banner
            $i++; // Tăng giá trị $i
            return $banner;
        });
        return response()->json([
            'success' => true,
            'data' => $banners
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return JsonResponse
     */
    public function create(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Ready to create a new banner'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'note' => 'nullable|string',
            'status' => 'required|in:display,hide'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $bannerData = $request->except(['image']);
        $pathFile = Storage::putFile('banners', $request->file('image'));
        $bannerData['image'] = 'storage/' . $pathFile;
        $bannerData['status'] = $request->input('status') === 'display' ? 1 : 0;

        $banner = Banner::create($bannerData);

        return response()->json([
            'success' => true,
            'data' => $banner,
            'message' => 'Banner created successfully!'
        ], 201);
    }

    /**
     * Show the specified resource.
     */
    public function show(Banner $banner): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $banner
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banner $banner): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $banner
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'note' => 'nullable|string',
            'status' => 'required|in:0,1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $banner = Banner::find($id);
        if (!$banner) {
            return response()->json([
                'success' => false,
                'message' => 'Banner not found'
            ], 404);
        }

        $banner->name = $request->input('name');
        $banner->note = $request->input('note');
        $banner->status = $request->input('status');
        
        if ($request->hasFile('image')) {
            $pathFile = Storage::putFile('banners', $request->file('image'));
            $banner->image = 'storage/' . $pathFile;
        }
        
        $banner->save();
        
        return response()->json([
            'success' => true,
            'data' => $banner,
            'message' => 'Banner updated successfully!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner): JsonResponse
    {
        if ($banner->image && file_exists(public_path($banner->image))) {
            unlink(public_path($banner->image));
        }

        $banner->delete();

        return response()->json([
            'success' => true,
            'message' => 'Banner deleted successfully.'
        ]);
    }

    public function getBanner(){
        $banners = Banner::where('status', 1)->latest('id')->paginate(7);
        return response()->json([
            'success' => true,
            'data' => $banners
        ]);
    }

    public function getHotBanner(){
        $banners = Banner::where('status', 1)->take(3)->get();
        return response()->json([
            'success' => true,
            'data' => $banners
        ]);
    }
}
