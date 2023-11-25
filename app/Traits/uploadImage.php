<?php
namespace App\Traits;

use Illuminate\Http\Request;

trait UploadImage{
    public function uploadImage(Request $request, $folderPath){
        $image = $request->file('photo')->getClientOriginalName();
        $path = $request->file('photo')->storeAs($folderPath,$image,'images_path');
        return $path;
    }
}