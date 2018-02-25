<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");


include('dbconfig.php');


$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$invoice_number = $request->invoice_number;


$sql = "INSERT INTO invoice_number_table (invoice_number) VALUES ('$invoice_number')";
if(mysqli_query($conn, $sql)) {
    // echo "Record Inserted";
}
else {
    echo "Kuch Gadbad h!";
}


// $sql2 = "SELECT * FROM item_table WHERE (item_name = '$item_name' AND item_sku = '$item_hsn_sac')";
$sql2 = "SELECT invoice_number FROM invoice_number_table ORDER BY invoice_number DESC LIMIT 1";
$result2 = mysqli_query($conn, $sql2);
if(mysqli_query($conn, $sql2)) {
    // echo "Record Fetched";
}
else {
    echo "Kuch Gadbad h returns!";
}

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


mysqli_close($conn);
?>