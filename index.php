<?php

// Check if logged in
if( isset($_POST['api_key'])) {

	if( isset($_POST['challan_id']) ) {

		include_once 'includes/ChallanHandler.inc.php';
		$challanHandler = new ChallanHandler();
			
		if( isset($_POST['payment_method']) ) {
			echo $challanHandler->update_pay_status($_POST['challan_id'],$_POST['payment_method']);
		} else {
			echo $challanHandler->get_challan_details($_POST['challan_id']);
		}

	}

	if( isset($_POST['get']) ) {

		if( $_POST['get'] == "my_challans") {
			include_once 'includes/ChallanHandler.inc.php';
			$challanHandler = new ChallanHandler();
			echo $challanHandler->get_all_challan($_POST['api_key']);
		}

		if( $_POST['get'] == "my_vehicles" ) {

			include_once 'includes/UserHandler.inc.php';
			$userHandler = new UserHandler();
			echo $userHandler->get_vehicles($_POST['api_key']);

		}

	} 
	if( isset($_POST['register']) ) {

		if( $_POST['register'] == "RC" ) {

			include_once 'includes/RegistrationCertHandler.inc.php';
			$handler = new RegistrationCertHandler();
			echo $handler->register_vehicle(
				$_POST['regno'],
				$_POST['engineno'],
				$_POST['chassisno'],
				$_POST['manufacturer'],
				$_POST['model'],
				$_POST['year'],
				$_POST['regdate'],
				$_POST['regupto'],
				$_POST['fueltype'],
				$_POST['fuelcapacity'],
				$_POST['seatingcapacity'],
				$_POST['category'],
				$_POST['weightcategory'],
				$_POST['usagecategory'],
				$_POST['color'],
				$_POST['noofcyl'],
				$_POST['cc'],
				$_POST['bodytype'],
				$_POST['ownername'],
				$_POST['ownerid']
				);
		} 
		else if( $_POST['register'] == "INS" ) {

			include_once 'includes/InsuranceCertHandler.inc.php';
			$handler = new InsuranceCertHandler();
			echo $handler->register_insCert(
				$_POST['regno'],
				$_POST['instype'],
				$_POST['inscompanyid'],
				$_POST['inscheckerid'],
				$_POST['insuredon'],
				$_POST['insuredupto'],
				$_POST['valuation'],
				$_POST['coverage'],
				$_POST['insuredtoid'],
				$_POST['inscost'],
				$_POST['lastinsid']
				);
		} 
		else if( $_POST['register'] == "PUCC" ) {

			include_once 'includes/PollutionCertHandler.inc.php';
			$handler = new PollutionCertHandler();
			echo $handler->register_pucc(
				$_POST['regno'],
				$_POST['enginestroke'],
				$_POST['fueltype'],
				$_POST['checkedon'],
				$_POST['validupto'],
				$_POST['centrecode'],
				$_POST['pcheckerid'],
				$_POST['costpucc'],
				$_POST['lastpuccno']
				);
		} 


	} else if( isset($_POST['details']) && isset($_POST['vehicle_number']) ) {

		if( $_POST['details'] == "RC" ) {

			include_once 'includes/RegistrationCertHandler.inc.php';
			echo (new RegistrationCertHandler())->rc_details($_POST['vehicle_number']);

		} else if( $_POST['details'] == "INS" ) {

			include_once 'includes/InsuranceCertHandler.inc.php';
			echo (new InsuranceCertHandler())->ins_details($_POST['vehicle_number']);

		} else if( $_POST['details'] == "PUCC" ) {

			include_once 'includes/PollutionCertHandler.inc.php';
			echo (new PollutionCertHandler())->pucc_details($_POST['vehicle_number']);

		}

	} else if( isset($_POST['vehicle_number']) ) {

		if( isset($_POST['description']) && isset($_POST['payment_amount']) ) {

			include_once 'includes/ChallanHandler.inc.php';
			$challanHandler = new ChallanHandler();

			echo $challanHandler->create_challan($_POST['vehicle_number'],$_POST['description'],$_POST['api_key'], $_POST['payment_amount']);

		} else {

			include_once 'includes/RegistrationCertHandler.inc.php';
			include_once 'includes/InsuranceCertHandler.inc.php';
			include_once 'includes/PollutionCertHandler.inc.php';
		
			$rc_details = trim((new RegistrationCertHandler())->check_status($_POST['vehicle_number']));
			$ins_details = trim((new InsuranceCertHandler())->check_status($_POST['vehicle_number']));
			$poll_details = trim((new PollutionCertHandler())->check_status($_POST['vehicle_number']));

			echo json_encode(json_decode('{ "rc_details" : '.$rc_details.', "ins_details" : '.$ins_details.', "poll_details" : '.$poll_details.'}'),JSON_PRETTY_PRINT);

		}
	} 

} else {

	include_once 'includes/UserHandler.inc.php';
	$userHandler = new UserHandler();

	// Registration API
	if( isset($_POST['username']) && isset($_POST['fullname']) && isset($_POST['password']) ) {
		echo $userHandler->create_user($_POST['username'],$_POST['password'],$_POST['fullname']);
	} 
	// Login API
	if( isset($_POST['username']) && isset($_POST['password']) ) {
		echo $userHandler->check_login($_POST['username'],$_POST['password']);
	}
}

?>