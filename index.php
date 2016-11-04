<?php

include_once "includes/InsuranceCertHandler.inc.php";

$handler = new InsuranceCertHandler(); 

echo $handler->check_status("DL13SG5035");

?>