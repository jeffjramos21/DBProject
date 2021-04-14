<?php
   header("Access-Control-Allow-Origin: *");
   header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
   header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");

   $inData = getRequestInfo();
   $userID = $inData['userID'];
   $eventName = $inData["eventName"];
   $comment = $inData['comment'];
   $rating = $inData['rating'];
   $public = "Public";
   $private = "Private";

   $conn = new mysqli('localhost', 'root', '', 'website');

   if ($conn->connect_error) 
   {
      returnWithError("Connection Failed.");
   }
   else
   {  
      $sql = "SELECT first,last,datelaston from users where User_ID = '".$userID."'";
      $result = $conn->query($sql);

      if($result->num_rows > 0)
      {
         $row = $result->fetch_assoc();
         $first = $row["first"];
         $last = $row["last"];
         $date = $row["datelaston"];
         $name = "$first $last";
        
         $sql2 = "SELECT Event_Type 
                  FROM public_events 
                  where Event_Name = '" . $eventName . "'
                  UNION ALL
                  SELECT Event_Type 
                  FROM private_events 
                  where Event_Name = '" . $eventName . "'
                  UNION ALL
                  SELECT Event_Type 
                  FROM rso_events 
                  where Event_Name = '" . $eventName . "'
                  "; 
         //$sql2 .= "SELECT Event_Type FROM private_events where Event_Name = '" . $eventName . "'";
         $result2 = $conn->query($sql2);
         
         if($result2->num_rows > 0 || $results2->num_rows <= 0)
         {
            $row = $result2->fetch_assoc();
            $eventType = $row["Event_Type"];

            if($eventType == $public)
            {  
               $sql3 = "INSERT INTO public_event_comments(User_ID,Event_Name,Name,text,rating,date) VALUES ('".$userID."','".$eventName."','".$name."','".$comment."','".$rating."','".$date."')";
               $result3 = $conn->query($sql3);
               
               if($result3 != TRUE)
               {
                  returnWithError("Comment not entered for public event!");
               }
               else
               {
                  returnWithInfo("Comment added successfully!");
               }
            }
            else if($eventType == $private)
            {
               $sql4 = "INSERT INTO private_event_comments(User_ID,Event_Name,Name,text,rating,date) VALUES ('".$userID."','".$eventName."','".$name."','".$comment."','".$rating."','".$date."')";
               $result4 = $conn->query($sql4);

               if($result4 != TRUE)
               {
                  returnWithError("Comment not entered for private event!");
               }
               else
               {
                  returnWithInfo("Comment added successfully!");
               }
            }
            else
            {
               $sql4 = "INSERT INTO rso_event_comments(User_ID,Event_Name,Name,text,rating,date) VALUES ('".$userID."','".$eventName."','".$name."','".$comment."','".$rating."','".$date."')";
               $result4 = $conn->query($sql4);

               if($result4 != TRUE)
               {
                  returnWithError("Comment not entered for rso event!");
               }
               else
               {
                  returnWithInfo("Comment added successfully!");
               }
            }
         }
      }
      else
      {
         returnWithError("User does not exist");
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
