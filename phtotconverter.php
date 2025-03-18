<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$directory = "C:/Users/user/Desktop/Darjeeling_2025/";
$outputDirectory = $directory . "Darjeeling_2025_output/";

if (!file_exists($outputDirectory)) {
    mkdir($outputDirectory, 0777, true);
}

$images = glob($directory . "*.{png,jpeg,jpg,gif,bmp,webp}", GLOB_BRACE);
var_dump($images); // Debugging to see if images are found

foreach ($images as $image) {
    $imageInfo = pathinfo($image);
    $newImagePath = $outputDirectory . $imageInfo['filename'] . ".jpg";

    $imageResource = null;
    switch (strtolower($imageInfo['extension'])) {
        case 'png':
            $imageResource = imagecreatefrompng($image);
            break;
        case 'jpeg':
        case 'jpg':
            $imageResource = imagecreatefromjpeg($image);
            break;
        case 'gif':
            $imageResource = imagecreatefromgif($image);
            break;
        case 'bmp':
            $imageResource = imagecreatefrombmp($image);
            break;
        case 'webp':
            $imageResource = imagecreatefromwebp($image);
            break;
        default:
            echo "Skipping unsupported file: " . $image . "\n";
            continue 2;
    }

    if (!$imageResource) {
        echo "Failed to create image resource for: " . $image . "\n";
        continue;
    }

    if (imagejpeg($imageResource, $newImagePath, 100)) {
        echo "Converted: " . $image . " -> " . $newImagePath . "\n";
    } else {
        echo "Failed to convert: " . $image . "\n";
    }

    imagedestroy($imageResource);
}

echo "Conversion completed!";
?>
