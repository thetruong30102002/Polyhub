<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = "User management";
        $sort = $request->get('sort');
        $direction = $request->get('direction', 'desc');
        $currentUserId = auth()->id(); // Lấy ID của người dùng hiện tại

        $users = User::onlyAdmins()
            ->where('id', '!=', $currentUserId) // Loại trừ người dùng hiện tại
            ->search($request->get('q', ''))
            ->sort($sort, $direction)
            ->paginate();

        $page = User::onlyAdmins()
            ->where('id', '!=', $currentUserId) // Loại trừ người dùng hiện tại
            ->paginate();

        return view('Backend.user.admin.index', compact('title', 'users', 'page'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "User create";
        return view('Backend.user.admin.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:8',
            're-password' => 'required|same:password',
        ]);
        $user = new User();
        $user->fill($request->except(['_token']));
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $fileName = $avatar->getClientOriginalName();
            $path = $request->file('avatar')->storeAs('/user', $fileName);
            $user->avatar =  $path;
            $user->user_type =  'employee';
        }
        $user->password = Hash::make($request->input('password'));
        $user->save();
        return redirect()->route('user.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $title = "User edit";
        return view('Backend.user.admin.edit', compact('user', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id . '',
        ]);
        $user->fill($request->except(['_token', 'password']));
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $fileName = $avatar->getClientOriginalName();
            $path = $request->file('avatar')->storeAs('/user', $fileName);
            $user->avatar =  $path;
        }
        $user->save();
        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::where('id', $id)->delete();
        return redirect()->route('user.index');
    }

    public function toggleActivation(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->activated = $request->input('is_active');
        $user->save();
        return back();
    }


    public function updateType(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'user_type' => 'required|in:admin,employee,client',
        ]);

        $user->user_type = $request->input('user_type');
        $user->save();

        return redirect()->route('user.index')->with('success', 'User type updated successfully.');
    }
}
