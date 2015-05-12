<?php

//$userdata_file = fopen("./se_profile.txt", "r");
$userdata_file = file_get_contents("./se_profile.txt");
$userdata = unserialize($userdata_file);

//print_r($userdata);

// Set the content-type
header('Content-Type: image/png');

$height = 0;
foreach ($userdata as $key => $value) {
    if (is_array($value)) {
        $height += 22;
        foreach($value["answer"] as $answer_content) {
            if ($answer_content != "") {
                $height += 20;
            }
        }

        $height += 22;
        foreach($value["question"] as $question_content) {
            if ($question_content != "") {
                $height += 20;
            }
        }
    } else {
    }

    $height += 30;
}

// Create the image
$im = imagecreatetruecolor(1000, $height);

// Create some colors
$white = imagecolorallocate($im, 255, 255, 255);
$grey = imagecolorallocate($im, 128, 128, 128);
$black = imagecolorallocate($im, 0, 0, 0);
imagefilledrectangle($im, 0, 0, 999, $height - 1, $white);

// The text to draw
$text = html_entity_decode(print_r($userdata, true));
//$text = "Fuck Me!";
// Replace path by your own font path
//$font = imageloadfont('./mp.ttf');
$font = 4;

// Add some shadow to the text
//imagettftext($im, 20, 0, 11, 21, $grey, $font, $text);

// Add the text
//imagettftext($im, 20, 0, 10, 20, $black, $font, $text);

//imagestring($im, $font, 0, 0, 'Hello', $black);

//imagestring($im, $font, 0, 0, $userdata["username"], $black);
$height = 0;

foreach ($userdata as $key => $value) {
    if (is_array($value)) {
        imagestring($im, $font, 0, $height, "   ". $key , $black);
        imagestring($im, $font, 200, $height, $value["reputation"] , $black);

        $height += 22;
        imagestring($im, $font, 0, $height, "      Recent Answers:" , $black);
        foreach($value["answer"] as $answer_content) {
            if ($answer_content != "") {
                $height += 20;
                imagestring($im, $font, 0, $height, "         " .$answer_content , $black);
            }
        }

        $height += 22;
        imagestring($im, $font, 0, $height, "      Recent Question:" , $black);
        foreach($value["question"] as $question_content) {
            if ($question_content != "") {
                $height += 20;
                imagestring($im, $font, 0, $height, "         " . $question_content , $black);
            }
        }
    } else {
        imagestring($im, $font, 0, $height, print_r($value, true), $black);
    }

    $height += 25;
}



//imagestring($im, $font, 0, 0, $text, $black);

// Using imagepng() results in clearer text compared with imagejpeg()
imagepng($im);
imagedestroy($im);

echo "\n";
print_r(html_entity_decode("&#39;"));
print_r(html_entity_decode("&quot;"));
print_r(html_entity_decode("&QUOT;"));
print_r(html_entity_decode("&#x00022;"));
print_r(html_entity_decode("&#34;"));
print_r($userdata);
?>