<?php
	header("Access-Control-Allow-Origin: *");

include('dbconfig.php');

$sql = "SELECT * FROM warehouse_table";
$result = mysqli_query($conn, $sql);
$jsonData = array();

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        // $final = "Id: " . $row["S.No."]. " - Name: " . $row["Name"]. " - Age " . $row["Age"]. "<br>";
        $jsonData[] = $row;
    }
} else {
    echo "0 results";
}

echo json_encode($jsonData);

mysqli_close($conn);
?>