<?php

namespace App\Http\Controllers\Helper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class uploadFileController extends Controller
{
    public function create(string $folder = "general", UploadedFile $file)
    {

        if ($file) {
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('upload/'.$folder, $fileName, 'public');
            $fileUrl = $path;

            return $fileUrl;
        }
        return null;
    }

    public function update(string $url, UploadedFile $file)
    {
        if ($file && file_exists(public_path($url))) {
            // ambil folder dan type dari url
            $folder = explode("/", $url)[1];
            $type = explode("/", $url)[2];
            unlink(public_path($url));
            $path = $this->create( $folder, $file);
            return $path;
        }
        return null;
    }

    public function delete($path)
    {
        if (file_exists(public_path($path))) {
            unlink(public_path($path));
            return true;
        }
        return false;
    }
    public function get($path)
    {
        if (file_exists(public_path($path))) {
            return public_path($path);
        } else {
            return public_path('assets/img/sampel/sampel 2.png');
        }
        return null;
    }
}
