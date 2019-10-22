<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Creating Array for JSON response
$response = array();
date_default_timezone_set('Europe/Lisbon');

// Include data base connect class
$filepath = realpath (dirname(__FILE__));
require_once($filepath."/db_connect.php");

// Connecting to database
$db = new DB_CONNECT();

// Fire SQL query to get all data from weather
$result = mysql_query("SELECT *FROM level01") or die(mysql_error());

// Check for succesfull execution of query and no results found
if (mysql_num_rows($result) > 0) {

    // Storing the returned array in response
    $response["data"] = array();

    // While loop to store all the returned response in variable
    for ($i = mysql_num_rows($result)-1; $i > mysql_num_rows($result)-2; $i--){
        // temperorary user array
        $data = array();
        $data["id"] = mysql_result($result, $i, "id");
        $data["dis"] = mysql_result($result, $i, "dis");
        $data["vol"] = mysql_result($result, $i, "vol");
        $data["pct"] = mysql_result($result, $i, "pct");
        $data["time_create"] = mysql_result($result, $i, "time_create");

        // Push all the items
        array_push($response["data"], $data);
    }
    // On success
    $response["success"] = 1;

    // Show JSON response
    echo json_encode($response);
}
else
{
    // If no data is found
    $response["success"] = 0;
    $response["message"] = "No data on level was founded";

    // Show JSON response
    echo json_encode($response);
}
?>
