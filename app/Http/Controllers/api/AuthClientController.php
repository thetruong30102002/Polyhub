<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Storage;
use Modules\Bill\Entities\Bill;
class AuthClientController extends Controller
{
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'repassword' => 'required|same:password',
            'phonenumber' => 'required|string|max:20',
            'date_of_birth' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        // Create new user
        $user = new User();
        $user->fill($request->except(['_token']));
        $user->user_type = 'client';
        $user->password = Hash::make($request->password);
        $user->save();
        return response()->json(['message' => 'User created successfully', 'user' => $user], 201);
    }

    public function signin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['errors' => ['auth' => 'Invalid credentials']], 422);
        }

        $user = Auth::user();

        if ($user->user_type !== 'client') {
            Auth::logout();
            return response()->json(['errors' => ['auth' => 'Unauthorized user type']], 403);
        } else if ($user->activated != true) {
            Auth::logout();
            return response()->json(['errors' => ['auth' => 'Account has not been activated']], 403);
        }


        // Optionally, you can include more user information in the response
    return response()->json([
        'message' => 'User signed in successfully', 
        'token' => $token,
        'user' => $user // Optional: Include user details in the response
    ]);
    }


    public function signout()
    {
        Auth::logout();
        return response()->json(['message' => 'User logged out successfully']);
    }

    public function getUser()
    {
        $user = Auth::user()->load('rankMember'); // Tải thông tin rank
        return response()->json($user);
    }
    public function getBill(){
        $user = Auth::user();
        $bill = Bill::where('user_id', $user->id)->orderBy('created_at','desc')->get();
        
        return response()->json([
            'success' => true,
            'data' => $bill
        ], 200);
    }

    public function updateUser(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phonenumber' => 'required|string|max:20',
            'gender' => 'required|string|in:male,female,other',
            'address' => 'nullable|string|max:255',
            'avatar' => 'nullable|string',
            'password' => 'nullable|string|min:6',
            'repassword' => 'nullable|required_with:password|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user->fill($request->except(['_token']));

        // Xử lý avatar
        if (isset($request->avatar) && preg_match('/^data:image\/(png|jpg|jpeg);base64,/', $request->avatar)) {
            $avatarData = $request->avatar;
            $avatarPath = preg_replace('/^data:image\/\w+;base64,/', '', $avatarData);
            $avatarPath = str_replace(' ', '+', $avatarPath);
            $image = base64_decode($avatarPath);
            $fileName = time() . '.png';
            $directory = 'user';
            
            // Tạo thư mục nếu chưa tồn tại
            if (!Storage::exists($directory)) {
                Storage::makeDirectory($directory);
            }
            
            $path = $directory . '/' . $fileName;
            
            Storage::put($path, $image);
            
            $user->avatar = 'user/' . $fileName;
        }
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return response()->json(['message' => 'Successfully updated', 'user' => $user]);
    }
}
