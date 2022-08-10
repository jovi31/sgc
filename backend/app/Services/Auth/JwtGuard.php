<?php

namespace App\Services\Auth;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;

use \Firebase\JWT\JWT;
use \Firebase\JWT\SignatureInvalidException;
use \Firebase\JWT\ExpiredException;
use \UnexpectedValueException;

class JwtGuard implements Guard
{

  use GuardHelpers;

  protected $request;

  public function __construct(UserProvider $provider, Request $request)
  {
    $this->request = $request;
    $this->provider = $provider;
  }

  public function user()
  {

    if (! is_null($this->user)) {
      return $this->user;
    }

    $user = null;

    $token = $this->request->bearerToken();

    if (! empty($token)) {
      try {
        $payload = JWT::decode($token, env('JWT_KEY'), array('HS256'));
        $user = $this->provider->retrieveById($payload->id);
      } catch (SignatureInvalidException $e) {
        // Assinatura inválida
      } catch (ExpiredException $e) {
        // Token expirado
      } catch (UnexpectedValueException $e) {
        // Token inválido
      }
    }

    return $this->user = $user;

  }

  public function validate(array $credentials = [])
  {

    if ($this->provider->retrieveByCredentials($credentials)) {
      return true;
    }

    return false;

  }

  public function setRequest(Request $request)
  {
    $this->request = $request;

    return $this;
  }

}
