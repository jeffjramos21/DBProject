<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");

    $inData = getRequestInfo();
    $public = "Public";
    $private = "Private";
    $comment = $inData['comment'];
    $rating = $inData['rating'];
    $eventNameVar = $inData["eventName"];
    $userID = $inData["userID"];

    $conn = new mysqli('localhost', 'root', '', 'website');

    if ($conn->connect_error) 
    {
        returnWithError("Connection Failed.");
    }
    else
    {
        $sql0 ="SELECT datelaston from users where User_ID = '".$userID."'";
        $result0 = $conn->query($sql0);
        if($result0->num_rows > 0)
        {
            $row = $result0->fetch_assoc();
            $date = $row["datelaston"];
        
            $sql = "SELECT Event_Type 
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
                echo($eventType);

                if($eventType == $public)
                {
                    echo($eventType);
                    $sql3 = "UPDATE public_event_comments SET text= '".$comment."', rating = '".$rating."', date = '".$date."' where User_ID = '".$userID."'";
                    $result3 = $conn->query($sql3);
                    if($result3 != TRUE)
                    {
                        returnWithError("rating and comment not changed in public");
                    }

                    else
                    {
                        returnWithInfo("comment updated!");
                    }
                }
                else if($eventType == $private)
                {
                    $sql3 = "UPDATE private_event_comments SET text= '".$comment."', rating = '".$rating."', date = '".$date."' where User_ID = '".$userID."'";
                    $result3 = $conn->query($sql3);
                    if($result3 != TRUE)
                    {
                        returnWithError("rating and comment not changed in private");
                    }

                    else
                    {
                        returnWithInfo("comment updated!");
                    }
                }
                else
                {
                    $sql3 = "UPDATE rso_event_comments SET text= '".$comment."', rating = '".$rating."', date = '".$date."' where User_ID = '".$userID."'";
                    $result3 = $conn->query($sql3);
                    if($result3 != TRUE)
                    {
                        returnWithError("rating and comment not changed in private");
                    }

                    else
                    {
                        returnWithInfo("comment updated!");
                    }
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
       $retValue = '{"info":"' . $info . '"}';
       sendResultInfoAsJson($retValue);
    }

    function returnwithstuff($comment,$rating)
    {
        $retValue = '{"comment":'.$comment.',"rating":'.$rating.'}';
        sendResultInfoAsJson($retValue);
    }
?>
