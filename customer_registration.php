<!-- UI: Prithviraj Narahari, php code: Alexander Martens -->
<head>
<title> CUSTOMER REGISTRATION </title>
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

$username = $_POST['username'];
$pin = $_POST['pin'];
$retype_pin = $_POST['retype_pin'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$address = $_POST['address'];
$city = $_POST['city'];
$state = $_POST['state'];
$cardType = $_POST['credit_card'];
$cardNumber = $_POST['card_number'];

if (isset($_POST['register_submit'])) {

	/*$username = $_POST['username'];
	$pin = $_POST['pin'];
	$retype_pin = $_POST['retype_pin'];
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$address = $_POST['address'];
	$city = $_POST['city'];
	$state = $_POST['state'];
	$cardType = $_POST['credit_card'];
	$cardNumber = $_POST['card_number'];*/

	if (empty($username) || empty($pin) || empty($retype_pin) || empty($firstname) || empty($lastname) || empty($address) || empty($city) || empty($state) || empty($cardType) || empty($cardNumber)) {
		echo "<script type='text/javascript'>alert('All fields are rquired.');</script>";
		header("Location: customer_registration.php");
	}

	$sql = "SELECT * FROM customer WHERE username = '$username'";
	$result = mysqli_query($dbConnection, $sql);

	if(mysqli_num_rows($result) == 0)
	{
		if($pin == $retype_pin)
		{
			$sql = "INSERT INTO customer (username, pin, firstname, lastname, address, city, state, cardType, cardNumber) VALUES ('$username', '$pin', '$firstname', '$lastname', '$address', '$city', '$state', '$cardType', '$cardNumber')";
			$result = mysqli_query($dbConnection, $sql);
			echo "<script type='text/javascript'>alert('Registration successful.');</script>";
			header("Location: index.php");
		}
		else
		{
			echo "<script type='text/javascript'>alert('PINs do not match.');</script>";
		}
	}
	else
	{
		echo "<script type='text/javascript'>alert('Username already exists.');</script>";
	}
	
}
	
?>

	<table align="center" style="border:2px solid blue;">
		<tr>
			<form id="register" action="customer_registration.php" method="post">
			<td align="right">
				Username<span style="color:red">*</span>:
			</td>
			<td align="left" colspan="3">
				<input type="text" id="username" name="username" placeholder="Enter your username">
			</td>
		</tr>
		<tr>
			<td align="right">
				PIN<span style="color:red">*</span>:
			</td>
			<td align="left">
				<input type="password" id="pin" name="pin">
			</td>
			<td align="right">
				Re-type PIN<span style="color:red">*</span>:
			</td>
			<td align="left">
				<input type="password" id="retype_pin" name="retype_pin">
			</td>
		</tr>
		<tr>
			<td align="right">
				Firstname<span style="color:red">*</span>:
			</td>
			<td colspan="3" align="left">
				<input type="text" id="firstname" name="firstname" placeholder="Enter your firstname">
			</td>
		</tr>
		<tr>
			<td align="right">
				Lastname<span style="color:red">*</span>:
			</td>
			<td colspan="3" align="left">
				<input type="text" id="lastname" name="lastname" placeholder="Enter your lastname">
			</td>
		</tr>
		<tr>
			<td align="right">
				Address<span style="color:red">*</span>:
			</td>
			<td colspan="3" align="left">
				<input type="text" id="address" name="address">
			</td>
		</tr>
		<tr>
			<td align="right">
				City<span style="color:red">*</span>:
			</td>
			<td colspan="3" align="left">
				<input type="text" id="city" name="city">
			</td>
		</tr>
		<tr>
			<td align="right">
				State<span style="color:red">*</span>:
			</td>
			<td align="left">
				<select id="state" name="state">
				<option selected disabled>select a state</option>
				<option>Michigan</option>
				<option>California</option>
				<option>Tennessee</option>
				</select>
			</td>
			<td align="right">
				Zip<span style="color:red">*</span>:
			</td>
			<td align="left">
				<input type="text" id="zip" name="zip">
			</td>
		</tr>
		<tr>
			<td align="right">
				Credit Card<span style="color:red">*</span>
			</td>
			<td align="left">
				<select id="credit_card" name="credit_card">
				<option selected disabled>select a card type</option>
				<option>VISA</option>
				<option>MASTER</option>
				<option>DISCOVER</option>
				</select>
			</td>
			<td colspan="2" align="left">
				<input type="text" id="card_number" name="card_number" placeholder="Credit card number">
			</td>
		</tr>
		<tr>
			<td colspan="2" align="right">
				Expiration Date<span style="color:red">*</span>:
			</td>
			<td colspan="2" align="left">
				<input type="text" id="expiration" name="expiration" placeholder="MM/YY">
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center"> 
				<input type="submit" id="register_submit" name="register_submit" value="Register">
			</td>
			</form>
			<form id="no_registration" action="index.php" method="post">
			<td colspan="2" align="center">
				<input type="submit" id="donotregister" name="donotregister" value="Don't Register">
			</td>
			</form>
		</tr>
	</table>
</body>
</HTML>