<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");

    $inData = getRequestInfo();
   
    $rsoName = $inData['pendingRSO'];


    $conn = new mysqli('localhost', 'root', '', 'website');

    if ($conn->connect_error) 
    {
        returnWithError("Connection Failed.");
    }
    else
    {
        $sql1 = "SELECT Uni_Name, rso_desc,rso_admin_email FROM pending_RSO where rso_name = '" . $rsoName . "'";
        $result1 = $conn->query($sql1);
      
        if($result1->num_rows > 0)
        {
            $row = $result1->fetch_assoc();
            $uni = $row['Uni_Name'];
            $desc = $row["rso_desc"];
            $email = $row["rso_admin_email"];
            

            $sql = "INSERT INTO rsos(RSO_Name,Uni_Name,description,Admin_email) values ('" . $rsoName . "', '" . $uni . "', '" . $desc . "', '" . $email . "')";
            $result = $conn->query($sql);

            if($result != TRUE)
            {
                returnWithError("rso already exists!");
            }
            else
            {

                $sql3 = "DELETE FROM pending_RSO where rso_name = '" . $rsoName . "'";
                $result3 = $conn->query($sql3);
                //echo($rsoName);
                if($result3 != TRUE)
                {
                    returnWithError("not deleted from pending rsos");
                }
                else
                {   
                    $sql4 = "SELECT User_ID from users where email = '" . $email . "'";
                    $result4 = $conn->query($sql4);
                    if($result4->num_rows > 0)
                    {
                        $row = $result4->fetch_assoc();
                        $userID = $row['User_ID'];

                        $sql5 = "INSERT into admins(User_ID) values ('" . $userID ."')";
                        $result5 = $conn->query($sql5);
                        if($result5 != TRUE)
                        {
                            returnWithError("admin not added to list");
                        }
                        else
                        {
                            returnWithInfo("rso approved and admin successfully added");
                        }
                        
                    }
                     
                }
                
            }
        }
        else
        {
            returnWithError("oopsies");
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