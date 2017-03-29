<?php

include_once 'includes/DbHandler.inc.php';

$DbHandler= new DbHandler();

echo getenv("MYSQLCONNSTR_localdb");

?>