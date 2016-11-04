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

		$sql = "select * from pollutiondetails where RegNo = '$RegNo'";
		$message = "";
		if($result = $this->conn->query($sql)) {

			if($result->num_rows == 1) {

				$row = $result->fetch_assoc();
				$message = "found_success";
				$response['PUCC_Number'] = $row['PUCCNo'];
				$response['Validity'] = $row['ValidUpto'];
				$response['FuelType'] = $row['FuelType'];
				$response['EngineStroke'] = $row['EngineStroke'];
				$response['Checked From'] = "Center:- ".$row['CentreCode']." , By:- ".$row['pCheckerID'];
				
			}

			else if($result->num_rows == 0){
				$message="No such record found under this RegNo";
			}
			else{
				$message="This is something unusual!";
			}
		}

		else{
			$response['error']="Query error encountered!!";

		}

		if(strcmp($message,"found_success")!=0){
			$response['message'] = $message;
		}


		return json_encode($response, JSON_PRETTY_PRINT);

	}


	function register_pollution() {

		//$sql = "INSERT INTO ";
	}
}

?>