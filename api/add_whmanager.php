<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");


include('dbconfig.php');

 
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$user_salutation = $request->whmanager_salutation;
$user_name = $request->whmanager_name;
$user_email = $request->whmanager_email;
$user_password = $request->whmanager_password;
$user_address = $request->whmanager_address;
$user_contact = $request->whmanager_contact;



$sql = "SELECT user_id FROM user_table ORDER BY s_no DESC LIMIT 1";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        $temp_id = $row["user_id"];
    }
    $new_id = substr($temp_id,1) + 1;
    $new_id = 'u'.$new_id.'';
} 
else {
    $new_id = 'u1';
}



$sql2 = "INSERT INTO user_table (user_id, user_salutation, user_name, user_email, user_password, user_role, user_address, user_contact)
VALUES ('$new_id', '$user_salutation', '$user_name', '$user_email', '$user_password', 'whmanager' , '$user_address', '$user_contact')";


if(mysqli_query($conn, $sql2)) {
    $sql2 = "SELECT * FROM user_table";
    $result = mysqli_query($conn, $sql2);
    $jsonData = array();
    while($row = mysqli_fetch_assoc($result)) {
            $jsonData[] = $row;
        }
    echo json_encode($jsonData);
}
else {
    echo "Kuch Gadbad h!";
}


mysqli_close($conn);
?>