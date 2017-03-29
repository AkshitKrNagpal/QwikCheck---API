<?php

include_once "DbHandler.inc.php";

class InsuranceCertHandler extends DbHandler {

	function check_status($RegNo) {

		$success = false;
		$error = "";
		
		$ok = false;
		$message = "";
		
		$sql = "SELECT DATEDIFF(CURDATE(),InsuredUpto) as expiredDaysAgo FROM ".INS_TABLE_NAME." WHERE RegNo = '$RegNo'";

		if( $result = $this->conn->query($sql) ) {
			
			if( $result->num_rows == 1 ) {

				$success = true;

				$row = $result->fetch_assoc();

				if( $row['expiredDaysAgo'] > 0 ) {
					$days = $row['expiredDaysAgo'];
					$message = "Insurance Certificate expired $days days ago. ";
				} else {
					$ok = true;
					$message = "Insurance certificate is fine. ";
				}

			} else if ($result->num_rows == 0){
				$success = true;
				$message = "No Insurance Certificate was found.";
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

	function ins_details($RegNo){

		$success = false;
		$error = "";

		$sql = "SELECT * from ".INS_TABLE_NAME." WHERE RegNo = '$RegNo'";

		if( $result = $this->conn->query($sql) ) {

			if($result->num_rows == 1) {
				
				$success = true;
				$details =  $result->fetch_assoc();

			} else if ($result->num_rows == 0) {
				$error = "No Insurance Certificate was found.";
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

	function register_insCert($RegNo, $InsType, $InsCompanyID,$InsCheckerID, $InsuredOn, $InsuredUpto, $Valuation, $Coverage, $InsuredToID, $InsCost, $LastInsID) {

		$success = false;
		$error = "";

		$sql="Insert into ".INS_TABLE_NAME." (RegNo, InsType, InsCompanyID,InsCheckerID, InsuredOn, InsuredUpto, Valuation, Coverage, InsuredToID, InsCost, LastInsID) values ('$RegNo','$InsType','$InsCompanyID','$InsCheckerID','$InsuredOn','$InsuredUpto','$Valuation','$Coverage','$InsuredToID',$InsCost,$LastInsID)";

		if ($result = $this->conn->query($sql)){
			$success = true;
			$message = "Insurance record registered";
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