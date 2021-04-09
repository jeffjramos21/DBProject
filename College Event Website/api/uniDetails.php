<?php
     header("Access-Control-Allow-Origin: *");
     header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
     header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");

     $inData = getRequestInfo();
     $address ="";
     $city ="";
     $state = "";
     $zip ="";
     $desc ="";
     $numStud ="";
     $Uni_Name = $inData["Uni_Name"];
     $User_ID = 0;
     $searchCount = 0;
     $searchResults = "";

     $conn = new mysqli('localhost', 'root', '', 'website');
    if($conn->connect_error)
    {
        returnWithError("Connection Failed");
    }
    else
    {   
        $sql = "SELECT * FROM universities where Uni_Name = '" . $Uni_Name ."'";
        $result = $conn->query($sql);
        //$searchCount = $results->num_rows;
         $searchCount = $conn->query($sql)->num_rows;

        if($searchCount > 0)
        {
            while($searchCount > 0)
            {
                $row = $result->fetch_assoc();
                $thisUni = '{"Uni_Name":"' . $row["Uni_Name"] . '", 
                             "Address":"' . $row["Address"] . '", 
                             "City":"' . $row["City"] . '",
                             "State":"' . $row["State"] . '",
                             "Zip":' . $row["Zip"] . ',
                             "Desc":"' . $row["Description"] . '",
                             "NumStud":' . $row["Num_Students"] . '
                            }';
                $searchResults .= $thisUni;

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
            returnWithError("No universities in database");
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
        $retValue = '{"results":' . $searchResults . '}';
        sendResultInfoAsJson($retValue);
    }
?>