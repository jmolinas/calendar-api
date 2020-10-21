<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Auth\Access\AuthorizationException;

class AuthController extends Controller
{
  /**
   * Get a JWT via given credentials.
   *
   * @param Request $request
   *
   * @return @inheritDoc
   */
  public function login(Request $request)
  {
    $this->validate($request, [
      'email' => 'required|email',
      'password' => 'required',
    ]);

    $credentials = $request->only(['email', 'password']);

    if (!($token = app('auth')->attempt($credentials))) {
      throw new AuthorizationException('Invalid Credentials');
    }

    return $this->respondWithToken($token);
  }

  /**
   * Get User Data
   *
   * @return array
   */
  protected function getUserData()
  {
    $user = app('auth')->user();
    $data['user'] = $user;
    return $data;
  }

  /**
   * Log the user out (Invalidate the token).
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function logout()
  {
    app('auth')->logout();

    return response()->json(['message' => 'Successfully logged out']);
  }

  /**
   * Get the token array structure.
   *
   * @param  string $token
   *
   * @return \Illuminate\Http\JsonResponse
   */
  protected function respondWithToken($token)
  {
    $response = [
      'access_token' => $token,
      'token_type' => 'bearer',
    ];

    $response = array_merge($response, $this->getUserData());

    return response()->json($response);
  }

  /**
   * Get user data.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function user()
  {
    return $this->buildResponse($this->getUserData());
  }
}
