<!--Ruben-->
<?php
session_start();
session_unset();
session_destroy();
session_start();

$isUser = false;

//add isUser to the session
$_SESSION['isUser'] = $isUser;

?>
<title>Welcome to Best Book Buy Online Bookstore!</title>
<body>
	<table align="center" style="border:1px solid blue;">
	<tr><td><h2>Best Book Buy (3-B.com)</h2></td></tr>
	<tr><td><h4>Online Bookstore</h4></td></tr>
	<tr><td><form action="" method="post">
		<input type="radio" name="group1" value="SearchCat.html" onclick="document.location.href='screen2.php'">Search Online<br/>
		<input type="radio" name="group1" value="customer_registration.html" onclick="document.location.href='customer_registration.php'">New Customer<br/>
		<input type="radio" name="group1" value="user_login.php" onclick="document.location.href='user_login.php'">Returning Customer<br/>
		<input type="radio" name="group1" value="admin_login.php" onclick="document.location.href='admin_login.php'">Administrator<br/>
		<input type="submit" name="submit" value="ENTER">
	</form></td></tr>
	</table>
</body>
</html>