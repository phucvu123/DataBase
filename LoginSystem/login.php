<?php
session_start();
requrie 'connectDB.php';
?>


<!DOCTYPE html>
<html>
<head>

	<link rel="stylesheet" type="text/css" href="style.css">

	<title>Login Page</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

	<div>
		<header>
			<div class="main">
				<h1><a href="http://www.databaseteam12.x10host.com"><font color="white">University of Houston</font></a></h1>
				<h3><a href="http://www.databaseteam12.x10host.com"><font color="white">Libraries</font></a></h3>
			</div>
			<div class="subhead">
				
			</div>
		</header>
	</div>
	
	<div class="container">
		
		<div class="innerbox">
			<h2>Sign in</h2>
			<form action="processData.php" method="POST" >   <!-- action="processData" sends the data that was inputed in the form to the. POST method is used for sensetive data. --> 
				<p>
					<label>Email:</label><br>
					<input type="text" name="email">
					<br>
				</p>
				<p>
					<label>Password:</label><br>
					<input type="password" name="password">
                    <span class="right">
                    </span>
					<br>
				</p>
				<p>
					<br>
					<button type="submit">Sign in</button>
				</p>
                
                <div class="divider">
                    <hr class="left"> <small>Need an account?</small> <hr class="right"> 
                </div>
                <div class="regbox">
                <p> <button class="registerbutton" type="submit">Create an account</button></p>
                </div>

			</form>
		</div>
		
	</div>

	<footer>
		&copy; Spring 2017 COSC 3380 Team 12
		<br><br>
		4333 University Drive
		<br>
		Houston, TX 77204-2000
	</footer>
</body>
</html>