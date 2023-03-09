<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset='utf-8'>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Register · eLibrary</title>

        <link rel="stylesheet" href="../CSS/style.css">
        
    </head>

    <?php

        session_start();

        require_once "database_connect.php";

        if (!empty($_POST['Username']) && !empty($_POST['Password']) && !empty($_POST['Password2'])
        && !empty($_POST['FirstName']) && !empty($_POST['Surname']) && !empty($_POST['AddressLine1']) 
        && !empty($_POST['City']) && !empty($_POST['Telephone']) && !empty($_POST['Mobile'])) 
        {
            $Username = $_POST['Username'];
            $Password = $_POST['Password'];
            $Password2 = $_POST['Password2'];

            if (strlen($Password) > 6) 
            {
                $_SESSION["error"] = "Password must be 6 characters or less";
                header('Location: register.php');
                exit();
            }
            
            if ($Password != $Password2) 
            {
                $_SESSION["error"] = "Passwords do not match";
                header('Location: register.php');
                exit();
            }

            $FirstName = $_POST['FirstName'];
            $Surname = $_POST['Surname'];
            $AddressLine1 = $_POST['AddressLine1'];
            $Addressline2 = $_POST['AddressLine2'];
            $City = $_POST['City'];
            $Telephone = $_POST['Telephone'];
            $Mobile = $_POST['Mobile'];

            if(strlen((string)$Mobile) != 10) 
            {
                $_SESSION["error"] = "Mobile phone numbers must be 10 numbers in length";
                header('Location: register.php');
                exit();
            }

            $sql = "INSERT INTO userstable VALUES ('$Username', '$Password', '$FirstName', '$Surname', '$AddressLine1', '$Addressline2', '$City', $Telephone, $Mobile)";

            if ($connection -> query($sql) === TRUE) 
            {
                echo '<script>alert("New user registered successfully");</script>';
            } 

            else 
            {
                $sql = "SELECT Username FROM userstable";
                $result = $connection -> query($sql);

                if ($result -> num_rows > 0) 
                {
                    while($row = $result -> fetch_assoc()) 
                    {
                        if($username == $row["Username"]) 
                        {
                            $_SESSION["error"] = "Error: Username already exists!";
                            header('Location: register.php');
                            exit();
                        }
                    }

                    echo "Error:" . $sql . "<br>" . $connection -> error;
                    
                }
            }
        }

        elseif (count($_POST) > 0) 
        {
            $_SESSION["error"] = "Error: Make sure all fields are filled in!";
            header('Location: register.php');
            return;
        }
        
            $connection -> close();

    ?>

    <body id="background">
        <div id="main">

            <header>

                <br>
                <h1 id="header">eLibrary Ireland</h1>
                <br>
                <hr>
                
            </header>
            
            <div id="box">

                <h2>Register</h2>

                <?php

                    if (isset($_SESSION["error"])) 
                    {
                        echo("<script>alert('".$_SESSION["error"]."')</script>");
                        unset($_SESSION["error"]);
                    }

                ?>

                <form method="post">

                    <div><label>Username:</label><input type="text" name="Username"></div>
                    <div><label>Password:</label><input type="password" name="Password"></div>
                    <div><label>Confirm Password:</label><input type="password" name="Password2"></div>
                    <div><label>First Name:</label><input type="text" name="FirstName"></div>
                    <div><label>Surname:</label><input type="text" name="Surname"></div>
                    <div><label>Address Line 1:</label><input type="text" name="AddressLine1"></div>
                    <div><label>Address Line 2:</label><input type="text" name="AddressLine2"></div>
                    <div><label>City:</label><input type="text" name="City"></div>
                    <div><label>Telephone:</label><input type="number" name="Telephone"></div>
                    <div><label>Mobile:</label><input type="number" name="Mobile"></div>

                    <button type="submit">Register</button>
                    <button onclick="location.href='login.php'; return false ">Cancel</button>

                </form>
                
            </div>

            <hr>
            <footer>Copyright © 2022 Paulina Czarnota · All rights reserved.</footer>

        </div>
        
    </body> 

</html>