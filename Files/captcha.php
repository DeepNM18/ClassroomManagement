<?php
  header('Content-Type: image/jpeg');

  session_start();
  $text = rand(10000,99999);
  $_SESSION['captcha'] = $text;

  $height = 25;
  $width = 65;

  $image_p = imagecreate($width,$height);
  $black = imagecolorallocate($image_p,0,0,0);
  $white = imagecolorallocate($image_p,255,255,255);
  $font_size = 14;

  imagestring($image_p,$font_size,5,5,$text,$white);
  imagejpeg($image_p);

  imagedestroy($image_p);
?>