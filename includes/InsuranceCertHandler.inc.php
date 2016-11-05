<?php

include_once "DbHandler.inc.php";

class InsuranceCertHandler extends DbHandler {

	function check_status($RegNo) {

		$success = false;
		$error = "";
		
		$ok = false;
		$message = "";
		
		$sql = "SELECT DATEDIFF(CURDATE(),InsuredUpto) as expiredDaysAgo FROM Insurancedetails WHERE RegNo = '$RegNo'";

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

		$sql = "select * from insurancedetails where RegNo = '$RegNo'";
		$message = "";
		if($result = $this->conn->query($sql)) {

			if($result->num_rows == 1) {

				$row = $result->fetch_assoc();
				$message = "found_success";
				$response['InsuranceID'] = $row['InsuranceID'];
				$response['Validity'] = $row['InsuredUpto'];
				$response['Insurance Type'] = $row['InsType'];
				$response['InsuranceOwner'] = $row['InsuredToID'];
				$response['Coverage'] = $row['Coverage'];
				$response['Insured from'] = "Company:- ".$row['InsCompanyID']. " , By:- ".$row['InsCheckerID'];
				
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

	function register_insCert($RegNo, $InsType, $InsCompanyID,$InsCheckerID, $InsuredOn, $InsuredUpto, $Valuation, $Coverage, $InsuredToID, $InsCost, $LastInsID) {

		$sql="Insert into insurancedetails (RegNo, InsType, InsCompanyID,InsCheckerID, InsuredOn, InsuredUpto, Valuation, Coverage, InsuredToID, InsCost, LastInsID) values ('{$RegNo}','{$InsType}','{$InsCompanyID}','{$InsCheckerID}','{$InsuredOn}','{$InsuredUpto}',{$Valuation},	'{$Coverage}','{$InsuredToID}',{$InsCost},{$LastInsID});";

		if ($res = $this->conn->query($sql)){
			echo "PUCC Record Addition success";
		}
		else{
			echo "There is some error, Recheck the details and try again";
		}

	} 	
}

?>