<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    public function login(Request $request)
    {
        try {
            $this->validate($request, [
                'login' => 'required',
                'password' => 'required',
            ]);

            $credentials = $request->only('login', 'password');

            if (!$token = auth()->attempt($credentials)) {
                return response()->json(['erro' => 'erro ao fazer login'], 400);
            }
        } catch (\Throwable $e) {
            return response()->json(['erro' => 'não foi possível entrar no sistema'], 400);
        }

        $usuario = auth()->user();


        return response()->json([
            'token' => $token,
            'usuario' => $usuario
        ]);
    }
}
