<?php
	session_start();
?>
<!DOCTYPE html>

<head>
	<title>Search Rented Laptops</title>
	<link rel="stylesheet" href="/style/common.css">
	<link rel="stylesheet" href="/style/home.css">
	<link rel="stylesheet" href="/style/drop-down-menu.css">
    <link rel="stylesheet" href="/style/footer.css">
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
		<form method="get" action="">
		<label><b>Search By</b></label>
			<select id="search-type" name="search-type">
                <option value="" selected>Select Search Type</option>
                <option value="available" >Availability</option>
				<option value="serial" >Serial Number</option>
				<option value="id">Laptop ID</option>
			</select>
			
			<label><b>Search</b></label>
			<input type="search" placeholder="Search for..." name="search" >
			
			<button type="submit">Search</button>
		</form>

        <?php
        $servername = "162.253.224.12";
        $username = "databa39_user";
        $password = "databa39team12";
        $dbname = "databa39_library";

        $conn = new mysqli($servername, $username, $password, $dbname);

        $sql = "SELECT * FROM Laptop ORDER BY id ASC";

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $stype = '';

        if (isset($_GET['search-type'])) {
            $stype = $_GET['search-type'];
        }

        if (isset($_GET['search'])) {
            $value = $_GET['search'];
        }



        switch($stype){
            case "serial" :
                $sql = "SELECT * FROM Laptop WHERE serial LIKE '%$value%'";
                break;
            case "id" :
                $sql = "SELECT * FROM Laptop WHERE id LIKE $value";
                break;
            case "available" :
                $sql = "SELECT * FROM Laptop WHERE NOT EXISTS 
                    (SELECT laptop_id FROM Laptop_Rents WHERE end_date >= CURDATE() 
                    AND Laptop.id = Laptop_Rents.laptop_id)";
                break;
        }


		// Call procedure or query for specific page

		$result = $conn->query($sql);

		// If result is not empty, display it
		if ($result->num_rows > 0) {
            echo "<table><tr><th width='15%'>Laptop ID</th><th width='25%'>Serial Number</th>
			<th width='60%'>Availability</th></tr>";

            // Output data from every row
            while($row = $result->fetch_assoc()) {
                $id = $row["id"];

                echo "<tr><td>".$row["id"]."</td><td>".$row["serial"]."</td>";

                $sql2 = "SELECT * FROM Laptop_Rents WHERE laptop_id = $id;";
                $result2 = $conn->query($sql2);

                if ($result2->num_rows > 0) {
                    echo "<td><i class='fa fa-times-circle' aria-hidden='true'
						style='color: #D25252'></i> Laptop is rented</td></tr>";
                }
                else {
                    echo "<td><i class='fa fa-check-circle' aria-hidden='true' 
						style='color: #57BC57'></i> Laptop is available</td></tr>";
                }
            }

            echo "</table>";
        } else {
            echo "0 results";
        }
		$conn->close();
		?>
	</main>
	<!--custom html above-->
    <br><br>
	<footer>
		&copy; Spring 2017 COSC 3380 Team 12
		<br>
		4333 University Drive
		<br>
		Houston, TX 77204-2000
	</footer>
</body>