<?php

namespace Modules\Voucher\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Voucher\Entities\Voucher;

class VoucherAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        //
        $voucher = Voucher::all();
        return response()->json([
            'status' => true,
            'message' => 'Get data',
            'data' => $voucher
        ]);
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
        //
        $voucher =  Voucher::find($id);
        return response()->json([
            'status' => true,
            'message' => 'Lấy dữ liệu thành công!',
            'data' => $voucher
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
    public function getAmountById($id){
        $voucher = Voucher::select('id', 'amount')->find($id);

        // Kiểm tra nếu voucher tồn tại
        if ($voucher) {
            // Trả về dữ liệu dưới dạng JSON
            return response()->json([
                'status' => true,
                'message' => 'Voucher found',
                'data' => $voucher
            ]);
        } else {
            // Nếu không tìm thấy voucher
            return response()->json([
                'status' => false,
                'message' => 'Voucher not found'
            ], 404);
        }
    }
    public function getVoucherById($id){
        $voucher = Voucher::select('id', 'code', 'type', 'amount')->find($id);

        // Kiểm tra nếu voucher tồn tại
        if ($voucher) {
            // Trả về dữ liệu dưới dạng JSON
            return response()->json([
                'status' => true,
                'message' => 'Voucher found',
                'data' => $voucher
            ]);
        } else {
            // Nếu không tìm thấy voucher
            return response()->json([
                'status' => false,
                'message' => 'Voucher not found'
            ], 404);
        }
    }
    public function applyVoucher(Request $request)
{
    // Validate request
    $request->validate([
        'code' => 'required|string',
    ]);

    // Get voucher code from request
    $code = $request->input('code');

    // Find voucher by code
    $voucher = Voucher::where('code', $code)
    ->where('status', 'Active')
    ->first();


    if (!$voucher) {
        return response()->json(['status' => false, 'message' => 'Voucher không hợp lệ.'], 400);
    }

    // Check if the voucher can still be used
    if ($voucher->usage_limit <= 0) {
        return response()->json(['status' => false, 'message' => 'Voucher đã hết lượt sử dụng.'], 400);
    }

    // Update usage_limit and used count
    $voucher->usage_limit -= 1;
    $voucher->used += 1;
    $voucher->save();

    // Return success response with voucher details
    return response()->json([
        'status' => true,
        'message' => 'Voucher áp dụng thành công.',
        'data' => [
            'code' => $voucher->code,
            'type' => $voucher->type, // Assuming the voucher has a 'type' field
            'amount' => $voucher->amount, // Assuming the voucher has an 'amount' field
            'status' => $voucher->status, // Assuming the voucher has a 'status' field
        ],
    ]);
}
public function getVoucherByName(Request $request)
{
    // Validate request
    $request->validate([
        'code' => 'required|string',
    ]);

    // Get voucher code from request
    $code = $request->input('code');

    // Find voucher by code
    $voucher = Voucher::where('code', $code)->first();

    if (!$voucher) {
        return response()->json(['status' => false, 'message' => 'Voucher không hợp lệ.'], 400);
    }

    // Return voucher details without altering the usage count
    return response()->json([
        'status' => true,
        'message' => 'Voucher found.',
        'data' => [
            'code' => $voucher->code,
            'type' => $voucher->type,
            'amount' => $voucher->amount,
            'status' => $voucher->status,
        ],
    ]);
}


}
