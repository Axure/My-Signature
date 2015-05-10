<?php

print_r(write_log());

$my_img = imagecreate( 2000, 200 );
$background = imagecolorallocate( $my_img, 0, 0, 255 );
$text_colour = imagecolorallocate( $my_img, 255, 255, 0 );
$line_colour = imagecolorallocate( $my_img, 128, 255, 0 );
imagestring( $my_img, 4, 30, 25, time(), $text_colour );
imagesetthickness ( $my_img, 5 );
//imageline( $my_img, 30, 45, 165, 45, $line_colour );
//imagestring( $my_img, 4, 30, 165, print_r(getallheaders(), true), $text_colour );
//header( "Content-type: image/png" );
//imagepng( $my_img );

//print($my_img);

$user_id = 'f';

fetch_with_url("http://stackexchange.com/users/2843751/aszunes-heart?tab=accounts");

//print_r(fetch('2843751'));

//    One static version that generates for the given sites
//    One dynamic version taht generates for the most active sites

function update() {
//  You should write one log file, and keep one last access file to avoid complication.


    if (file_exists("./date_file.log")) {
        $date_file = fopen("./date_file.log", "a+") or die("Unable to open file");

    } else {
        $date_file = fopen("./date_file.log", "a+") or die("Unable to open file");
    }


    fclose($date_file);

}

function write_log() {
    $log_file = fopen("./signature_log.log", "a") or die("Fucked!");
    date_default_timezone_set('Asia/Shanghai');
    fwrite($log_file, print_r(getallheaders(), true) . ','. date('l jS \of F Y h:i:s A', time()));
    fclose($log_file);
}

function fetch_with_api($uid) {
    $account_list = file_get_contents("https://api.stackexchange.com/2.2/users/" . $uid . "/associated");

    write_log();
    return $account_list;
}

function fetch_with_url($url) {
    $stackexchange_page = file_get_contents($url);
    print_r($stackexchange_page);
}

function forceUpdate() {

}