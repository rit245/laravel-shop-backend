<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * @group Admin
 * 관리자 로그인
 *
 * @authenticated
 * @response {"token": "토큰 값"}
 * @response 401 {"message": "Unauthorized"}
 */
class AdminController extends Controller
{
    /**
     * 관리자 로그인
     *
     * @bodyParam email string required 이메일
     * @bodyParam password string required 비밀번호
    */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $token = $admin->createToken('adminToken')->plainTextToken;

        return response()->json(['token' => $token]);
    }

    /**
    * 관리자 계정 생성
    *
    * @bodyParam name string required 관리자 이름
    * @bodyParam email string required 관리자 이메일
    * @bodyParam password string required 비밀번호
    * @bodyParam password_confirmation string required 비밀번호 확인
    *
    * @response 201 {
    *  "message": "Admin created successfully",
    *  "admin": {
    *      "name": "Admin",
    *      "email": ""
    */

     public function create(Request $request)
     {
         $request->validate([
             'name' => 'required|string|max:255',
             'email' => 'required|string|email|max:255|unique:admins',
             'password' => 'required|string|min:8|confirmed',
         ]);

         $admin = Admin::create([
             'name' => $request->name,
             'email' => $request->email,
             'password' => Hash::make($request->password),
         ]);

         return response()->json(['message' => '관리자 계정을 생성하였습니다.', 'admin' => $admin], 201);
    }
}
