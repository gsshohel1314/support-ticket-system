<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;

trait ImageStore
{
    public function uploadFile($file)
    {
        $fileName = "";
        $fileName = time() . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move('uploads/files', $fileName);

        return $fileName;
    }
    
    public function deleteImage($url)
    {
        $file_path = public_path('uploads/files/' . $url);
        if (isset($url) && File::exists($file_path)) {
            File::delete($file_path);

            return true;
        }

        return false;
    }
}
