<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccessTokenController extends Controller
{
    public function index()
    {

        return Auth::guard('sanctum')->user()->tokens;
        // $request->user('guard name')->tokens;
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'device_name' => ['nullable'],
            'abilities' => ['array'],
        ]);

        $user = User::whereEmail($request->email)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            $device_name = $request->post('device_name', $request->userAgent());
            $abilities = $request->post('abilites', ['*']);
            //$abilities= ['classrooms.create','classrooms.update',...];

            $token = $user->createToken($device_name, $abilities, now()->addDays(90));

            return response()->json([
            'token' => $token->plainTextToken,
                'user' => $user,
            ], 201);
        }

        return response()->json([
            'message' => __('Invalid credintials'),
        ], 401);
    }

    public function destroy($id = null)
    {
        $user = Auth::guard('sanctum')->user();
        if ($id) {
            if ($id == 'current') {
                $user->currentAccessToken()->delete();
            } else {
                $user->tokens()->destroy($id);
            }
        } else {
            $user->tokens()->delete();
        }
    }
}
