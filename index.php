<?php

/*
include_once "includes/RegistrationCertHandler.inc.php";

$handler = new RegistrationCertHandler(); 

echo $handler->check_status("DL13SG5035");
*/


/*
include_once "includes/RegistrationCertHandler.inc.php";

$handler = new RegistrationCertHandler(); 

echo $handler->rc_details("DL13SG5035");
*/


/*
include_once "includes/PollutionCertHandler.inc.php";

$handler = new PollutionCertHandler(); 

echo $handler->check_status("DL13SG5035");
*/


/*
include_once "includes/PollutionCertHandler.inc.php";

$handler = new PollutionCertHandler(); 

echo $handler->pucc_details("DL13SG5035");
*/


/*
include_once "includes/InsuranceCertHandler.inc.php";

$handler = new InsuranceCertHandler(); 

echo $handler->check_status("DL13SG5035");
*/


/*
include_once "includes/InsuranceCertHandler.inc.php";

$handler = new InsuranceCertHandler(); 

echo $handler->ins_details("DL13SG5035");
*/

/*
include_once "includes/RegistrationCertHandler.inc.php";

$handler = new RegistrationCertHandler();

echo $handler->register_vehicle('UP15H1517','12121212','34343434','SUZUKI','WAGON R','2000','2000-09-09','2018-09-10','CNG',100,8,'LMV','1010','COM','TRANSPARENT',100,2000,'COOL','MEEE','002');
*/

include_once "includes/PollutionCertHandler.inc.php";

$handler = new PollutionCertHandler();

echo $handler->register_pucc('UP15H1517','8','CNG','2016-09-09','2016-12-12','CENTRE001','Checker002',200,1);

?>