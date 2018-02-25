<?php


header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");


include('dbconfig.php');


$jsonData = array();

$sql = "SELECT invoice_number FROM invoice_number_table ORDER BY invoice_number DESC LIMIT 1";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        $jsonData[] = $row;
        // echo "id: " . $row["S.No."]. " - Name: " . $row["Name"]. " - Age " . $row["Age"]. "<br>";
    }
} else {
    $array2 = array( 
    "invoice_number" => "0"
); 
    $jsonData[] = $array2;
}

$jsonData[0]["invoice_number"] = $jsonData[0]["invoice_number"] + 1;

echo json_encode($jsonData);


mysqli_close($conn);
?>