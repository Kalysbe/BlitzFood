<?php

session_start();
$i1=rand(1, 99);
$i2=rand(1, 99);
$codev = $i1.$i2;
$_SESSION['secure_code'] = $codev;
$im = imagecreatetruecolor(75, 28);
$black = imagecolorallocate($im, 255, 255, 255);
imagefill($im, 0, 0, $black);

for ($i = 0; $i < strlen($codev); $i++) {

  //$cl=imagecolorallocate($im, rand(150, 255), rand(150, 255), rand(150, 255));

  imageline($im,rand(0,75),rand(0,28),rand(0,75),rand(0,28),$black);
  imageline($im,rand(0,75),rand(0,28),rand(0,75),rand(0,28),$black);

  $char = imagecreatetruecolor(14, 16);

  //$black = imagecolorallocate($char, 0, 0, 0);
  imagefill($char, 0, 0, $black);
  //$font=imageloadfont('./font'.rand(1, 2).'.phpfont');
  $cl=imagecolorallocate($char, rand(0, 180), rand(0, 180), rand(0, 180));
  imagestring(
    $char,
    rand(4,5),
    1,
    1,
    substr($codev, $i, 1),
    $cl
  );
  //imageline($im,rand(0,75),rand(0,28),rand(0,75),rand(0,28),$cl);

  $char = imagerotate($char, rand(-20, 20), $black);
  imagecopy(
    $im,
    $char,
    5 + (14 * ($i - 1)) + rand(10, 15),
    5 + rand(-4, 3),
    0,
    0,
    14,
    16
  );
  imagedestroy($char);
}

for ($i=0;$i<100;$i++)
{
   $cl=imagecolorallocate($im, rand(200, 255), rand(200, 255), rand(200, 255));
   imagesetpixel($im,rand(0,75),rand(0,28),$cl);
}

header("Content-type: image/png");
imagepng($im);

?>
