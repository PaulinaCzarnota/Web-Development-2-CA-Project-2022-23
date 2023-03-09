<!DOCTYPE html>
<html lang="en">

    <head>

        <title>Database Connection</title>

    </head>

    <body>

        <?php

            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "bookdb";

            $connection = new mysqli($servername, $username, $password, $dbname);

            if ($connection -> connect_error) 
            {
                die ("Connection Failed: " . $connection -> connect_error);
            }

        ?>

    </body>

</html>