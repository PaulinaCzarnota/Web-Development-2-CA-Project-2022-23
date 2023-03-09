<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset='utf-8'>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Reservations · eLibrary</title>

        <link rel="stylesheet" href="../CSS/style.css">

    </head>

    <body id="background">
        <div id="main">

            <header>

                <br>
                <h1 id="header">eLibrary Ireland</h1>
                <br>
                <hr>

            </header>


        <?php

            session_start();

            if(!$_SESSION["username"])
            {
                header("location:index.php?page=0");
            }

            require_once "database_connect.php";

            if (isset($_GET["book"])) 
            {
                $ISBN = $_GET["book"];
                $username = $_SESSION["username"];
                $reservedate = date('Y-m-d');
                $sql = "INSERT INTO reservedbooktable (ISBN, Username, ReservedDate) VALUES ('$ISBN', '$username', '$reservedate')";

                if ($connection -> query($sql) === TRUE) 
                {
                    echo "<script>alert('New Reservation Added')</script>";
                    $sql = "UPDATE bookstable SET Reserved = 'Y' WHERE ISBN = '$ISBN'";
                    $connection -> query($sql);
                } 

                else 
                {
                    echo "Error: Reservation could not be completed";
                }
            }
            
            if(isset($_GET["remove"])) 
            {
                $ISBN = $_GET["remove"];
                $sql = "DELETE FROM reservedbooktable WHERE ISBN = '$ISBN'";

                if ($connection -> query($sql) === TRUE) 
                {
                    echo "<script>alert('Reservation Deleted')</script>";
                    $sql = "UPDATE bookstable SET Reserved = 'N' WHERE ISBN = '$ISBN'";
                    $connection -> query($sql);
                } 

                else 
                {
                    echo "Error: Reservation could not be deleted";
                }
            }

        ?>

        <div id="result">

        <?php
            
            $username = $_SESSION["username"];
            $check = false;

            $result = mysqli_query($connection, "SELECT * FROM bookstable LEFT JOIN reservedbooktable ON bookstable.ISBN = reservedbooktable.ISBN");
            
            if ($result === false) 
            {
                echo "There was an error when processing the request";
                die(mysqli_error($connection)); 
            }

                if($result -> num_rows > 0)
                {
                    echo "<table border='1'>";
                    echo "<thead>";
                    echo "</tr><td>"; echo "ISBN";
                    echo "</td><td>"; echo "Title";
                    echo "</td><td>"; echo "Author";
                    echo "</td><td>"; echo "Edition";
                    echo "</td><td>"; echo "Year";
                    echo "</td><td>"; echo "Category";
                    echo "</td><td>"; echo "ReservedDate";
                    echo "</td><td>"; echo "Reserved";
                    echo "</td></tr>\n";
                    echo "</thead>\n";
                    
                    $i = 0;

                    while($row = mysqli_fetch_array($result))
                    {
                        if ($row[8] == $username)
                        {
                            if (($i % 2) == 0)
                            {
                                echo "<tr class =\"even\"><td>"; 
                            }
                
                            else
                            {
                                echo "<tr><td>"; 
                            }

                            echo $row[0];
                            echo "</td><td>"; echo $row[1];
                            echo "</td><td>"; echo $row[2];
                            echo "</td><td>"; echo $row[3];
                            echo "</td><td>"; echo $row[4];
                            echo "</td><td>"; echo $row[5];
                            echo "</td><td>"; echo $row[9];
                            echo "</td>"."<td><button onclick=".'location.href="reserve.php?remove='.$row["ISBN"].'"; return false >Remove</button></td>'."</tr>\n";

                            $check = true;
                            $i++;
                        }
                    }

                    echo "</table>";
                }

            if ($check == false)
            {
                echo "0 results found";
            }
    
        ?>
                
        </div>
            
        <div><button onclick='location.href="index.php?page=0"; return false'>Return to Homepage</button></div>
        <hr>
        
        <footer>Copyright © 2022 Paulina Czarnota · All rights reserved.</footer>

        </div>

    </body>

</html>