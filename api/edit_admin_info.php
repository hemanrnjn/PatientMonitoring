<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");


include('dbconfig.php');


$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$admin_name = $request->admin_name;
$admin_email = $request->admin_email;
$admin_password = $request->admin_password;



if($admin_name) {

    $sql = "UPDATE user_table SET user_name = '$admin_name' WHERE user_role = 'admin'";
    if(mysqli_query($conn, $sql)) {
        // echo "Record Inserted";
        $sql2 = "SELECT * FROM user_table WHERE user_role = 'admin'";

        $result2 = mysqli_query($conn, $sql2);

        if(mysqli_query($conn, $sql2)) {
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
        echo "Kuch Gadbad h!";
    }
}

else if ($admin_email) {

    $sql = "UPDATE user_table SET user_email = '$admin_email' WHERE user_role = 'admin'";
    if(mysqli_query($conn, $sql)) {
        // echo "Record Inserted";
        $sql2 = "SELECT * FROM user_table WHERE user_role = 'admin'";

        $result2 = mysqli_query($conn, $sql2);

        if(mysqli_query($conn, $sql2)) {
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
        echo "Kuch Gadbad h!";
    }

}

else {

    $sql = "UPDATE user_table SET user_password = '$admin_password' WHERE user_role = 'admin'";
    if(mysqli_query($conn, $sql)) {
        // echo "Record Inserted";
        $sql2 = "SELECT * FROM user_table  WHERE user_role = 'admin'";

        $result2 = mysqli_query($conn, $sql2);

        if(mysqli_query($conn, $sql2)) {
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
        echo "Kuch Gadbad h!";
    }

}


mysqli_close($conn);
?>