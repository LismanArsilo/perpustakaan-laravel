<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use stdClass;

class AuthenticationController extends Controller
{
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json(['status' => false, 'error' => 'Incorrect Email Or Password'], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            $token = $user->createToken('access_token')->plainTextToken;

            // $data = (object)[
            //     $user, 'token' => $token
            // ];
            $data = new stdClass;
            $data->name = $user->name;
            $data->role_id = $user->role_id;
            $data->token = $token;

            return response()->json(['status' => true, 'message' => 'Your Login Successfully', 'data' => $data], Response::HTTP_OK);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status' => false, 'error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|min:3|max:255',
                'phone' => 'required|min:8|max:15',
                'address' => 'string|min:3|max:255',
                'email' => 'required|email',
                'password' => 'required'
            ]);

            $user = User::create([
                "name" => $request->input('name'),
                "phone" => $request->input('phone'),
                "address" => $request->input('address'),
                "email" => $request->input('email'),
                "password" => Hash::make($request->input('password')),
            ]);

            return response()->json(['status' => true, 'message' => 'Your Registered Successfully']);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status' => false, 'error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['status' => true, 'message' => 'Your Logout Successfully']);
    }
}
