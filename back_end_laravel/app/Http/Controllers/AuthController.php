<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\OTP;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(LoginRequest $request){
        $user = User::Where('email', $request['email'])->first();
        if (!$user){
            return response([
                'message'=>'Địa chỉ email chưa được đăng ký'
            ],Response::HTTP_UNAUTHORIZED);   
        }

        if (!Hash::check($request['password'], $user->password)){
            return response([
                'message'=>'Mật khẩu không chính xác'
            ],Response::HTTP_UNAUTHORIZED);    
        }

        if (!$user->email_verified_at){
            return response([
                'message'=>'Tài khoản chưa được xác thực'
            ],Response::HTTP_UNAUTHORIZED);    
        }
        $token =$user->createTokenAccess();
        $response = [
            'user' => $user,
            'token' => $token
        ];
        return response($response);
    }

    public function register(RegisterRequest $request)
    {
        $user = User::Where('email', $request['email'])->first();
        if ($user)
        {
            return response([
                'message'=>'Địa chỉ email đã tồn tại'
            ],Response::HTTP_UNAUTHORIZED); 
        }
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password'])
        ]);
        $user->sendEmailVerificationNotification();
        
        return response([
            'message'=>'Đăng kí thành công. Vui lòng xác thực tài khoản'
        ],Response::HTTP_OK);
    }
    
    public function verify(Request $request)
    {
        $user = User::Where('id', $request['id'])
            ->Where('email_verification_token', $request['token'])
            ->first();
        if ($user)
        {
            $user->email_verified_at = now();
            $user->save();
            $token =$user->createTokenAccess();
            $response = [
                'user' => $user,
                'token' => $token
            ];
            return response($response);
        }
        return response([
            'message'=>'Yêu cầu xác thực không hợp lệ'
        ],Response::HTTP_UNAUTHORIZED);
    }

    public function redirectGoogleLogin()
    {
        try {
            $url = Socialite::driver('google')->stateless()
                ->redirect()->getTargetUrl();
            return response()->json([
                'url' => $url,
            ])->setStatusCode(Response::HTTP_OK);
        } catch (\Exception $exception) {
            return response()->json([
                'url' => '',
            ])->setStatusCode(Response::HTTP_BAD_GATEWAY);
        }
    }
    public function callbackGoogleLogin(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            $user = User::where('email', $googleUser->email)->first();
            // đã tồn tại trong hệ thống -> đăng nhập vô
            if ($user) {
                $token =$user->createTokenAccess();
                return response()->json([
                    'status' => 'google sign in successful',
                    'user' => $user,
                    'token' => $token
                ], Response::HTTP_CREATED);
            } 
            //chưa vô lần nào -> tạo acc
            $userinfor = [
                'email' => $googleUser->email,
                'name' => $googleUser->name,
                'social_id'=> $googleUser->id,
                'social_type' => 'google',
                'email_verified_at'=> now(),
                'password' => bcrypt(Str::random(10)),
                'avatar' => $googleUser->avatar,
            ];

            $newuser = User::create($userinfor);
            $token =$newuser->createTokenAccess();
            return response()->json([
                'status' => 'google sign in successful',
                'user' => $newuser,
                'token' => $token
            ], Response::HTTP_CREATED);

        } catch (\Exception $exception) {
            return response()->json([
                'status' => 'google sign in failed',
                'error' => $exception,
                'message' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function sendEmailResetPassword(Request $request)
    {
        $user = User::Where('email', $request['email'])->first();
        if($user){
            $token =  (new OTP())->createOTP($user->email);
            $user->sendPasswordResetNotification($token);
            return response([
                'message'=>'Email đặt lại mật khẩu đã được gửi. Vui lòng kiểm tra email của bạn'
            ],Response::HTTP_OK);
        }
        return response([
            'message'=>'Email chưa được đăng kí tại Navyuh'
        ],Response::HTTP_UNAUTHORIZED);
    }
    public function resetPassword(Request $request)
    {
        $validateRequest = $request->validate([
            'email' =>'required|string',
            'otp' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $validateRequest['email'])->first();
        if ($user->checkOTP($validateRequest['otp'])){
            $user->password = bcrypt($validateRequest['password']);
            $user->save();
            return response([
                'message'=>'Đặt lại mật khẩu thành công'
            ],Response::HTTP_OK);
        }
        
        return response([
            'message'=>'Mã OTP không hợp lệ hoặc quá thời hạn'
        ],Response::HTTP_UNAUTHORIZED);

    }
}
