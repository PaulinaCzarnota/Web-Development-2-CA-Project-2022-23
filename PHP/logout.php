<!DOCTYPE html>
<html lang="en">

    <head>

        <title>Logout · eLibrary</title>

    </head>

	<body>

        <?php
            
            session_start();
            session_destroy();
            header("Location: index.php?page=0");
            
        ?>

    </body>

</html>