<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");
    $public = "Public";
    $private = "Private";
    $inData = getRequestInfo();
    $eventName = $inData["pendingEvent"];
    
    $conn = new mysqli('localhost', 'root', '', 'website');

    if ($conn->connect_error) 
    {
        returnWithError("Connection Failed.");
    }
    else
    {
        //echo($eventName);
        $sql5 = "SELECT Event_Type,Event_Category,Event_Date,Event_Start_Time,Event_End_Time,Contact_Email,Contact_Phone,Description,Address,Latitude,Longitude,Uni_Name FROM pending_events where Event_Name = '" . $eventName . "'";
        $result5 = $conn->query($sql5);
        if($result5->num_rows > 0)
        {
            //echo("Inside first sql1");
            $row = $result5->fetch_assoc();
            $Event_Type = $row["Event_Type"];
            $Cat = $row["Event_Category"];
            $date = $row["Event_Date"];
            $end = $row["Event_End_Time"];
            $start =$row["Event_Start_Time"];
            $email = $row["Contact_Email"];
            $phone = $row["Contact_Phone"];
            $desc = $row["Description"];
            $address = $row["Address"];
            $lat = $row["Latitude"];
            $lon = $row["Longitude"];
            $uni = $row["Uni_Name"];
            //echo($uni);
            
            if($Event_Type == $public)
            {
                $sql = "INSERT INTO public_events(Event_Name, Event_Type, Event_Category, Event_Date, Event_Start_Time,Event_End_Time, Contact_Email, Contact_Phone, Description, Address) VALUES ('" . $eventName . "', '" . $Event_Type . "', '" . $Cat . "', '" . $date . "', '" . $start . "','" . $end . "', '" . $email . "', '" . $phone . "', '" . $desc . "', '" . $address . "')";
                $location = "INSERT INTO location(Location_ID, Latitude,Longitude) VALUES ('" . $eventName . "','" . $lat . "','" . $lon . "')";
                $result = $conn->query($sql);
                $result2 = $conn->query($location);

                if(($result && $result2) != TRUE)
                {
                    returnWithError("Public event not created");
                }
                else
                {
                    $sql2 = "DELETE FROM pending_events where Event_Name = '" . $eventName . "'";
                    $result2 = $conn->query($sql2);
                    if($result2 != TRUE)
                    {
                        returnWithError("Event still pending!");
                    }
                    else
                    {   
                        returnWithError("Public event created");
                    }
                }
            }
            else if($Event_Type == $private)
            {
                $sql = "INSERT INTO private_events(Event_Name, Event_Type, Event_Category, Event_Date, Event_Start_Time,Event_End_Time, Contact_Email, Contact_Phone, Description, Address,Uni_Name) VALUES ('" . $eventName . "', '" . $Event_Type . "', '" . $Cat . "', '" . $date . "', '" . $start . "','" . $end . "', '" . $email . "', '" . $phone . "', '" . $desc . "', '" . $address . "','" . $uni . "')";
                $location = "INSERT INTO location(Location_ID, Latitude,Longitude) VALUES ('" . $eventName . "','" . $lat . "','" . $lon . "')";
                $result = $conn->query($sql);
                $result2 = $conn->query($location);

                if(($result && $result2) != TRUE)
                {
                    returnWithError("Private event not created");
                }
                else
                {
                    $sql2 = "DELETE FROM pending_events where Event_Name = '" . $eventName . "'";
                    $result2 = $conn->query($sql2);
                    if($result2 != TRUE)
                    {
                        returnWithError("Event still pending!");
                    }
                    else
                    {
                        returnWithError("Private event created");
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
 
    function returnWithInfo($searchResults)
    {
       $retValue = '{"info":"' . $searchResults . '"}';
        sendResultInfoAsJson($retValue);
    }
?>