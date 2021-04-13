<?php
         header("Access-Control-Allow-Origin: *");
         header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
         header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");
    $public = "Public";
    $private = "Private";
    $RSO = "RSO";
    

    $inData = getRequestInfo();
    $Event_Name = $inData["eventName"];
    $Event_Type = $inData["type"];
    $date = $inData["date"];
    $start = $inData["startTime"];
    $end = $inData["endTime"];
    $email = $inData["email"];
    $phone = $inData["phone"];
    $desc = $inData["description"];
    $address = $inData["address"];
    $Cat = $inData['category'];
    $rso = $inData['rso'];
    $lat = $inData["lat"];
    $lon = $inData["lng"];
    $userID = $inData['userID'];

    // Connecting to database
    $conn = new mysqli('localhost', 'root', '', 'website');
    if($conn->connect_error)
    {
        returnWithError("Connection Failed");
    }

    else
    {   
		$sql3 = "SELECT Uni_Name from student_attends where User_ID = '".$userID."'";
        $results3 = $conn->query($sql3);
		
		if($results3->num_rows > 0)
        {
            $row = $results3->fetch_assoc();
            $uni = $row["Uni_Name"];
			
        if($Event_Type == $public)
        {   
            $sql = "INSERT INTO pending_events(Event_Name, Event_Type, Event_Category, Event_Date, Event_Start_Time, Event_End_Time,Contact_Email, Contact_Phone, Description, Address,Latitude,Longitude) VALUES ('" . $Event_Name . "', '" . $Event_Type . "', '" . $Cat . "', '" . $date . "', '" . $start . "','" . $end . "', '" . $email . "', '" . $phone . "', '" . $desc . "', '" . $address . "', '" . $lat . "','" . $lon . "')";
            //$locations = "INSERT INTO location(Latitude,Longitude) VALUES ('" . $lat . "','" . $lon . "')";
           
            $result1 = $conn->query($sql);
            //$result2 = $conn->query($locations);

            if($result1 != TRUE)
            {
                returnWithError("Didn't work! public");
            }

            else
            {
                returnWithInfo("public event needs approval");
            }
            $conn->close();
        
        }

        else if($Event_Type == $private)
        {        
            $sql = "INSERT INTO pending_events(Event_Name, Event_Type, Event_Category, Event_Date, Event_Start_Time, Event_End_Time, Contact_Email, Contact_Phone, Description, Address,Latitude,Longitude,Uni_Name) VALUES ('" . $Event_Name . "', '" . $Event_Type . "', '" . $Cat . "', '" . $date . "', '" . $start . "','" . $end . "', '" . $email . "', '" . $phone . "', '" . $desc . "', '" . $address . "', '" . $lat . "','" . $lon . "','" . $uni . "')";
            //$locations = "INSERT INTO location(Latitude,Longitude) VALUES ('" . $lat . "','" . $lon . "')";

            if($result = $conn->query($sql) != TRUE)
            {
                
                returnWithError("Didn't work! private");
            }

            else
            {
                returnWithInfo("private event needs approval");
            }
            $conn->close();
        }
          

        else if($Event_Type == $RSO)
        {
            
            $sql = "INSERT INTO rso_events(Event_Name, Event_Type, Event_Category, Rso_Name, Event_Date,Event_Start_Time, Event_End_Time, Contact_Email, Contact_Phone, Description, Address,Uni_Name) VALUES ('" . $Event_Name . "', '" . $Event_Type . "', '" . $Cat . "', '" . $rso . "', '" . $date . "', '" . $start . "','" . $end . "', '" . $email . "', '" . $phone . "', '" . $desc . "', '" . $address . "','" . $uni . "')";
            $location = "INSERT INTO location(Location_ID, Latitude,Longitude) VALUES ('" . $Event_Name . "','" . $lat . "','" . $lon . "')";
            $result = $conn->query($sql);

            if(($result)!= TRUE)
            {
				returnWithError("NO RSO EVENT CREATED!");       
            }

            else
            {
				returnWithInfo("Event Created");   
               
            }
            $conn->close();
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

?>