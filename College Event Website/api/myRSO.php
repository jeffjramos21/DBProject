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
        $sql =" SELECT RSO_Name from joined where User_ID = '".$userID."'";
        $result = $conn->query($sql);

        $searchCount = $result->num_rows;
        if($searchCount > 0)
        {
            while($searchCount > 0)
            {
                $row = $result->fetch_assoc();
                $thisRSO = '{"rsoName":"'.$row["RSO_Name"].'"}';
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
            returnWithError("You are not a member of any RSOs");
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