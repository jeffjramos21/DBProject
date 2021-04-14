<?php
   header("Access-Control-Allow-Origin: *");
   header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
   header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");
   date_default_timezone_set('America/New_York');

   // Register a user.
   $inData = getRequestInfo();
   $User_ID = $inData['studID'];
   $first = $inData['firstName'];
   $last = $inData['lastName'];
   $university = $inData['university'];
   $email = $inData['email'];
   $password = $inData['password'];

   //$datelaston= getdate(YYYY/MM/DD);

   // hash password
   $password = password_hash($password, PASSWORD_DEFAULT);
   // connect to mysql database
   $conn = new mysqli('localhost', 'root', '', 'website');

   // check for connectivity issues
   if ($conn->connect_error) 
   {
      returnWithError("Connection Failed.");
   }

   else
   {
      // query the database with the user information
      $sql = "INSERT INTO users(first,last,university,User_ID,email,password) VALUES ('" . $first . "','" . $last . "','" . $university . "','" . $User_ID . "','" . $email . "','" . $password . "')";
      $result = $conn->query($sql);

      if($result != TRUE)
		{
			returnWithError("Email address is already taken!");
      }
      
      else 
      {  
         $sql2 = "INSERT INTO student_attends (Uni_Name,User_ID) VALUES ('" . $university . "','" . $User_ID . "')";
         $result2 = $conn->query($sql2);
         if($result2 != TRUE)
         {
            returnWithError("user ID belongs to someone else!");
         }
         else
         {
            returnWithInfo("we did it!");
         }
      }

		$conn->close();
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

   function returnWithID($User_ID)
   {
      $retValue = '{"User_ID":"' . $User_ID . '"}';
		sendResultInfoAsJson($retValue);
   }
?>