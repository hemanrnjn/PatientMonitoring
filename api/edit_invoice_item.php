<?php

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

include('dbconfig.php');

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$item_invoice_number = $request->item_invoice_number;
$item_invoice_adjustments_name = $request->item_invoice_adjustments_name;
$item_invoice_adjustments = $request->item_invoice_adjustments;
$item_invoice_warehouse = $request->item_invoice_warehouse;



$transactionTable = "transaction_".$item_invoice_warehouse."";

$sql = "UPDATE `$transactionTable` SET item_invoice_adjustments = '$item_invoice_adjustments' , item_invoice_adjustments_name = '$item_invoice_adjustments_name', item_invoice_edited = 1  WHERE item_invoice_number = '$item_invoice_number'";

if(mysqli_query($conn, $sql)) {
   // echo "Record Inserted";
   $sql2 = "SELECT * FROM `$transactionTable` WHERE item_transaction = 'sold'";
   $result2 = mysqli_query($conn, $sql2);


   $jsonData = array();



   if (mysqli_num_rows($result2) > 0) {
   // output data of each row
       while($row = mysqli_fetch_assoc($result2)) {
           $jsonData[] = $row;
       }
       echo json_encode($jsonData);
   }
   else {
       $jsonData[] = "Invalid Credentials";
       echo json_encode($jsonData);
   }
}
else {
   echo "Kuch Gadbad h!";
}


mysqli_close($conn);
?>