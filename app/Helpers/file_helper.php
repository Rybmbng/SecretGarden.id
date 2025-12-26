<?php

if (!function_exists('rrmdir')) {
    function rrmdir($dir) {
        if(is_dir($dir)){
            $objects = scandir($dir);
            foreach($objects as $object){
                if($object!="." && $object!=".."){
                    $path = $dir . DIRECTORY_SEPARATOR . $object;
                    if(is_dir($path) && !is_link($path))
                        rrmdir($path);
                    else
                        unlink($path);
                }
            }
            rmdir($dir);
        }
    }
}
