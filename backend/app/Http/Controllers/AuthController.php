<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\User;
use \Firebase\JWT\JWT;
use \Firebase\JWT\SignatureInvalidException;
use \Firebase\JWT\ExpiredException;
use \UnexpectedValueException;

class AuthController extends Controller
{
    public function signIn(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = User::where('email', $credentials['email'])->first();

            $now = time();

            $payload = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'admin' => $user->admin,
                'iat' => $now,
                'exp' => $now + 60 * 60 * 24
            ];

            $jwt = JWT::encode($payload, env('JWT_KEY'));

            $payload['token'] = $jwt;

            return response($payload, 200);
        }

        return response("Falha de autenticação", 401);
    }

    public function validateToken(Request $request)
    {
        $token = $request->token;

        if ($token) {
            try {
                $payload = JWT::decode($token, env('JWT_KEY'), array('HS256'));
                return response(true, 200);
            } catch (SignatureInvalidException $e) {
                return response('Assinatura inválida', 401);
            } catch (ExpiredException $e) {
                return response('Token expirado', 401);
            } catch (UnexpectedValueException $e) {
                return response('Token inválido', 401);
            }
        }

        return response('Token não informado', 401);
    }
}
