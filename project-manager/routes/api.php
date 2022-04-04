<?php


// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AdminController;
use App\Http\Controllers\API\ProjectController;

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

Route::get('admins/index', [AdminController::class,'index']);
Route::post('admins/store', [AdminController::class,'store']);
Route::get('admins/edit/{id}', [AdminController::class,'edit']);
Route::post('admins/update/{id}', [AdminController::class,'update']);
Route::delete('admins/delete/{id}', [AdminController::class,'delete']);
Route::get('projects/index', [ProjectController::class,'index']);
Route::get('projects/assign_users', [ProjectController::class,'assignUsers']);
Route::post('project/store', [ProjectController::class,'store']);
Route::get('projects/{id}', [ProjectController::class,'show']);
Route::get('projects/edit/{id}', [ProjectController::class,'edit']);
Route::post('projects/update/{id}', [ProjectController::class,'update']);
Route::delete('projects/delete/{id}', [ProjectController::class,'delete']);

Route::post('projects/section/create/', [ProjectController::class, 'sectionCreate']);
Route::post('projects/section-item/create', [ProjectController::class, 'sectionItemCreate']);

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
