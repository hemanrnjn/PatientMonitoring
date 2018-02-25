<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

include('dbconfig.php');

$sql = "SELECT user_name, user_id, user_role, user_email, user_warehouse, user_address, user_contact, user_status FROM user_table WHERE user_role = 'whmanager'";

$result = mysqli_query($conn, $sql);
$jsonData = array();

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        // $final = "Id: " . $row["S.No."]. " - Name: " . $row["Name"]. " - Age " . $row["Age"]. "<br>";
        if($row["user_status"] == "1") {
        	$row["user_status"] = true;
        }
        else {
        	$row["user_status"] = false;
        }
        $jsonData[] = $row;
    }
} else {
    echo "0 results";
}

echo json_encode($jsonData);

mysqli_close($conn);
?>