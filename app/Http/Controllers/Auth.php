<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class Auth extends Controller
{
  public function auth(Request $request) {
    $validated = $request->validate([
      'login' => 'required|string',
      'password' => 'required|string'
    ]);

    $user = User::where([
      'login' => $validated['login']
    ])->first();


    if (!$user) {
      throw ValidationException::withMessages([
        'Логин не найден'
      ]);
    }
    if (!Hash::check($validated['password'], $user->password)) {
      throw ValidationException::withMessages([
        'Пароль не соответствует'
      ]);
    }

    $token = $user->createToken('spa');

    return response()->json([
      'token' => $token->plainTextToken
    ]);
  }

  public function logout(Request $request) {
    $request->user()->currentAccessToken()->delete();
    return response()->json([]);
  }
}
