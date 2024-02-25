<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    /**
     * 등록 방법
     *  Params >>
     *  name, email, password, password_confirmation
     *
     *  Return >>
        "access_token": "1|qATqzBjvibq4iI9Rah70L2HlWVM4JWO9wMBgRM0Le2be26a7",
        "token_type": "Bearer"
     */
    public function register(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);
        } catch (ValidationException $e) {
            return response()->json(['message' => '입력 데이터가 유효하지 않습니다.', 'errors' => $e->errors()], 422);
        }

        $user = User::create([
             'name' => $validatedData['name'],
             'email' => $validatedData['email'],
             'password' => Hash::make($validatedData['password']),
         ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        // 토큰 유효기간 설정 (120분 뒤에 만료)
        $tokenModel = PersonalAccessToken::findToken($token);
        $tokenModel->expires_at = now()->addMinutes(120);
        $tokenModel->save();

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'current_time' => now()->format('Y-m-d H:i:s'),
        ]);
    }

    /**
     * 로그인
     */
    public function login(Request $request): JsonResponse
    {
        // 입력 데이터 유효성 검사
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 이메일 기준 조회
        $user = User::where('email', $validated['email'])->first();

        // 유저가 없거나 비밀번호가 일치하지 않는 경우
        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json(['message' => '이메일 또는 비밀번호가 올바르지 않습니다.'], 401);
        }

        // 유저가 존재하고 비밀번호가 일치하는 경우, 토큰 생성
        $token = $user->createToken('auth_token')->plainTextToken;

        // 토큰 유효기간 설정 (120분 뒤에 만료)
        $tokenModel = PersonalAccessToken::findToken($token);
        $tokenModel->expires_at = now()->addMinutes(120);
        $tokenModel->save();

        // 성공 응답과 함께 토큰 반환
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'current_time' => now()->format('Y-m-d H:i:s'),
        ]);
    }

    /**
     * 로그아웃
     */
    public function logout(Request $request): JsonResponse
    {
        // 인증된 유저의 모든 토큰을 삭제
        $request->user()->tokens()->delete();

        // 성공 메시지와 함께 응답 반환
        return response()->json(['message' => '성공적으로 로그아웃되었습니다.']);
    }

    /**
     * 정보 수정
     */
    public function update(Request $request): JsonResponse
    {
        $user = auth()->user();
        $validatedData = $request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'password' => ['sometimes', 'confirmed', Rules\Password::defaults()],
        ]);

        if (isset($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }

        $updateResult = $user->update($validatedData);

        if ($updateResult) {
            // 업데이트 성공
            return response()->json($user);
        } else {
            // 업데이트 실패
            return response()->json(['message' => '정보를 업데이트할 수 없습니다.'], 500);
        }
    }

    /**
     * 삭제
     */
    public function destroy(): JsonResponse
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['message' => '유저를 찾을 수 없습니다.'], 404);
        }

        $user->tokens()->delete(); // 유저의 모든 Sanctum 토큰을 삭제
        $user->delete();

        return response()->json(['message' => '삭제를 성공했습니다.']);
    }
}
