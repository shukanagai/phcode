<?php
/**
 * PH35 Sample12 マスタテーブル管理Laravel版 Src02/17
 * ルーティング情報記述ファイル。
 *
 * @author Shinzo SAITO
 *
 * ファイル名=web.php
 * フォルダ=/scottadminlaravel/routes/
 */

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TopController;
use App\Http\Controllers\DeptController;
use App\Http\Controllers\EmpController;

Route::get("/", [LoginController::class, "goLogin"]);
Route::post("/login", [LoginController::class, "login"]);
Route::get("/logout", [LoginController::class, "logout"]);
Route::get("/goTop", [TopController::class, "goTop"]);

Route::get("/dept", [TopController::class, "goTop"]);
Route::get("/dept/showDeptList", [DeptController::class, "showDeptList"]);
Route::get("/dept/goDeptAdd", [DeptController::class, "goDeptAdd"]);
Route::post("/dept/deptAdd", [DeptController::class, "deptAdd"]);
Route::get("/dept/prepareDeptEdit/{dpId}", [DeptController::class, "prepareDeptEdit"]);
Route::post("/dept/deptEdit", [DeptController::class, "deptEdit"]);
Route::get("/dept/confirmDeptDelete/{dpId}", [DeptController::class, "confirmDeptDelete"]);
Route::post("/dept/deptDelete", [DeptController::class, "deptDelete"]);

Route::get("/emp", [TopController::class, "goTop"]);
Route::get("/emp/showEmpList", [EmpController::class, "showEmpList"]);
Route::get("/emp/goEmpAdd", [EmpController::class, "goEmpAdd"]);
Route::post("/emp/empAdd", [EmpController::class, "empAdd"]);
Route::get("/emp/prepareEmpEdit/{emId}", [EmpController::class, "prepareEmpEdit"]);
Route::post("/emp/empEdit", [EmpController::class, "empEdit"]);
Route::get("/emp/confirmEmpDelete/{emId}", [EmpController::class, "confirmEmpDelete"]);
Route::post("/emp/empDelete", [EmpController::class, "empDelete"]);