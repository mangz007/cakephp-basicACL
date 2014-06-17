<?php

class ImageResizeComponent extends Component {

    /**
     * create a cropped image of given size in $org_folder/$width$height folder
     * @param sring $org_folder The absolute folder path where the original file is present
     * @param sring $image_name the name of the file
     * @param sring $width width of cropped image
     * @param sring $height height of cropped image
     * @return path to the image
     */
    public function scale_crop($org_folder, $image_name, $width, $height, $out_folder = "") {
        if ($out_folder != "") {
            list(, $path) = explode("webroot/files/", $out_folder);
            $finalFolders = explode("/", $path);
            $path = WWW_ROOT . 'files/';
            foreach ($finalFolders as $v) {
                @mkdir($path . $v);
                @chmod($path . $v, 0777);
                $path = $path . "/$v/";
            }
        } else {
            @mkdir("$org_folder/{$width}x{$height}");
            @chmod("$org_folder/{$width}x{$height}", 0777);
        }

        if ($out_folder != "") {
            $cmd = "convert $org_folder/$image_name -resize {$width}x{$height}\> $out_folder/$image_name";
        } else {
            $cmd = "/usr/bin/convert $org_folder/$image_name -resize {$width}x{$height}\> $org_folder/{$width}x{$height}/$image_name";
        }
        $arr = array();
        exec($cmd, $arr);
        @chmod("$org_folder/{$width}x{$height}/$image_name", 0777);

        $webroot = WWW_ROOT;
        if ($out_folder != "") {
            return preg_replace("!$webroot!", "/", "$out_folder/$image_name");
        } else {
            return preg_replace("!$webroot!", "/", "$org_folder/{$width}x{$height}/$image_name");
        }
    }

    public function profile_scale_crop($org_folder, $image_name, $width, $height, $out_folder = "") {
        if ($out_folder != "") {
            @mkdir("$out_folder");
            @chmod("$out_folder", 0777);
        } else {
            @mkdir("$org_folder/{$width}x{$height}");
            @chmod("$org_folder/{$width}x{$height}", 0777);
        }

        if ($out_folder != "") {
            $cmd = "/usr/bin/convert $org_folder/$image_name -resize {$width}x{$height}^ -gravity Center -crop {$width}x{$height}+0+0 +repage $out_folder/$image_name";
        } else {
            $cmd = "/usr/bin/convert $org_folder/$image_name -resize {$width}x{$height}^ -gravity Center -crop {$width}x{$height}+0+0 +repage $org_folder/{$width}x{$height}/$image_name";
        }
        $arr = array();
        exec($cmd, $arr);
        @chmod("$org_folder/{$width}x{$height}/$image_name", 0777);

        $webroot = WWW_ROOT;
        if ($out_folder != "") {
            return preg_replace("!$webroot!", "/", "$out_folder/$image_name");
        } else {
            return preg_replace("!$webroot!", "/", "$org_folder/{$width}x{$height}/$image_name");
        }
    }

    public function template_scale($folder, $scale, $filename) {
        @mkdir(WWW_ROOT . "files/templates/$folder/$scale", 0777);
        $cmd = "/usr/bin/convert " . WWW_ROOT . "files/templates/$folder/$filename -resize {$scale}% " . WWW_ROOT . "files/templates/$folder/$scale/$filename";
        exec($cmd);
        @chmod(WWW_ROOT . "files/templates/$folder/$scale/$filename", 0777);
        return "/files/templates/$folder/$scale/$filename";
    }

    public function user_scale($scale, $filename) {
        @mkdir(WWW_ROOT . "files/user-uploads/$scale", 0777);
        $cmd = "/usr/bin/convert " . WWW_ROOT . "files/user-uploads/$filename -resize {$scale}% " . WWW_ROOT . "files/user-uploads/$scale/$filename";
        exec($cmd);
        @chmod(WWW_ROOT . "files/user-uploads/$scale/$filename", 0777);
        return "/files/user-uploads/$scale/$filename";
    }

    public function generateCaptcha($text) {
        /* Create some objects */
        $image = new Imagick();
        $draw = new ImagickDraw();
        $pixel = new ImagickPixel('white');

        /* New image */
        $image->newImage(120, 50, $pixel);

        /* Black text */
        $draw->setFillColor('black');

        /* Font properties */
        $draw->setFontSize(30);
        
        /* Create text */
        $image->annotateImage($draw, 5, 30, 0, $text);
        $image->oilPaintImage(1);
        $image->swirlImage(25);
        $image->addNoiseImage(4, 2);
        
        /* Give image a format */
        $image->setImageFormat('png');

        /* Output the image with headers */
        header('Content-type: image/png');
        echo $image;
    }

}