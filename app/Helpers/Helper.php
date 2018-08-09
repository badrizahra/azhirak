<?php

namespace App\Helpers;

use Intervention\Image\ImageManagerStatic as Image;
use App\WebSample;
use App\WebTag;

class Helper {

    /**
     * Uploads image under public/$folder
     * 
     * @param file object $image
     * @param string $folder
     * @param string $prefix
     * @param int $width
     * @param int $height
     * 
     * @return string $filename
     */
    public static function upload_image($image, $folder, $prefix, $width=300, $height=300){
                
        $imageName = $image->getFilename();
        $imageExtenstion = '.' . $image -> getClientOriginalExtension();
        
        $imagePath = public_path($folder);

        if (!file_exists($imagePath)) {
            mkdir($imagePath, 0777, true);
        }
        $filename = $prefix . '_' . date("dmYhis") . $imageExtenstion;
        
        $imageFile = $imagePath.$filename;
        // dd($imageFile);
        if(Image::make($image->getRealPath())->fit($width,$height)->save($imageFile)) {

            return $filename;
        }
        else {
            return false;
        }
    }

    /**
     * Manages websamples tags
     * 
     * @param integer $smaple_id 
     * @param array $tags
     * 
     * @return 
     */
    public static function manage_web_tags($sample_id, $tags=['']) 
    {
        $webSample = WebSample::findOrFail($sample_id);

        // dd($tags);

        if ($tags[0] == '') {
            $webRes = $webSample->webtags()->detach();
        } else {
            $webSample->webtags()->detach();
            $webRes = $webSample->webtags()->attach($tags);
        }
        
        if($webRes) {
            return 'true';
        } else {
            return 'false';
        }
        
    }


}