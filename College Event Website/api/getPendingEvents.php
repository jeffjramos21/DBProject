<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");

    $inData = getRequestInfo();
    $searchCount = 0;
    $searchResults ="";

    $conn = new mysqli('localhost', 'root', '', 'website');

    if ($conn->connect_error) 
    {
        returnWithError("Connection Failed.");
    }
    else
    {
        $sql = "SELECT * FROM pending_events";
        $result = $conn->query($sql);
        $searchCount = $conn->query($sql)->num_rows;

        if($searchCount > 0)
        {
            while($searchCount > 0)
            {
                $row = $result->fetch_assoc();
                $thisEvent = '{"Event Name":"' . $row["Event_Name"] . '",
                               "Event Type":"' . $row["Event_Type"] . '",
                               "Event Category":"' . $row["Event_Category"] . '",
                               "date":"' . $row["Event_Date"] . '",
                               "startTime":"' . $row["Event_Start_Time"] . '",
							   "endTime":"' . $row["Event_End_Time"] . '",
                               "email":"' . $row["Contact_Email"] . '",
                               "phone":"' . $row["Contact_Phone"] . '",
                               "desc":"' . $row["Description"] . '",
                               "address":"' . $row["Address"] . '",
                               "lat":"' . $row["Latitude"] . '",
                               "long":"' . $row["Longitude"] . '"
                             }';
                $searchResults .= $thisEvent;

                if($searchCount >  1)
                {
                    $searchResults .= ",";
                }
                $searchCount--;
            }
            returnWithInfo($searchResults);
        }
        else
        {
            returnWithError("No Pending Events.");
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
