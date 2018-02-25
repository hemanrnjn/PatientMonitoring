<?php

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

include('dbconfig.php');
 
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$wh_warehouse_name = $request->wh_warehouse_name;
$wh_email = $request->wh_email;
$wh_address = $request->wh_address;
$wh_contact = $request->wh_contact;




$sql = "SELECT wh_id FROM warehouse_status ORDER BY s_no DESC LIMIT 1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if($row['wh_id'] == "") {
	$new_id = 'wh001';
}
else {
	$splice = (int)substr($row['wh_id'], 2);
	$splice_str = (string)$splice;
	if(strlen($splice_str) == 1) {
		$append = "wh00";
	}
	else if(strlen($splice_str) == 2) {
		$append = "wh0";
	}
	else {
		$append = "wh";
	}
	$splice++;
	$new_str = (string)$splice;
	$new_id = $append . "" . $new_str;
}


$sql2 = "INSERT INTO warehouse_status (wh_id, wh_status)
VALUES ('$new_id', '1')";
mysqli_query($conn, $sql2);
// if(mysqli_query($conn, $sql2)) {
// 	echo "Record Inserted status wale me";
// }
// else {
// 	echo "Kuch Gadbad h status dalne me!";
// }

$sql3 = "INSERT INTO warehouse_table (wh_id, wh_warehouse_name, wh_email, wh_address, wh_contact)
VALUES ('$new_id', '$wh_warehouse_name', '$wh_email','$wh_address', '$wh_contact')";
mysqli_query($conn, $sql3);
// if(mysqli_query($conn, $sql3)) {
// 	echo "Record Inserted table wale me";
// }
// else {
// 	echo "Kuch Gadbad h table dalne me!";
// }

$demandtablename = "demand_order_".$new_id."";
$transfertablename = "transfer_order_".$new_id."";
$transactiontablename = "transaction_".$new_id."";

$sql4 = "CREATE TABLE `$demandtablename` (s_no INT(10) NOT NULL AUTO_INCREMENT, demand_id VARCHAR(20) NOT NULL, demand_item_type VARCHAR(20) NOT NULL, demand_item_name VARCHAR(50) NOT NULL, demand_item_hsn_sac VARCHAR(20) NOT NULL, demand_item_reqfrom VARCHAR(10) NOT NULL, demand_item_quantity INT(10) NOT NULL, demand_item_status VARCHAR(20) NOT NULL, demand_item_received INT(10) NOT NULL, PRIMARY KEY(s_no))";
mysqli_query($conn, $sql4);

$sql5 = "CREATE TABLE `$transfertablename` (s_no INT(10) NOT NULL AUTO_INCREMENT, transfer_id VARCHAR(20) NOT NULL, transfer_item_type VARCHAR(20) NOT NULL, transfer_item_name VARCHAR(50) NOT NULL, transfer_item_hsn_sac VARCHAR(20) NOT NULL, transfer_item_reqby VARCHAR(10) NOT NULL, transfer_item_reqquantity INT(10) NOT NULL, transfer_item_status VARCHAR(20) NOT NULL, transfer_item_sent INT(10) NOT NULL, PRIMARY KEY(s_no))";
mysqli_query($conn, $sql5);

$sql6 = "CREATE TABLE `$transactiontablename` (
  s_no int(10) NOT NULL AUTO_INCREMENT,
  item_timestamp datetime DEFAULT NULL,
  item_invoice_number varchar(30) DEFAULT NULL,
  item_salesperson varchar(30) DEFAULT NULL,
  item_salesperson_email varchar(50) DEFAULT NULL,
  item_additional_salesperson varchar(50) DEFAULT NULL,
  item_customer_name varchar(30) DEFAULT NULL,
  item_customer_contact varchar(20) DEFAULT NULL,
  item_name varchar(30) NOT NULL,
  item_type varchar(30) NOT NULL,
  item_hsn_sac varchar(30) NOT NULL,
  item_quantity int(10) NOT NULL,
  item_rate int(10) NOT NULL,
  item_discount int(10) DEFAULT NULL,
  item_discount_type varchar(5) DEFAULT NULL,
  item_min_sellingprice int(10) DEFAULT NULL,
  item_purchasingprice int(10) NOT NULL,
  item_tax varchar(10) NOT NULL,
  item_tax_type tinyint(1) NOT NULL DEFAULT 0,
  item_amount int(10) DEFAULT NULL,
  item_transaction varchar(10) NOT NULL,
  item_destination varchar(10) DEFAULT NULL,
  item_invoice_amount int(10) DEFAULT NULL,
  item_invoice_edited tinyint(1) NOT NULL DEFAULT 0,
  item_invoice_shippingcharge int(10) DEFAULT NULL,
  item_invoice_adjustments int(10) DEFAULT NULL,
  item_invoice_adjustments_name varchar(30) DEFAULT NULL,
  item_details varchar(200) DEFAULT NULL,
  PRIMARY KEY(s_no))";
mysqli_query($conn, $sql6);


$sql7 = "ALTER TABLE item_table ADD `$new_id` INT(10) NOT NULL DEFAULT 0";
mysqli_query($conn, $sql7);

$sql8 = "UPDATE item_table SET `$new_id` = 100000 WHERE item_type = 'service'";
mysqli_query($conn, $sql8);
$sql9 = "SELECT * FROM warehouse_table";
$result2 = mysqli_query($conn, $sql9);
$jsonData = array();


while($row = mysqli_fetch_assoc($result2)) {
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