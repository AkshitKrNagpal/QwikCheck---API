<?php

include_once "includes/RegistrationCertHandler.inc.php";

$handler = new RegistrationCertHandler(); 

echo $handler->check_status("DL13SG5035");

?>