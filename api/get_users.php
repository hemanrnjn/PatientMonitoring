<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

include('dbconfig.php');



// $postdata = file_get_contents("php://input");
// $request = json_decode($postdata);
// $warehouse = $request->wh_id;
// $page = $request->page;
// $transactionTable = "transaction_".$warehouse."";
// $offset = ($page - 1)*10;



$sql = "SELECT * FROM user_table";
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