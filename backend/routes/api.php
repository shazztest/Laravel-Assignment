<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->group(function(){
    Route::post('/createposts',[PostController::class,'createPost']);
    Route::get('/allposts',[PostController::class,'allPosts']);
    Route::get('/getpost/{id}',[PostController::class,'getPostById']);
    Route::post('/updateposts/{id}',[PostController::class,'updatePosts']);
    Route::delete('/deleteposts/{id}',[PostController::class,'deletePosts']);
});

Route::prefix('admin')->middleware(['auth:api', 'admin'])->group(function(){
    Route::get('/admin', [AdminController::class, 'checkadmin']);
    Route::get('/getAllRoles', [AdminController::class, 'getAllRoles']);
    Route::get('/getAllPosts', [AdminController::class, 'getAllPosts']);
    Route::post('/getCreatePosts', [AdminController::class, 'getCreatePosts']);
    Route::post('/getUpdatePosts/{id}', [AdminController::class, 'getUpdatePosts']);
    Route::get('/getDeletePosts/{id}', [AdminController::class, 'getDeletePosts']);
});

Route::post('/register',[UserController::class,'createUser']);
Route::post('/login',[UserController::class,'loginUser']);
Route::get('/check',[UserController::class,'check']);