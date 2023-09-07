<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function register(RegisterRequest $registerRequest)
    {
        try {
            if ($user = User::create($registerRequest->all())) {
                return response([
                    'message' => 'Pendaftaran berhasil, anda akan dialihkan kehalaman member',
                    'result' => Arr::add($registerRequest->all(), 'token', $user->createToken($user->email)->plainTextToken)
                ], 201);
            } else {
                throw new Exception('Terjadi kesalahan disisi server');
            }
        } catch (Exception $exception) {
            return response([
                'message' => $exception->getMessage(),
                'result' => null
            ], 422);
        }
    }

    public function login(LoginRequest $loginRequest)
    {
        try {
            if (Auth::attempt($loginRequest->all())) {
                return response([
                    'message' => 'Berhasil masuk, anda akan dialihkan dalam 2 detik.',
                    'result' => [
                        'token' => $loginRequest->user()->createToken($loginRequest->user()->email)->plainTextToken
                    ]
                ]);
            } else {
                throw new Exception('Alamat Email & Kata Sandi tidak cocok');
            }
        } catch (Exception $exception) {
            return response([
                'message' => $exception->getMessage(),
                'result' => null
            ], 422);
        }
    }

    public function user(Request $request)
    {
        return response([
            'message' => null,
            'result' => $request->user()
        ]);
    }

    public function forgot(Request $request)
    {
        try {
            if ($request->verify) {

            } else {
                $status = Password::sendResetLink(
                    $request->only('email')
                );
                return $status === Password::RESET_LINK_SENT ?
                    response([
                        'message' => $status,
                        'result' => null
                    ]) :
                    throw new Exception('Data pengguna tidak ditemukan.');
            }
        } catch (Exception $exception) {
            return response([
                'message' => $exception->getMessage(),
                'result' => null
            ]);
        }
    }

    public function reset(Request $request)
    {

    }
}
