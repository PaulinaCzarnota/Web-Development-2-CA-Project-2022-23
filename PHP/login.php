<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset='utf-8'>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
         
        <title>Login · eLibrary</title>

        <link rel="stylesheet" href="../CSS/style.css">       

    </head>

    <?php

        session_start(); 
        
        require_once "database_connect.php";

        if (!empty($_POST["username"]) && !empty($_POST["password"])) 
        {
            $username = $_POST["username"];
            $password = $_POST["password"];
            $sql = "SELECT Username, Password FROM userstable";
            $result = $connection -> query($sql);

            if ($result -> num_rows > 0) 
            {
                while($row = $result -> fetch_assoc()) 
                {
                    if($username == $row["Username"] && $password == $row["Password"]) 
                    {
                        $_SESSION["username"] = $username;
                        $_SESSION["success"] = "Login Successful";
                        header("Location: index.php?page=0");
                        exit();
                    }
                }

                $_SESSION["error"] = "Incorrect username or password. Please try again.";
                header("Location: login.php");
                exit(); 
            }
        }

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
                <h2>Login</h2>

                <?php

                    if (isset($_SESSION["error"])) 
                    {
                        echo("<script>alert('".$_SESSION["error"]."')</script>");
                        unset($_SESSION["error"]);
                    }

                ?>

                <form method="post">

                    <p>Username:<input type="text" name="username"></p>
                    <p>Password:<input type="password" name="password"></p>
                    <button type="submit">Login</button>
                    <button onclick="location.href='register.php'; return false ">Register</button>

                </form>

            </div>

            <hr>
            <footer>Copyright © 2022 Paulina Czarnota · All rights reserved.</footer>

        </div>

    </body>  

</html>