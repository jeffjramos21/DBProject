<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");
    
    $public = "Public";
    $private = "Private";
    $inData = getRequestInfo();
    $eventNameVar = $inData['eventName'];
    $searchCount = 0;
    $searchResults ="";
   
    $conn = new mysqli('localhost', 'root', '', 'website');

    if ($conn->connect_error) 
    {
       returnWithError("Connection Failed.");
    }

    else
    {           $sql = "SELECT Event_Type 
                FROM public_events 
                where Event_Name = '" . $eventNameVar . "'
                UNION ALL
                SELECT Event_Type
                FROM private_events
                where Event_Name = '".$eventNameVar."'
                UNION ALL
                SELECT Event_Type
                FROM rso_events
                WHERE Event_Name = '".$eventNameVar."'
                ";
                 
        $result = $conn->query($sql);
        
        if($result->num_rows > 0 || $result->num_rows <= 0)
        {
            $row = $result->fetch_assoc();
            $eventType = $row["Event_Type"];

            if($eventType == $public)
            {
                $sql2 = "SELECT User_ID,Name,text,rating,date FROM public_event_comments where Event_Name = '" . $eventNameVar . "'";
                $result2 = $conn->query($sql2);

                $searchCount = $conn->query($sql2)->num_rows;
                //echo("in private comments");
                if($searchCount > 0)
                {
                    while($searchCount > 0)
                    {
                        $row = $result2->fetch_assoc();
                        $thisComment = '{"User_ID":"' . $row["User_ID"] . '",
                                        "name":"' . $row["Name"] . '", 
                                        "text":"' . $row["text"] . '",
                                        "rating":"' . $row["rating"] . '",
                                        "date":"' . $row["date"] . '"
                                        }';
                        $searchResults .= $thisComment;

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
                    returnWithError("No Comments yet!");
                }
            }
            else if($eventType == $private)
            {
                $sql3 = "SELECT User_ID,Name,text,rating,date FROM private_event_comments where Event_Name = '" . $eventNameVar . "'";
                $result3 = $conn->query($sql3);
                $searchCount = $result3->num_rows;

                if($searchCount > 0)
                {
                    while($searchCount > 0)
                    {
                        $row = $result3->fetch_assoc();
                        $thisComment = '{"User_ID":"' . $row["User_ID"] . '",
                                        "name":"' . $row["Name"] . '", 
                                        "text":"' . $row["text"] . '",
                                        "rating":"' . $row["rating"] . '",
                                        "date":"' . $row["date"] . '"
                                        }';
                        $searchResults .= $thisComment;
    
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
                    returnWithError("No Comments yet!");
                }
            }
            else
            {
                $sql3 = "SELECT User_ID,Name,text,rating,date FROM rso_event_comments where Event_Name = '" . $eventNameVar . "'";
                $result3 = $conn->query($sql3);
                $searchCount = $result3->num_rows;
                if($searchCount > 0)
                {
                    while($searchCount > 0)
                    {
                        $row = $result3->fetch_assoc();
                        $thisComment = '{"User_ID":"' . $row["User_ID"] . '",
                                        "name":"' . $row["Name"] . '", 
                                        "text":"' . $row["text"] . '",
                                        "rating":"' . $row["rating"] . '",
                                        "date":"' . $row["date"] . '"
                                        }';
                        $searchResults .= $thisComment;
    
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
                    returnWithError("No Comments yet!");
                }
            }
        }
        else
        {
            returnWithError("EVENT DOES NOT EXIST!");
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
        $retValue = '{"results":[' . $searchResults . ']}';
        sendResultInfoAsJson($retValue);
    }
?>