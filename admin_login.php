
<head>
<title>Admin Login</title>
</head>
<body>
<?php 
$user = 'admin1';
$pass = 'Admin1Pass4235!a';
$db = 'cosc471';

try {
$dbConnection = new mysqli('localhost', $user, $pass, $db) or die("Unable to connect");
} catch (mysqli_sql_exception $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}

if(isset($_POST['login'])){
	$adminname = $_POST['adminname'];
	$pin = $_POST['pin'];
	
	$sql = "SELECT * FROM admin WHERE adminname = '$adminname' AND pin = '$pin'";
	$result = mysqli_query($dbConnection, $sql);
	
	// if the adminname and pin match, redirect to the admin tasks page
	if(mysqli_num_rows($result) == 1){
		header("Location: admin_tasks.php");
	}
	// if the adminname and pin do not match, display an error message
	else{
		echo "Invalid adminname or pin";
	}
}
?>
	<table align="center" style="border:2px solid blue;">
		<form action="admin_login.php" method="post" id="adminlogin_screen">
		<tr>
			<td align="right">
				Adminname<span style="color:red">*</span>:
			</td>
			<td align="left">
				<input type="text" name="adminname" id="adminname"> 
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

