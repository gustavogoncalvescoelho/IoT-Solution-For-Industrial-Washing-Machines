<?php
// Creating a Secant Method
// The program is separate in 4 blocks
// 1. It reads the information from the mysql_list_tables
// 2. It takes care with the timestamp format using Epoch Method
// 3. It process the information using Secant Method
// 4. It inserts into a new table the information

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Creating Array for JSON response
$response = array();
//date_default_timezone_set('Europe/Lisbon');

// How many numbers for the last to read
$numbers = 50;

// Fire SQL query to get all data from weather
$result = mysql_query("SELECT *FROM level01") or die(mysql_error());

// Numbers of total rows of the table
$rows = mysql_num_rows($result);

// Check for succesfull execution of query and no results found
if ($rows > 0) {

    // Storing the returned array in response
    $response["level01"] = array();

    // While loop to store all the returned response in variable
    for ($i = $rows-1; $i >= $rows-$numbers; $i--){
        // temperorary user array
        $data = array();
        $data["id"] = mysql_result($result, $i, "id");
        $data["pct"] = mysql_result($result, $i, "pct");
        $data["time_create"] = mysql_result($result, $i, "time_create");

        // Push all the items
        array_push($response["level01"], $data);
    }

    // Store the data from the last measurement (X)
    $response["X"] = array();

    // temperorary user array
    $aux1 = array();

    $aux1["id"] = $response["level01"][0]["id"];
    $aux1["pct"] = $response["level01"][0]["pct"];
    $aux1["time_create"] = $response["level01"][0]["time_create"];
    // Push all the items
    array_push($response["X"], $aux1);

    // Now it is time to read the last information (the X old)
    // The stop criteria is to take the last measurement with negative angular coeficient
    // With the f(Xold) being greater then 1% (pct) of difference

    if ($response["level01"][0]["pct"] == 100) {
      // System is is_uploaded_file
      // The old measumrent must be igual to the recent measurement
      // Xold <- X

      // Storing the returned array in response
      $response["Xold"] = array();
      // Push all the items
      array_push($response["Xold"], $aux1);
    } else {
      // System is not loaded

      // Storing the returned array in response
      $response["Xold"] = array();

      // The system will make compararisons by searching a pre determined value vector size
      for ($i = 1; $i < $numbers; $i++){
        $a = $response["level01"][$i-1]["pct"];
        $b = $response["level01"][$i]["pct"];

        // If the previous value is bigger, the system capacity is decreasing
        // Therefore, there a value for Xold
        if ($a > $b){
          // temperorary user array
          $aux2 = array();
          $aux2["id"] = $response["level01"][$i-1]["id"];
          $aux2["pct"] = $response["level01"][$i-1]["pct"];
          $aux2["time_create"] = $response["level01"][$i-1]["time_create"];
          // Push all the items
          array_push($response["Xold"], $aux2);

          break 1;
        }
        if ($i == $numbers - 1){
          // temperorary user array
          $aux2 = array();
          $aux2["id"] = $response["level01"][$i]["id"];
          $aux2["pct"] = $response["level01"][$i]["pct"];
          $aux2["time_create"] = $response["level01"][$i]["time_create"];
          // Push all the items
          array_push($response["Xold"], $aux2);

          break 1;
        }
      }
    }

    // Secant Method
    // Date format using EPOCH Method

    // Actual X
    $x0 = strtotime($response["X"][0]["time_create"]);
    $fx0 = $response["X"][0]["pct"];
    $actualTime = gmdate("Y-m-d H:i:s", $x0);

    // Old X
    $x1 = strtotime($response["Xold"][0]["time_create"]);
    $fx1 = $response["Xold"][0]["pct"];
    $oldTime = gmdate("Y-m-d H:i:s", $x1);

    // Secant equation
    // mi = coeficient Angular
    $mi = ($x0 - $x1) / ($fx0 - $fx1);

    // Result in total of seconds
    $xroot = $x0 - ($fx0 * $mi);
    $resultTime = gmdate('Y-m-d H:i:s', $xroot);

    // In case both are igual, the system is loading, so there is no time predict
    if ($actualTime == $resultTime) {
      // Verify if the system is loading or not
      // 1 is loading/loaded
      $verify = 1;

      // Include database connect class
      $filepath1 = realpath (dirname(__FILE__));
      require_once($filepath1."/db_connect.php");

      // Connecting to database
      $db1 = new DB_CONNECT();

      // Fire SQL query to insert in data level01 predict
      $result1 = mysql_query("INSERT INTO predict(pct,pct_old,time_old,time_create,time_predict,verify) VALUES('$fx0', '$fx1','$oldTime', '$actualTime', '$resultTime', '$verify')");
    } else {
      // Verify if the system is loading or not
      // 0 is not loading/loaded
      $verify = 0;

      // Include database connect class
      $filepath1 = realpath (dirname(__FILE__));
      require_once($filepath1."/db_connect.php");

      // Connecting to database
      $db1 = new DB_CONNECT();

      // Fire SQL query to insert in data level01 predict
      $result1 = mysql_query("INSERT INTO predict(pct,pct_old,time_old,time_create,time_predict,verify) VALUES('$fx0', '$fx1', '$oldTime', '$actualTime', '$resultTime', '$verify')");
    }

    // Check for succesfull execution of query
    if($result1){
        // Succesfully inserted
        $response["sucess"] = 1;
        $response["message"] = "Level succesfully created.";

        // Show JSON response
        echo json_encode($response);

    }else{
        // Failed to insert database
        $response["success"] = 0;
        $response["message"] = "Something has been wrong";

        // Show JSON response
        echo json_encode($response);
    }
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
