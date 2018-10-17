<?php

namespace App\Tools;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Upload
{
    /**
     * 上傳
     * @param Request $request
     * @param $name input name
     * @return bool|string
     */
    public function put(Request $request,$name)
    {
        $file = $request->file($name);

        if(!$file){
            return false;
        }

        if(!$file->isValid()){
            return false;
        }

        $ext = $file->getClientOriginalExtension();
        $path = $file->getRealPath();

        $fileName = date('Y-m-d') . '/' . uniqid() . '.' .$ext;

        if(Storage::disk('ftp')->put($fileName,file_get_contents($path))){
            return $fileName;
        }
        return false;
    }

    /**
     * 刪除文件
     * @param string|array $name 文件名
     * @return bool
     */
    public function delete($name)
    {
        if(is_string($name)){
            return Storage::disk('ftp')->delete($name);
        }
        if(is_array($name)){
            return Storage::disk('ftp')->delete($name);
        }
        return false;
    }
}