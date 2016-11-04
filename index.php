<?php

include_once "includes/PollutionCertHandler.inc.php";

$handler = new PollutionCertHandler(); 

echo $handler->check_status("DL13SG5035");

?>