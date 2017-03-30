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

	function get_all_challan( $api_key , $type ) {
		
		$success = false;
		$error = "";

		include_once 'includes/UserHandler.inc.php';
		$userHandler = new UserHandler();
		$user_id = $userHandler->get_user_id($api_key);
		
		if($type == "police") {
			$sql = "select * from ".CHALLAN_TABLE_NAME." where issuing_officer_id = '$user_id' ORDER BY challan_id DESC";
		} else {
			$sql = "select * from ".CHALLAN_TABLE_NAME." where user_id = '$user_id' ORDER BY challan_id DESC";
		}
		echo $sql;
		
		if( $result = $this->conn->query($sql) ) {

			if($result->num_rows > 0) {

				$success = true;
				$details =  $result->fetch_array();

			} else {
				$error = "No Challans found.";
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

	function create_challan(
		$registration_number,
		$description,
		$api_key,
		$payment_amount
		) {

		$success=false;
		$error="";

		include_once 'includes/UserHandler.inc.php';
		$userHandler = new UserHandler();
		$userId = $userHandler->get_user_id($api_key);

		$sql = "INSERT INTO ".CHALLAN_TABLE_NAME." (registration_number, challan_description, issuing_officer_id , issue_time, payment_amount) VALUES ('$registration_number', '$description', '$userId', NOW(),'$payment_amount')";
		if( $this->conn->query($sql) )
			$success=true;
		else
			$error = "Could not insert into table";

		if( !$response['success'] = $success ) {
			$response['error']=$error;
		} else {

		}
		return json_encode($response,JSON_PRETTY_PRINT);

	}

	function update_pay_status($challan_id, $payment_method) {

		$success=false;
		$error="";

		$sql = "UPDATE ".CHALLAN_TABLE_NAME." SET payment_method=$payment_method,paid=true WHERE challan_id = '$challan_id'";

		if( $this->conn->query($sql) )
			$success = true;
		else
			$error = "Could not update value";

		if( !$response['success'] = $success ) {
			$response['error'] = $error;
		}
		return json_encode($response,JSON_PRETTY_PRINT);
		
	}

}

?>