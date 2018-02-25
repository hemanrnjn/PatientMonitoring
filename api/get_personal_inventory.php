<?php

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

include('dbconfig.php');

 
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$warehouse = $request->warehouse;
$email = $request->email;
$id = $request->id;



$sql = "SELECT item_type, item_name, item_hsn_sac, item_sellingprice, item_min_sellingprice, item_purchasingprice, item_tax, `$id`  FROM marketingperson_item_table WHERE `$id` != 0";

if(mysqli_query($conn, $sql)) {
	$result = mysqli_query($conn, $sql);
	$jsonData = array();

	while($row = mysqli_fetch_assoc($result)) {
    	$jsonData[] = $row;
	}

	echo json_encode($jsonData);
}
else {
	echo "Kuch Gadbad h!";
}



mysqli_close($conn);
?>