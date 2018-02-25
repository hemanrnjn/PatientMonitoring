<?php

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");


include('dbconfig.php');


$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

$confirm_demand_item_timestamp = $request->confirm_demand_item_timestamp;
$confirm_demand_item_id = $request->confirm_demand_item_id;
$confirm_demand_item_from = $request->confirm_demand_item_from;
$confirm_demand_item_reqfrom = $request->confirm_demand_item_reqfrom;
$confirm_demand_item_type = $request->confirm_demand_item_type;
$confirm_demand_item_name = $request->confirm_demand_item_name;
$confirm_demand_item_hsn_sac = $request->confirm_demand_item_hsn_sac;
$confirm_demand_item_rate = $request->confirm_demand_item_rate;
$confirm_demand_item_min_sellingprice = $request->confirm_demand_item_min_sellingprice;
$confirm_demand_item_purchasingprice = $request->confirm_demand_item_purchasingprice;
$confirm_demand_item_tax = $request->confirm_demand_item_tax;
$confirm_demand_item_quantity = $request->confirm_demand_item_quantity;
$confirm_demand_item_assignedby_id = $request->confirm_demand_item_assignedby_id;



$transfer_item_id = substr($confirm_demand_item_id, 2);
$transfer_item_id = "TO".$transfer_item_id."";





$updateDemandTable = "demand_order_".$confirm_demand_item_from."";


$sql = "UPDATE `$updateDemandTable` SET demand_item_status = 'confirmed' WHERE demand_id = '$confirm_demand_item_id' AND demand_item_hsn_sac = '$confirm_demand_item_hsn_sac'";
mysqli_query($conn, $sql);
// if(mysqli_query($conn2, $sql)) {
// 	echo "Record Inserted";
// }
// else {
// 	echo "Kuch Gadbad h!";
// }

$updateTransferTable = "transfer_order_".$confirm_demand_item_reqfrom."";


$sql2 = "UPDATE `$updateTransferTable` SET transfer_item_status = 'confirmed' WHERE transfer_id = '$transfer_item_id' AND transfer_item_hsn_sac = '$confirm_demand_item_hsn_sac'";
mysqli_query($conn, $sql2);
// if(mysqli_query($conn3, $sql2)) {
// 	echo "Record Inserted";
// }
// else {
// 	echo "Kuch Gadbad h!";
// }



$transactionTable = "transaction_".$confirm_demand_item_from."";


$sql3 = "INSERT INTO `$transactionTable` (item_timestamp, item_salesperson, item_name, item_type, item_hsn_sac, item_quantity, item_rate, item_min_sellingprice, item_purchasingprice, item_tax, item_transaction, item_destination)
VALUES ('$confirm_demand_item_timestamp', '$confirm_demand_item_assignedby_id', '$confirm_demand_item_name', '$confirm_demand_item_type', '$confirm_demand_item_hsn_sac', '$confirm_demand_item_quantity', '$confirm_demand_item_rate', '$confirm_demand_item_min_sellingprice', '$confirm_demand_item_purchasingprice', '$confirm_demand_item_tax', 'confirmed', '$confirm_demand_item_reqfrom')";
mysqli_query($conn, $sql3);



$sql4 = "UPDATE item_table SET `$confirm_demand_item_from` = `$confirm_demand_item_from` + '$confirm_demand_item_quantity' WHERE item_name = '$confirm_demand_item_name' AND item_hsn_sac = '$confirm_demand_item_hsn_sac'";
mysqli_query($conn, $sql4);



$sql4 = "SELECT * FROM `$updateDemandTable` ORDER BY s_no DESC";
$result = mysqli_query($conn, $sql4);
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