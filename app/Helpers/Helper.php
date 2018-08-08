<?php

namespace App\Helpers;

use Intervention\Image\ImageManagerStatic as Image;

class Helper {

    /**
     * @param file $image
     * 
     * @return boolean
     */
    public static function upload_image_old($image, $path, $prefix ="", $storage_path, $width=300, $height=300){
                
        //upload_image($request->file('nameOfFormField'), 'prefix', '/directoryInPublicFolder', 300,300);

        // $extension = $path->getClientOriginalExtension();
        $my_path = public_path('uploads' . $prefix . $image->getFileName() . $image->getClientOriginalExtension());
        // dd($storage_path);
        dd($my_path);
        dd($destination_path = public_path('uploads/websamples/' . $path . $extension));
        dd($path);

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        $filename = $prefix.'_' . date("jFYhis") . '.' . $extention;
        if(Image::make($path)->fit($width,$height)->save(public_path("websamples/" . $storage_path . $filename))) {

            return $storage_path.$filename;
        }
        else {
            return false;
        }
    }

    public static function upload_image($image, $folder, $width, $height){
                
        $imageName = $image->getFilename();
        $imageExtenstion = '.' . $image -> getClientOriginalExtension();
        $imagePath = public_path($folder . $imageName . $imageExtenstion);

        if (!file_exists($imagePath)) {
            mkdir($imagePath, 0777, true);
        }

        $filename = $prefix.'_' . date("jFYhis") . '.' . $extention;
        if(Image::make($path)->fit($width,$height)->save(public_path("websamples/" . $storage_path . $filename))) {

            return $storage_path.$filename;
        }
        else {
            return false;
        }
    }

    public static function uploadImage($id,$model_name,$image,$file_name) {

        $destinationPath = public_path('upload/'.$model_name.'/'.$id.'/');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }
        $img = Image::make($image->getRealPath());
        $img->resize(100, 100, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath . 'thumb_' . $file_name);
        $upload_res = $image->move($destinationPath, $file_name);
        return $upload_res;
    }


}