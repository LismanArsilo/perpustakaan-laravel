<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StatusController extends Controller
{
    public function createdStatus(Request $request)
    {
        try {
            $validate =  $request->validate([
                'status_name' => 'required|max:255'
            ]);

            $status = Status::create([
                'status_name' => $request->input('status_name')
            ]);
            return response()->json(['status' => true, 'message' => 'Created Status Successfully', 'data' => $status], Response::HTTP_OK);
        } catch (\Throwable $th) {
            // Contoh penanganan sederhana: Mengembalikan pesan kesalahan
            return response()->json(['status' => false, 'error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function getAllStatus()
    {
        try {
            $status = Status::select('id', 'status_name', 'created_at', 'updated_at')->get();

            return response()->json(['status' => true, 'message' => 'Created Category Successfully', 'data' => $status], Response::HTTP_OK);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status' => false, 'error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getOneStatus($id)
    {
        try {
            $status = Status::select('id', 'status_name', 'created_at', 'updated_at')->where('id', $id)->get();

            if ($status->count() == 0) return response()->json(['status' => false, 'message' => 'Status Not Found'], Response::HTTP_NOT_FOUND);

            return response()->json(['status' => true, 'message' => 'Get One Status Successfully', 'data' => $status], Response::HTTP_OK);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status' => false, 'error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updatedStatus($id)
    {
        try {
            //code...
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function deletedStatus($id)
    {
        try {
            $status = Status::findOrFail($id)->delete();

            return response()->json(['status' => true, 'message' => 'Deleted Status Successfully'], Response::HTTP_OK);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status' => false, 'error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function restoreStatus($id)
    {
        try {
            //code...
            $status = Status::withTrashed()->where('id', $id)->restore();

            return response()->json(['status' => true, 'message' => 'Restore Status Successfully'], Response::HTTP_OK);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status' => false, 'error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
