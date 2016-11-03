<?php

include_once "config.inc.php";

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