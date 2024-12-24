<?php

namespace Modules\SeatType\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\SeatType\Entities\SeatType;

class SeatTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        // $seattype = SeatType::query()->orderBy('created_at');
        $seattype = SeatType::query()->orderBy('created_at')->paginate(4);
        // $page = $seattype->paginate(4);
        $title = "List Seat Type";
        return view('seattype::index', compact('seattype', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $title = "Add new Seat Type";
        $title2 = "Add new Seat Type";
        return view('seattype::create', compact('title', 'title2'));
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
            'price' => 'required'
        ]);
        $input = [
            'name' => $request->name,
            'price' => $request->price,
        ];

        SeatType::create($input);


        return redirect(route('seattype.list'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $seattype = SeatType::find($id);
        $title = ' Seattype';
        $title2 = 'Update Seattype';
        return view('seattype::show', compact('seattype', 'title', 'title2'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $seattype = SeatType::find($id);
        $title = ' Seattype';
        $title2 = 'Update Seattype';
        return view('seattype::edit', compact('seattype', 'title', 'title2'));
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
        $seattype = SeatType::find($id);
        $request->validate([
            'name' => 'required',
            'price' => 'required',

        ]);


        $input = [
            'name' => $request->name,
            'price' => $request->price,
        ];

        $seattype->update($input);


        return redirect(route('seattype.list'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
        $seattype = SeatType::find($id);
        $seattype->delete();
        return redirect(route('seattype.list'));
    }
}
