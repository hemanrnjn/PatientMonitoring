<?php

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");


include('dbconfig.php');

 
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

$transfer_item_timestamp = $request->transfer_item_timestamp;
$transfer_item_id = $request->transfer_id;
$transfer_item_name = $request->transfer_item_name;
$transfer_item_type = $request->transfer_item_type;
$transfer_item_hsn_sac = $request->transfer_item_hsn_sac;
$transfer_item_reqby = $request->transfer_item_reqby;
$transfer_item_reqquantity = $request->transfer_item_reqquantity;
$transfer_item_sent = $request->transfer_item_sent;
$transfer_item_from = $request->transfer_item_from;
$transfer_item_rate = $request->transfer_item_rate;
$transfer_item_min_sellingprice = $request->transfer_item_min_sellingprice;
$transfer_item_purchasingprice = $request->transfer_item_purchasingprice;
$transfer_item_tax = $request->transfer_item_tax;
$transfer_item_assignedby_id = $request->transfer_item_assignedby_id;

$transfer_item_reqquantity = (int)$transfer_item_reqquantity;
$transfer_item_sent = (int)$transfer_item_sent;
$transfer_item_rate = (int)$transfer_item_rate;
$transfer_item_min_sellingprice = (int)$transfer_item_min_sellingprice;
$transfer_item_purchasingprice = (int)$transfer_item_purchasingprice;





$demand_item_id = substr($transfer_item_id, 2);
$demand_item_id = "DO".$demand_item_id."";



$updateDemandTable = "demand_order_".$transfer_item_reqby."";



$sql = "UPDATE `$updateDemandTable` SET demand_item_status = 'approved', demand_item_received = '$transfer_item_sent' WHERE demand_id = '$demand_item_id' AND demand_item_hsn_sac = '$transfer_item_hsn_sac'";
mysqli_query($conn, $sql);
// if(mysqli_query($conn2, $sql)) {
// 	echo "Record Inserted";
// }
// else {
// 	echo "Kuch Gadbad h!";
// }


$updateTransferTable = "transfer_order_".$transfer_item_from."";



$sql2 = "UPDATE `$updateTransferTable` SET transfer_item_status = 'approved', transfer_item_sent = '$transfer_item_sent' WHERE transfer_id = '$transfer_item_id' AND transfer_item_hsn_sac = '$transfer_item_hsn_sac'";
mysqli_query($conn, $sql2);
// if(mysqli_query($conn3, $sql2)) {
// 	echo "Record Inserted";
// }
// else {
// 	echo "Kuch Gadbad h!";
// }


$transactionTable = "transaction_".$transfer_item_from."";



$sql3 = "INSERT INTO `$transactionTable` (item_timestamp, item_salesperson, item_name, item_type, item_hsn_sac, item_quantity, item_rate, item_min_sellingprice, item_purchasingprice, item_tax, item_transaction, item_destination)
VALUES ('$transfer_item_timestamp', '$transfer_item_assignedby_id', '$transfer_item_name', '$transfer_item_type', '$transfer_item_hsn_sac', '$transfer_item_sent', '$transfer_item_rate', '$transfer_item_min_sellingprice', '$transfer_item_purchasingprice', '$transfer_item_tax', 'approved', '$transfer_item_reqby')";
mysqli_query($conn, $sql3);




$sql4 = "UPDATE item_table SET `$transfer_item_from` = `$transfer_item_from` - '$transfer_item_sent' WHERE item_name = '$transfer_item_name' AND item_hsn_sac = '$transfer_item_hsn_sac'";
mysqli_query($conn, $sql4);
 



$sql5 = "SELECT * FROM `$updateTransferTable` ORDER BY s_no DESC";
$result = mysqli_query($conn, $sql5);
$jsonData = array();

while($row = mysqli_fetch_assoc($result)) {
    	$jsonData[] = $row;
    }

echo json_encode($jsonData);

// if (mysqli_query($conn, $sql)) {
//     echo "New record created successfully";
// } else {
//     echo "Error: " . $sql . "<br>" . mysqli_error($conn);
// }

mysqli_close($conn);
?>