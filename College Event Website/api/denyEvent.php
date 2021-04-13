<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");

    $inData = getRequestInfo();
    $name = $inData["pendingEvent"];
    $conn = new mysqli('localhost', 'root', '', 'website');

    if ($conn->connect_error) 
    {
       returnWithError("Connection Failed.");
    }
    else
    {
        $sql = "DELETE FROM pending_events where Event_Name = '" . $name . "'";
        $result = $conn->query($sql);

        if($result != TRUE)
        {
            returnWithError("Event does not exist!");
        }
        else
        {
            returnWithInfo("EVENT DENIED AND DELETED");
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

    function returnWithInfo($info)
    {
        $retValue = '{"info":"' . $info . '"}';
            sendResultInfoAsJson($retValue);
    }
?>