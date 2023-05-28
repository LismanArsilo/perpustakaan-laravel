<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleCreateRequest;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

class RoleController extends Controller
{
    public function createdRole(Request $request)
    {
        try {
            $request->validate([
                'role' => 'required|min:3|max:255'
            ], [
                'role.required' => "Field Role Is Required",
                'role.min' => 'Field Role Minimum :min Character',
                'role.max' => 'Field Role Minimum :max Character',
            ]);


            $role = Role::create([
                'role' => $request->input('role')
            ]);

            return response()->json(['status' => true, 'message' => 'Created Role Successfully', 'data' => $role], Response::HTTP_OK);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status' => false, 'error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getAllRole()
    {
        try {
            $role = Role::select('id', 'role', 'created_at', 'updated_at')->get();
            if ($role->count() == 0) return response()->json(['status' => false, 'message' => 'Role Not Found'], Response::HTTP_NOT_FOUND);

            return response()->json(['status' => true, 'message' => 'Get All Role Successfully', 'data' => $role], Response::HTTP_OK);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status' => false, 'error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getOneRole($id)
    {
        try {
            $role = Role::select('id', 'role', 'created_at', 'updated_at')->where('id', $id)->get();

            if ($role->count() == 0) return response()->json(['status' => false, 'message' => 'Role Not Found'], Response::HTTP_NOT_FOUND);

            return response()->json(['status' => true, 'message' => 'Get One Role Successfully', 'data' => $role], Response::HTTP_OK);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status' => false, 'error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
