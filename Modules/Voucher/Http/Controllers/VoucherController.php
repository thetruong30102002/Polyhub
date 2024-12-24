<?php

namespace Modules\Voucher\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Voucher\Entities\Voucher;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $title = 'Voucher';
        $title2 = 'List Voucher';
        $voucher = Voucher::query()->orderByDesc('created_at');
        $page = $voucher->paginate(4);
        return view('voucher::index',compact('title','title2','voucher','page'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $title = 'Voucher';
        $title2 = 'Add New Voucher';
        return view('voucher::create', compact('title','title2'));
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
            'code' => 'required',
            'type' => 'required|string',	
            'amount' => 'required|numeric|min:1|max:90000',	
            'start_date' => 'required|date',	
            'end_date' => 'required|date|after_or_equal:start_date',	
            'usage_limit' => 'required|numeric|min:1|max:30',	
            'status' => 'required|string',	         
        ]);

        $input = [
            'code' => $request->code,
            'type' => $request->type,	
            'amount' => $request->amount,	
            'start_date' => $request->start_date,	
            'end_date' => $request->end_date,	
            'usage_limit' => $request->usage_limit,	
            'used' => $request->used ? $request->used : 0,	
            'status' => $request->status,	 
            'created_at' => now(),	 
            'updated_at' => null,	 
        ];
        Voucher::create($input);
        return redirect('/admin/voucher')->with('success', 'Add Voucher Successfully!');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $title = 'Voucher';
        $title2 = 'Voucher Details';
        $voucher = Voucher::find($id);
        return view('voucher::show', compact('title', 'title2', 'voucher'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $title = 'Voucher';
        $title2 = 'Voucher Edit';
        $voucher = Voucher::find($id);
        return view('voucher::edit', compact('title', 'title2', 'voucher'));
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
        $voucher = Voucher::find($id);
        $request->validate([
            'code' => 'required',
            'type' => 'required|string',	
            'amount' => 'required|numeric|min:1|max:90000',	
            'start_date' => 'required|date',	
            'end_date' => 'required|date|after_or_equal:start_date',	
            'usage_limit' => 'required|numeric|min:1|max:30',	
            'status' => 'required|string',	         
        ]);

        $input = [
            'code' => $request->code,
            'type' => $request->type,	
            'amount' => $request->amount,	
            'start_date' => $request->start_date,	
            'end_date' => $request->end_date,	
            'usage_limit' => $request->usage_limit,	
            'used' => $request->used ? $request->used : 0,	
            'status' => $request->status,	  
            'updated_at' => now(),	 
        ];
        $voucher->update($input);
        return redirect('/admin/voucher')->with('success', 'Update Voucher Successfully!');
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
}
