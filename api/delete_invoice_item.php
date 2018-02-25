<?php

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

include('dbconfig.php');
 
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$invoiceNumber = $request->invoiceNumber;
$warehouse = $request->warehouse;




$transactionTable = "transaction_".$warehouse."";


$sql = "DELETE FROM `$transactionTable` WHERE item_invoice_number='$invoiceNumber'";
// mysqli_query($conn, $sql);
if(mysqli_query($conn, $sql)) {
	// echo "Record Deleted";
}
else {
	echo "Kuch Gadbad h!";
}


$sql2 = "SELECT * FROM `$transactionTable` WHERE item_transaction = 'sold'";
$result = mysqli_query($conn, $sql2);
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