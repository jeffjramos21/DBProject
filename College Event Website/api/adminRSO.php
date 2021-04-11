<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");

    $inData = getRequestInfo();
    $userID = $inData["userID"];
    $searchCount = 0;
    $searchResults = "";
    
    $conn = new mysqli('localhost', 'root', '', 'website');
    if($conn->connect_error)
    {
        returnWithError("Connection Failed");
    }
    else
    {
        $sql ="SELECT email from users where User_ID = '" . $userID . "'";
        $result = $conn->query($sql);

        if($result->num_rows > 0)
        {
            $row = $result->fetch_assoc();
            $email = $row["email"];

            $sql1 = "SELECT RSO_Name from rsos where Admin_Email = '" . $email . "'";
            $result2 = $conn->query($sql1);
            $searchCount = $result2->num_rows;
            if($searchCount > 0)
            {
                while($searchCount > 0)
                {
                    $row = $result2->fetch_assoc();
                    $thisAdminRSO = '{"rsoName":"'.$row["RSO_Name"].'"}';
                    $searchResults .= $thisAdminRSO;

                    if($searchCount > 1)
                    {
                        $searchResults .= ",";
                    }
                    $searchCount--;
                }
                returnWithInfo($searchResults);
            }
        }
        else
        {
            returnWithError("You are not an admin for any RSOs!");
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