
<!DOCTYPE HTML>
<head>
<title>User Login</title>
</head>
<body>
<?php
$user = 'admin1';
$pass = 'Admin1Pass4235!a';
$db = 'cosc471';

try {
$dbConnection = new mysqli('localhost', $user, $pass, $db);
} catch (mysqli_sql_exception $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}

$username = "";
$pin = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$username = $_POST['username'];
	$pin = $_POST['pin'];

	//if statements to check if fields are empty
	if (empty($username)) {
		echo "<script type='text/javascript'>alert('Username is required.');</script>";
	}
	if (empty($pin)) {
		echo "<script type='text/javascript'>alert('PIN is required.');</script>";
	}

	//if statements to check if username and pin are in database
	$sql = "SELECT * FROM customer WHERE username = '$username' AND pin = '$pin'";
	$result = $dbConnection->query($sql);
	if ($result->num_rows > 0) {
		echo "<script type='text/javascript'>alert('Login successful.');</script>";
		header("Location: screen2.html");
	} else {
		echo "<script type='text/javascript'>alert('Login failed.');</script>";
	}
}

?>
	<table align="center" style="border:2px solid blue;">
		<form action="screen2.html" method="post" id="login_screen">
		<tr>
			<td align="right">
				Username<span style="color:red">*</span>:
			</td>
			<td align="left">
				<input type="text" name="username" id="username">
			</td>
			<td align="right">
				<input type="submit" name="login" id="login" value="Login">
			</td>
		</tr>
		<tr>
			<td align="right">
				PIN<span style="color:red">*</span>:
			</td>
			<td align="left">
				<input type="password" name="pin" id="pin">
			</td>
			</form>
			<form action="index.php" method="post" id="login_screen">
			<td align="right">
				<input type="submit" name="cancel" id="cancel" value="Cancel">
			</td>
		</form>
		</tr>
	</table>
</body>

</html>
