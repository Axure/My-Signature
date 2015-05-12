<?php

//$userdata_file = fopen("./se_profile.txt", "r");
$userdata_file = file_get_contents("./se_profile.txt");
$userdata = unserialize($userdata_file);

print_r($userdata);