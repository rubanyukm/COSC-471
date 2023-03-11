
<!DOCTYPE HTML>
<head>
	<title>UPDATE ADMIN</title>
</head>
<body>
<?php
$user = 'ruben';
$pass = 'myPasword123!a';
$db = 'cosc471';

try {
$dbConnection = new mysqli('localhost', $user, $pass, $db) or die("Unable to connect");
} catch (mysqli_sql_exception $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}

// grab the  oldadminname and oldpin from the form and store them in variables
$oldadminname = $_POST['oldadminname'];
$oldpin = $_POST['oldpin'];

// grab the newadminname and newpin from the form and store them in variables
$newadminname = $_POST['newadminname'];
$newpin = $_POST['newpin'];

// create a query to update the admin table with the new adminname and pin where the old adminname and pin match
$sql = "UPDATE admin SET adminname = '$newadminname', pin = '$newpin' WHERE adminname = '$oldadminname' AND pin = '$oldpin'";
$result = mysqli_query($dbConnection, $sql);

?>
    <table align="center" style="border:2px solid blue;">
		<form action="update_adminprofile.php" method="post" id="adminupdate_screen">
        <tr>
			<td align="right">
				New Adminname<span style="color:red">*</span>:
			</td>
			<td align="left">
				<input type="text" name="newadminname" id="newadminname"> 
			</td>
		</tr>
        <tr>
            <td align="right">
				New PIN<span style="color:red">*</span>:
			</td>
			<td align="left">
				<input type="password" name="newpin" id="newpin">
			</td>
		</tr>
		<tr>
			<td align="right">
				Old Adminname<span style="color:red">*</span>:
			</td>
			<td align="left">
				<input type="text" name="oldadminname" id="oldadminname"> 
			</td>
			<td align="right">
				<input type="submit" name="submit" id="submit" value="Submit">
			</td>
		</tr>
		<tr>
			<td align="right">
				Old PIN<span style="color:red">*</span>:
			</td>
			<td align="left">
				<input type="password" name="oldpin" id="oldpin">
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