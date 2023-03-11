
<head>
<title>Admin Login</title>
</head>
<body>
<table align="center" style="border:2px solid blue;">
		<form action="admin_tasks.html" method="get" id="adminlogin_screen">
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
			<form action="index.html" method="get" id="login_screen">
			<td align="right">
				<input type="submit" name="cancel" id="cancel" value="Cancel">
			</td>
			</form>
		</tr>
	</table>
</body>
<?php 
$user = 'root';
$pass = '';
$db = 'cosc471';

$dbConnection = new mysqli('localhost', $user, $pass, $db) or die("Unable to connect");

if(isset($_GET['login'])){
	$adminname = $_GET['adminname'];
	$pin = $_GET['pin'];
	
	$sql = "SELECT * FROM admin WHERE adminname = '$adminname' AND pin = '$pin'";
	$result = mysqli_query($dbConnection, $sql);
	
	if(mysqli_num_rows($result) == 1){
		header("Location: admin_tasks.html");
	}
	else{
		echo "Incorrect adminname or pin";
	}
}
?>
</html>

