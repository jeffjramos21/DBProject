<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");

    // Login as a user
    $inData = getRequestInfo();
    $User_ID = 0;
    $email = $inData["email"];
    $password = $inData["password"];
    
    //$password = password_hash($password, PASSWORD_DEFAULT);
    // Connecting to database
   $conn = new mysqli('localhost', 'root', '', 'website');
    if($conn->connect_error)
    {
        returnWithError("Connection Failed");
    }

    else
    {
        $sql = "SELECT User_ID ,password,first,last FROM users where email = '" . $email . "'" ;
        $result = $conn->query($sql);

        if($result->num_rows > 0)
        {
            $row = $result->fetch_assoc();
            $User_ID = $row["User_ID"];
            $hash = $row["password"];
            $first = $row["first"];
            $last = $row["last"];
            
            if(password_verify($password, $hash))
            {   
                
                $superCheck = "SELECT User_ID FROM superAdmins  WHERE User_ID = '" . $User_ID . "'";
                $superNum = $conn->query($superCheck)->num_rows;
                
                if($superNum > 0)
                {   
                    $role = "SA";
                    //echo($role);
                    returnWithInfo($User_ID, $first, $last, $role);
                }
                else 
                {
                    $adminCheck = "SELECT User_ID FROM admins  WHERE User_ID = '" . $User_ID . "'";
                    $adminNum = $conn->query($adminCheck)->num_rows;
                    if($adminNum > 0)
                    {
                        $role = "A";
                        //echo($role);
                        returnWithInfo($User_ID, $first, $last, $role);
                    }
                    else
                    {
                        $role = "S";
                        //echo($role);
                        returnWithInfo($User_ID, $first, $last, $role);
                    }
                }
            }
            else
            { 
                returnWithError("Incorrect Password.");
            }
        }
        else
        {
            returnWithError("No Matching Records!");
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

    function returnWithInfo($User_ID, $first, $last, $role)
    {
        $retValue = '{"User_ID":' . $User_ID . ',"first":"' . $first . '","last":"' . $last . '","role":"' . $role . '"}';
        sendResultInfoAsJson($retValue);
    }
?>