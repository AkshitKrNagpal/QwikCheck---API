<?php

$contents = explode(';',getenv("MYSQLCONNSTR_localdb") );

define("DB_HOST", explode('=',$contents[1])[1]);
define("DB_USER", explode('=',$contents[2])[1]);
define("DB_PASS", explode('=',$contents[3])[1]);
define("DB_NAME","qwikcheck");

echo DB_USER . DB_NAME . DB_HOST . DB_PASS;

define("ROOT","http://localhost");

define("ENC_KEY","AKNVSVS");
?>