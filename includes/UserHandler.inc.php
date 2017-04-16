<?php

include_once "DbHandler.inc.php";
include_once "Hasher.inc.php";

class UserHandler extends DbHandler {

	function username_exists($username) {

		$sql = "SELECT count(*) as count FROM ".USER_TABLE_NAME." WHERE user_name = '$username'";
		$result = $this->conn->query($sql);
		$count = $result->fetch_assoc()['count'];

		if ( $count > 0 ) 
			return true;
		return false;
	}

	function get_user_id($apikey) {

		$sql = "SELECT user_id FROM ".SESSION_TABLE_NAME." WHERE api_key = '$apikey'";
		
		if( $result = $this->conn->query($sql) ) {
			if( $result->num_rows == 1 ) {
				$user_id = $result->fetch_assoc()['user_id'];
				return $user_id;	
			} else {
				return false;
			}
		}
	}

	function generate_api_key($user_id) {

		// Deleting previous session 

		$sql = "DELETE from ".SESSION_TABLE_NAME." WHERE user_id = '$user_id'";
		
		if ( $this->conn->query($sql) ) {
			
			// Creating new session
			$sql = "INSERT INTO ".SESSION_TABLE_NAME." (api_key,user_id) VALUES ('','$user_id') ";

			if( $this->conn->query($sql) ) {	

				$api_key = Hasher::encrypt($this->conn->query("SELECT api_id FROM ".SESSION_TABLE_NAME." WHERE user_id='$user_id'")->fetch_assoc()['api_id']);

				$sql = "UPDATE ".SESSION_TABLE_NAME." SET api_key = '$api_key' WHERE user_id='$user_id'";

				if( $this->conn->query($sql) )
					return $api_key;
			}
		}
		return false;
	}

	function check_login($username,$password) {
		
		$success=false;
		$error="";
		$user_data = array();

		$pass_hash = Hasher::encrypt($password);

		$sql = "SELECT user_id,full_name,type FROM ".USER_TABLE_NAME." WHERE user_name='$username' AND password='$pass_hash'";
		
		if( $result = $this->conn->query($sql) ) {
			
			if( $result->num_rows == 0 ) {
				$error = "Username for password is invalid.";
			} else if ( $result->num_rows > 1 ) {
				$error = "Multiple users with same credentials. This will not happen.";
			} else {
				$user_data['user_name'] = "$username";
				$user_data = $result->fetch_assoc();
				if(empty($user_data['type']) || $user_data == 'null')
					$user_data['type']="user";
				$api_key = $this->generate_api_key($user_data['user_id']);
				if($api_key)
					$user_data['api_key'] = $api_key;
				$success=true;
			}

		} else {
			$error = "Error executing query";
		}
		
		if( $response['success'] = $success ) {
			$response['user_data'] = $user_data;
		} else {
			$response['error']=$error;
		}
		return json_encode($response,JSON_PRETTY_PRINT);
	}

	function create_user($username,$password,$fullname) {

		$success=false;
		$error="";

		$pass_hash = Hasher::encrypt($password);

		if( $this->username_exists($username) ){
			$error = "Username already exists.";
		} else {
			$sql = "INSERT INTO ".USER_TABLE_NAME." (user_name,full_name,password) VALUES ('$username','$fullname','$pass_hash')";
			if( $this->conn->query($sql) )
				$success=true;
			else
				$error = "Could not insert into table";
		}

		if( !$response['success'] = $success ) {
			$response['error']=$error;
		}
		return json_encode($response,JSON_PRETTY_PRINT);
	}

	function update_profile($key,$value,$api_key) {
		
		$success=false;
		$error="";

		if( $user_id = $this->get_user_id($api_key) ) {

			$sql = "UPDATE ".USER_TABLE_NAME." SET $key=$value WHERE user_id = '$user_id'";

			if( $this->conn->query($sql) )
				$success = true;
			else
				$error = "Could not update value";

		} else {
			$error = "Session expired. Please logout and login again.";
		}

		if( !$response['success'] = $success ) {
			$response['error'] = $error;
		}
		return json_encode($response,JSON_PRETTY_PRINT);
	}

	function get_vehicles($api_key) {
		$success = false;
		$error = "";

		if( $user_id = $this->get_user_id($api_key) ) {

			$sql = "SELECT RegNo FROM ".RC_TABLE_NAME." WHERE OwnerID = '$user_id'";

			echo $sql;

			if( $result = $this->conn->query($sql) ) {
				
				$success = true;
				$number = $result->num_rows;
				$i=0;
				while($row = $result->fetch_assoc()) {
					$vehicles[$i++]['RegNo'] = $row['RegNo'];
				}
			}
			else
				$error = "SQL query is incorrect";

		} else {
			$error = "Session expired. Please logout and login again. ".$api_key;
		}

		if( $response['success'] = $success ) {

			$response['count']=$number;
			$response['vehicles'] = $vehicles;

		} else {
			$response['error']=$error;
		}
		return json_encode($response,JSON_PRETTY_PRINT);
	}

}