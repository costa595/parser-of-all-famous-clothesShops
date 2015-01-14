<?php
class GeneratorImageColorPalette  
{ 
    // get image color in RGB format function  
    function getImageColor($imageFile_URL, $numColors, $image_granularity = 5) 
    { 
           $image_granularity = max(1, abs((int)$image_granularity)); 
           $colors = array(); 
           //find image size 
           $size = @getimagesize($imageFile_URL); 
           if($size === false) 
           { 
              user_error("Unable to get image size data"); 
              return false; 
           } 
           // open image 
           $img = @imagecreatefromjpeg($imageFile_URL); 
           if(!$img) 
           { 
                 user_error("Unable to open image file"); 
              return false; 
           } 
            
           // fetch color in RGB format 
           for($x = 0; $x < $size[0]; $x += $image_granularity) 
           { 
              for($y = 0; $y < $size[1]; $y += $image_granularity) 
              { 
                 $thisColor = imagecolorat($img, $x, $y); 
                 $rgb = imagecolorsforindex($img, $thisColor); 
                $red = round(round(($rgb['red'] / 0x33)) * 0x33); 
                 $green = round(round(($rgb['green'] / 0x33)) * 0x33); 
                 $blue = round(round(($rgb['blue'] / 0x33)) * 0x33); 
                 $thisRGB = sprintf('%02X%02X%02X', $red, $green, $blue); 
                 if(array_key_exists($thisRGB, $colors)) 
                 { 
                        $colors[$thisRGB]++; 
                 } 
                 else 
                 { 
                        $colors[$thisRGB] = 1; 
                 } 
              } 
           } 
           arsort($colors); 
           // returns maximum used color of image format like #C0C0C0. 
           return array_slice(array_keys($colors), 0, $numColors); 
    } 
   
} 
?>