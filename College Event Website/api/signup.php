<?php
   header("Access-Control-Allow-Origin: *");
   header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
   header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");

   // Register a user.
   $inData = getRequestInfo();
   $User_ID = $inData['studID'];
   $first = $inData['firstName'];
   $last = $inData['lastName'];
   $university = $inData['university'];
   $email = $inData['email'];
   $password = $inData['password'];

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

      //////////////////////////////////////////////////////////////
      // NEED TO FIGURE OUT HOW TO ADD UNIVERSITY ID WITH STUDENT ID
      //////////////////////////////////////////////////////////////
      /*
         $studentAttends = "INSERT INTO student = 
      */
      
	  // check if records are inserted
      if($result != TRUE)
		{
			returnWithInfo("Email address is already taken!");
		}
      
      else 
      {
         returnWithInfo("we did it!");
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