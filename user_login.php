
<!DOCTYPE HTML>
<head>
<title>User Login</title>
</head>
<body>
<?php
session_start();

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

$isUser = $_SESSION['isUser'];

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
		$isUser = true;
		$_SESSION['username'] = $username;
		//put isUser back in session
		$_SESSION['isUser'] = $isUser;
		//grab the card type and cardnumber from the database and put them in session
		$sql = "SELECT cardType, cardNo FROM customer WHERE username = '$username'";
		$result = $dbConnection->query($sql);
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$_SESSION['card_type'] = $row['card_type'];
				$_SESSION['card_number'] = $row['card_number'];
			}
		}
		echo "<script type='text/javascript'>alert('Login successful.');</script>";
		header("Location: screen2.php");
	} else {
		echo "<script type='text/javascript'>alert('Login failed.');</script>";
	}
}

?>
	<table align="center" style="border:2px solid blue;">
		<form action="user_login.php" method="post" id="login_screen">
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
