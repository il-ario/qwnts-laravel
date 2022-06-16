<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Login the user.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            $response = ['errors' => $validator->errors()->all()];

            return response($response, 422);
        }

        $user = User::where('email', $request->email)->first();

        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('Qwnts Token')->accessToken;
                $response = ['token' => $token];

                return response($response, 200);
            } else {
                $response = ['message' => 'Wrong password.'];

                return response($response, 422);
            }
        } else {
            $response = ['message' => 'User does not exist.'];
            
            return response($response, 422);
        }
    }

    /**
     * Logout the user.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'Logged out.'];

        return response($response, 200);
    }
}
