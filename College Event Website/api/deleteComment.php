<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");
    
    $inData = getRequestInfo();
    $public = "Public";
    $eventNameVar = $inData["eventName"];
    $userID = $inData['userID'];

    $conn = new mysqli('localhost', 'root', '', 'website');

    if ($conn->connect_error) 
    {
       returnWithError("Connection Failed.");
    }

    else
    {
        $sql = "SELECT Event_Type FROM public_events where Event_Name = '" . $eventNameVar . "'";
        $result = $conn->query($sql);
        
        if($result->num_rows > 0 || $result->num_rows <= 0)
        {
            $row = $result->fetch_assoc();
            $eventType = $row["Event_Type"];
            //echo($eventType);

            if($eventType == $public)
            {
                $sql1 = "DELETE FROM public_event_comments where User_ID = '".$userID."'";
                $result1 = $conn->query($sql1);
                if($result1 != TRUE)
                {
                    returnWithError("public not deleted!");
                }
                else
                {
                    returnWithInfo("public Comment successfully DELETED");
                }
            }
            else
            {
                $sql1 = "DELETE FROM private_event_comments where User_ID = '".$userID."'";
                $result1 = $conn->query($sql1);
                if($result1 != TRUE)
                {
                    returnWithError("private Comment not deleted!");
                }
                else
                {
                    returnWithInfo("private Comment successfully DELETED");
                }
            }
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
        $retValue = '{"info":' . $info . '}';
        sendResultInfoAsJson($retValue);
    }
?>