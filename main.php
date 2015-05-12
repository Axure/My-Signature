<?php

include('./simple_html_dom.php');

//print_r(write_log());


print("This is a debug");
//$my_img = imagecreate( 2000, 200 );
//$background = imagecolorallocate( $my_img, 0, 0, 255 );
//$text_colour = imagecolorallocate( $my_img, 255, 255, 0 );
//$line_colour = imagecolorallocate( $my_img, 128, 255, 0 );
//imagestring( $my_img, 4, 30, 25, time(), $text_colour );
//imagesetthickness ( $my_img, 5 );
////imageline( $my_img, 30, 45, 165, 45, $line_colour );
////imagestring( $my_img, 4, 30, 165, print_r(getallheaders(), true), $text_colour );
////header( "Content-type: image/png" );
////imagepng( $my_img );
//
////print($my_img);
//
//$user_id = 'f';
//
//fetch_with_url("http://stackexchange.com/users/2843751/aszunes-heart?tab=accounts");
fetch_with_url("http://127.0.0.1:1289/account.html");
//fetch_with_url("http://stackexchange.com/users/373922/loom?tab=accounts");

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
//    $stackexchange_page = file_get_html($url);
//    print_r($stackexchange_page);
    $html = file_get_html($url);

    // Get user name and avatar
    // Get user ID from the panel
    // Get reputation
    // Get newest questions and answers

    $accounts = $html->find('div[class="account-container"]');

    for($i = 0; $i < 3; $i++) {

//        print_r($accounts[$i]);
//        var_dump($accounts[$i]);

//        var_dump( is_object($accounts[$i]));
//        $current = str_get_html($accounts[$i]);
        $link = $accounts[$i]->find('a')[1]->href;
        $reputation = $accounts[$i]->find('div[class="account-stat"]')[0]->children[0]->innertext;
        echo "reputation is: " . $reputation . "\n";
//        foreach($link as $lk) {
////            var_dump($lk->innertext);
//            echo $lk->innertext;
//        }
        echo "Profile link is: " . $link ."\n";

        $uid_pattern = "/http:\/\/.*?\/(\d*)\//";
        preg_match_all($uid_pattern, $link, $ids);
        $ids = $ids[1][0];
        echo "User id is: " . $ids ."\n";


        $domain_pattern = "/http:\/\/(.*?)\/.*\//";
        preg_match_all($domain_pattern, $link, $domain);
        $domain = $domain[1][0];
        var_dump($domain);

//        $detail_account = file_get_html($link);

        // get question number and answer number
        $answer_number = $accounts[$i]->find('div[class="account-stat"]', 3)->children[0]->innertext;
        $question_number = $accounts[$i]->find('div[class="account-stat"]', 2)->children[0]->innertext;

//        var_dump($answer_number, $question_number);
        echo "answer number is: " . $answer_number ."\n";
        echo "question number is: " . $question_number ."\n";

        $answer_ajax = "http://" . $domain . "/ajax/users/panel/answers/" . $ids . "?sort=newest";
        $question_ajax = "http://" . $domain . "/ajax/users/panel/questions/" . $ids . "?sort=newest";


        $answers = file_get_html($answer_ajax);
        if ($answer_number > 3) $answer_number = 3;
        $answer_entries = $answers->find("tr");
        echo "\n";

        $answer_list = [];

        for ($j = 0; $j < $answer_number; ++$j) {
            echo $answer_entries[$j]->innertext;
            echo "An answer is: " . $answer_entries[$j]->children[1]->title . "\n";
            array_push($answer_list, $answer_entries[$j]->children[1]->title);
        }

        for ($j = $answer_number; $j < 3; ++$j) {
            array_push($answer_list, "");
        }
        print_r($answer_list);
        echo "\n";
//

//
        $questions = file_get_html($question_ajax);
        if ($question_number > 3) $question_number = 3;
        $question_entries = $questions->find("tr");
        echo "\n";

        $question_list = [];

        for ($j = 0; $j < $question_number; ++$j) {
            echo $question_entries[$j]->innertext;
            echo "An question is: " . $question_entries[$j]->children[1]->title . "\n";
            array_push($question_list, $question_entries[$j]->children[1]->title);
        }

        for ($j = $question_number; $j < 3; ++$j) {
            array_push($question_list, "");
        }
        print_r($question_list);
        echo "\n";
            




//        echo $accounts[$i] .'<br>';
    }


    // Fetch the top 3 sites



}

function forceUpdate() {

}