<!DOCTYPE JPEG>
<!-- http://php.net/manual/en/imagickdraw.point.php> -->
<!--To DO:
1 use proper img src
2 determine whether to run as a function w/in home or not
3 

-->
<img src = "http://cs.gettysburg.edu/~boucbe01/cs360_s18/neighborhoods.jpg">

<?php


    //Create a ImagickDraw object to draw into.
    $draw = new \ImagickDraw();

    $strokeColor = new \ImagickPixel(blue);

    $draw->setStrokeOpacity(.8);
    $draw->setStrokeColor($strokeColor);
   // $draw->setFillColor(transparent);

    $draw->setStrokeWidth(2);

    $draw->circle(500, 500, 40, 500);

    $imagick = new \Imagick();
    $imagick->newImage(500, 500, blue);
    $imagick->setImageFormat("jpg");
    $imagick->drawImage($draw);

    header("Content-Type: image/jpg");
    echo $imagick->getImageBlob();//what does this mean?
  
?>
