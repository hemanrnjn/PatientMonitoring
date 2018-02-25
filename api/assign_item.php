<?php

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");


include('dbconfig.php');

 
$postdata = file_get_contents("php://input");
$request = json_decode($postdata, TRUE);

for($i = 0; $i< count($request); $i++) {

	$item_timestamp = $request[$i]["item_timestamp"];
	$item_marketingperson_id = $request[$i]["item_marketingperson_id"];
	$item_marketingperson_name = $request[$i]["item_marketingperson_name"];
	$item_marketingperson_email = $request[$i]["item_marketingperson_email"];
	$item_assignedby = $request[$i]["item_assignedby"];
	$item_assignedby_id = $request[$i]["item_assignedby_id"];
	$item_assignedby_email = $request[$i]["item_assignedby_email"];
	$item_name = $request[$i]["item_name"];
	$item_type = $request[$i]["item_type"];
	$item_hsn_sac = $request[$i]["item_hsn_sac"];
	$item_rate = $request[$i]["item_rate"];
	$item_min_sellingprice = $request[$i]["item_min_sellingprice"];
	$item_purchasingprice = $request[$i]["item_purchasingprice"];
	$item_tax = $request[$i]["item_tax"];
	$item_quantity = $request[$i]["item_quantity"];
	$item_details = $request[$i]["item_details"];
	$item_warehouse = $request[$i]["item_warehouse"];
	$item_transaction = $request[$i]["item_transaction"];

	$item_rate = (int)$item_rate;
	$item_min_sellingprice = (int)$item_min_sellingprice;
	$item_purchasingprice = (int)$item_purchasingprice;




	$sql = "INSERT INTO marketingperson_inventory (item_timestamp, item_marketingperson_id, item_marketingperson_name, item_marketingperson_email, item_assignedby, item_assignedby_id, item_assignedby_email, item_name, item_type, item_hsn_sac, item_quantity, item_rate, item_min_sellingprice, item_purchasingprice, item_warehouse, item_transaction, item_details)
	VALUES ('$item_timestamp', '$item_marketingperson_id', '$item_marketingperson_name', '$item_marketingperson_email', '$item_assignedby','$item_assignedby_id' ,'$item_assignedby_email', '$item_name', 'product', '$item_hsn_sac', '$item_quantity', '$item_rate', '$item_min_sellingprice', '$item_purchasingprice', '$item_warehouse', 'assigned', '$item_details')";
	if(!mysqli_query($conn, $sql)) {
		echo 'Marketing Person Inventory Error';
	}


	$transactionTable = "transaction_".$item_warehouse."";

	$sql2 = "INSERT INTO `$transactionTable` (item_timestamp, item_salesperson, item_salesperson_email, item_name, item_type, item_hsn_sac, item_quantity, item_rate, item_min_sellingprice, item_purchasingprice, item_tax, item_destination, item_transaction, item_details)
	VALUES ('$item_timestamp', '$item_assignedby_id', '$item_assignedby_email', '$item_name', 'product', '$item_hsn_sac', '$item_quantity', '$item_rate', '$item_min_sellingprice', '$item_purchasingprice', '$item_tax', '$item_marketingperson_id', 'assigned', '$item_details')";
	if(!mysqli_query($conn, $sql2)) {
		echo 'Warehouse Transaction Error';
	}




	$sql3 = "UPDATE item_table SET `$item_warehouse` = `$item_warehouse` - '$item_quantity' WHERE item_name = '$item_name' AND item_hsn_sac = '$item_hsn_sac'";
	// mysqli_query($conn, $sql2);
	if(!mysqli_query($conn, $sql3)) {
		echo 'Item Table Error';
	}




	
    $sql4 = "UPDATE marketingperson_item_table SET `$item_marketingperson_id` = `$item_marketingperson_id` + '$item_quantity' WHERE item_name = '$item_name' AND item_hsn_sac = '$item_hsn_sac'";
    if(!mysqli_query($conn, $sql4)) {
		echo 'Marketing Person Item Table Error';
	}


	// if (mysqli_query($conn, $sql) && mysqli_query($conn, $sql2) && mysqli_query($conn, $sql3)) {
	//     echo "New record created successfully";
	// } else {
	//     echo "Error= " . $sql . "<br>" . mysqli_error($conn);
	// }

}


$sql5 = "SELECT * FROM item_table";
$result2 = mysqli_query($conn, $sql5);
$jsonData = array();
while($row = mysqli_fetch_assoc($result2)) {
        $jsonData[] = $row;
    }
echo json_encode($jsonData);


// $sql5 = "SELECT * FROM `$updateTransferTable`";
// $result = mysqli_query($conn, $sql5);
// $jsonData = array();

// while($row = mysqli_fetch_assoc($result)) {
//     	$jsonData[] = $row;
//     }

// echo json_encode($jsonData);

// if (mysqli_query($conn, $sql)) {
//     echo "New record created successfully";
// } else {
//     echo "Error= " . $sql . "<br>" . mysqli_error($conn);
// }

mysqli_close($conn);
?>