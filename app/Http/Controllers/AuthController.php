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
     * 회원가입을 처리합니다.
     *
     * 요청된 사용자 데이터를 검증한 후, 유효한 경우 새 사용자를 생성하고
     * 생성된 사용자에 대한 인증 토큰을 반환합니다.
     *
     * @param string $name 사용자 이름
     * @param string $email 사용자 이메일
     * @param string $password 사용자 비밀번호
     * @param string $password_confirmation 비밀번호 확인
     * @return JsonResponse 사용자 생성 성공 시, 사용자 토큰 및 발급시간을 포함한 JSON 응답
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
     * 로그인을 처리합니다.
     *
     * 이메일과 비밀번호를 검증하여 일치하는 사용자가 있는 경우,
     * 해당 사용자에 대한 인증 토큰을 생성하고 반환합니다.
     *
     * @param string $email 사용자 이메일
     * @param string $password 사용자 비밀번호
     * @return JsonResponse 로그인 성공 시, 사용자 토큰 및 정보를 포함한 JSON 응답
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
     * 로그아웃을 처리합니다.
     *
     * 현재 인증된 사용자의 모든 인증 토큰을 삭제합니다.
     *
     * @return JsonResponse 로그아웃 성공 시 메시지를 포함한 JSON 응답
     */
    public function logout(): JsonResponse
    {
        // 인증된 유저의 모든 토큰을 삭제
        auth()->user()->tokens()->delete();
        // $request->user()->tokens()->delete(); // user 를 지칭하여 로그아웃 하고 싶다면

        // 성공 메시지와 함께 응답 반환
        return response()->json(['message' => '성공적으로 로그아웃되었습니다.']);
    }

    /**
     * 사용자 정보를 수정합니다.
     *
     * 요청된 사용자 데이터를 검증한 후, 유효한 경우 현재 인증된 사용자의 정보를 업데이트합니다.
     *
     * @param string|null $name 사용자 이름 (선택)
     * @param string|null $email 사용자 이메일 (선택)
     * @param string|null $password 사용자 비밀번호 (선택)
     * @return JsonResponse 정보 수정 성공 시, 수정된 사용자 정보를 포함한 JSON 응답
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
     * 사용자 계정을 삭제합니다.
     *
     * 현재 인증된 사용자의 계정과 관련된 모든 데이터를 삭제합니다.
     *
     * @return JsonResponse 계정 삭제 성공 시 메시지를 포함한 JSON 응답
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
