<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");


include('dbconfig.php');

// $request = array();
$result = array();
$error = FALSE;
$postdata = file_get_contents("php://input");
$request = json_decode($postdata, TRUE);
$invNum = 0;
$invoice_table_entry = 0;

for($i = count($request) - 1; $i < count($request); $i++) {
    $transactionWarehouse = $request[$i]["source_warehouse"];
}


$transactionTable = "transaction_".$transactionWarehouse."";

$sql3 = "SELECT invoice_number FROM invoice_number_table ORDER BY invoice_number DESC LIMIT 1";
$result3 = mysqli_query($conn, $sql3);


while($row = mysqli_fetch_array($result3)) {
    $invNum = (int)$row[0] + 1;
    $invoice_table_entry = $invNum;
    $invNum = 'INV-' . $invNum . '';
}


for($i = 0; $i< count($request)-1; $i++) {
    $item_timestamp = $request[$i]['current_time'];
    $item_invoice_number = $invNum;
    $item_salesperson = $request[$i]["item_salesperson"];
    $item_additional_salesperson = $request[$i]["item_additional_salesperson"];
    $item_customer_name = $request[$i]["item_customer_name"];
    $item_customer_contact = $request[$i]["item_customer_contact"];
    $item_name = $request[$i]["item_name"];
    $item_type = $request[$i]["item_type"];
    $item_hsn_sac = $request[$i]["item_hsn_sac"];
    $item_quantity = $request[$i]["item_quantity"];
    $item_rate = $request[$i]["item_rate"];
    $item_discount = $request[$i]["item_discount"];
    $item_discount_type = $request[$i]["item_discount_type"];
    $item_min_sellingprice = $request[$i]["item_min_sellingprice"];
    $item_min_sellingprice = (int)$item_min_sellingprice;
    $item_purchasingprice = $request[$i]["item_purchasingprice"];
    $item_purchasingprice = (int)$item_purchasingprice;
    $item_tax = $request[$i]["item_tax"];
    $item_tax_type = $request[$i]["item_tax_type"];
    $item_amount = $request[$i]["item_amount"];
    $item_invoice_amount = $request[$i]["item_invoice_amount"];
    $item_invoice_edited = 0;
    $item_invoice_shippingcharge = $request[$i]["item_invoice_shippingcharge"];
    $item_invoice_adjustments = $request[$i]["item_invoice_adjustments"];
    $item_invoice_adjustments_name = $request[$i]["item_invoice_adjustments_name"];

    if($item_tax_type) {
        $item_tax_type = 1;
    }
    else {
        $item_tax_type = 0;
    }


    $sql = "INSERT INTO `$transactionTable` (item_timestamp, item_invoice_number, item_salesperson, item_additional_salesperson, item_customer_name, item_customer_contact, item_name, item_type, item_hsn_sac, item_quantity, item_rate, item_discount, item_discount_type, item_min_sellingprice, item_purchasingprice, item_tax, item_tax_type, item_amount, item_transaction, item_destination, item_invoice_amount, item_invoice_edited, item_invoice_shippingcharge, item_invoice_adjustments, item_invoice_adjustments_name) 
    VALUES ('$item_timestamp' , '$item_invoice_number', '$item_salesperson', '$item_additional_salesperson','$item_customer_name','$item_customer_contact', '$item_name', '$item_type', '$item_hsn_sac', '$item_quantity', '$item_rate', '$item_discount', '$item_discount_type', '$item_min_sellingprice', '$item_purchasingprice', '$item_tax', '$item_tax_type', '$item_amount', 'sold', 'customer','$item_invoice_amount','$item_invoice_edited','$item_invoice_shippingcharge','$item_invoice_adjustments','$item_invoice_adjustments_name')";


    if(mysqli_query($conn, $sql)) {
        if($item_type == 'product') {
//        echo "Inserted!";
        $sql2 = "UPDATE item_table SET `$transactionWarehouse` = `$transactionWarehouse` - '$item_quantity' WHERE item_hsn_sac = '$item_hsn_sac'";
    mysqli_query($conn, $sql2);
        }
    }
    else {
     //   echo "Not Inserted!";
        //       $result['status'] = 'Sorry! Could Not Complete';
        // $result['boolean'] = FALSE;
        $error = TRUE;
    }


    
}
// foreach($data in $result)
// $demand_item_type = $request->demand_item_type;
// $demand_item_name = $request->demand_item_name;
// $demand_item_hsn_sac = $request->demand_item_hsn_sac;
// $demand_item_reqfrom = $request->demand_item_reqfrom;
// $demand_item_quantity = $request->demand_item_quantity;
// $demand_item_from = $request->demand_item_from;
// $demand_item_quantity = (int)$demand_item_quantity;
// $updateDemandTable = "demand_order_".$demand_item_from."";
// $sql = "INSERT INTO `$updateDemandTable` (demand_item_type, demand_item_name, demand_item_hsn_sac, demand_item_reqfrom, demand_item_quantity, demand_item_status, demand_item_received)
// VALUES ('$demand_item_type', '$demand_item_name', '$demand_item_hsn_sac', '$demand_item_reqfrom', '$demand_item_quantity', 'pending', '0')";
// mysqli_query($conn2, $sql);
// // if(mysqli_query($conn2, $sql)) {
// //     echo "Record Inserted";
// // }
// // else {
// //     echo "Kuch Gadbad h!";
// // }
// $updateTransferTable = "transfer_order_".$demand_item_reqfrom."";
// $sql2 = "INSERT INTO `$updateTransferTable` (transfer_item_type, transfer_item_name, transfer_item_hsn_sac, transfer_item_reqby, transfer_item_reqquantity, transfer_item_status, transfer_item_sent)
// VALUES ('$demand_item_type', '$demand_item_name', '$demand_item_hsn_sac', '$demand_item_from', '$demand_item_quantity', 'pending', '0')";
// mysqli_query($conn3, $sql2);
// // if(mysqli_query($conn3, $sql2)) {
// //     echo "Record Inserted";
// // }
// // else {
// //     echo "Kuch Gadbad h!";
// // }
// $sql3 = "SELECT * FROM `$updateDemandTable`";
// $result = mysqli_query($conn2, $sql3);
// $jsonData = array();
// while($row = mysqli_fetch_assoc($result)) {
//        $jsonData[] = $row;
//    }
// echo json_encode($jsonData);
// if (mysqli_query($conn, $sql)) {
//     echo "New record created successfully";
// } else {
//     echo "Error: " . $sql . "<br>" . mysqli_error($conn);
// }

$sql4 = "INSERT INTO invoice_number_table (invoice_number) VALUES ('$invoice_table_entry')";
mysqli_query($conn, $sql4);


if($error == TRUE) {
       $result['status'] = 'Sorry! Could Not Complete';
       $result['boolean'] = FALSE;
       $result['invoice_number'] = $invNum;
}else {
    $result['status'] = 'Order Recorded';
    $result['boolean'] = TRUE;
    $result['invoice_number'] = $invNum;
}


echo json_encode($result);
mysqli_close($conn);
?>