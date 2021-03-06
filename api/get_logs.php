<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

include('dbconfig.php');



$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$warehouse = $request->wh_id;
$page = $request->page;
$transactionTable = "transaction_".$warehouse."";
$offset = ($page - 1)*10;



$sql = "SELECT s_no, item_timestamp, item_salesperson, item_additional_salesperson,item_customer_name, item_destination,item_name, item_quantity,item_hsn_sac, item_transaction FROM `$transactionTable` ORDER BY s_no DESC LIMIT $offset, 10";
$result = mysqli_query($conn, $sql);
$jsonData = array();

if (mysqli_num_rows($result) > 0) {
	    // output data of each row
		 while($row = mysqli_fetch_assoc($result)) {
		        // $final = "Id: " . $row["S.No."]. " - Name: " . $row["Name"]. " - Age " . $row["Age"]. "<br>";
		 $jsonData[] = $row;
		    }
		} else {
		    echo "{'results': 'none'}";
		}

echo json_encode($jsonData);
mysqli_close($conn);
?>