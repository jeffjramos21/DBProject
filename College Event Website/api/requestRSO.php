<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");
    
    $inData = getRequestInfo();
    $rso_name = $inData['rsoName'];
    $rso_desc = $inData['description'];
    $admin_email = $inData['admin'];
    $email2 = $inData['mem1'];
    $email3 = $inData['mem2'];
    $email4 = $inData['mem3'];
    $email5 = $inData['mem4'];
    $userID = $inData['userID'];

        $conn = new mysqli('localhost', 'root', '', 'website');

    if ($conn->connect_error) 
    {
       returnWithError("Connection Failed.");
    }

    else
    {
        $sql2 = "SELECT Uni_Name from student_attends where User_ID = '" . $userID ."'";
        $result2 = $conn->query($sql2);
        if($result2->num_rows > 0)
        {   
            $row = $result2->fetch_assoc();
            $uni = $row["Uni_Name"];
            //echo($uni);
            //returnWithError("Didnt work!");   
            $sql = "INSERT INTO pending_RSO(Uni_Name,rso_name,rso_desc,rso_admin_email,email2,email3,email4,email5) VALUES ('" . $uni . "','" . $rso_name . "','" . $rso_desc . "','" . $admin_email . "','" . $email2 . "','" . $email3 . "','" . $email4 . "','" . $email5 . "')";
            $result = $conn->query($sql);
            
            if($result != TRUE)
            {
                  returnWithError("Request no permitted");
            }
            else{
                  returnWithInfo("Needs to be approved first");
            }
        }
        else
        {
            returnWithError("NOOOOOOO!!!");
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
