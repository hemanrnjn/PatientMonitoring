<?php

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

include('dbconfig.php');
 
$postdata = file_get_contents("php://input");
$request = json_decode($postdata, TRUE);



    for($i = 0; $i < 1; $i++) {
        $demand_item_from = $request[$i]["demand_item_from"];
        $demand_item_reqfrom = $request[$i]["demand_item_reqfrom"];
    }


    $updateDemandTable = "demand_order_".$demand_item_from."";
    $updateTransferTable = "transfer_order_".$demand_item_reqfrom."";


    $sql = "SELECT id FROM demand_transfer_id ORDER BY id DESC LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $temp_demand_id = $row["id"];
        }
        $new_demand_number = $temp_demand_id + 1;
        $demand_id = 'DO'.$new_demand_number.'';
        $transfer_id = 'TO'.$new_demand_number.'';
    } 
    else {
        $new_demand_number = 1;
        $demand_id = 'DO1';
        $transfer_id = 'TO1';
    }


for($i = 0; $i< count($request); $i++) {
    
    $demand_item_timestamp = $request[$i]["demand_item_timestamp"];
    $demand_item_type = $request[$i]["demand_item_type"];
    $demand_item_name = $request[$i]["demand_item_name"];
    $demand_item_hsn_sac = $request[$i]["demand_item_hsn_sac"];
    $demand_item_rate = $request[$i]["demand_item_rate"];
    $demand_item_min_sellingprice = $request[$i]["demand_item_min_sellingprice"];
    $demand_item_purchasingprice = $request[$i]["demand_item_purchasingprice"];
    $demand_item_tax = $request[$i]["demand_item_tax"];
    $demand_item_reqfrom = $request[$i]["demand_item_reqfrom"];
    $demand_item_quantity = $request[$i]["demand_item_quantity"];
    $demand_item_from = $request[$i]["demand_item_from"];
    $demand_item_assignedby_id = $request[$i]["demand_item_assignedby_id"];

    $demand_item_rate = (int)$demand_item_rate;
    $demand_item_min_sellingprice = (int)$demand_item_min_sellingprice;
    $demand_item_purchasingprice = (int)$demand_item_purchasingprice;        




    $sql2 = "INSERT INTO `$updateDemandTable` (demand_id, demand_item_type, demand_item_name, demand_item_hsn_sac, demand_item_reqfrom, demand_item_quantity, demand_item_status, demand_item_received)
    VALUES ('$demand_id', '$demand_item_type', '$demand_item_name', '$demand_item_hsn_sac', '$demand_item_reqfrom', '$demand_item_quantity', 'pending', '0')";
    mysqli_query($conn, $sql2);
    // if(mysqli_query($conn2, $sql)) {
    //  echo "Record Inserted";
    // }
    // else {
    //  echo "Kuch Gadbad h!";
    // }




    $sql3 = "INSERT INTO `$updateTransferTable` (transfer_id, transfer_item_type, transfer_item_name, transfer_item_hsn_sac, transfer_item_reqby, transfer_item_reqquantity, transfer_item_status, transfer_item_sent)
    VALUES ('$transfer_id', '$demand_item_type', '$demand_item_name', '$demand_item_hsn_sac', '$demand_item_from', '$demand_item_quantity', 'pending', '0')";
    mysqli_query($conn, $sql3);
    // if(mysqli_query($conn3, $sql2)) {
    //  echo "Record Inserted";
    // }
    // else {
    //  echo "Kuch Gadbad h!";
    // }

    $transactionTable = "transaction_".$demand_item_from."";


    $sql4 = "INSERT INTO `$transactionTable` (item_timestamp, item_salesperson, item_name, item_type, item_hsn_sac, item_quantity, item_rate, item_min_sellingprice, item_purchasingprice, item_tax, item_transaction, item_destination)
    VALUES ('$demand_item_timestamp', '$demand_item_assignedby_id', '$demand_item_name', '$demand_item_type', '$demand_item_hsn_sac', '$demand_item_quantity', '$demand_item_rate', '$demand_item_min_sellingprice', '$demand_item_purchasingprice', '$demand_item_tax', 'demanded', '$demand_item_reqfrom')";
    mysqli_query($conn, $sql4);

    
}



