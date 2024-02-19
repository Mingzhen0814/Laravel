<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/getsession', function () {
    // return view('home');
});

Route::get('/{locale}/aaa', function ($locale) {
    App::setLocale($locale);
    return view('home');
    // return __('message.age'); // 抓取語系檔.key
})->whereIn('locale',['en','tw']); // 透過middleware限制打入的網址

Route::get('/upload',function(){
    return view('uploadform');
});

Route::post('/upload', FileController::class);

Route::get('/download/{id}', [FileController::class,'download']);

Route::get('/set',function(Request $request){
    Cookie::queue('name','David',1);
    Cookie::queue('id','A02',1); // cookie有效期限1分鐘，Laravel最少設定1分鐘
    // session(["tel" => "1234"]);
    $request->session()->put("tel", "1234");
    $request->session()->put("address", "台中");
    echo "OK"; // 也可使用return
});

Route::get('/get',function(Request $request){
    $name = $request->cookie('name');
    $id = $request->cookie('id');
    // $tel = session("tel");
    $tel = $request->session()->get("tel");
    echo"{$id} : {$name} : {$tel}";
});
