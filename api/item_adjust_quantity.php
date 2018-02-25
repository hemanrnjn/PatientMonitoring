<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");


include('dbconfig.php');


$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$item_name = $request->item_name;
$item_type = $request->item_type;
$item_hsn_sac = $request->item_hsn_sac;
$item_rate = $request->item_rate;
$item_min_sellingprice = $request->item_min_sellingprice;
$item_purchasingprice = $request->item_purchasingprice;
$item_tax = $request->item_tax;
$item_warehouse_id = $request->item_warehouse_id;
$item_adjust_quantity = $request->item_adjust_qty;
$item_adjust_details = $request->item_adjust_details;




$transactionTable = "transaction_".$item_warehouse_id."";


$sql = "UPDATE item_table SET `$item_warehouse_id` = `$item_warehouse_id` - '$item_adjust_quantity' WHERE item_name = '$item_name' AND item_hsn_sac = '$item_hsn_sac'";

$sql2 = "INSERT INTO `$transactionTable` (item_name, item_type, item_hsn_sac, item_quantity, item_rate, item_min_sellingprice, item_purchasingprice, item_tax, item_tax_type, item_transaction, item_destination, item_details)
VALUES ('$item_name', '$item_type', '$item_hsn_sac', '$item_adjust_quantity', '$item_rate', '$item_min_sellingprice', '$item_purchasingprice', '$item_tax', 0, 'adjusted', '$item_warehouse_id', '$item_adjust_details')";


if(mysqli_query($conn, $sql) AND mysqli_query($conn, $sql2)) {
    // echo "Record Inserted";
    $sql3 = "SELECT * FROM item_table";

    $result2 = mysqli_query($conn, $sql3);

    if(mysqli_query($conn, $sql3)) {
        // echo "Record Fetched";
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
    
}
else {
    echo "Kuch Gadbad h in niche wala!";
}

mysqli_close($conn);
?>