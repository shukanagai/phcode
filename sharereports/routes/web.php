<?php



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ReportController;


Route::get("/", [LoginController::class, "goLogin"]);
Route::post("/login", [LoginController::class, "login"]);
Route::get("/logout", [LoginController::class, "logout"]);
Route::get("/report/showList", [ReportController::class, "showList"])->middleware("logincheck");
Route::get("/report/goAdd", [ReportController::class, "goAdd"])->middleware("logincheck");
Route::post("/report/add", [ReportController::class, "Add"])->middleware("logincheck");
Route::get("/report/showDetail/{reId}", [ReportController::class, "showDetail"])->middleware("logincheck");
Route::get("/report/prepareEdit/{reId}", [ReportController::class, "prepareEdit"])->middleware("logincheck");
Route::post("/report/edit", [ReportController::class, "Edit"])->middleware("logincheck");
Route::get("/report/confirmDelete/{reId}", [ReportController::class, "confirmDelete"])->middleware("logincheck");
Route::post("/report/delete", [ReportController::class, "delete"])->middleware("logincheck");