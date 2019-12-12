<?php
$req_width = 100;
$req_height = 100;
$width = 340;
$height = 255;
$out_img_file = './uploads/dwell/dwell.jpg';

$in_img_file = 'http://localhost/php_fma_galery/uploads/images/boxing.gif';
$src = imagecreatefromgif($in_img_file);
// Create the new canvas ready for resampled image to be inserted into it
$new = imagecreatetruecolor($req_width, $req_height);

// Resample input image into newly created image
imagecopyresampled($new, $src, 0,0,0,0, $req_width, $req_height, $width, $height);
// Create output jpeg at quality level of 90
imagejpeg($new, $out_img_file, 90);


// Destroy any intermediate image files
imagedestroy($new);
imagedestroy($src);
?>