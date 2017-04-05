<?php
session_start();
?>
<!DOCTYPE html>

<head>
    <title>Search</title>
    <link rel="stylesheet" href="/style/common.css">
    <link rel="stylesheet" href="/style/home.css">
    <link rel="stylesheet" href="/style/drop-down-menu.css">
    <script src="/site/script/common.js"></script>
    <!--Embedded code for Font Awesome icons-->
    <script src="https://use.fontawesome.com/4f7fcc0d3d.js"></script>
    <script>
        // add functionality to individual elements
        document.addEventListener("DOMContentLoaded", function (event) {
            //var height_left =
            //	window.innerHeight
            //	- (tag("header")[0].offsetHeight
            //		+ tag("nav")[0].offsetHeight
            //		+ tag("footer")[0].offsetHeight);
            //tag("main")[0].style.minHeight = (height_left - 40) + "px";
        });
    </script>

    <style>
        .detail_label {
            width: 90px;
            padding: 10px;
            background-color: #c8102e;
            color: #FFF9D9;
        }

        .details {
            width: 95%;
            margin-top: 5px;
            padding: 10px;
            background-color: #eee;
            border: 1px solid #555;
        }

        main a, button {
            padding: 10px;
            border: none;
            background-color: #c8102e;
            color: #FFF9D9;
            text-transform: uppercase;
            text-decoration: none;
            font: bold 14px sans-serif;
            cursor: pointer;
        }

        input[type=search], select {
            width: 100%;
            display: inline-block;
            padding: 10px 15px;
            margin-top: 5px;
            margin-bottom: 10px;
            border: 1px solid #555;
            box-sizing: border-box;
        }
    </style>
</head>

<body>
<header>
    <h1>University of Houston</h1>
    <h3>Libraries</h3>
</header>
<nav>
    <a href="/index.php" style="float:left;">Home</a>
    <a href="/login.php">Login</a>
    <a href="/register.php">Register</a>
</nav>
<!--custom html below-->
<aside id="drop-down-menu">
    <!--if logged in member is faculty, display faculty menu-->
    <?php if (isset($_SESSION["faculty"])) { ?>
        <div class="item vgap">
            Faculty Menu
            <div class="content">
                <a href="#">Add New Media</a>
                <a href="#">Check Out Media</a>
                <a href="#">Check In Media</a>
                <a href="http://www.databaseteam12.x10host.com/searchMembers.php">Search Members</a>
                <a href="#">Display All Members By Last Name</a>
                <a href="#">Display All Members By Fines</a>
                <a href="http://www.databaseteam12.x10host.com/searchLaptops.php">Search Rented Laptops</a>
                <a href="http://www.databaseteam12.x10host.com/searchRooms.php">Search Rented Rooms</a>
            </div>
        </div>
    <?php } ?>
    <div class="item vgap">
        Search Media
        <div class="content">
            <a href="http://www.databaseteam12.x10host.com/search.php">Search</a>
            <a href="http://www.databaseteam12.x10host.com/displayAll.php">Display All Media</a>
            <a href="http://www.databaseteam12.x10host.com/displayAllBooks.php">Display All Books</a>
            <a href="http://www.databaseteam12.x10host.com/displayAllCassettes.php">Display All Cassettes</a>
            <a href="http://www.databaseteam12.x10host.com/displayAllCds.php">Display All CDs</a>
            <a href="http://www.databaseteam12.x10host.com/displayAllDvds.php">Display All DVDs</a>
            <a href="http://www.databaseteam12.x10host.com/displayAllVhs.php">Display All VHS</a>

        </div>
    </div>
    <div class="item vgap">
        Laptop Rentals
        <div class="content">
            <a href="http://www.databaseteam12.x10host.com/displayAllLaptops.php">Display All Laptops</a>
        </div>
    </div>
    <div class="item">
        Room Reservations
        <div class="content">
            <a href="http://www.databaseteam12.x10host.com/displayAllRooms.php">Display All Rooms</a>
        </div>
    </div>
