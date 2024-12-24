<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BackendControllerBase extends Controller
{
    //
    public function index() {
        return view('Backend.index');
    }

    public function getProductsData()
    {
        $data = DB::table('ticket_seats')
        ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(movie_id) as sold_tickets'))
        ->where('created_at', '>=', now()->subDays(7))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();

        return response()->json($data);
    }

    public function getMovieTicketData(Request $request)
    {
        $timeframe = $request->get('timeframe');
        $query = DB::table('ticket_seats')
        ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(movie_id) as sold_tickets'));

        if ($timeframe === 'day') {
            $query->whereDate('created_at', now());
        } elseif ($timeframe === 'week') {
            $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($timeframe === 'month') {
            $query->whereMonth('created_at', now()->month);
        } elseif ($timeframe === 'year') {
            $query->whereYear('created_at', now()->year);
        }

        $data = $query->groupBy(DB::raw('DATE(created_at)'))
        ->orderBy('date')
            ->get();

        return response()->json($data);
    }

    public function getPaymentMethodsData()
    {
        $data = DB::table('checkins')
            ->select('type', DB::raw('COUNT(*) as total'))
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('type')
            ->orderBy('total', 'desc')
            ->get();

        $totalPayments = $data->sum('total');

        $data = $data->map(function ($item) use ($totalPayments) {
            $item->percentage = round(($item->total / $totalPayments) * 100, 2);
            return $item;
        });

        return response()->json($data);
    }

    public function getTicketAmountData()
    {
        $data = DB::table('ticket_seats')
        ->select(DB::raw('MIN(price) as min_amount'), DB::raw('MAX(price) as max_amount'))
        ->where('created_at', '>=', now()->subDays(7))
        ->first();

        if ($data->max_amount != 0) {
            $progress = ($data->min_amount / $data->max_amount) * 100;
        } else {
            $progress = 0;
        }

        return response()->json([
            'min_amount' => $data->min_amount,
            'max_amount' => $data->max_amount,
            'progress' => $progress
        ]);
    }

    public function getVoucherUsageData()
    {
        $usedVouchers = DB::table('vouchers')
            ->where('used', ">", 0)
            ->sum('used');

        $totalVouchers = DB::table('vouchers')
            ->count();

        return response()->json([
            'used' => $usedVouchers,
            'total' => $totalVouchers
        ]);
    }

    public function getRecentPurchasersData()
    {
        $recentPurchasers = DB::table('ticket_seats')
        ->join('bills', 'ticket_seats.bill_id', '=', 'bills.id')
        ->join('users', 'bills.user_id', '=', 'users.id')
        ->select('users.id', 'users.name', 'users.avatar')
        ->orderBy('ticket_seats.created_at', 'desc')
        ->take(5)
            ->get();

        return response()->json($recentPurchasers);
    }

    public function getCustomerData()
    {
        $data = DB::table('users')
        ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as client_count'))
        ->where('created_at', '>=', now()->subDays(7))
        ->where('user_type', '=' , 'client')
        ->groupBy(DB::raw('DATE(created_at)'))
        ->orderBy('date')
        ->get();

        return response()->json($data);
    }

    public function getClientLocations()
    {
        $cityData = DB::table('users')
        ->select(DB::raw('city, COUNT(*) as count'))
        ->whereNotNull('city')
        ->where('user_type','=','client')
        ->groupBy('city')
        ->orderBy('count', 'desc')
        ->limit(3)
        ->get();

        return response()->json($cityData);
    }

    public function getBookedMovies()
    {
        $dateFrom = Carbon::now()->subWeek();

        $bookedMovies = DB::table('ticket_seats')
        ->join('bills', 'ticket_seats.bill_id', '=', 'bills.id')
        ->join('users', 'bills.user_id', '=', 'users.id')
        ->join('movies', 'ticket_seats.movie_id', '=', 'movies.id')
        ->join('seat_showtime_status', 'seat_showtime_status.id', '=', 'ticket_seats.seat_showtime_status_id')
        ->join('seats', 'seat_showtime_status.seat_id', '=', 'seats.id')
        ->join('seat_types', 'seat_types.id', '=', 'seats.seat_type_id')
        ->whereDate('ticket_seats.created_at', '>=', $dateFrom) 
        ->select('movies.id', 'movies.name', 'movies.duration', 'movies.premiere_date', 'movies.photo', 
                'users.name as customer_name', 'users.email as customer_email', 'users.avatar as customer_avatar', 'ticket_seats.price', 
                'ticket_seats.created_at',
                'seats.column as seatColumn', 'seats.row as seatRow', 'seat_types.name as seatType')
        ->orderBy('ticket_seats.created_at', 'desc')
        ->limit(5)
        ->get();

        return response()->json($bookedMovies);
    }

    public function getTopMovies()
    {
        $topMovies = DB::table('ticket_seats')
            ->join('bills', 'bills.id', '=', 'ticket_seats.bill_id')
            ->join('movies', 'movies.id', '=', 'ticket_seats.movie_id')
            ->join('checkins', 'bills.checkin_id', '=', 'checkins.id')
            ->select('movies.name as movieName', 'movies.photo as moviePhoto', 'checkins.type as paymentMethod')
            ->orderBy('bills.grand_total', 'desc')
            ->limit(5)
            ->get();

        return response()->json($topMovies);
    }

}
