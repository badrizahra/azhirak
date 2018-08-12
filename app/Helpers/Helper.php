<?php

namespace App\Helpers;

use Intervention\Image\ImageManagerStatic as Image;
use App\WebSample;
use App\WebTag;
use App\NetworkSample;
use App\NetworkTag;
use App\GraphicSample;
use App\GraphicTag;

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
     * 
     */
    public static function manage_web_tags($sample_id, $tags=['']) 
    {
        $webSample = WebSample::findOrFail($sample_id);

        if ($tags[0] == "" && count($webSample->webtags()->get()->toArray()) > 0 ) {
            $webSample->webtags()->detach();
            return true;
        } elseif ($tags[0] == "" && $webSample->webtags()->get()->toArray() == 0) {
            return true;
        } elseif($tags[0] != "") {
            $webSample->webtags()->detach();
            $webRes = $webSample->webtags()->attach($tags);
            return true;
        } else {
            return true;
        }
    }

    /**
     * Manage networksample tags
     */
    public static function manage_network_tags($sample_id, $tags=['']) 
    {
        $networkSample = NetworkSample::findOrFail($sample_id);

        if ($tags[0] == "" && count($networkSample->networktags()->get()->toArray()) > 0 ) {
            $networkSample->networktags()->detach();
            return true;
        } elseif ($tags[0] == "" && $networkSample->networktags()->get()->toArray() == 0) {
            return true;
        } elseif($tags[0] != "") {
            $networkSample->networktags()->detach();
            $networkRes = $networkSample->networktags()->attach($tags);
            return true;
        } else {
            return true;
        }
    }

    /**
     * Manage graphicsample tags
     */
    public static function manage_graphic_tags($sample_id, $tags=['']) 
    {
        $graphicSample = GraphicSample::findOrFail($sample_id);

        if ($tags[0] == "" && count($graphicSample->graphictags()->get()->toArray()) > 0 ) {
            $graphicSample->graphictags()->detach();
            return true;
        } elseif ($tags[0] == "" && $graphicSample->graphictags()->get()->toArray() == 0) {
            return true;
        } elseif($tags[0] != "") {
            $graphicSample->graphictags()->detach();
            $graphicRes = $graphicSample->graphictags()->attach($tags);
            return true;
        } else {
            return true;
        }
    }


}