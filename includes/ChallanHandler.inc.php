<?php

include_once "DbHandler.inc.php";

class ChallanHandler extends DbHandler {

	function get_challan_details( $challan_id ) {

		$success = false;
		$error = "";

		$sql = "select * from ".CHALLAN_TABLE_NAME." where challan_id = '$challan_id'";
		
		if( $result = $this->conn->query($sql) ) {

			if($result->num_rows == 1) {
				
				$success = true;
				$details =  $result->fetch_assoc();

			} else if ($result->num_rows == 0) {
				$error = "No challan was found with id $challan_id.";
			} else {
				$error = "Something went wrong. It should not happen.";
			}

		} else {
			$error = "Sql query is incorrect";
		}

		if( $response['success'] = $success ) {
			$response['details'] = $details;
		} else {
			$response['error'] = $error; 
		}

		return json_encode($response, JSON_PRETTY_PRINT);
	}

}

?>