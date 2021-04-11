<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");

    $inData = getRequestInfo();
    $rsoName = $inData["rsoName"]; 
    $conn = new mysqli('localhost', 'root', '', 'website');

    if ($conn->connect_error) 
    {
        returnWithError("Connection Failed.");
    }
    else
    {
        $sql ="SELECT Uni_Name,description,Admin_Email FROM rsos where RSO_Name = '" . $rsoName . "'";
        $result = $conn->query($sql);

        if($result->num_rows > 0)
        {
            $row = $result->fetch_assoc();
            $uni = $row["Uni_Name"];
            $desc = $row["description"];
            $email = $row["Admin_Email"];

            returnWithInfo($rsoName,$uni,$desc,$email);
        }
        else
        {
            returnWithError("RSO does not exist");
        }

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
 
    function returnWithError($err)
    {
       $retValue = '{"error":"' . $err . '"}';
       sendResultInfoAsJson($retValue);
    }
 
    function returnWithInfo($rsoName, $uni, $desc, $email)
    {
        $retValue = '{"rsoName":"' . $rsoName . '","university":"' . $uni . '","description":"' . $desc . '","adminEmail":"' . $email . '"}';
        sendResultInfoAsJson($retValue);
    }
?>