<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");


    $inData = getRequestInfo();
    $userID = $inData['userID'];
    $searchCount = 0;
    $searchResults = ""; 
    $conn = new mysqli('localhost', 'root', '', 'website');

    if ($conn->connect_error) 
    {
        returnWithError("Connection Failed.");
    }
    else
    {   $sql = "SELECT datelaston from users where User_ID = '".$userID."'";
        $result = $conn->query($sql);

        if($result->num_rows > 0)
        {
            $row = $result->fetch_assoc();
            $date = $row["datelaston"];
        
            $sql = "SELECT Event_Name,Event_Type,Event_Start_Time,Event_Date,Description
                    FROM public_events
                    WHERE Event_Date = '".$date."'
                    UNION ALL
                    SELECT Event_Name,Event_Type,Event_Start_Time,Event_Date,Description
                    FROM private_events
                    WHERE Event_Date = '".$date."'
                    UNION ALL
                    SELECT Event_Name,Event_Type,Event_Start_Time,Event_Date,Description
                    FROM rso_events
                    WHERE Event_Date = '".$date."'";
            $result = $conn->query($sql);
            $searchCount = $result->num_rows;
            //echo($searchCount);
            if($searchCount > 0)
            {   
                while($searchCount > 0)
                {
                    $row = $result->fetch_assoc();
                    $thisEvent = '{"Event_Name":"'.$row["Event_Name"].'",
                                   "Event_Type":"'.$row["Event_Type"].'",
                                   "Event_Time":"'.$row["Event_Start_Time"].'",
                                   "Event_Date":"'.$row["Event_Date"].'",
                                   "Desc":"'.$row["Description"].'"
                                   }';
                    $searchResults .= $thisEvent;
                    if($searchCount > 1)
                    {
                        $searchResults .= ",";
                    }
                    $searchCount--; 
                }
                returnWithInfo($searchResults);
            }
            else
            {
                returnWithError("no events?");
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
 
    function returnWithInfo($searchResults)
    {
       $retValue = '{"info":[' . $searchResults . ']}';
        sendResultInfoAsJson($retValue);
    }
?>