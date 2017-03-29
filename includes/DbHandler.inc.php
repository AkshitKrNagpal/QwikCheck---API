<?php

include_once "config.inc.php";

define("USER_TABLE_NAME"	,"users"		 	);
define("RC_TABLE_NAME"		,"vehicle_details"	);
define("INS_TABLE_NAME"		,"insurance_details");
define("PUCC_TABLE_NAME"	,"pollution_details");
define("SESSION_TABLE_NAME"	,"session_api"		);
define("CHALLAN_TABLE_NAME"	,"challan"			);

class DbHandler {

	protected $conn;

	public function __construct() {
		$this->conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
		if($this->conn->error) {
			die("Error connecting to database");
		}
	}

	public function __destruct() {
		$this->conn->close();
	}

}