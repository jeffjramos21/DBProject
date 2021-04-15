<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");

    $inData = getRequestInfo();
    $searchCount = 0;
    $searchResults = "";
    $userID = $inData['userID'];

    $conn = new mysqli('localhost', 'root', '', 'website');

    if ($conn->connect_error) 
    {
       returnWithError("Connection Failed.");
    }

    else
    {
            $sql = "SELECT Uni_Name from student_attends where User_ID = '".$userID."'";
            $result = $conn->query($sql);
            if($result->num_rows > 0)
            {
                $row = $result->fetch_assoc();
                $uni = $row["Uni_Name"];
                
                $sql = "SELECT RSO_Name FROM rsos where Uni_Name = '".$uni."'";
                $result = $conn->query($sql);
                $searchCount = $conn->query($sql)->num_rows;

                if($searchCount > 0)
                {
                    while($searchCount > 0)
                    {
                        $row = $result->fetch_assoc();
                        $thisRSO = '{"RSO":"' . $row["RSO_Name"] . '"}';
                   
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
                    returnWithError("No RSO's!");
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
        $retValue = '{"results":[' . $searchResults . ']}';
        sendResultInfoAsJson($retValue);
    }

?>
