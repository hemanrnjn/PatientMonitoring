<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

include('dbconfig.php');



$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$startDate = $request->startDate;
$endDate = $request->endDate;


$sql = "SELECT wh_id FROM warehouse_table";
$result = mysqli_query($conn, $sql);
$jsonData = array();
$finalData = array();
$sold = "sold";

if (mysqli_num_rows($result) > 0) {
	    // output data of each row
		 while($row = mysqli_fetch_assoc($result)) {
		        // $final = "Id: " . $row["S.No."]. " - Name: " . $row["Name"]. " - Age " . $row["Age"]. "<br>";
		 $jsonData[] = $row;
		    }
		} else {
		    echo "0 upar";
		}


for($i = 0; $i < count($jsonData); $i++) {
	$transactionTable = "transaction_".$jsonData[$i]["wh_id"]."";
// $sql2 = "SELECT * FROM `$transactionTable` WHERE ( item_timestamp > '$startDate' AND item_timestamp < '$endDate' )";	
	$sql2 = "SELECT * FROM `$transactionTable` WHERE item_transaction = 'sold' AND item_timestamp > '$startDate' AND item_timestamp < '$endDate'";
	$result2 = mysqli_query($conn, $sql2);
	$jsonData2 = array();

	if (mysqli_num_rows($result2) > 0) {
		    // output data of each row
			 while($row = mysqli_fetch_assoc($result2)) {
			        // $final = "Id: " . $row["S.No."]. " - Name: " . $row["Name"]. " - Age " . $row["Age"]. "<br>";
			 $jsonData2[] = $row;
			 }
	} else {
		
	}

	$finalData = array_merge($finalData, $jsonData2);


}

	// $transactionTable = "transaction_".$jsonData[0]["wh_id"]."";
	// $sql2 = "SELECT * FROM  `$transactionTable` WHERE s_no = 1";	
	// $result2 = mysqli_query($conn, $sql2);
	// $jsonData2 = array();
	// 	if (mysqli_num_rows($result2) > 0) {
	// 	    // output data of each row
	// 		 while($row = mysqli_fetch_assoc($result2)) {
	// 		        // $final = "Id: " . $row["S.No."]. " - Name: " . $row["Name"]. " - Age " . $row["Age"]. "<br>";
	// 		 $jsonData2[] = $row;
	// 		 }
	// } else {
	// 	echo "0 results";
	// }

		// if($startDate > $jsonData2[0]["item_timestamp"]) {
		// 	echo $startDate;
		// 	echo "phla";
		// 	echo $jsonData2[0]["item_timestamp"];
		// }else {
		// 	echo $startDate;
		// 	echo "doosra";
		// 	echo $jsonData2[0]["item_timestamp"];
		// }





echo json_encode($finalData);
mysqli_close($conn);
?>