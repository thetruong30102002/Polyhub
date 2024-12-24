<?php

namespace Modules\Director\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\Director\Entities\Director;

class DirectorController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $title = "List Dirctor";

        $query = Director::query();

        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }

        $director = $query->latest('id')->paginate(6);
        return view('director::index', compact('director','title'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {   
        $title = "Add Director";
        return view('director::create',compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
    // Validate các trường nhập vào
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'date_of_birth' => 'required|date',
    ]);

    // Nếu dữ liệu không hợp lệ, trả về thông báo lỗi và dữ liệu đã nhập trước đó
    if ($validator->fails()) {
        return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
    }

    // Tính toán tuổi dựa trên ngày sinh
    $dateOfBirth = $request->input('date_of_birth');
    $age = \Carbon\Carbon::parse($dateOfBirth)->age;

    // Kiểm tra điều kiện tuổi
    if ($age < 18 || $age > 90) {
        return redirect()->back()
                    ->withErrors(['age' => 'The age must be between 18 and 90 years.'])
                    ->withInput();
    }

    // Lưu trữ dữ liệu vào database
    Director::create([
        'name' => $request->input('name'),
        'age' => $age,
        'date_of_birth' => $dateOfBirth,
    ]);

    return redirect('/admin/director')->with('success', 'Director created successfully.');
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
        $title = "Edit Director";
        $director = Director::find($id);
        return view('director::edit',compact('director','title'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
    // Xác thực dữ liệu đầu vào
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'date_of_birth' => 'required|date',
    ]);

    // Nếu dữ liệu không hợp lệ, trả về thông báo lỗi và dữ liệu đã nhập trước đó
    if ($validator->fails()) {
        return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
    }

    // Tìm đối tượng Director theo ID
    $director = Director::find($id);

    if (!$director) {
        return redirect()->back()
                    ->withErrors(['error' => 'Director not found'])
                    ->withInput();
    }

    // Tính toán tuổi dựa trên ngày sinh
    $dateOfBirth = $request->input('date_of_birth');
    $age = \Carbon\Carbon::parse($dateOfBirth)->age;

    // Kiểm tra điều kiện tuổi
    if ($age < 18 || $age > 90) {
        return redirect()->back()
                    ->withErrors(['age' => 'The age must be between 18 and 90 years.'])
                    ->withInput();
    }

    // Cập nhật thông tin director
    $director->name = $request->input('name');
    $director->age = $age; // Cập nhật tuổi được tính toán
    $director->date_of_birth = $dateOfBirth;
    $director->save();

    return redirect('/admin/director')->with('success', 'Director updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $director = Director::find($id);

        $hasMovie = $director->movies()->exists();

        if ($hasMovie){
            return redirect('/admin/director')->with('error', 'Cannot delete the movie because this director had movies');
        }

        $director -> delete();
        return redirect('/admin/director')->with('success', 'Deleted Director Successfully!');
    }
}
