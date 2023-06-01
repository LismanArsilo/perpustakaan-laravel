<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\UserController;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::get('/books', function () {
//     return 'ok';
// });

// Auth sanctum
Route::prefix('/v1/auth')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::post('/register', [AuthenticationController::class, 'register']);
        Route::post('/login', [AuthenticationController::class, 'login']);
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthenticationController::class, 'logout']);
    });
});


// Category
Route::prefix('/v1/category')->middleware('auth:sanctum')->group(function () {
    Route::post('/', [CategoryController::class, 'createdCategory']);
    Route::get('/', [CategoryController::class, 'getAllCategory']);
    Route::get('/{id}', [CategoryController::class, 'getOneCategory']);
    Route::delete('/{id}', [CategoryController::class, 'deletedCategory']);
    Route::get('/restore/{id}', [CategoryController::class, 'restoreCategory']);
});

// Status
Route::prefix('/v1/status')->middleware(['auth:sanctum', 'isAdmin'])->group(function () {
    Route::get('/', [StatusController::class, 'getAllStatus']);
    Route::get('/{id}', [StatusController::class, 'getOneStatus']);
    Route::post('/', [StatusController::class, 'createdStatus']);
    Route::delete('/{id}', [StatusController::class, 'deletedStatus']);
    Route::get('/restore/{id}', [StatusController::class, 'restoreStatus']);
});

// Book
Route::prefix('/v1/book')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [BookController::class, 'getAllBook']);
    Route::get('/image/{pathImage}', [BookController::class, 'showImage']);
    Route::get('/{id}', [BookController::class, 'getOneBook']);
    Route::middleware('isAdmin')->group(function () {
        Route::post('/', [BookController::class, 'createdBook']);
        Route::delete('/{id}', [BookController::class, 'deletedBook']);
        Route::get('/restore/{id}', [BookController::class]);
    });
});

// Role
Route::prefix('/v1/role')->middleware(['auth:sanctum', 'isAdmin'])->group(function () {
    Route::post('/', [RoleController::class, 'createdRole']);
    Route::get('/', [RoleController::class, 'getAllRole']);
    Route::get('/{id}', [RoleController::class, 'getOneRole']);
});

// User
Route::prefix('/v1/user')->group(function () {
    Route::get('/{id}', [UserController::class, 'getOneUser']);
});



Route::fallback(function (Request $request) {
    $url = $request->url();
    return response()->json(['status' => false, 'message' => 'API endpoint not found', 'URL' => $url], Response::HTTP_NOT_FOUND);
});
