<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");


include('dbconfig.php');

 
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$user_email = $request->user_email;
$user_status = $request->user_status;
$user_role = $request->user_role;

if($user_status) {
	$user_status = 1;
}
else {
	$user_status = 0;
}


$sql = "UPDATE user_table SET user_status = '$user_status' WHERE user_email = '$user_email'";


if(mysqli_query($conn, $sql)) {
	if($user_role == 'whmanager') {
	    $sql2 = "SELECT user_name, user_email, user_warehouse, user_address, user_contact, user_status FROM user_table WHERE user_role = 'whmanager'";
	    $result = mysqli_query($conn, $sql2);
	    $jsonData = array();
	    while($row = mysqli_fetch_assoc($result)) {
	    	if($row["user_status"] == "1") {
        		$row["user_status"] = true;
        	}
        	else {
        		$row["user_status"] = false;
        	}
	            $jsonData[] = $row;
	        }
	    echo json_encode($jsonData);
	}
	else if($user_role == 'marketingperson') {
		$sql2 = "SELECT user_name, user_email, user_warehouse, user_address, user_city, user_state, user_zipcode, user_country, user_contact, user_status FROM user_table WHERE user_role = 'marketingperson'";
	    $result = mysqli_query($conn, $sql2);
	    $jsonData = array();
	    while($row = mysqli_fetch_assoc($result)) {
	    		if($row["user_status"] == "1") {
	        		$row["user_status"] = true;
	        	}
	        	else {
	        		$row["user_status"] = false;
	        	}
	            $jsonData[] = $row;
	        }
	    echo json_encode($jsonData);
	}
	else if($user_role == 'officeperson') {
		$sql2 = "SELECT user_name, user_email, user_warehouse, user_address, user_city, user_state, user_zipcode, user_country, user_contact, user_status FROM user_table WHERE user_role = 'officeperson'";
	    $result = mysqli_query($conn, $sql2);
	    $jsonData = array();
	    while($row = mysqli_fetch_assoc($result)) {
	    		if($row["user_status"] == "1") {
	        		$row["user_status"] = true;
	        	}
	        	else {
	        		$row["user_status"] = false;
	        	}
	            $jsonData[] = $row;
	        }
	    echo json_encode($jsonData);
	}
}
else {
    echo "Error!";
}


mysqli_close($conn);
?>