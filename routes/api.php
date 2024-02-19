<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

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

Route::get('/',function(Request $request) {
    $uid = $request->uid;
    $users = DB::select('select uid, ifnull(cname,"noname") as cname, ifnull(birth,"0000-00-00 00:00:00") as birth, ifnull(PWD,"lost") as PWD from UserInfo'); // 陣列
    // $jsonString = $users->toJson(JSON_UNESCAPED_UNICODE);
    return response($users); // JSON格式 (若使用model要手動轉json)
        // ->header("content-type","application/json")
        // ->header("charset","utf-8"); // 編碼格式
});

Route::post('/',function(Request $request) {
    $cname = $request->cname;
    $users = DB::select("select * from UserInfo where cname = '{$cname}'"); // 陣列
    return response($users); // JSON格式 (若使用model要手動轉json)
});