</aside>
<main>
    <form name="form" action="" method="get">
        <label><b>Media Type</b></label>
        <select id="media-type" name="media-type">
            <option value="all" selected>All</option>
            <option value="book">Book</option>
            <option value="cassette">Cassette</option>
            <option value="cd">CD</option>
            <option value="dvd">DVD</option>
            <option value="vhs">VHS</option>
        </select>

        <label><b>Search Type</b></label>
        <select id="search-type" name="search-type">
            <option value="artist">Artist</option>
            <option value="audience">Audience</option>
            <option value="author">Author</option>
            <option value="director">Director</option>
            <option value="genre">Genre</option>
            <option value="isbn10">ISBN-10</option>
            <option value="isbn13">ISBN-13</option>
            <option value="language">Language</option>
            <option value="producer">Producer</option>
            <option value="publisher">Publisher</option>
            <option value="title">Title</option>
            <option value="publish_date">Year Published</option>
        </select>

        <label><b>Search</b></label>
        <input type="text" placeholder="Search for..." name="search" required>
        <button type="submit">Search</button>
    </form>

    <?php

    $servername = "162.253.224.12";
    $username = "databa39_user";
    $password = "databa39team12";
    $dbname = "databa39_library";

    $conn = new mysqli($servername, $username, $password, $dbname);

    $sql = "";

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $stype = '';
    $mtype = '';

    if (isset($_GET['media-type'])) {
        $mtype = $_GET['media-type'];
    }

    if (isset($_GET['search-type'])) {
        $stype = $_GET['search-type'];
    }

    if (isset($_GET['search'])) {
        $value = $_GET['search'];
    }

    if ($mtype == "cd") {
        switch ($stype) {
            case "artist":
                $sql = "SELECT * FROM Full_CD_View WHERE first_name LIKE '%$value%' OR last_name LIKE '%$value%'";
                break;
            case "audience":
                $sql = "SELECT * FROM Full_CD_View WHERE audience LIKE '%$value%'";
                break;
            case "genre":
                $sql = "SELECT * FROM Full_CD_View WHERE genre LIKE '%$value%'";
                break;
            case "language":
                $sql = "SELECT * FROM Full_CD_View WHERE language LIKE '%$value%'";
                break;
            case "producer":
                $sql = "SELECT * FROM Full_CD_View WHERE producer LIKE '%$value%'";
                break;
            case "publisher":
                $sql = "SELECT * FROM Full_CD_View WHERE publisher LIKE '%$value%'";
                break;
            case "title":
                $sql = "SELECT * FROM Full_CD_View WHERE title LIKE '%$value%'";
                break;
            case "publish_date":
                $sql = "SELECT * FROM Full_CD_View WHERE published_date LIKE $value";
                break;
        }
        //$sql = "SELECT * FROM Full_Book_View WHERE first_name LIKE '%$value%' OR last_name LIKE '%$value%' ORDER BY title";
        $result = $conn->query($sql);

        // If result is not empty, display it
        if ($result->num_rows > 0) {
            // Output data from every row
            while ($row = $result->fetch_assoc()) {
                $book = $row["id"];
                $copy = $row["copy_num"];

                echo "<hr><h2>" . $row["title"] . "</h2>"
                    . $row["first_name"] . " "
                    . $row["published_date"] . "<br>" . $row["publisher"] . ".<br><br>
				<a href=\"details.php?id=$book&copy=$copy\">More Details</a><br><br>";

                // If the book is available
                if ($row["is_available"] == "available") {
                    echo "<p><i class='fa fa-check-circle' aria-hidden='true' 
						style='color: #57BC57'></i> Copy #" . $row["copy_num"] . " is 
						<b>available</b>. ";

                    // If logged in, provide options to reserve or hold
                    if (session_status() == PHP_SESSION_ACTIVE) {
                        echo "<a href=\"\">Hold</a>
						<a href=\"\" style=\"margin-left:5px;\">Reserve</a>
						</p>";
                    }
                } // Else, display status of the book
                else {
                    echo "<p><i class='fa fa-times-circle' aria-hidden='true'
						style='color: #D25252'></i> Copy #" . $row["copy_num"] . " is 
						<b>" . $row["is_available"] . "</b>.</p>";
                }
            }

        } else {
            echo "0 results";
        }
    }
    else if ($mtype == "cassette"){

        switch ($stype) {
            case "artist":
                $sql = "SELECT * FROM Full_Cassette_View WHERE first_name LIKE '%$value%' OR last_name LIKE '%$value%'";
                break;
            case "audience":
                $sql = "SELECT * FROM Full_Cassette_View WHERE audience LIKE '%$value%'";
                break;
            case "genre":
                $sql = "SELECT * FROM Full_Cassette_View WHERE genre LIKE '%$value%'";
                break;
            case "language":
                $sql = "SELECT * FROM Full_Cassette_View WHERE language LIKE '%$value%'";
                break;
            case "producer":
                $sql = "SELECT * FROM Full_Cassette_View WHERE producer LIKE '%$value%'";
                break;
            case "publisher":
                $sql = "SELECT * FROM Full_Cassette_View WHERE publisher LIKE '%$value%'";
                break;
            case "title":
                $sql = "SELECT * FROM Full_Cassette_View WHERE title LIKE '%$value%'";
                break;
            case "publish_date":
                $sql = "SELECT * FROM Full_Cassette_View WHERE published_date LIKE $value";
                break;
        }

        echo "THIS Value is \n";
        echo $value;
        echo "\n";

        //$sql = "SELECT * FROM Full_Book_View WHERE first_name LIKE '%$value%' OR last_name LIKE '%$value%' ORDER BY title";
        $result = $conn->query($sql);

        // If result is not empty, display it
        if ($result->num_rows > 0) {
            // Output data from every row
            while ($row = $result->fetch_assoc()) {
                $book = $row["id"];
                $copy = $row["copy_num"];

                echo "<hr><h2>" . $row["title"] . "</h2>"
                    . $row["first_name"] . " "
                    . $row["published_date"] . "<br>" . $row["publisher"] . ".<br><br>
				<a href=\"details.php?id=$book&copy=$copy\">More Details</a><br><br>";

                // If the book is available
                if ($row["is_available"] == "available") {
                    echo "<p><i class='fa fa-check-circle' aria-hidden='true' 
						style='color: #57BC57'></i> Copy #" . $row["copy_num"] . " is 
						<b>available</b>. ";

                    // If logged in, provide options to reserve or hold
                    if (session_status() == PHP_SESSION_ACTIVE) {
                        echo "<a href=\"\">Hold</a>
						<a href=\"\" style=\"margin-left:5px;\">Reserve</a>
						</p>";
                    }
                } // Else, display status of the book
                else {
                    echo "<p><i class='fa fa-times-circle' aria-hidden='true'
						style='color: #D25252'></i> Copy #" . $row["copy_num"] . " is 
						<b>" . $row["is_available"] . "</b>.</p>";
                }
            }

        } else {
            echo "0 results";
        }
    } else if ($mtype == "book") {
        switch ($stype) {
            case "audience":
                $sql = "SELECT * FROM Full_Book_View WHERE audience LIKE '%$value%'";
                break;
            case "author":
                $sql = "SELECT * FROM Full_Book_View WHERE first_name LIKE '%$value%' OR last_name LIKE '%$value%'";
                break;
            case "genre":
                $sql = "SELECT * FROM Full_Book_View WHERE genre LIKE '%$value%'";
                break;
            case "isbn10":
                $sql = "SELECT * FROM Full_Book_View WHERE ISBN_10 LIKE '%$value%'";
                break;
            case "isbn13":
                $sql = "SELECT * FROM Full_Book_View WHERE ISBN_13 LIKE '%$value%'";
                break;
            case "language":
                $sql = "SELECT * FROM Full_Book_View WHERE language LIKE '%$value%'";
                break;
            case "producer":
                $sql = "SELECT * FROM Full_Book_View WHERE producer LIKE '%$value%'";
                break;
            case "publisher":
                $sql = "SELECT * FROM Full_Book_View WHERE publisher LIKE '%$value%'";
                break;
            case "title": //NOT ALWAYS WORKING... WHY?
                $sql = "SELECT * FROM Full_Book_View WHERE title LIKE '%$value%'";
                break;
            case "publish_date":
                $sql = "SELECT * FROM Full_Book_View WHERE published_date LIKE $value";
                break;
        }

        echo "THIS Value is \n";
        echo $value;
        echo "\n";

        //$sql = "SELECT * FROM Full_Book_View WHERE first_name LIKE '%$value%' OR last_name LIKE '%$value%' ORDER BY title";
        $result = $conn->query($sql);

        // If result is not empty, display it
        if ($result->num_rows > 0) {
            // Output data from every row
            while ($row = $result->fetch_assoc()) {
                $book = $row["id"];
                $copy = $row["copy_num"];

                echo "<hr><h2>" . $row["title"] . "</h2>"
                    . $row["first_name"] . " " . $row["last_name"] . " "
                    . $row["published_date"] . "<br>" . $row["publisher"] . ".<br><br>
				<a href=\"details.php?id=$book&copy=$copy\">More Details</a><br><br>";

                // If the book is available
                if ($row["is_available"] == "available") {
                    echo "<p><i class='fa fa-check-circle' aria-hidden='true' 
						style='color: #57BC57'></i> Copy #" . $row["copy_num"] . " is 
						<b>available</b>. ";

                    // If logged in, provide options to reserve or hold
                    if (session_status() == PHP_SESSION_ACTIVE) {
                        echo "<a href=\"\">Hold</a>
						<a href=\"\" style=\"margin-left:5px;\">Reserve</a>
						</p>";
                    }
                } // Else, display status of the book
                else {
                    echo "<p><i class='fa fa-times-circle' aria-hidden='true'
						style='color: #D25252'></i> Copy #" . $row["copy_num"] . " is 
						<b>" . $row["is_available"] . "</b>.</p>";
                }
            }
        } else {
            echo "0 results";
        }

    } else if($mtype == "dvd"){
        switch ($stype) {
            case "audience":
                $sql = "SELECT * FROM Full_DVD_View WHERE audience LIKE '%$value%'";
                break;
            case "director":
                $sql = "SELECT * FROM Full_DVD_View WHERE director LIKE '%$value%'";
                break;
            case "genre":
                $sql = "SELECT * FROM Full_DVD_View WHERE genre LIKE '%$value%'";
                break;
            case "language":
                $sql = "SELECT * FROM Full_DVD_View WHERE language LIKE '%$value%'";
                break;
            case "producer":
                $sql = "SELECT * FROM Full_DVD_View WHERE producer LIKE '%$value%'";
                break;
            case "publisher":
                $sql = "SELECT * FROM Full_DVD_View WHERE publisher LIKE '%$value%'";
                break;
            case "title":
                $sql = "SELECT * FROM Full_DVD_View WHERE title LIKE '%$value%'";
                break;
            case "publish_date":
                $sql = "SELECT * FROM Full_DVD_View WHERE published_date LIKE $value";
                break;
        }
        $result = $conn->query($sql);

        // If result is not empty, display it
        if ($result->num_rows > 0) {
            // Output data from every row
            while($row = $result->fetch_assoc()) {
                $book = $row["id"];
                $copy = $row["copy_num"];

                echo "<hr><h2>".$row["title"]."</h2>"
                    . $row["director"] . " "
                    .$row["published_date"]."<br>".$row["publisher"].".<br><br>
				<a href=\"details.php?id=$book&copy=$copy\">More Details</a><br><br>";

                // If the book is available
                if ($row["is_available"] == "available") {
                    echo "<p><i class='fa fa-check-circle' aria-hidden='true' 
						style='color: #57BC57'></i> Copy #".$row["copy_num"]." is 
						<b>available</b>. ";

                    // If logged in, provide options to reserve or hold
                    if (session_status() == PHP_SESSION_ACTIVE) {
                        echo "<a href=\"\">Hold</a>
						<a href=\"\" style=\"margin-left:5px;\">Reserve</a>
						</p>";
                    }
                }
                // Else, display status of the book
                else {
                    echo "<p><i class='fa fa-times-circle' aria-hidden='true'
						style='color: #D25252'></i> Copy #".$row["copy_num"]." is 
						<b>".$row["is_available"]."</b>.</p>";
                }
            }
        }
    } else if($mtype == "vhs") {
        switch ($stype) {
            case "audience":
                $sql = "SELECT * FROM Full_VHS_View WHERE audience LIKE '%$value%'";
                break;
            case "director":
                $sql = "SELECT * FROM Full_VHS_View WHERE director LIKE '%$value%'";
                break;
            case "genre":
                $sql = "SELECT * FROM Full_VHS_View WHERE genre LIKE '%$value%'";
                break;
            case "language":
                $sql = "SELECT * FROM Full_VHS_View WHERE language LIKE '%$value%'";
                break;
            case "producer":
                $sql = "SELECT * FROM Full_VHS_View WHERE producer LIKE '%$value%'";
                break;
            case "publisher":
                $sql = "SELECT * FROM Full_VHS_View WHERE publisher LIKE '%$value%'";
                break;
            case "title":
                $sql = "SELECT * FROM Full_VHS_View WHERE title LIKE '%$value%'";
                break;
            case "publish_date":
                $sql = "SELECT * FROM Full_VHS_View WHERE published_date LIKE $value";
                break;
        }
        $result = $conn->query($sql);

        // If result is not empty, display it
        if ($result->num_rows > 0) {
            // Output data from every row
            while ($row = $result->fetch_assoc()) {
                $book = $row["id"];
                $copy = $row["copy_num"];

                echo "<hr><h2>" . $row["title"] . "</h2>"
                    . $row["director"] . " "
                    . $row["published_date"] . "<br>" . $row["publisher"] . ".<br><br>
				<a href=\"details.php?id=$book&copy=$copy\">More Details</a><br><br>";

                // If the book is available
                if ($row["is_available"] == "available") {
                    echo "<p><i class='fa fa-check-circle' aria-hidden='true' 
						style='color: #57BC57'></i> Copy #" . $row["copy_num"] . " is 
						<b>available</b>. ";

                    // If logged in, provide options to reserve or hold
                    if (session_status() == PHP_SESSION_ACTIVE) {
                        echo "<a href=\"\">Hold</a>
						<a href=\"\" style=\"margin-left:5px;\">Reserve</a>
						</p>";
                    }
                } // Else, display status of the book
                else {
                    echo "<p><i class='fa fa-times-circle' aria-hidden='true'
						style='color: #D25252'></i> Copy #" . $row["copy_num"] . " is 
						<b>" . $row["is_available"] . "</b>.</p>";
                }
            }
        }
    }

    $conn->close();

    ?>


</main>
<!--custom html above-->
<footer>
    <br>
    &copy; Spring 2017 COSC 3380 Team 12
    <br>
    4333 University Drive
    <br>
    Houston, TX 77204-2000
</footer>
</body>