<?php

include_once 'includes/UserHandler.inc.php';
$userHandler = new UserHandler();
$apikey = $userHandler->generate_api_key(3);
echo $apikey;
echo $userHandler->get_user_id($apikey);
?>