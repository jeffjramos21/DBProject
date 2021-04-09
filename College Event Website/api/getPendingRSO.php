<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");

    $inData = getRequestInfo();
    $Uni_Name = "";
    $rso_name = "";
    $rso_desc = "";
    $rso_admin_email = "";
    $email2 = "";
    $email3 = "";
    $email4 = "";
    $email5 = "";
    $searchCount = 0;
    $searchResults ="";

    $conn = new mysqli('localhost', 'root', '', 'website');

    if ($conn->connect_error) 
    {
        returnWithError("Connection Failed.");
    }

    else
    {
        $sql = "SELECT * FROM pending_RSO";
        $result = $conn->query($sql);
        $searchCount = $conn->query($sql)->num_rows;
        
        if($searchCount > 0)
        {
            while($searchCount > 0)
            {
                $row = $result->fetch_assoc();
                $thisRSO = '{"Uni_Name":"' .$row["Uni_Name"] . '", 
                             "rso_name":"' .$row["rso_name"] . '",
                             "rso_desc":"' .$row["rso_desc"] . '", 
                             "rso_admin_email":"' .$row["rso_admin_email"] . '", 
                             "email2":"' .$row["email2"] . '", 
                             "email3":"' .$row["email3"] . '", 
                             "email4":"' .$row["email4"] . '", 
                             "email5":"' .$row["email5"] . '"
                            }';
                $searchResults .= $thisRSO;

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
            returnWithError("No Pending Requests!");
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