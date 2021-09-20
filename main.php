<?php

function convertImageToWebP($source, $quality = 80)
{
    try {
        $fileinfo = pathinfo($source);
        $destination = implode([
            $fileinfo['dirname'],
            DIRECTORY_SEPARATOR,
            $fileinfo['filename'],
            '.webp'
        ]);

        if (file_exists($destination)) {
            return false;
        }

        switch (true) {
            case ($fileinfo['extension'] == 'jpeg' || $fileinfo['extension'] == 'jpg'):
                $image = imagecreatefromjpeg($source);
                break;
            case ($fileinfo['extension'] == 'gif'):
                $image = imagecreatefromgif($source);
                break;
            case ($fileinfo['extension'] == 'png'):
                $image = imagecreatefrompng($source);
                imagepalettetotruecolor($image);
                imagealphablending($image, true);
                imagesavealpha($image, true);
                break;
            default:
                return false;
        }

        return imagewebp($image, $destination, $quality);
    } catch (\Exception $e) {
        echo $e->getMessage();
    }
}

function searchDir($dir)
{
    foreach (array_diff(scandir($dir), ['..', '.']) as $key => $item) {
        $itemPath = implode([$dir, DIRECTORY_SEPARATOR, $item]);

        if (!is_dir($itemPath)) {
            var_dump($itemPath);
            convertImageToWebP($itemPath);
        } else {
            searchDir($itemPath);
        }
    }
}

$parentDir = './uploads/2016/08';

searchDir($parentDir);
