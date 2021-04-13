<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");

    $inData = getRequestInfo();
    $eventName = $inData["eventName"];
    $conn = new mysqli('localhost', 'root', '', 'website');

    if ($conn->connect_error) 
    {
        returnWithError("Connection Failed.");
    }

    else
    {
        $sql = "SELECT Event_Type, Event_Date,Event_Start_Time,Event_End_Time,Event_Category,Contact_Email, Description, Address
                FROM public_events
                WHERE Event_Name = '".$eventName."'
                UNION ALL
                SELECT Event_Type, Event_Date,Event_Start_Time,Event_End_Time,Event_Category,Contact_Email, Description, Address
                FROM private_events
                WHERE Event_Name = '".$eventName."'
                UNION ALL
                SELECT Event_Type, Event_Date,Event_Start_Time,Event_End_Time,Event_Category,Contact_Email, Description, Address
                FROM rso_events
                WHERE Event_Name = '".$eventName."'";
        $result = $conn->query($sql);
        if($result->num_rows > 0)
        {
            $row = $result->fetch_assoc();
            $type = $row["Event_Type"];
            $date = $row["Event_Date"];
            $start = $row["Event_Start_Time"];
            $end = $row["Event_End_Time"];
            $cat = $row["Event_Category"];
            $email = $row["Contact_Email"];
            $desc = $row["Description"];
            $addy = $row["Address"];

            returnWithInfo($eventName,$type,$date,$start,$end,$cat,$email,$desc,$addy);
        }
        else
        {
            returnWithError("Event does not exist!");
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
 
    function returnWithInfo($eventName,$type,$date,$start,$end,$cat,$email,$desc,$addy)
    {
        $retValue = '{"eventName":"' . $eventName . '","type":"' . $type . '","date":"' . $date . '","start":"' . $start . '","end":"' . $end . '","cat":"' . $cat . '", "email":"' . $email . '","description":"' . $desc . '","address":"' . $addy . '"}';
        sendResultInfoAsJson($retValue);
    }
?>