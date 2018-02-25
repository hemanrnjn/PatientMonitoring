<?php

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

include('dbconfig.php');

 
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$warehouse = $request->warehouse;


$transactionTable = "transaction_".$warehouse."";


$sql = "SELECT * FROM `$transactionTable` WHERE item_transaction = 'sold' ORDER BY s_no DESC";
$result = mysqli_query($conn, $sql);
$jsonData = array();
// if(mysqli_query($conn2, $sql)) {
// 	echo "Record Inserted";
// }
// else {
// 	echo "Kuch Gadbad h!";
// }

while($row = mysqli_fetch_assoc($result)) {
    	$jsonData[] = $row;
}

echo json_encode($jsonData);


mysqli_close($conn);
?>