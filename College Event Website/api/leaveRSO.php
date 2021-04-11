<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");

    $inData = getRequestInfo();
    $rsoName = $inData["rsoName"];
    //$rsoName = "FCFC";

    $conn = new mysqli('localhost', 'root', '', 'website');

    if ($conn->connect_error) 
    {
       returnWithError("Connection Failed.");
    }
    else
    {
        $sql = "DELETE FROM joined where RSO_Name = '".$rsoName."'";
        $result = $conn->query($sql);
        if($result != TRUE)
        {
            returnWithInfo("RSO does not exist!");
        }
        else
        {
            returnWithInfo("We're sorrry to see you go!");
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
 
    function returnWithInfo($info)
    {
       $retValue = '{"info":"' . $info . '"}';
         sendResultInfoAsJson($retValue);
    }
?>