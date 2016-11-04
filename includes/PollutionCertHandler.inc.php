<?php

include_once "DbHandler.inc.php";

class PollutionCertHandler extends DbHandler {

	function check_status($RegNo) {

		$success = false;
		$error = "";
		
		$ok = false;
		$message = "";
		
		$sql = "SELECT DATEDIFF(CURDATE(),ValidUpto) as expiredDaysAgo FROM pollutiondetails WHERE RegNo = '$RegNo'";

		if( $result = $this->conn->query($sql) ) {
			
			if( $result->num_rows == 1 ) {

				$success = true;

				$row = $result->fetch_assoc();

				if( $row['expiredDaysAgo'] > 0 ) {
					$days = $row['expiredDaysAgo'];
					$message = "Pollution Certificate expired $days days ago. ";
				} else {
					$ok = true;
					$message = "Pollution certificate is fine. ";
				}

			} else if ($result->num_rows == 0){
				$success = true;
				$message = "No Pollution Certificate was found.";
			} else { 
				$error = "Something went wrong. It should not happen.";
			}
		} else {
			$error = "Sql query is incorrect";
		}

		if(  $response['success'] = $success) {
			$response['ok'] = $ok;
			$response['message'] = $message;
		} else {
			$response['error']= $error;
		}

		return json_encode($response);
	} 

	function register_vehicle() {

		//$sql = "INSERT INTO ";
	}
}

?>