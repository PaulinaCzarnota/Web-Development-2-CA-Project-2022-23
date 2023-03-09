<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset='utf-8'>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Homepage · eLibrary</title>

        <link rel="stylesheet" href="../CSS/style.css"> 
        
    </head>

    <?php

        session_start(); 
        
        require_once "database_connect.php";

        if (isset($_SESSION["success"])) 
        {
            echo("<script>alert('".$_SESSION["success"]."')</script>");
            unset($_SESSION["success"]);
            $_POST['book'] = '';
            $_POST['searchtype'] = 'both';
            $_SESSION['searchtype'] = $_POST['searchtype'];
        }

        if (!isset($_SESSION["username"])) 
        {
            echo("<script>alert('No user logged in')</script>");
            session_destroy();
            header('Location: login.php');
            exit();
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

            <div>

                <button onclick="location.href='logout.php'; return false ">Logout</button>

            </div>

            <div id="box">

                <h2>Search</h2>

                <?php

                    if (isset($_SESSION["error"])) 
                    {
                        if ($_SESSION['error'] == 'Error: Please choose a searchtype') 
                        {
                            $_POST['book'] = '';
                            $_POST['searchtype'] = 'both';
                        }

                        echo("<script>alert('".$_SESSION["error"]."')</script>");
                        unset($_SESSION["error"]);

                    }

                ?>

                <form method="post">

                    <div>Search by keyword (Book Title or Author)<input type="text" name="book"></div>
                    
                    <div>

                        <input class="rad" type="radio" id="bt" name="searchtype" value="booktitle"
                        <?php if (isset($_POST['searchtype']) && $_POST['searchtype'] == 'booktitle') echo 'checked'?>>
                        <label for="bt">Book Title</label>
                        <br>

                        <input class="rad" type="radio" id="aut" name="searchtype" value="author"
                        <?php if (isset($_POST['searchtype']) && $_POST['searchtype'] == 'author') echo 'checked'?>>
                        <label for="aut">Author</label>
                        <br>

                        <input class="rad" type="radio" id="b" name="searchtype" value="both"
                        <?php if (isset($_POST['searchtype']) && $_POST['searchtype'] == 'both') echo 'checked'?>>
                        <label for="b">Both</label>

                    </div>

                    <button type="submit">Search</button>

                </form>

                <form method="post" name="CategorySelect">

                    <p>Search by Category Description</p>
                    
                    <select name="categorytable" onchange="CategorySelect.submit()">
                    <option value="">-- Please Select --</option>

                    <?php

                        $sql = "SELECT CategoryDescription FROM categorytable";
                        $result = $connection -> query($sql);

                        while($row = $result -> fetch_assoc()) 
                        {
                            echo("<option value='".$row["CategoryDescription"]."'>".$row["CategoryDescription"]."</option>");
                        }
                    ?>

                    </select>

                </form>

            </div>

            <div id="result">

            <div class="button"><button onclick="location.href='reserve.php'; return false ">View Reserved Books</button></div>
            <br>

            <?php

                if(!isset($_POST['book']) && !isset($_SESSION['categorytable'])) 
                {
                    $_POST['book'] = $_SESSION['book'];
                }

                if(isset($_POST['categorytable'])) 
                {
                    unset($_POST['book']);
                }

                if(isset($_POST['book'])) 
                {
                    unset($_SESSION['categorytable']);
                    $book = $_POST['book'];
                        
                    if(isset($_GET['page'])) 
                    {
                        $page = $_GET['page'];
                    }

                    if(isset($_POST['searchtype'])) 
                    {
                        $_SESSION['searchtype'] = $_POST['searchtype'];
                    }

                    else 
                    {
                        $_POST['searchtype'] = $_SESSION['searchtype'];
                    }

                    if (isset($_GET['page']) && isset($_POST['searchtype']) && $_POST['searchtype'] == 'booktitle') 
                    {
                        $sql = "SELECT * FROM bookstable WHERE (BookTitle LIKE '%$book%')";
                        $result = $connection -> query($sql);
                        $pagenum = ceil(($result -> num_rows) / 5);

                        if($pagenum < ($page / 5) + 1 && $result -> num_rows > 0) 
                        {
                            $_SESSION['book'] = $book;
                            header("Location: index.php?page=0");
                            exit();
                        }

                        $sql= "SELECT * FROM bookstable WHERE (BookTitle LIKE '%$book%') LIMIT $page, 5";
                    }

                    elseif (isset($_GET['page']) && isset($_POST['searchtype']) && $_POST['searchtype'] == 'author') 
                    {  
                        $sql = "SELECT * FROM bookstable WHERE (Author LIKE '%$book%')";
                        $result = $connection -> query($sql);
                        $pagenum = ceil(($result -> num_rows) / 5);

                        if($pagenum < ($page / 5) + 1 && $result -> num_rows > 0) 
                        {
                            $_SESSION['book'] = $book;
                            header("Location: index.php?page=0");
                            exit();
                        }

                        $sql = "SELECT * FROM bookstable WHERE (Author LIKE '%$book%') LIMIT $page, 5";      
                    }

                    elseif (isset($_GET['page']) && isset($_POST['searchtype']) && $_POST['searchtype'] == 'both') 
                    {
                        $sql = "SELECT * FROM bookstable WHERE (BookTitle LIKE '%$book%' OR Author LIKE '%$book%')";
                        $result = $connection -> query($sql);
                            $pagenum = ceil(($result -> num_rows) / 5);

                        if($pagenum < ($page / 5) + 1 && $result -> num_rows > 0) 
                        {
                            $_SESSION['book'] = $book;
                            header("Location: index.php?page=0");
                            exit();
                        }

                        $sql = "SELECT * FROM bookstable WHERE (BookTitle LIKE '%$book%' OR Author LIKE '%$book%') LIMIT $page, 5";
                    }

                    $result = $connection -> query($sql);

                    if ($result -> num_rows > 0) 
                    {
                        echo "searched by: ".$_POST['searchtype'];
                        echo "<table border='1'>";
                        echo "<thead>";
                        echo "<tr><td>"."ISBN".
                        "</td><td>"."BookTitle".
                        "</td><td>" ."Author".
                        "</td><td>" ."Edition".
                        "</td><td>" ."Year".
                        "</td><td>" ."CategoryID".
                        "</td><td>" ."Reserved".
                        "</td></tr>\n";
                        echo "</thead>\n";

                        while($row = $result -> fetch_assoc()) 
                        {
                            echo "<tr><td>";
                            echo $row["ISBN"].
                            "</td><td>" .$row["BookTitle"].
                            "</td><td>" .$row["Author"].
                            "</td><td>" .$row["Edition"].
                            "</td><td>" .$row["Year"].
                            "</td><td>" .$row["CategoryID"].
                            "</td><td>" .$row["Reserved"].
                            "</td>";

                            if($row["Reserved"] == 'N') 
                            {
                                echo "<td><button onclick=".'location.href="reserve.php?book='.$row["ISBN"].'"; return false >Reserve</button></td>';
                            }

                            echo "</tr>\n";
                        }

                        echo "</table>\n";
                        $i = 0;

                        while($i < $pagenum) 
                        {
                            echo "<button"." onclick=".'location.href="index.php?page='.($i * 5).'"; return false >'.($i + 1)."</button>";
                            $_SESSION['book'] = $book;
                            $i++;
                        }
                    }
                        else 
                        {
                            echo "searched by: ".$_POST['searchtype']."</br>";
                            echo "0 results found";
                        }
                }

                if(!isset($_POST['categorytable']) && !isset($_SESSION['book'])) 
                {
                    $_POST['categorytable'] = $_SESSION['categorytable'];
                }

                if(isset($_POST['book'])) 
                {
                    unset($_POST['categorytable']);
                }

                if(isset($_POST['categorytable'])) 
                {
                    unset($_SESSION['book']);
                    $category = $_POST['categorytable'];

                    if(isset($_GET['page'])) 
                    {
                        $page = $_GET['page'];
                    }

                    if($category == '' && ! isset($_GET['categorytable'])) 
                    {
                        $sql = "SELECT * FROM bookstable";
                    }

                    elseif(isset($_GET['categorytable']) && $category == '') 
                    {
                        $sql = "SELECT * FROM bookstable";
                        $result = $connection -> query($sql);
                        $pagenum = ceil(($result -> num_rows) / 5);
                        $sql = "SELECT * FROM bookstable LIMIT $page, 5";
                    }

                    else 
                    {
                        $sql = "SELECT * FROM bookstable WHERE CategoryID LIKE (SELECT CategoryID FROM categorytable WHERE CategoryDescription = '$category')";
                        $result = $connection -> query($sql);
                        $pagenum = ceil(($result -> num_rows) / 5);
                        $sql = "SELECT * FROM bookstable WHERE CategoryID LIKE (SELECT CategoryID FROM categorytable WHERE CategoryDescription = '$category') LIMIT $page, 5";
                    }

                    $result = $connection -> query($sql);

                    if ($result -> num_rows > 0) 
                    {
                        echo "<table border='1'>";
                        echo "<thead>";
                        echo "</tr><td>" ."ISBN";
                        echo "</td><td>" ."BookTitle";
                        echo "</td><td>" ."Author";
                        echo "</td><td>" ."Edition";
                        echo "</td><td>" ."Year";
                        echo "</td><td>" ."CategoryID";
                        echo "</td><td>" ."Reserved";
                        echo "</td></tr>\n";
                        echo "</thead>\n";

                        while($row = $result -> fetch_assoc()) 
                        {
                            echo "<tr><td>";
                            echo $row["ISBN"].
                            "</td><td>" .$row["BookTitle"].
                            "</td><td>" .$row["Author"].
                            "</td><td>" .$row["Edition"].
                            "</td><td>" .$row["Year"].
                            "</td><td>" .$row["CategoryID"].
                            "</td><td>" .$row["Reserved"].
                            "</td>";

                            if($row["Reserved"] == 'N') 
                            {
                                echo "<td><button onclick=".'location.href="reserve.php?book='.$row["ISBN"].'"; return false >Reserve</button></td>';
                            }

                            echo "</tr>\n";
                        }

                        echo "</table>\n";

                        $i = 0;

                        while($i < $pagenum) 
                        {
                            echo "<button"." onclick=".'location.href="index.php?page='.($i * 5).'"; return false >'.($i + 1)."</button>";
                            $_SESSION['categorytable'] = $category;
                            $i++;
                        }
                    }

                        else 
                        {
                            echo "0 results found";
                        }
                }

                ?>

            </div>

            <hr>
            <footer>Copyright © 2022 Paulina Czarnota · All rights reserved.</footer>

        </div>

    </body>

</html>