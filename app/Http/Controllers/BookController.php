<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function createdBook(Request $request)
    {
        try {
            $validate = $request->validate([
                'title' => 'required|min:3|max:255',
                'author' => 'min:3|max:255',
                'publisher' => 'min:3|max:255',
                'publisher_year' => 'numeric|digits:4',
                'image' => 'mimes:jpg,png,jpeg|image|max:2048', //2Mb
                'cate_id' => 'required'
            ]);
            if ($request->hasFile('image')) {
                $extension = $request->file('image')->getClientOriginalExtension();
                $replace = str_replace(' ', '-', $request->title);
                $pathName = $replace . '-' . now()->timestamp . '.' . $extension;
                $path = $request->file('image')->storeAs('images', $pathName);
            } else {
                $pathName = '';
            }

            $book = Book::create([
                'title' => $request->input('title'),
                'author' => $request->input('author'),
                'publisher' => $request->input('publisher'),
                'publisher_year' => $request->input('publisher_year'),
                'image' => $pathName,
                'cate_id' => $request->input('cate_id'),
            ]);

            return response()->json(['status' => true, 'message' => 'Created Book Successfully', 'data' => $book]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status' => false, 'message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getAllBook()
    {
        try {
            $book = Book::select('id', 'title', 'author', 'publisher', 'publisher_year', 'image', 'cate_id', 'created_at', 'updated_at')->get();

            return response()->json(['status' => true, 'message' => 'Get All Book Successfully', 'data' => $book], Response::HTTP_OK);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status' => false, 'message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getOneBook($id)
    {
        try {
            $book = Book::select('id', 'author', 'publisher', 'publisher_year', 'image', 'cate_id', 'created_at', 'updated_at')->where('id', $id)->first();

            if ($book->count() == 0) return response()->json(['status' => false, 'message' => 'Book Not Found'], Response::HTTP_NOT_FOUND);

            return response()->json(['status' => true, 'Message' => 'Get One Book Successfully', 'data' => $book], Response::HTTP_OK);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status' => false, 'message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function showImage($pathImage)
    {
        try {
            $path = storage_path('app/public/images/' . $pathImage);
            if (!Storage::disk('public')->exists('images/' . $pathImage)) {
                return response()->json(['status' => false, 'error' => 'Image not found'], Response::HTTP_NOT_FOUND);
            }
            $mimeType = File::mimeType($path);

            // Membaca isi gambar dan mengembalikan respons
            $fileContents = Storage::disk('public')->get('images/' . $pathImage);
            return new Response($fileContents, Response::HTTP_OK, ['Content-Type' => $mimeType]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status' => false, 'message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function deletedBook($id)
    {
        try {
            $book = Book::findOrfail($id)->delete();

            return response()->json(['status' => true, 'message' => 'Deleted Book Successfully'], Response::HTTP_OK);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status' => false, 'message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
