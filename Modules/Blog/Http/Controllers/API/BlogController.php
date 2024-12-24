<?php

namespace Modules\Blog\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Blog\Entities\Blog;
use Modules\Blog\Transformers\BlogResource;
use Modules\Category\Entities\Category;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $blogs = Blog::with('category')
                 ->orderBy('created_at','desc')
                 ->paginate(5);

        return response()->json([
            'status' => true,
            'message' => 'Lấy danh sách thành công',
            'data' => $blogs
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show(string $id)
    {
    $blog = Blog::find($id);
    
    if (!$blog) {
        return response()->json([
            'status' => false,
            'message' => 'Không tìm thấy bài viết này',
            'data' => []
        ], 200);
    }

    // Lấy các bài viết cùng danh mục
    $relatedBlogs = Blog::where('categories_id', $blog->categories_id)
        ->where('id', '!=', $id) // Loại bỏ bài viết hiện tại
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();

    return response()->json([
        'status' => true,
        'message' => 'Thông tin chi tiết bài viết',
        'data' => [
            'blog' => $blog,
            'relatedBlogs' => $relatedBlogs
        ]
    ], 200);
    }


    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
    public function bloghome()
    {
    // Get the 3 most recent blog posts
    $blogs = Blog::orderBy('created_at', 'desc')->take(2)->get();
    return response()->json([
        'status' => true,
        'message' => 'Lấy danh sách thành công',
        'data' => $blogs,
    ], 200);
    }
    public function bloghome1()
    {
    // Get the 3 most recent blog posts
    $blogs = Blog::orderBy('created_at', 'desc')->take(1)->get();
    return response()->json([
        'status' => true,
        'message' => 'Lấy danh sách thành công',
        'data' => $blogs,
    ], 200);
    }


     public function getLatestBlogs()
    {
        $latestBlogs = Blog::orderBy('created_at', 'desc')->take(3)->get();
        return response()->json([
            'status' => true,
            'message' => 'Lấy danh sách thành công',
            'data' => $latestBlogs,
        ], 200);
    }

    public function getBlogByCategory($categoryId)
    {
        $blogs = Blog::with('category')
        ->whereHas('category', function ($query) use ($categoryId) {
            $query->where('categories.id', $categoryId);
        })
        ->orderBy('created_at', 'desc')
        ->paginate(5);
        return response()->json([
           'status'=> true,
           'message'=>'Lấy danh sách thành công',
           'data' => $blogs
        ], 200);
    }

    public function getAllCategory()
    {
        $categories = Category::withCount('blogs')
        ->orderBy('created_at', 'desc')
        ->get();
        $allBlogs = Blog::get()->count();
        return response()->json([
            'status' => true,
            'message' => 'Lấy danh sách thành công',
            'data' => $categories,
            'allBlogs' => $allBlogs
        ], 200);
    }

    public function getTopBlogs(){
        $topBogs = Blog::with('category')->latest()->take(3)->get();;
        return response()->json([
           'status'=> true,
           'message'=>'Lấy danh sách thành công',
           'data' => $topBogs,
        ], 200);
    }

    public function search(Request $request)
    {
        $title = $request->get('title');
        if(empty($title)){
            $blog = Blog::with('category')
            ->orderBy('created_at', 'desc')
            ->paginate(5);
        }else{
            $blogs = Blog::with('category')->where('title', 'LIKE', '%'.$title.'%')
            ->paginate(5);
        }
        return response()->json([
           'status'=> true,
           'message'=>'Tìm kiếm thành công',
           'data' => $blogs,
           'title' => $title
        ], 200);
    }

   
}
