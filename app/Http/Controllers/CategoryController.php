<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    public function createdCategory(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'category_name' => 'required|min:3|max:255',
                // Tambahkan aturan validasi lainnya sesuai kebutuhan
            ]);
            $category = Category::create([
                'category_name' => $request->input('category_name'),
                // tambahkan kolom lainnya yang ingin Anda simpan
            ]);

            return response()->json(['status' => true, 'message' => 'Get All Category Successfully', 'data' => $category], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            // Contoh penanganan sederhana: Mengembalikan pesan kesalahan
            return response()->json(['status' => false, 'error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
            // Contoh penanganan lebih lanjut: Logging pengecualian
            // Log::error('Pengecualian terjadi: ' . $e->getMessage());
        }
    }
    public function getAllCategory()
    {
        try {
            $category = Category::select('id', 'category_name', 'created_at', 'updated_at')->get();

            return response()->json(['status' => true, 'message' => 'Created Category Successfully', 'data' => $category], Response::HTTP_OK);
        } catch (\Throwable $th) {
            // Contoh penanganan sederhana: Mengembalikan pesan kesalahan
            return response()->json(['status' => false, 'error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
            // Contoh penanganan lebih lanjut: Logging pengecualian
            // Log::error('Pengecualian terjadi: ' . $e->getMessage());
        }
    }

    public function getOneCategory($id)
    {
        try {
            $category = Category::select('id', 'category_name', 'created_at', 'updated_at')->where('id', $id)->get();
            if ($category->count() == 0) return response()->json(['status' => false, 'message' => 'Category Not Found'], Response::HTTP_NOT_FOUND);

            return response()->json(['status' => true, 'message' => 'Get One Category Successfully', 'data' => $category], Response::HTTP_OK);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status' => false, 'error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updatedCategory(Request $request)
    {
        try {
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status' => false, 'error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deletedCategory($id)
    {
        try {
            $category = Category::findOrfail($id)->delete();

            return response()->json(['status' => true, 'message' => 'Deleted Category Successfully'], Response::HTTP_OK);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status' => false, 'error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function restoreCategory($id)
    {
        try {
            //code...
            $category = Category::withTrashed()->where('id', $id)->restore();

            return response()->json(['status' => true, 'message' => 'Restore Category Successfully'], Response::HTTP_OK);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status' => false, 'error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
