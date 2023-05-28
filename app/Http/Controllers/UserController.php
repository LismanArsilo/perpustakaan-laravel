<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function getOneUser($id)
    {
        try {
            $user = User::select('name', 'email', 'phone', 'address', 'role_id')->with('roles')->where('id', $id)->first();

            if ($user->count() == 0) return response()->json(['status' => false, 'message' => 'User Not Found'], Response::HTTP_NOT_FOUND);

            return response()->json(['status' => true, 'message' => 'Get One User Successfully', 'data' => $user]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status' => false, 'error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
