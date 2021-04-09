<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");

    $inData = getRequestInfo();

    $uniName = $inData["uniName"];
    $address = $inData["address"];
    $city = $inData["city"];
    $state = $inData["state"];
    $zip = $inData["zip"];
    $desc = $inData["description"];
    $numStud = $inData["population"];

    $conn = new mysqli('localhost', 'root', '', 'website');

    // check for connectivity issues
    if ($conn->connect_error) 
    {
        returnWithError("Connection Failed.");
    }
    else
    {
        $sql = "INSERT into universities(Uni_Name,Address,City,State,Zip,Description,Num_Students) values('" . $uniName . "','" . $address . "','" . $city . "','" . $state . "','" . $zip . "','" . $desc . "','" . $numStud . "')";
        
        if($result = $conn->query($sql) != TRUE)
        {
            returnWithInfo("A Profile for this University already exists!");
        }
        else
        {
            returnWithInfo("Created!");
        }
        $conn->close();
    }
    function getRequestInfo()
   {
      return json_decode(file_get_contents('php://input'), true);
   }

   function sendResultInfoAsJson($obj)
   {
      header('Content-type: application/json');
      echo $obj;
   }

   function returnWithInfo($info)
   {
      $retValue = '{"info":"' . $info . '"}';
		sendResultInfoAsJson($retValue);
   }
?>