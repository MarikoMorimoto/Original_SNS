<?php

namespace App\Services;

class FileUploadService {

    public function saveImage($image){
        $path = '';
        if( isset($image) === true ){
            // photos/（ランダムな文字列）が生成
            $path = $image->store('photos', 'public');
        }
        return $path;
    }
}