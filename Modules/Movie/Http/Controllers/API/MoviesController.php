<?php

namespace Modules\Movie\Http\Controllers\API;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Category\Entities\Category;
use Modules\Movie\Entities\Movie;

class MoviesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $movie = Movie::with('director', 'attributes.attributeValues', 'categories')
                        ->where('activated', true)
                        ->orderBy('created_at', 'desc')
                        ->paginate(9);
        // return KhachHangResource::collection($khachHangs);
        return response()->json([
            'status'=> true,
            'message'=>'Lấy danh sách thành công',
            'data' => $movie,
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
    public function show($id)
    {
        $movie = Movie::with('categories', 'director', 'attributes.attributeValues', 'actors')->find($id);
        if (!$movie) {
            $arr = [
                'status'=> false,
                'message'=>'Không tìm thấy bài viết này',
                'data'=>[]
            ];
            return response()->json($arr,200);
        }
        $arr = [
            'status'=>true,
            'message'=>'Thông tin chi tiết bài viết',
            'data'=>$movie
        ];
        return response()->json($arr,200);
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

    public function search(Request $request)
    {
        $title = $request->get('title');
        if(empty($title)){
            $movie = Movie::with('director', 'attributes.attributeValues', 'categories')
            ->where('activated', true)
            ->orderBy('created_at', 'desc')
            ->paginate(9);
        }else{
            $movies = Movie::with('director', 'attributes.attributeValues', 'categories')->where('name', 'LIKE', '%'.$title.'%')
            ->where('activated', true)
            ->paginate(9);
        }
        return response()->json([
           'status'=> true,
           'message'=>'Tìm kiếm thành công',
           'data' => $movies,
           'title' => $title
        ], 200);
    }

    public function getMovieByCategory($categoryId)
    {
        $movies = Movie::with('director', 'attributes.attributeValues', 'categories')
        ->whereHas('categories', function ($query) use ($categoryId) {
            $query->where('categories.id', $categoryId);
        })
        ->orderBy('created_at', 'desc')
        ->where('activated', true)
        ->paginate(9);
        return response()->json([
           'status'=> true,
           'message'=>'Lấy danh sách thành công',
           'data' => $movies
        ], 200);
    }

    public function getAllCategory()
    {
        $categories = Category::withCount('movies')
        ->orderBy('created_at', 'desc')
        ->get();
        $allMovies = Movie::where('activated', true)->get()->count();
        return response()->json([
           'status'=> true,
           'message'=>'Lấy danh sách thành công',
           'data' => $categories,
           'allMovies' => $allMovies
        ], 200);
    }

    public function getTopMovies(){
        $currentMonth = Carbon::now()->month;

        // Truy vấn để lấy 10 phim có số lượng vé bán nhiều nhất trong tháng
        $topSellingMovies = Movie::select('movies.*', 
            DB::raw('GROUP_CONCAT(categories.name) as cate_names'), 
            DB::raw('count(ticket_seats.id) as total_quantity'))
            ->join('ticket_seats', 'movies.id', '=', 'ticket_seats.movie_id')
            ->leftJoin('category_movie', 'category_movie.movie_id', '=', 'movies.id')
            ->leftJoin('categories', 'category_movie.category_id', '=', 'categories.id')
            ->whereMonth('ticket_seats.created_at', $currentMonth)
            ->where('movies.activated', 1)
            ->groupBy('movies.id')
            ->orderBy('total_quantity', 'desc')
            ->take(10)
            ->get();

            return response()->json([
                'status'=> true,
                'message'=>'Lấy danh sách thành công',
                'data' => $topSellingMovies,
             ], 200);
    }

    public function home()
    {
        $currentDate = now(); // Lấy ngày và thời gian hiện tại
        $tenDaysAgo = now()->subDays(10); // Lấy ngày và thời gian của 10 ngày trước

        $movies = Movie::with('director', 'attributes.attributeValues', 'categories')
                    ->where('premiere_date', '<', $currentDate)
                    ->where('premiere_date', '>=', $tenDaysAgo)
                    ->where('activated', 1)
                    ->orderBy('id', 'desc') 
                    ->paginate(8);

        return response()->json([
            'status'=> true,
            'message'=>'Lấy danh sách thành công',
            'data' => $movies,
        ], 200);
    }

    public function upcoming()
    {
        $currentDate = now(); // Lấy ngày và thời gian hiện tại
        $currentDatePlus10Days = now()->addDays(10); // Lấy ngày hiện tại cộng thêm 10 ngày

        $movies = Movie::with('director', 'attributes.attributeValues', 'categories')
                    ->where('premiere_date', '>', $currentDate)
                    ->where('premiere_date', '<=', $currentDatePlus10Days)
                    ->where('activated', 1)
                    ->orderBy('id', 'desc') 
                    ->paginate(8);

        return response()->json([
            'status'=> true,
            'message'=>'Lấy danh sách thành công',
            'data' => $movies,
        ], 200);
    }
    public function silder()
    {
        $currentMonth = Carbon::now()->month;

        // Truy vấn để lấy 10 phim có số lượng vé bán nhiều nhất trong tháng
      $topSellingMovies = Movie::select('movies.*', 
    DB::raw('GROUP_CONCAT(categories.name) as cate_names'), 
    DB::raw('count(ticket_seats.id) as total_quantity'),
    'directors.name as director_name') // Thêm trường tên đạo diễn
    ->join('ticket_seats', 'movies.id', '=', 'ticket_seats.movie_id')
    ->leftJoin('category_movie', 'category_movie.movie_id', '=', 'movies.id')
    ->leftJoin('categories', 'category_movie.category_id', '=', 'categories.id')
    ->leftJoin('directors', 'movies.director_id', '=', 'directors.id') // Join bảng directors
    ->with(['attributes.attributeValues']) // Tải trước mối quan hệ attributes và attributeValues
    ->whereMonth('ticket_seats.created_at', $currentMonth)
    ->groupBy('movies.id', 'directors.name') // Nhóm theo cả director_name
    ->orderBy('total_quantity', 'desc')
    ->where('movies.activated', 1)
    ->take(8)
    ->get();
    
        return response()->json([
            'status' => true,
            'message' => 'Lấy danh sách thành công',
            'data' => $topSellingMovies,
        ], 200);
    }

}