$sql5 = "INSERT INTO demand_transfer_id (id) VALUES ('$new_demand_number')";
mysqli_query($conn, $sql5);




// $demand_item_type = $request->demand_item_type;
// $demand_item_name = $request->demand_item_name;
// $demand_item_hsn_sac = $request->demand_item_hsn_sac;
// $demand_item_rate = $request->demand_item_rate;
// $demand_item_min_sellingprice = $request->demand_item_min_sellingprice;
// $demand_item_purchasingprice = $request->demand_item_purchasingprice;
// $demand_item_tax = $request->demand_item_tax;
// $demand_item_reqfrom = $request->demand_item_reqfrom;
// $demand_item_quantity = $request->demand_item_quantity;
// $demand_item_from = $request->demand_item_from;

// $demand_item_quantity = (int)$demand_item_quantity;



// $updateDemandTable = "demand_order_".$demand_item_from."";
// $updateTransferTable = "transfer_order_".$demand_item_reqfrom."";



// $sql = "SELECT demand_id FROM `$updateDemandTable` ORDER BY demand_id DESC LIMIT 1";
// $result = mysqli_query($conn, $sql);

// if (mysqli_num_rows($result) > 0) {
//     while($row = mysqli_fetch_assoc($result)) {
//     	$temp_demand_id = $row["demand_id"];
//     }
//     $temp_demand_id = substr($temp_demand_id, 2);
//     $new_demand_number = (int)$temp_demand_id + 1;
//     $demand_id = 'DO'.$new_demand_number.'';
//     $transfer_id = 'TO'.$new_demand_number.'';
// } 
// else {
//     $demand_id = 'DO1';
//     $transfer_id = 'TO1';
// }





// $sql2 = "INSERT INTO `$updateDemandTable` (demand_id, demand_item_type, demand_item_name, demand_item_hsn_sac, demand_item_reqfrom, demand_item_quantity, demand_item_status, demand_item_received)
// VALUES ('$demand_id', '$demand_item_type', '$demand_item_name', '$demand_item_hsn_sac', '$demand_item_reqfrom', '$demand_item_quantity', 'pending', '0')";
// mysqli_query($conn, $sql2);
// // if(mysqli_query($conn2, $sql)) {
// // 	echo "Record Inserted";
// // }
// // else {
// // 	echo "Kuch Gadbad h!";
// // }




// $sql3 = "INSERT INTO `$updateTransferTable` (transfer_id, transfer_item_type, transfer_item_name, transfer_item_hsn_sac, transfer_item_reqby, transfer_item_reqquantity, transfer_item_status, transfer_item_sent)
// VALUES ('$transfer_id', '$demand_item_type', '$demand_item_name', '$demand_item_hsn_sac', '$demand_item_from', '$demand_item_quantity', 'pending', '0')";
// mysqli_query($conn, $sql3);
// // if(mysqli_query($conn3, $sql2)) {
// // 	echo "Record Inserted";
// // }
// // else {
// // 	echo "Kuch Gadbad h!";
// // }

// $transactionTable = "transaction_".$demand_item_from."";


// $sql4 = "INSERT INTO `$transactionTable` (item_name, item_type, item_hsn_sac, item_quantity, item_rate, item_min_sellingprice, item_purchasingprice, item_tax, item_transaction, item_destination)
// VALUES ('$demand_item_name', '$demand_item_type', '$demand_item_hsn_sac', '$demand_item_quantity', '$demand_item_rate', '$demand_item_min_sellingprice', '$demand_item_purchasingprice', '$demand_item_tax', 'demanded', '$demand_item_reqfrom')";
// mysqli_query($conn, $sql4);



$sql6 = "SELECT * FROM `$updateDemandTable` ORDER BY s_no DESC";
$result = mysqli_query($conn, $sql6);
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