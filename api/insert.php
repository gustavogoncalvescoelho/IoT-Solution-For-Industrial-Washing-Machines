<?php
header("Acess-Control-Allow-Origin: *");
header("Content-type: application/json; charset=UTF-8"); // JSON Format

// Creating Array for JSON response
$response = array();
//date_default_timezone_set('Europe/Lisbon');

// Check if we got the field from the user
if(isset($_GET['dis']) && isset($_GET['vol']) && isset($_GET['pct'])){

    $dis = $_GET['dis'];
    $vol = $_GET['vol'];
    $pct = $_GET['pct'];

    // Include database connect class
    $filepath = realpath (dirname(__FILE__));
    require_once($filepath."/db_connect.php");

    // Connecting to database
    $db = new DB_CONNECT();

    // Fire SQL query to insert in data level01
    $result = mysql_query("INSERT INTO level01(dis,vol,pct) VALUES('$dis', '$vol', '$pct')");

    // Check for succesfull execution of query
    if($result){
        // Succesfully inserted
        $response["sucess"] = 1;
        $response["message"] = "Level succesfully created.";

        // Show JSON response
        echo json_encode($response);

        require 'secantMethod.php';
    }else{
        // Failed to insert database
        $response["success"] = 0;
        $response["message"] = "Something has been wrong";

        // Show JSON response
        echo json_encode($response);
    }
}else{
    // If required parameter is missed
    $response["success"] = 0;
    $response["message"] = "Parameter(s) are missing. Please check the request";

    // Show JSON response
    echo json_encode($response);
}
?>
