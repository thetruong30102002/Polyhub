<?php

namespace Modules\RankMember\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\RankMember\Entities\RankMember;

class RankMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $title = "RankMember management";
        $sort = $request->get('sort');
        $direction = $request->get('direction', 'desc');
        $rankmembers = RankMember::search($request->get('q', ''))
            ->sort($sort, $direction) 
            ->paginate();
        $page = RankMember::paginate();
        return view('rankmember::index',compact('title','rankmembers','page'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $title = "RankMember create";
        return view('rankmember::create',compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'rank' => 'required|max:255',
            'min_points' => 'required|integer|min:0|unique:rank_members',
        ]);
        $rankmember = new RankMember();
        $rankmember->fill($request->except(['_token']));
        $rankmember->save();
        User::where('points', '>=', $rankmember->min_points)
        ->update(['rank_member_id' => $rankmember->id]);
        return redirect()->route('rankmember.index');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('rankmember::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $title = "RankMember edit";
        $rankmember = RankMember::findOrFail($id);
        return view('rankmember::edit',compact('title','rankmember'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $rankMember = RankMember::findOrFail($id);
        $request->validate([
            'rank' => 'required|max:255',
           'min_points' => 'required|integer|min:0|unique:rank_members,min_points,'.  $rankMember->id . '',
        ]);
        $rankMember->fill($request->except(['_token']));
        $rankMember->save();

        User::where('rank_member_id', $id)
        ->where('points', '>=', $rankMember->min_points)
        ->update(['rank_member_id' => $id]);
        $users = User::all();
        foreach ($users as $user) {
            $newRankMember = RankMember::where('min_points', '<=', $user->points)
                                       ->orderBy('min_points', 'desc')
                                       ->first();
            if ($newRankMember) {
                $user->rank_member_id = $newRankMember->id;
                $user->save();
            }
        }
        return redirect()->route('rankmember.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
{
    // Bắt đầu giao dịch để đảm bảo tính nhất quán
    DB::beginTransaction();
    try {
        // Tìm RankMember hoặc báo lỗi nếu không tìm thấy
        $rankMember = RankMember::findOrFail($id);

        // Xóa RankMember
        $rankMember->delete();

        // Cập nhật rank_member_id cho các User
        $users = User::where('rank_member_id', $id)
                     ->get();

        foreach ($users as $user) {
            // Tìm RankMember mới cho từng User
            $newRankMember = RankMember::where('min_points', '<=', $user->points)
                                       ->orderBy('min_points', 'desc')
                                       ->first();

            if ($newRankMember) {
                // Cập nhật rank_member_id nếu tìm thấy RankMember mới
                $user->rank_member_id = $newRankMember->id;
            } else {
                // Nếu không tìm thấy RankMember mới, có thể gán rank_member_id về null hoặc xử lý theo nhu cầu
                $user->rank_member_id = null;
            }
            $user->save();
        }

        // Cam kết giao dịch
        DB::commit();

        // Chuyển hướng về danh sách RankMember
        return redirect()->route('rankmember.index');
    } catch (\Exception $e) {
        // Nếu có lỗi, hoàn tác giao dịch
        DB::rollBack();
        return back()->withErrors(['error' => 'Có lỗi xảy ra: ' . $e->getMessage()]);
    }
}

}
