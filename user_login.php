
<!DOCTYPE HTML>
<head>
<title>User Login</title>
</head>
<body>
<?php
$user = 'root';
$pass = '';
$db = 'cosc471';

try {
$dbConnection = new PDO("mysql:host=localhost;dbname=$db", $user, $password);
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
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
			<form action="index.html" method="post" id="login_screen">
			<td align="right">
				<input type="submit" name="cancel" id="cancel" value="Cancel">
			</td>
			</form>
		</tr>
	</table>
</body>

</html>
