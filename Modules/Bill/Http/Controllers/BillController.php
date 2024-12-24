<?php

namespace Modules\Bill\Http\Controllers;

use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Modules\Bill\Entities\Bill;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\Support\Renderable;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $query = Bill::with(['ticketSeats', 'user']);

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        $bills = $query->orderBy('created_at', 'desc')->paginate(5);

        // dd($bills);
        return view('bill::index',  compact('bills'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('bill::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $bill = Bill::with([
            'user',
            'checkin',
            'ticketFoodCombo.food_combo',
            'ticketSeats.seat_showTime_status.seat.seatType', 
            'ticketSeats.movie', 
            'ticketSeats.room', 
            'ticketSeats.cinema', 
            'ticketSeats.showingRelease',
        ])->find($id);

        $movie = $bill->ticketSeats->first()->movie;
        $room = $bill->ticketSeats->first()->room;
        $cinema = $bill->ticketSeats->first()->cinema;
        $food_combo = $bill->ticketFoodCombo;
        $checkin = $bill->checkin;

            // dd($checkin->checkin_code);

        return view('bill::show', compact('bill', 'movie', 'room', 'cinema', 'food_combo', 'checkin'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('bill::edit');
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
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }

    public function printBill($id)
    {
        $bill = Bill::findOrFail($id);
        // dd($bill->checkin->checkin_code);die;
        if (!$bill) {
            abort(404, 'Bill not found');
        }

        // Tạo đối tượng PDF từ service container
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('bill::pdf.bill', compact('bill'));

        return $pdf->download('invoice.pdf');
    }
    
}
