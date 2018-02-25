<?php

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

include('dbconfig.php');
 
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$user_salutation = $request->user_salutation;
$user_name = $request->user_name;
$user_email = $request->user_email;
$user_password = $request->user_password;
$user_role = $request->user_role;
$user_warehouse = $request->user_warehouse;
$user_address = $request->user_address;
$user_city = $request->user_city;
$user_state = $request->user_state;
$user_zipcode = $request->user_zipcode;
$user_country = $request->user_country;
$user_contact = $request->user_contact;
$user_status = 1;



$sql = "SELECT user_id FROM user_table ORDER BY s_no DESC LIMIT 1";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        $temp_id = $row["user_id"];
    }
    $new_id = substr($temp_id,1) + 1;
    $new_id = 'u'.$new_id.'';
} 
else {
    $new_id = 'u1';
}




$sql2 = "INSERT INTO user_table (user_id, user_salutation, user_name, user_email, user_password, user_role, user_warehouse, user_address, user_city, user_state, user_zipcode, user_country, user_contact, user_status)
VALUES ('$new_id', '$user_salutation', '$user_name', '$user_email', '$user_password', '$user_role', '$user_warehouse', '$user_address', '$user_city', '$user_state', '$user_zipcode', '$user_country', '$user_contact', '$user_status')";


$sql3 = "ALTER TABLE marketingperson_item_table ADD `$new_id` INT(10) NOT NULL DEFAULT 0";

if($user_role == "marketingperson") {
    if(mysqli_query($conn, $sql2) && mysqli_query($conn, $sql3)) {
    	$sql4 = "SELECT * FROM user_table";
    	$result = mysqli_query($conn, $sql4);
    	$jsonData = array();

    	while($row = mysqli_fetch_assoc($result)) {
    	    	$jsonData[] = $row;
    	    }

    	echo json_encode($jsonData);
    }
    else {
    	echo "Error!";
    }
}
else {
    if(mysqli_query($conn, $sql2)) {
        $sql4 = "SELECT * FROM user_table";
        $result = mysqli_query($conn, $sql4);
        $jsonData = array();

        while($row = mysqli_fetch_assoc($result)) {
                $jsonData[] = $row;
            }

        echo json_encode($jsonData);
    }
    else {
        echo "Error!";
    }
}



// if (mysqli_query($conn, $sql)) {
//     echo "New record created successfully";
// } else {
//     echo "Error: " . $sql . "<br>" . mysqli_error($conn);
// }

mysqli_close($conn);
?>