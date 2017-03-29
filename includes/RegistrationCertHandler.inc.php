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

		$success = false;
		$error = "";

		$sql = "select * from vehicledetails where RegNo = '$RegNo'";
		
		if( $result = $this->conn->query($sql) ) {

			if($result->num_rows == 1) {
				
				$success = true;
				$details =  $result->fetch_assoc();

			} else if ($result->num_rows == 0) {
				$error = "No Registration Certificate was found.";
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


	function register_vehicle(
		$RegNo,
		$EngineNo,
		$ChassisNo,
		$Manufacturer,
		$Model,
		$YearOfManufacturing,
		$RegDate,
		$RegUpto,
		$FuelType,
		$FuelCapacity,
		$SeatingCapacity,
		$VehicleCategory,
		$WeightCategory,
		$UsageCategory,
		$Color,
		$NoOfCyl,
		$CC,
		$BodyType,
		$OwnerName,
		$OwnerID
		) {

		$success = false;
		$error = "";

		$sql="Insert into vehicledetails values ('$RegNo','$EngineNo','$ChassisNo','$Manufacturer','$Model','$YearOfManufacturing','$RegDate','$RegUpto','$FuelType',$FuelCapacity,$SeatingCapacity,'$VehicleCategory','$WeightCategory','$UsageCategory','$Color',$NoOfCyl,$CC,'$BodyType','$OwnerName','$OwnerID');";

		if ($result = $this->conn->query($sql)){
			$success = true;
			$message = "Vehicle record registered";
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