<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");

    $inData = getRequestInfo();
    $rso = $inData['pendingRSO'];
	$conn = new mysqli('localhost', 'root', '', 'website');
	
    if ($conn->connect_error) 
    {
       returnWithError("Connection Failed.");
    }
    else
    {
        $sql = "DELETE FROM pending_RSO where rso_name = '" . $rso . "'";
        $result = $conn->query($sql);

        if($result != TRUE)
        {
            returnWithError("RSO does not exist!");
        }
        else
        {
            returnWithInfo("RSO DENIED AND DELETED");
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
