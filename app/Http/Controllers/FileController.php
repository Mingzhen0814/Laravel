<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    function __invoke(Request $request){
        // 有上傳檔案才抓取檔案內容
        if ($request->hasFile("file1")){
            $file = $request->file1;
            $filename = $file->store("documents"); // 經過雜湊後的檔名，以免後蓋前、程式碼寫成的檔名、亂碼(非ascii code編碼)的檔名
            $ori = $file->getClientOriginalName(); // 原檔名
            return $ori;
        }

        return "No file uploads";
    }
}
