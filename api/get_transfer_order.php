<?php

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

include('dbconfig.php');

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$warehouse = $request->warehouse;


$transferOrderTable = "transfer_order_".$warehouse."";


$sql = "SELECT * FROM `$transferOrderTable` ORDER BY s_no DESC";
$result = mysqli_query($conn, $sql);
$jsonData = array();

if (mysqli_num_rows($result) > 0) {
// output data of each row
    while($row = mysqli_fetch_assoc($result)) {
    	$jsonData[] = $row;
    }
} 
// else {
// 	$jsonData[] = "Invalid Credentials";
// }

echo json_encode($jsonData);

mysqli_close($conn);
?>