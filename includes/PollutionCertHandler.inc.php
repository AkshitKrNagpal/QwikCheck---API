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

	function pucc_details($RegNo){

		$success = false;
		$error = "";
		
		$sql = "SELECT * from pollutiondetails where RegNo = '$RegNo'";
		

		if( $result = $this->conn->query($sql) ) {

			if($result->num_rows == 1) {
				
				$success = true;
				$details =  $result->fetch_assoc();

			} else if ($result->num_rows == 0) {
				$error = "No Pollution Certificate was found.";
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


	function register_pucc($RegNo, $EngineStroke, $FuelType,$CheckedOn, $ValidUpto, $CentreCode, $pCheckerID, $CostPUCC, $LastPUCCNo) {

		$success = false;
		$error = "";

		$sql="Insert into pollutiondetails (RegNo, EngineStroke, FuelType,CheckedOn, ValidUpto, CentreCode, pCheckerID, CostPUCC, LastPUCCNo) values ('$RegNo','$EngineStroke','$FuelType','$CheckedOn','$ValidUpto','$CentreCode','$pCheckerID',$CostPUCC,$LastPUCCNo);";

		if ($result = $this->conn->query($sql)){
			$success = true;
			$message = "Pollution record registered";
		} else {
			$error = "The sql query was not valid.";
		}

		if( $response['success'] = $success ) {
			$response['message'] = $message;
		} else {
			$response['error'] = $error;
		}

		return json_encode($response, JSON_PRETTY_PRINT);
	}
}

?>