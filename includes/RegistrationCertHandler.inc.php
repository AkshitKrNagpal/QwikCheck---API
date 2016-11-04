<?php

include_once "DbHandler.inc.php";

class RegistrationCertHandler extends DbHandler {

	function check_status($RegNo) {

		$success = false;
		$error = "";
		
		$ok = false;
		$message = "";
		
		$sql = "SELECT DATEDIFF(CURDATE(),RegUpto) as expiredDaysAgo FROM vehicledetails WHERE RegNo = '$RegNo'";

		if( $result = $this->conn->query($sql) ) {
			
			if( $result->num_rows == 1 ) {

				$success = true;

				$row = $result->fetch_assoc();

				if( $row['expiredDaysAgo'] > 0 ) {
					$days = $row['expiredDaysAgo'];
					$message = "Registration Certificate expired $days days ago. ";
				} else {
					$ok = true;
					$message = "Registration certificate is fine. ";
				}

			} else if ($result->num_rows == 0){
				$success = true;
				$message = "No Registration Certificate was found.";
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

	function rc_details($RegNo){

		$sql = "select * from vehicledetails where RegNo = '$RegNo'";
		$message = "";
		if($result = $this->conn->query($sql)) {

			if($result->num_rows == 1) {

				$row = $result->fetch_assoc();
				$message = "found_success";
				$response['RegistrationNo'] = $RegNo;
				$response['Owner'] = $row['OwnerName'] . " :- " .$row['OwnerID'];
				$response['EngineNo'] = $row['EngineNo'];
				$response['ChassisNo'] = $row['ChassisNo'];
				$response['Vehicle'] = $row['Manufacturer'] ." , ".$row['Model']." , ".$row['YearOfManufacturing']." , ".
										$row['Color']." , ".$row['CC']."CC , ".$row['NoOfCyl']." cyl";
				$response['UsageCategory'] = $row['UsageCategory']." , ".$row['BodyType']." , ".$row['WeightCategory']."kg";
				$response['Fuel'] = $row['FuelType'] . " , ". $row['FuelCapacity']." litre ";
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


	function register_vehicle() {

		//$sql = "INSERT INTO ";
	}
}

?>