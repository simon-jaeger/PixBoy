<?php
/**
 * convert a shadesArray to a base64 encoded png image
 * @param string $shadesArray - string of 256 shades (0, 1, 2, 3)
 * @return string - base64 encoded png image
 */
function shadesArrayToBase64($shadesArray) {
  // convert to real number array
  $shadesArrayNum = str_split($shadesArray);

  // create image and colors
  $img = imagecreate(16, 16);
  $gb = [];
  $gb[0] = imagecolorallocate($img, 196, 240, 194);
  $gb[1] = imagecolorallocate($img, 90, 185, 168);
  $gb[2] = imagecolorallocate($img, 49, 124, 140);
  $gb[3] = imagecolorallocate($img, 31, 31, 31);

  // draw image
  foreach ($shadesArrayNum as $i => $v) {
    $x = $i % 16;
    $y = floor($i / 16);
    imagesetpixel($img, $x, $y, $gb[$v]);
  }

  // convert to base64
  ob_start();
  imagepng($img);
  $base64 = base64_encode(ob_get_clean());
  return $base64;
}
