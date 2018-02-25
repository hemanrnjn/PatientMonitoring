<?php

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

include('dbconfig.php');
 
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$item_type = $request->item_type;
$item_name = $request->item_name;
$item_hsn_sac = $request->item_hsn_sac;
$item_manufacturer = $request->item_manufacturer;
$item_brand = $request->item_brand;
$item_upc = $request->item_upc;
$item_sellingprice = $request->item_sellingprice;
$item_min_sellingprice = $request->item_min_sellingprice;
$item_purchasingprice = $request->item_purchasingprice;
$item_tax = $request->item_tax;
$item_reorderlevel = $request->item_reorderlevel;
$item_sellingprice = (int)$item_sellingprice;
$item_min_sellingprice = (int)$item_min_sellingprice;
$item_purchasingprice = (int)$item_purchasingprice;
$item_reorderlevel = (int)$item_reorderlevel;

$sql = "INSERT INTO item_table (item_type, item_name, item_hsn_sac, item_manufacturer, item_brand, item_upc, item_sellingprice, item_min_sellingprice, item_purchasingprice, item_tax, item_reorderlevel)
VALUES ('$item_type', '$item_name' , '$item_hsn_sac', '$item_manufacturer' , '$item_brand' , '$item_upc' , '$item_sellingprice' , '$item_min_sellingprice' , '$item_purchasingprice' , '$item_tax' , '$item_reorderlevel')";

	if(!mysqli_query($conn, $sql)) {
	    echo "Kuch Gadbad h!";
	}

if($item_type == 'product'){
	$sql5 = "INSERT INTO marketingperson_item_table (item_type, item_name, item_hsn_sac, item_sellingprice, item_min_sellingprice, item_purchasingprice, item_tax)
	VALUES ('$item_type', '$item_name' , '$item_hsn_sac', '$item_sellingprice' , '$item_min_sellingprice' , '$item_purchasingprice' , '$item_tax')";
	if(!mysqli_query($conn, $sql5)) {
		echo "Kuch Gadbad h naye wale me!";
	}
}



if ($item_type == 'service') {
    $sql2 = "SELECT * FROM warehouse_table";
    $result = mysqli_query($conn, $sql2);
    $jsonData = array();
        while($row = mysqli_fetch_assoc($result)) {
            $jsonData[] = $row;
        }
    for ($i = 0; $i < count($jsonData); $i++) {
        $temp_wh_id = $jsonData[$i]['wh_id'];
        $sql4 = "UPDATE item_table SET `$temp_wh_id` = 100000 WHERE item_hsn_sac = '$item_hsn_sac'";
        mysqli_query($conn, $sql4);
    }
}

$sql3 = "SELECT * FROM item_table";
$result2 = mysqli_query($conn, $sql3);
$jsonData = array();
while($row = mysqli_fetch_assoc($result2)) {
        $jsonData[] = $row;
    }
echo json_encode($jsonData);
// if (mysqli_query($conn, $sql)) {
//     echo "New record created successfully";
// } else {
//     echo "Error: " . $sql . "<br>" . mysqli_error($conn);
// }
mysqli_close($conn);
// header("Access-Control-Allow-Origin: *");
// header('Content-Type: application/json');
// header("Access-Control-Allow-Headers: X-Requested-With");
// header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
// include('dbconfig.php');
 
// $postdata = file_get_contents("php://input");
// $request = json_decode($postdata);
// $item_type = $request->item_type;
// $item_name = $request->item_name;
// $item_hsn_sac = $request->item_hsn_sac;
// $item_manufacturer = $request->item_manufacturer;
// $item_brand = $request->item_brand;
// $item_upc = $request->item_upc;
// $item_sellingprice = $request->item_sellingprice;
// $item_min_sellingprice = $request->item_min_sellingprice;
// $item_purchasingprice = $request->item_purchasingprice;
// $item_tax = $request->item_tax;
// $item_reorderlevel = $request->item_reorderlevel;

// $item_sellingprice = (int)$item_sellingprice;
// $item_min_sellingprice = (int)$item_min_sellingprice;
// $item_purchasingprice = (int)$item_purchasingprice;
// $item_reorderlevel = (int)$item_reorderlevel;

// $sql = "INSERT INTO item_table (item_type, item_name, item_hsn_sac, item_manufacturer, item_brand, item_upc, item_sellingprice, item_min_sellingprice, item_purchasingprice, item_tax, item_reorderlevel)
// VALUES ('$item_type', '$item_name' , '$item_hsn_sac', '$item_manufacturer' , '$item_brand' , '$item_upc' , '$item_sellingprice' , '$item_min_sellingprice' , '$item_purchasingprice' , '$item_tax' , '$item_reorderlevel')";
// if(mysqli_query($conn, $sql)) {
    
// }
// else {
//     echo "Kuch Gadbad h!";
// }
// $sql2 = "SELECT * FROM item_table";
// $result = mysqli_query($conn, $sql2);
// $jsonData = array();
// while($row = mysqli_fetch_assoc($result)) {
//         $jsonData[] = $row;
//     }
// echo json_encode($jsonData);
// // if (mysqli_query($conn, $sql)) {
// //     echo "New record created successfully";
// // } else {
// //     echo "Error: " . $sql . "<br>" . mysqli_error($conn);
// // }
// mysqli_close($conn);
?>